<?php

namespace App\Livewire\Component;

use App\Livewire\Master\Tag;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ModalKualifikasi extends Component
{
    use WithPagination;
    public $search;
    public $modal = false;
    public $hasil;

    public function pilih($id)
    {
        $this->dispatch('pilih-klasifikasi', $id);
        $this->showModal();
    }

    #[On('show-modal-obat')]
    public function showModal()
    {
        $this->modal = !$this->modal;
        $this->search = null;
        $this->dispatch('autofocus', id: 'search-klasifikasi');

    }

    public function render()
    {
        $data = Tag::with(['satuan'])
            ->cari($this->search)
            ->paginate(7);

        return view('livewire.component.modal-kualifikasi', [
            'posts' => $data
        ]);
    }
}
