<?php

namespace App\Livewire\Penyedia;

use Livewire\Component;
use App\Models\Penawaran;
use Livewire\WithPagination;
use Auth;

class PaketPekerjaanPenyediaIndex extends Component
{
    use WithPagination;

    public $cari = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $posts = Penawaran::with([
            'paketKegiatan.paketPekerjaan.desa',
            'paketKegiatan.paketType', // tambahkan ini
            'statusPenawaran'
        ])
            ->where('kirim_st', true)
            ->whereHas('paketKegiatan.paketPekerjaan', function ($query) {
                $query->where('nama_kegiatan', 'like', '%' . $this->cari . '%');
            })
            ->whereHas('paketKegiatan', function ($query) {
                // Menambahkan kondisi untuk filter paket_type = PAKET_TYPE_01
                $query->where('paket_type', 'PAKET_TYPE_01');
            });

        if (Auth::user()->vendor_id) {
            $posts->where('vendor_id', Auth::user()->vendor_id);
        }

        $posts = $posts->latest()->paginate(10);

        return view('livewire.penyedia.paket-pekerjaan-penyedia-index', compact('posts'));
    }
}
