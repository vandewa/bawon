<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\PaketKegiatan;

class PenawaranIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $showUploadModal = false;
    public $fileSuratPerjanjian;
    public $paketIdUpload;

    protected $paginationTheme = 'bootstrap'; // Agar pagination cocok jika pakai AdminLTE/Bootstrap

    public function render()
    {
        $paketKegiatans = PaketKegiatan::with(['paketPekerjaan', 'negosiasi'])
            ->whereHas('paketPekerjaan', function($q) {
                $q->where('nama_kegiatan', 'like', '%' . $this->search . '%');
            })
            ->where('paket_kegiatan', 'PAKET_KEGIATAN_ST_02')
            ->latest()
            ->paginate(10);

        return view('livewire.desa.penawaran-index', [
            'paketKegiatans' => $paketKegiatans,
        ]);
    }

    public function openUploadModal($paketId)
    {
        $this->paketIdUpload = $paketId;
        $this->fileSuratPerjanjian = null;
        $this->showUploadModal = true;
    }

    public function uploadSuratPerjanjian()
    {
        $this->validate([
            'fileSuratPerjanjian' => 'required|file|mimes:pdf,doc,docx|max:2048', // Maks 2MB
        ]);

        $path = $this->fileSuratPerjanjian->store('paket_kegiatan/kontrak');

        PaketKegiatan::where('id', $this->paketIdUpload)->update([
            'surat_perjanjian' => $path,
        ]);

        $this->resetUploadModal();

        session()->flash('message', 'Surat Perjanjian berhasil diupload.');
    }

    public function resetUploadModal()
    {
        $this->showUploadModal = false;
        $this->fileSuratPerjanjian = null;
        $this->paketIdUpload = null;
    }
}
