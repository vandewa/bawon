<?php

namespace App\Livewire\Penyedia;

use Livewire\Component;
use App\Models\Penawaran;
use Livewire\WithPagination;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;

class PaketPekerjaanPenyediaIndex extends Component
{
    use WithPagination;

    public $cari = '';

    public function render()
    {
        $posts = Penawaran::with('paketKegiatan.paketPekerjaan.desa')
        // ->where('vendor_id', Auth::id())
        ->whereHas('paketKegiatan.paketPekerjaan', function ($query) {
            $query->where('nama_kegiatan', 'like', '%' . $this->cari . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.penyedia.paket-pekerjaan-penyedia-index', compact('posts'));
    }
}
