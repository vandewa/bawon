<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaketKegiatan;

class PelaporanIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $paketKegiatans = PaketKegiatan::with(['paketPekerjaan', 'negosiasi', 'statusKegiatan'])
            ->whereNotNull('surat_perjanjian') // Hanya yang sudah upload kontrak
            ->whereHas('paketPekerjaan', function($q) {
                $q->where('nama_kegiatan', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.desa.pelaporan-index', [
            'paketKegiatans' => $paketKegiatans,
        ]);
    }
}
