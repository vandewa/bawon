<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Jobs\kirimPesan;
use App\Models\Negoisasi;
use App\Models\Penawaran;
use App\Models\NegosiasiLog;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use App\Models\NegosiasiLogItem;
use Illuminate\Support\Facades\DB;

class PenawaranList extends Component
{
    use WithFileUploads;

    public $penawaranId;
    public $baEvaluasi;
    public $isModalOpen = false;
    public $paketKegiatanId;
    public $isNegotiationExist = false;

    public function openModal($penawaranId)
    {
        $this->penawaranId = $penawaranId;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('baEvaluasi');
    }

    public function simpanEvaluasi()
    {
        $penawaran = Penawaran::with(['paketKegiatan', 'items', 'vendor.user'])->findOrFail($this->penawaranId);

        $paketType = $penawaran->paketKegiatan->paket_type;

        // if ($paketType == 'PAKET_TYPE_02') {
            DB::beginTransaction();
            try {
                // simpan vendor yang di pilih
                $penawaran->update(['penawaran_st' => 'PENAWARAN_ST_02']);

                      $this->validate([
                        'baEvaluasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    ]);

                    // tolak yang lainnya
                Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
                    ->where('id', '!=', $penawaran->id)
                    ->update(['nilai' => $penawaran->jumlah_anggaran, 'penawaran_st' => 'PENAWARAN_ST_03']);

                    // buat negosiasi baru
                $negosiasi = Negoisasi::create([
                    'paket_kegiatan_id' => $penawaran->paket_kegiatan_id,
                    'vendor_id' => $penawaran->vendor_id,
                    'nilai' => $penawaran->nilai,
                    'negosiasi_st' => 'NEGOSIASI_ST_01',
                    'ba_negoisasi' => null,
                ]);

                $penawaran = Penawaran::with(['paketKegiatan', 'items', 'vendor.user'])->findOrFail($this->penawaranId);


                $log = NegosiasiLog::create([
                    'negoisasi_id' => $negosiasi->id,
                    'penawaran' => $penawaran->nilai,
                    'keterangan' => 'Pengajuan awal penawaran oleh vendor',
                    'user_id' => ambilUserIdVendor($penawaran->vendor_id),
                    'status_st' => false,
                ]);

                foreach ($penawaran->items as $item) {
                    NegosiasiLogItem::create([
                        'negosiasi_log_id' => $log->id,
                        'paket_kegiatan_rinci_id' => $item->paket_kegiatan_rinci_id,
                        'penawaran' => $item->harga_satuan,
                        'catatan' => 'Penawaran awal',
                    ]);
                }

                DB::commit();
                $this->closeModal();

                $this->js(<<<'JS'
                    Swal.fire({
                        icon: 'success',
                        title: 'Disetujui!',
                        text: 'Penawaran disetujui tanpa BA. Negosiasi otomatis disetujui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                JS);
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
                report($e);
            }
            $a = Penawaran::with(['vendor', 'paketKegiatan.paketPekerjaan'])->where('paket_kegiatan_id', $penawaran->paketKegiatan->id)->get();

            // kirim pesan whatsapp
            foreach ($a as $penawaran) {
               $vendor = $penawaran->vendor ?? null;
               $namaVendor = $penawaran->vendor->nama_perusahaan ?? 'Penyedia';
               $nilai = number_format($penawaran->nilai, 0, ',', '.');
               $desa = $this->paketKegiatan->paketPekerjaan->desa ?? null;
               if ( $vendor && $vendor->telepon) {
                   $namaPaket = $penawaran->paketKegiatan->paketPekerjaan->nama_kegiatan ?? 'Kegiatan Pengadaan';

                   $pesan = "Yth. *{$namaVendor}*,\n\nEvaluasi penawaran telah dilakukan terkait kegiatan: *{$namaPaket}*.\n\nMohon agar dapat melakukan pengecekan melalui aplikasi.\n\nTerima kasih atas perhatian dan kerja samanya.\n\nHormat kami,\nTim Pengadaan Desa";

                   $telepon = $penawaran->vendor->telepon ?? '089604484626'; // fallback jika belum ada

                   kirimPesan::dispatch($telepon, $pesan);
               }
           }
    }

    public function render()
    {
        $penawarans = Penawaran::with(['vendor', 'evaluasi'])
            ->where('paket_kegiatan_id', $this->paketKegiatanId)
            ->whereNotNull('dok_penawaran')
            ->get();

        return view('livewire.components.penawaran-list', compact('penawarans'));
    }
}
