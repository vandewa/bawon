<?php

namespace App\Livewire\Master;

use App\Models\Kecamatan as ModelKecamatan;
use Livewire\Component;
use Livewire\WithPagination;

class Kecamatan extends Component
{
    use WithPagination;

    public $form = [
        'nama' => '',
    ];

    public $search, $edit = false;
    public $idHapus;

    // Fungsi untuk mengambil data dan mengisi form edit
    public function getEdit($id)
    {
        $data = ModelKecamatan::find($id);
        $this->form = $data->only(['nama']);
        $this->edit = true;
        $this->idHapus = $id;
    }

    // Fungsi untuk membatalkan edit
    public function batal()
    {
        $this->edit = false;
        $this->reset();
    }

    // Fungsi untuk menyimpan data baru atau mengupdate data
    public function save()
    {

        if ($this->edit) {
            $this->storeUpdate();
        } else {
            $this->store();
        }

        // Menampilkan SweetAlert
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Good job!',
            text: 'Data berhasil disimpan!',
            icon: 'success',
        })
        JS);

        $this->reset();
    }

    // Menyimpan data baru
    public function store()
    {
        ModelKecamatan::create($this->form);
    }

    // Menghapus data tag
    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah kamu ingin menghapus data ini? Proses ini tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.hapus()
            }
        })
        JS);
    }

    // Fungsi untuk menghapus data tag setelah konfirmasi
    public function hapus()
    {
        ModelKecamatan::destroy($this->idHapus);
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Good job!',
            text: 'Kualifikasi berhasil dihapus!',
            icon: 'success',
        })
        JS);
    }

    // Fungsi untuk memperbarui data tag
    public function storeUpdate()
    {
        ModelKecamatan::find($this->idHapus)->update($this->form);
        $this->reset();
        $this->edit = false;
    }

    // Fungsi untuk render dan menampilkan data
    public function render()
    {
        $data = ModelKecamatan::when($this->search, function ($query) {
            return $query->where('nama', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.master.kecamatan', [
            'data' => $data
        ]);
    }
}
