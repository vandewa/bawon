<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use App\Models\Penawaran;


class PenawaranPreview extends Component
{
    public $penawaranId;
    public $penawaran;

    public function mount($penawaranId)
    {
        $this->penawaranId = $penawaranId;
        // Fetch penawaran data
        $this->penawaran = Penawaran::with('vendor','evaluasi', 'statusPenawaran')->findOrFail($this->penawaranId);
    }
    public function render()
    {
        return view('livewire.desa.penawaran-preview',[
            'penawaran' => $this->penawaran,  // Pass the penawaran data to the view
        ]);
    }
}
