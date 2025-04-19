<?php

namespace App\Livewire\Components\Paket;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class InformasiPaket extends Component
{
    public $paketPekerjaanId;
    public $paket;

    public function mount($paketPekerjaanId)
    {
        $this->paket = PaketPekerjaan::with('desa')->findOrFail($paketPekerjaanId);
    }
    public function render()
    {
        return view('livewire.components.paket.informasi-paket');
    }
}
