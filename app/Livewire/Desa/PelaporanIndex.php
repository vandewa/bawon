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
        $user = auth()->user();

        $paketKegiatans = PaketKegiatan::with(['paketPekerjaan', 'negosiasi', 'statusKegiatan', 'paketType'])
            ->whereNotNull('surat_perjanjian') // Sudah upload Surat Perjanjian
            ->whereNotNull('spk')              // Sudah upload SPK
            ->whereHas('paketPekerjaan', function($q) use ($user) {
                $q->where('nama_kegiatan', 'like', '%' . $this->search . '%');

                // Jika user memiliki desa_id, tambahkan filter
                if (!empty($user->desa_id)) {
                    $q->where('desa_id', $user->desa_id);
                }
            })
            ->latest()
            ->paginate(10);
        return view('livewire.desa.pelaporan-index', [
            'paketKegiatans' => $paketKegiatans,
        ]);
    }
}
