<?php

namespace App\Livewire\Penyedia;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarHitam extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleStatus($id)
    {
        $vendor = Vendor::findOrFail($id);

        // Toggle antara 1 dan 0
        $newStatus = $vendor->daftar_hitam ? 0 : 1;

        $vendor->update(['daftar_hitam' => $newStatus]);

        $this->dispatch('statusToggled', id: $id, status: $newStatus);
    }

    public function render()
    {
        $vendors = Vendor::with(['jenisUsaha'])
            ->where(function ($query) {
                $query->where('nama_perusahaan', 'like', "%{$this->search}%")
                    ->orWhere('nib', 'like', "%{$this->search}%");
            })
            ->where('daftar_hitam', 1)
            ->orderBy('nama_perusahaan')
            ->paginate(10);

        return view('livewire.penyedia.daftar-hitam', [
            'vendors' => $vendors
        ]);
    }
}