<?php

namespace App\Livewire;

use App\Models\Berita as ModelBerita;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class BeritaIndex extends Component
{
    use WithPagination;

    public $search;
    public $deleteId;

    public function delete($id)
    {
        $this->deleteId = $id;
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Berita akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.hapus();
            }
        });
        JS);
    }

    public function hapus()
    {
        $berita = ModelBerita::find($this->deleteId);
        if ($berita && $berita->file_berita) {
            Storage::disk('public')->delete($berita->file_berita);
        }
        $berita->delete();
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Berita berhasil dihapus!',
            icon: 'success',
        });
        JS);
    }

    public function toggleStatus($id)
    {
        $berita = ModelBerita::findOrFail($id);
        $newStatus = $berita->status_berita_st === 'STATUS_BERITA_ST_01'
            ? 'STATUS_BERITA_ST_02'
            : 'STATUS_BERITA_ST_01';

        $berita->update(['status_berita_st' => $newStatus]);

        $this->dispatch('statusToggled', id: $id, status: $newStatus);
    }

    public function render()
    {
        $data = ModelBerita::with(['status', 'creator'])
            ->when($this->search, function ($query) {
                return $query->where('judul', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.berita-index', [
            'data' => $data,
        ]);
    }
}