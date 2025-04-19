<?php

namespace App\Livewire\Components\Paket;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class InformasiPaket extends Component
{
    public $paketPekerjaanId;
    public $paket;
    public $sisaPagu = 0;

    public function mount($paketPekerjaanId)
    {
        $this->paket = PaketPekerjaan::with(['desa', 'paketKegiatans'])->findOrFail($paketPekerjaanId);

        $totalKesepakatan = $this->paket->paketKegiatans->sum(function ($item) {
            return $item->nilai_kesepakatan ?? 0;
        });

        $this->sisaPagu = $this->paket->pagu_pak - $totalKesepakatan;
    }

    public function render()
    {
        return view('livewire.components.paket.informasi-paket');
    }
}

