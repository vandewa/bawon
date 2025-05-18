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
    public $allDokPenawaranUploaded = false;

    public function mount()
{
    $total = Penawaran::where('paket_kegiatan_id', $this->paketKegiatanId)->count();
    $withDok = Penawaran::where('paket_kegiatan_id', $this->paketKegiatanId)
        ->whereNotNull('dok_penawaran')
        ->count();
    $this->allDokPenawaranUploaded = ($total > 1) && ($total == $withDok);
}


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
        $penawaran = Penawaran::with(['paketKegiatan.paketPekerjaan', 'items', 'vendor.user'])
            ->findOrFail($this->penawaranId);

        DB::beginTransaction();
        try {
            // 1. Validasi upload dokumen BA
            $this->validate([
                'baEvaluasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // 2. Set status penawaran terpilih ke "Disetujui"
            $penawaran->update(['penawaran_st' => 'PENAWARAN_ST_02']);

            // 3. Tolak penawaran lain (tidak terpilih)
            Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
                ->where('id', '!=', $penawaran->id)
                ->update([
                    'nilai' => $penawaran->jumlah_anggaran,
                    'penawaran_st' => 'PENAWARAN_ST_03'
                ]);

            // 4. Buat entri negosiasi baru
            $negosiasi = Negoisasi::create([
                'paket_kegiatan_id' => $penawaran->paket_kegiatan_id,
                'vendor_id' => $penawaran->vendor_id,
                'nilai' => $penawaran->nilai,
                'negosiasi_st' => 'NEGOSIASI_ST_01',
                'ba_negoisasi' => null,
            ]);

            // 5. Buat log negosiasi (pengajuan awal)
            $log = NegosiasiLog::create([
                'negoisasi_id' => $negosiasi->id,
                'penawaran' => $penawaran->nilai,
                'keterangan' => 'Pengajuan awal penawaran oleh vendor',
                'user_id' => ambilUserIdVendor($penawaran->vendor_id),
                'status_st' => false,
            ]);

            // 6. Log detail tiap item penawaran
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

            // 7. Notifikasi WA ke semua vendor terkait
            $this->kirimNotifikasiVendor($penawaran->paketKegiatan->id);

            // 8. Notif UI
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
    }

    /**
     * Kirim notifikasi WA ke semua vendor pada paket terkait.
     */
    protected function kirimNotifikasiVendor($paketKegiatanId)
    {
        $penawarans = Penawaran::with(['vendor', 'paketKegiatan.paketPekerjaan'])
            ->where('paket_kegiatan_id', $paketKegiatanId)
            ->get();

        foreach ($penawarans as $penawaran) {
            $vendor = $penawaran->vendor;
            if ($vendor && $vendor->telepon) {
                $namaVendor = $vendor->nama_perusahaan ?? 'Penyedia';
                $nilai = number_format($penawaran->nilai, 0, ',', '.');
                $paketPekerjaan = $penawaran->paketKegiatan->paketPekerjaan ?? null;
                $namaPaket = $paketPekerjaan->nama_kegiatan ?? 'Kegiatan Pengadaan';

                $pesan = "Yth. *{$namaVendor}*,\n\nEvaluasi penawaran telah dilakukan terkait kegiatan: *{$namaPaket}*.\n\nMohon agar dapat melakukan pengecekan melalui aplikasi.\n\nTerima kasih atas perhatian dan kerja samanya.\n\nHormat kami,\nTim Pengadaan Desa";
                $telepon = $vendor->telepon;

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
