<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use App\Models\PaketKegiatan;

class PenawaranIndex extends Component
{
    public $search = '';

    public function render()
    {
        $paketKegiatans = PaketKegiatan::with('paketPekerjaan')
            ->whereHas('paketPekerjaan', function($q) {
                $q->where('nama_kegiatan', 'like', '%' . $this->search . '%');
            })
            ->orWhere('paket_kegiatan', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.desa.penawaran-index', [
            'paketKegiatans' => $paketKegiatans
        ]);
    }
}
