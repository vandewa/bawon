<?php

namespace App\Livewire\Component\Paket;

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
        return view('livewire.component.paket.informasi-paket');
    }
}
