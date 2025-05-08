<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Desa;
use App\Models\PaketPekerjaan;

class SyncPaketPekerjaan extends Command
{
    protected $signature = 'sync:paket-pekerjaan';
    protected $description = 'Sinkronisasi data dari MSSQL ke paket_pekerjaans dengan chunking';

    public function handle()
{
    $this->info('🚀 Proses sinkronisasi dimulai...');

    DB::connection('sqlsrv')->disableQueryLog();

    $query = DB::connection('sqlsrv')->table('TA_Kegiatan as o')
        ->join('Ref_Bidang as b', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 2)'), '=', 'b.Kd_Bid')
        ->join('Ref_SubBidang as c', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 6)'), '=', 'c.Kd_Sub')
        ->join('Ref_Kegiatan as d', DB::raw('SUBSTRING(CAST(o.Kd_Keg AS VARCHAR), 9, 9)'), '=', 'd.ID_Keg')
        ->select(
            'o.tahun', 'o.Kd_Desa', 'o.Kd_Keg', 'o.Sumberdana', 'o.Nama_Kegiatan',
            'o.NilaiPAK', 'o.Satuan', 'o.Pagu_PAK', 'o.Nm_PPTKD', 'o.Jbt_PPTKD',
            'b.Nama_Bidang', 'c.Nama_SubBidang'
        )
        ->orderBy('o.Kd_Desa');

    $total = $query->count();
    $this->output->progressStart($total);

    foreach ($query->cursor() as $item) {
        $desa = Desa::where('kode_desa', $item->Kd_Desa)->first();

        if (!$desa) {
            $this->warn("⚠ Desa '{$item->Kd_Desa}' tidak ditemukan. Lewat.");
            $this->output->progressAdvance();
            continue;
        }

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

        // Validasi panjang
        foreach ([
            'nama_kegiatan'  => 255,
            'nm_pptkd'       => 100,
            'jbt_pptkd'      => 100,
            'nama_bidang'    => 100,
            'nama_subbidang' => 100
        ] as $field => $max) {
            if (strlen($data[$field]) > $max) {
                $this->warn("⚠ '$field' terlalu panjang ({strlen($data[$field])} karakter) untuk kd_keg {$item->Kd_Keg}.");
            }
        }

        $existing = PaketPekerjaan::where('kd_keg', $item->Kd_Keg)
            ->where('desa_id', $desa->id)
            ->first();

        if ($existing) {
            if ($existing->paketKegiatans()->exists()) {
                $this->warn("↪ Data kd_keg {$item->Kd_Keg} sudah terhubung ke paket_kegiatans. Lewat.");
            } else {
                $existing->update($data);
                $this->info("🔁 Data kd_keg {$item->Kd_Keg} diperbarui karena belum punya paket_kegiatan.");
            }
        } else {
            $data['created_at'] = now();
            PaketPekerjaan::create($data);
            $this->info("✅ Data kd_keg {$item->Kd_Keg} berhasil disimpan.");
        }

        $this->output->progressAdvance();
    }

    $this->output->progressFinish();
    $this->info('✅ Sinkronisasi selesai tanpa duplikat, data diperbarui jika belum punya relasi ke paket kegiatan.');
}
}
