<?php

namespace App\Livewire\Penyedia;

use App\Models\PaketKegiatan;
use Livewire\Component;
use App\Models\Penawaran;
use Livewire\WithPagination;
use Auth;

class LelangIndex extends Component
{
    use WithPagination;

    public $cari = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $posts = PaketKegiatan::with(['paketPekerjaan.desa'])
            ->where('paket_type', 'PAKET_TYPE_03')
            ->latest()
            ->paginate(10);

        return view('livewire.penyedia.lelang-index', compact('posts'));
    }
}
