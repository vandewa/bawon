<?php

namespace App\Livewire\Penyedia;

use App\Models\PaketPekerjaan;
use Livewire\Component;
use Livewire\WithPagination;

class PaketPekerjaanPenyediaIndex extends Component
{
    use WithPagination;

    public $cari = '';

    public function render()
    {
        $posts = PaketPekerjaan::with('desa')
            ->where('nama_kegiatan', 'like', '%' . $this->cari . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.penyedia.paket-pekerjaan-penyedia-index', compact('posts'));
    }
}
