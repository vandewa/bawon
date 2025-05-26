<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PaketPekerjaan;
use App\Models\PaketPekerjaanRinci;
use App\Models\Desa;

class SyncAnggaranRinci extends Component
{
    public $kodeDesa = '';
    public $isProcessing = false;
    public $message = '';
    public $desaList = [];
    public $limit = 300; // Biar chunk tidak berat
     public $progressMsg = '';

    public function mount()
    {
        $desa = Desa::select('*');
        if(auth()->user()->desa_id) {
            $desa->where('id', auth()->user()->desa_id);

            $data = Desa::find(auth()->user()->desa_id);
            $this->kodeDesa = $data->kode_desa;

        }

        $this->desaList = $desa->orderBy('name')->get();
    }

    public function sync()
    {
        $this->reset(['message', 'progressMsg']);
        $this->isProcessing = true;

        try {
            // ---- SINKRONISASI PaketPekerjaan (seperti handle yang kamu kirimkan) ----
            $totalKegiatan = DB::connection('sqlsrv')->table('TA_Kegiatan as o')
                ->where('o.Kd_Desa', $this->kodeDesa)
                ->count();

            $this->progressMsg = "Sinkronisasi Paket Kegiatan ($totalKegiatan data)...";
            $this->dispatch('sync-progress', msg: $this->progressMsg);

            $query = DB::connection('sqlsrv')->table('TA_Kegiatan as o')
                ->join('Ref_Bidang as b', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 2)'), '=', 'b.Kd_Bid')
                ->join('Ref_SubBidang as c', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 6)'), '=', 'c.Kd_Sub')
                ->join('Ref_Kegiatan as d', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 9)'), '=', 'd.ID_Keg')
                ->select(
                    'o.tahun', 'o.Kd_Desa', 'o.Kd_Keg', 'o.Sumberdana', 'o.Nama_Kegiatan',
                    'o.NilaiPAK', 'o.Satuan', 'o.Pagu_PAK', 'o.Nm_PPTKD', 'o.Jbt_PPTKD',
                    'b.Nama_Bidang', 'c.Nama_SubBidang'
                )
                ->where('o.Kd_Desa', $this->kodeDesa)
                ->orderBy('o.Kd_Desa');

            $totalSaved = 0;
            foreach ($query->cursor() as $item) {
                $desa = Desa::where('kode_desa', $item->Kd_Desa)->first();
                if (!$desa) continue;

                $data = [
                    'desa_id'        => $desa->id,
                    'tahun'          => $item->tahun,
                    'kd_desa'        => $item->Kd_Desa,
                    'kd_keg'         => $item->Kd_Keg,
                    'sumberdana'     => $item->Sumberdana,
                    'nama_kegiatan'  => $item->Nama_Kegiatan,
                    'nilaipak'       => $item->NilaiPAK,
                    'satuan'         => $item->Satuan,
                    'pagu_pak'       => $item->Pagu_PAK,
                    'nm_pptkd'       => $item->Nm_PPTKD,
                    'jbt_pptkd'      => $item->Jbt_PPTKD,
                    'nama_bidang'    => $item->Nama_Bidang,
                    'nama_subbidang' => $item->Nama_SubBidang,
                    'kegiatan_st'    => 'KEGIATAN_ST_01',
                    'updated_at'     => now(),
                ];

                // Validasi panjang field
                foreach ([
                    'nama_kegiatan'  => 255,
                    'nm_pptkd'       => 100,
                    'jbt_pptkd'      => 100,
                    'nama_bidang'    => 100,
                    'nama_subbidang' => 100
                ] as $field => $max) {
                    if (strlen($data[$field]) > $max) {
                        // Boleh tulis ke $this->message jika ingin tampilkan warning.
                        // $this->message .= "Field $field terlalu panjang (".strlen($data[$field])." karakter)\n";
                        $data[$field] = mb_substr($data[$field], 0, $max); // Biar tetap masuk
                    }
                }

                $existing = PaketPekerjaan::where('kd_keg', $item->Kd_Keg)
                    ->where('desa_id', $desa->id)
                    ->first();

                if ($existing) {
                    if (!$existing->paketKegiatans()->exists()) {
                        $existing->update($data);
                        $totalSaved++;
                    }
                } else {
                    $data['created_at'] = now();
                    PaketPekerjaan::create($data);
                    $totalSaved++;
                }
            }

            $this->progressMsg = "Sinkronisasi Paket Kegiatan selesai ($totalSaved disimpan/diperbarui)";
            $this->dispatch('sync-progress', ['msg' => $this->progressMsg]);

            // ---- SINKRONISASI RINCIAN (lanjut seperti kode sebelumnya) ----
            $this->progressMsg = "Sinkronisasi rincian anggaran...";
            $this->dispatch('sync-progress', ['msg' => $this->progressMsg]);

            $totalInserted = 0;
            $chunkCount = 0;
            $offset = 0;
            $limit = 300;
            do {
                $results = DB::connection('sqlsrv')->select("
                    WITH Ranked AS (
                        SELECT
                            a.KdPosting,
                            a.Tahun,
                            a.Kd_Desa,
                            a.Kd_Keg,
                            a.Kd_Rincian,
                            rr.Nama_Obyek,
                            a.Kd_SubRinci,
                            a.No_Urut,
                            a.Uraian,
                            a.SumberDana,
                            a.JmlSatuanPAK,
                            a.Satuan,
                            a.HrgSatuanPAK,
                            a.AnggaranStlhPAK,
                            ROW_NUMBER() OVER (
                                PARTITION BY
                                    a.Tahun,
                                    a.Kd_Desa,
                                    a.Kd_Keg,
                                    a.Kd_Rincian,
                                    a.Kd_SubRinci,
                                    a.No_Urut
                                ORDER BY a.KdPosting DESC
                            ) AS rn
                        FROM Ta_Kegiatan tk
                        JOIN Ta_KegiatanOutput tko  ON tk.Kd_Keg = tko.Kd_Keg
                        JOIN Ta_Anggaran ta          ON ta.Kd_Keg = tko.Kd_Keg
                        JOIN Ref_Rek4 rr             ON rr.Obyek = ta.Kd_Rincian
                        JOIN Ta_AnggaranRinci a      ON a.Kd_Keg = ta.Kd_Keg AND ta.Kd_Rincian = a.Kd_Rincian
                    )
                    SELECT *
                    FROM Ranked
                    WHERE rn = 1
                      AND AnggaranStlhPAK > 0
                      AND Kd_Desa = ?
                    ORDER BY Kd_Keg, Kd_Rincian
                    OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
                ", [$this->kodeDesa, $offset, $limit]);

                $processedInChunk = 0;

                foreach ($results as $rincian) {
                    $paket = PaketPekerjaan::where('kd_keg', $rincian->Kd_Keg)
                        ->where('tahun', $rincian->Tahun)
                        ->where('kd_desa', $rincian->Kd_Desa)
                        ->first();

                    if (!$paket) continue;

                    $existing = PaketPekerjaanRinci::where('paket_pekerjaan_id', $paket->id)
                        ->where('kd_rincian', $rincian->Kd_Rincian)
                        ->where('kd_subrinci', $rincian->Kd_SubRinci)
                        ->where('no_urut', $rincian->No_Urut)
                        ->first();

                    if ($existing && $existing->use_st) continue;

                    $data = [
                        'paket_pekerjaan_id' => $paket->id,
                        'kd_posting' => $rincian->KdPosting,
                        'tahun' => $rincian->Tahun,
                        'kd_desa' => $rincian->Kd_Desa,
                        'kd_keg' => $rincian->Kd_Keg,
                        'kd_rincian' => $rincian->Kd_Rincian,
                        'nama_obyek' => $rincian->Nama_Obyek,
                        'kd_subrinci' => $rincian->Kd_SubRinci,
                        'no_urut' => $rincian->No_Urut,
                        'uraian' => $rincian->Uraian,
                        'sumber_dana' => $rincian->SumberDana,
                        'jml_satuan_pak' => $rincian->JmlSatuanPAK,
                        'satuan' => $rincian->Satuan,
                        'hrg_satuan_pak' => $rincian->HrgSatuanPAK,
                        'anggaran_stlh_pak' => $rincian->AnggaranStlhPAK,
                    ];

                    if ($existing) {
                        $existing->update($data);
                    } else {
                        $data['use_st'] = false;
                        PaketPekerjaanRinci::create($data);
                        $processedInChunk++;
                    }
                }

                $totalInserted += $processedInChunk;
                $chunkCount++;
                $offset += $limit;
                $this->progressMsg = "Chunk $chunkCount selesai. Data baru: $processedInChunk";
                $this->dispatch('sync-progress', ['msg' => $this->progressMsg]);

            } while (count($results) > 0);

            $this->message = "✅ Sinkronisasi selesai! Paket Kegiatan: $totalSaved, Rincian baru: $totalInserted ($chunkCount chunk)";
        } catch (\Throwable $e) {
            $this->message = '❌ ERROR: ' . $e->getMessage();
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        return view('livewire.components.sync-anggaran-rinci');
    }
}
