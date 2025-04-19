<?php

namespace App\Livewire\Desa;

use Livewire\Component;


use App\Models\PaketPekerjaan;

class PaketKegiatanIndex extends Component
{
    public $paketPekerjaan;
    public $paketKegiatans;
    public $totalNilaiKesepakatan = 0;

    public function mount($paketPekerjaanId)
    {
        $this->paketPekerjaan = PaketPekerjaan::with('desa', 'paketKegiatans')->findOrFail($paketPekerjaanId);
        $this->paketKegiatans = $this->paketPekerjaan->paketKegiatans;

        $this->totalNilaiKesepakatan = $this->paketKegiatans->sum(function($item) {
            return $item->nilai_kesepakatan ?? 0;
        });
    }

    public function render()
    {
        return view('livewire.desa.paket-kegiatan-index');
    }
}
