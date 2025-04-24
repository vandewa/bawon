<?php

namespace App\Livewire\Components;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Penawaran;
use App\Models\PaketKegiatan;
use App\Models\EvaluasiPenawaran;

class PenawaranList extends Component
{
    use WithFileUploads;

    public $penawarans;
    public $penawaranId, $baEvaluasi;
    public $isModalOpen = false;

    public function mount()
    {
        $this->penawarans = Penawaran::with('evaluasi')->get();
    }

    public function setujui($penawaranId)
    {
        $this->penawaranId = $penawaranId;
        $this->openModal();  // Open modal to upload BA Evaluasi
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanEvaluasi()
    {
        // Validate file upload
        $this->validate([
            'baEvaluasi' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Store file
        $fileName = $this->baEvaluasi->storeAs(
            'public/berita_acara',
            'ba_evaluasi_' . $this->penawaranId . '.pdf'
        );

        // Update penawaran status
        $penawaran = Penawaran::find($this->penawaranId);
        $penawaran->update(['penawaran_st' => 'PENAWARAN_ST_02']);

        // Update paket kegiatan BA Evaluasi file path
        PaketKegiatan::where('id', $penawaran->paket_kegiatan_id)
            ->update(['ba_evaluasi_penawaran' => $fileName]);

        // Update other penawarans to 'PENAWARAN_ST_03'
        Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
            ->where('id', '!=', $this->penawaranId)
            ->update(['penawaran_st' => 'PENAWARAN_ST_03']);

        // Close modal after saving
        $this->closeModal();

        // Refresh data
        $this->mount();
    }

    public function render()
    {
        return view('livewire.components.penawaran-list');
    }
}

