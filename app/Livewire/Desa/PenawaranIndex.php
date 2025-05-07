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
    public $fileSPK;
    public $paketIdUpload;

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
