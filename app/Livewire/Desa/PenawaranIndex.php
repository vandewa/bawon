<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use App\Jobs\kirimPesan;
use Livewire\WithPagination;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;

class PenawaranIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showUploadModal = false;
    public $fileSuratPerjanjian;
    public $fileSPK;
    public $paketIdUpload;
    public $idBatalStatus;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $paketKegiatans = PaketKegiatan::with(['paketPekerjaan', 'negosiasi'])
        ->whereHas('paketPekerjaan', function ($q) {
            $q->where('nama_kegiatan', 'like', '%' . $this->search . '%');
        })
        ->where('paket_kegiatan', 'PAKET_KEGIATAN_ST_02')
        ->where(function ($q) {
            $q->whereNull('surat_perjanjian')
              ->orWhereNull('spk');
        })
        ->latest();
        if(auth()->user()->desa_id){
            $paketKegiatans = $paketKegiatans->whereHas('paketPekerjaan', function ($q) {
                $q->where('desa_id', auth()->user()->desa_id);
            });
        }
        $paketKegiatans  = $paketKegiatans->paginate(10);


        return view('livewire.desa.penawaran-index', [
            'paketKegiatans' => $paketKegiatans,
        ]);
    }
    public function confirmCancelStatus($id)
        {
            $this->idBatalStatus = $id;
            $this->js(<<<'JS'
                Swal.fire({
                    title: 'Batalkan Pengadaan?',
                    text: "Pengadaan akan dibatalkan dan kembali ke tahap awal. Lanjutkan?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.cancelToSt01()
                    }
                });
            JS);
        }
        public function cancelToSt01()
        {
            $item = \App\Models\PaketKegiatan::find($this->idBatalStatus);

            if (!$item) return;

            $item->paket_kegiatan = 'PAKET_KEGIATAN_ST_01';
            $item->save();

            $this->reset('idBatalStatus');

            $this->js(<<<'JS'
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pengadaan telah dibatalkan dan kembali ke tahap awal.'
                });
            JS);
        }



    public function openUploadModal($paketId)
    {
        $this->paketIdUpload = $paketId;
        $this->fileSuratPerjanjian = null;
        $this->fileSPK = null;
        $this->showUploadModal = true;
    }

    public function uploadSuratPerjanjian()
    {
        $this->validate([
            'fileSuratPerjanjian' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'fileSPK' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = [];

        if ($this->fileSuratPerjanjian) {
            $data['surat_perjanjian'] = $this->fileSuratPerjanjian->store('paket_kegiatan/kontrak');
        }

        if ($this->fileSPK) {
            $data['spk'] = $this->fileSPK->store('paket_kegiatan/spk');
        }

        PaketKegiatan::where('id', $this->paketIdUpload)->update($data);


        $paketKegiatans = PaketKegiatan::with(['negosiasi.vendor', 'paketPekerjaan.desa'])->where('id', $this->paketIdUpload)->first();

        if ($paketKegiatans && $paketKegiatans->negosiasi && $paketKegiatans->negosiasi->vendor) {
            $vendor = $paketKegiatans->negosiasi->vendor;
            $namaVendor = $vendor->nama_perusahaan ?? '-';
            $teleponVendor = $vendor->telepon ?? null; // pastikan field telepon ada di table vendor
            $namaPaket = $paketKegiatans->paketPekerjaan->nama_kegiatan ?? '-';
            $namaDesa = $paketKegiatans->paketPekerjaan->desa->name ?? '-';


            // Pesan yang dikirim ke vendor
            $pesan = "Yth. $namaVendor,\n\nSurat Perjanjian dan SPK untuk paket *{$namaPaket}* telah di-upload. Mohon agar segera melaksanakan kegiatan sesuai ketentuan yang berlaku. Terima kasih.\n\nSalam,\nTim Pengadaan *{$namaDesa}*";

            if ($teleponVendor) {
                // Kirim pesan (gunakan job, helper, atau API yang kamu miliki)
                kirimPesan::dispatch($teleponVendor, $pesan);
            }
        }
        $this->resetUploadModal();

        session()->flash('message', 'Dokumen berhasil diupload.');
    }

    public function resetUploadModal()
    {
        $this->showUploadModal = false;
        $this->fileSuratPerjanjian = null;
        $this->fileSPK = null;
        $this->paketIdUpload = null;
    }
}
