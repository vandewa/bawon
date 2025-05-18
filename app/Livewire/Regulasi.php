<?php

namespace App\Livewire;

use App\Models\Regulasi as ModelRegulasi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Regulasi extends Component
{
    use WithPagination, WithFileUploads;

    public $form = [
        'nama' => '',
    ];

    public $file;
    public $search, $edit = false;
    public $idHapus;

    protected $rules = [
        'form.nama' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:pdf|max:2048',
    ];

    protected function messages()
    {
        return [
            'form.nama.required' => 'Nama regulasi wajib diisi.',
            'form.nama.string' => 'Nama regulasi harus berupa teks.',
            'form.nama.max' => 'Nama regulasi tidak boleh lebih dari 255 karakter.',
            'file.file' => 'Dokumen harus berupa file.',
            'file.mimes' => 'Dokumen harus berupa PDF.',
            'file.max' => 'Dokumen tidak boleh lebih dari 2MB.',
        ];
    }

    public function getEdit($id)
    {
        $data = ModelRegulasi::find($id);
        $this->form = $data->only(['nama']);
        $this->edit = true;
        $this->idHapus = $id;
        $this->file = null; // Reset file input
    }

    public function batal()
    {
        $this->edit = false;
        $this->reset(['form', 'file', 'idHapus']);
    }

    public function save()
    {
        $this->validate();

        if ($this->edit) {
            $this->storeUpdate();
        } else {
            $this->store();
        }

        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data regulasi berhasil disimpan!',
            icon: 'success',
        })
        JS);

        $this->reset(['form', 'file', 'edit', 'idHapus']);
    }

    public function store()
    {
        $data = $this->form;

        if ($this->file) {
            $data['file_path'] = $this->file->store('regulasi', 'public');
        }

        ModelRegulasi::create($data);
    }

    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data regulasi akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.hapus()
            }
        })
        JS);
    }

    public function hapus()
    {
        $regulasi = ModelRegulasi::find($this->idHapus);
        if ($regulasi && $regulasi->file_path) {
            Storage::disk('public')->delete($regulasi->file_path);
        }
        $regulasi->delete();

        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data regulasi berhasil dihapus!',
            icon: 'success',
        })
        JS);
    }

    public function storeUpdate()
    {
        $regulasi = ModelRegulasi::find($this->idHapus);
        $data = $this->form;

        if ($this->file) {
            // Delete old file if exists
            if ($regulasi->file_path) {
                Storage::disk('public')->delete($regulasi->file_path);
            }
            $data['file_path'] = $this->file->store('regulasi', 'public');
        }

        $regulasi->update($data);
        $this->reset(['form', 'file', 'edit', 'idHapus']);
    }

    public function render()
    {
        $data = ModelRegulasi::when($this->search, function ($query) {
            return $query->where('nama', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.regulasi', [
            'data' => $data,
        ]);
    }
}