<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PaketPekerjaan;

class TahunKegiatanSelect extends Component
{
    public $tahunList = [];
    public $selectedTahun;

    public function mount()
    {
       $this->tahunList = PaketPekerjaan::query()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();

        $this->selectedTahun = session('tahun_kegiatan', $this->tahunList[0] ?? date('Y'));

    }

    public function updatedSelectedTahun($value)
    {
        session(['tahun_kegiatan' => $value]);
        // Reload halaman
        $this->redirect(request()->header('Referer') ?? url()->current());
    }

    public function render()
    {
        return view('livewire.components.tahun-kegiatan-select');
    }
}
