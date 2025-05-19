<?php

namespace App\Livewire\Penyedia;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarHitam extends Component
{
    use WithPagination;

    public $search = '';
    public $idnya;

    public function confirmToggleStatus($id)
    {
        $this->idnya = $id;
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Apakah kamu ingin mengubah status daftar hitam? proses ini tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.toggleVendorStatus()
                }
            })
        JS);
    }


    public function toggleVendorStatus()
    {
        $vendor = Vendor::findOrFail($this->idnya);

        // Toggle antara 1 dan 0
        $newStatus = $vendor->daftar_hitam ? 0 : 1;

        $vendor->update(['daftar_hitam' => $newStatus]);

        $this->dispatch('statusToggled', id: $this->idnya, status: $newStatus);
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