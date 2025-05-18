<?php

namespace App\Livewire;

use App\Models\Berita as ModelBerita;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaEdit extends Component
{
    use WithFileUploads;

    public $form = [
        'judul' => '',
        'isi_berita' => '',
    ];

    public $file_berita;
    public $beritaId;

    protected $rules = [
        'form.judul' => 'required|string|max:255',
        'form.isi_berita' => 'required|string',
        'file_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    protected function messages()
    {
        return [
            'form.judul.required' => 'Judul berita wajib diisi.',
            'form.judul.string' => 'Judul berita harus berupa teks.',
            'form.judul.max' => 'Judul berita tidak boleh lebih dari 255 karakter.',
            'form.isi_berita.required' => 'Isi berita wajib diisi.',
            'form.isi_berita.string' => 'Isi berita harus berupa teks.',
            'file_berita.image' => 'File harus berupa gambar.',
            'file_berita.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'file_berita.max' => 'Gambar tidak boleh lebih dari 2MB.',
        ];
    }

    public function mount($id)
    {
        $berita = ModelBerita::findOrFail($id);
        $this->beritaId = $id;
        $this->form = [
            'judul' => $berita->judul,
            'isi_berita' => $berita->isi_berita,
        ];
        $this->file_berita = null;
        $this->dispatch('init-summernote');
    }

    public function updatedFileBerita()
    {
        $this->dispatch('init-summernote');
    }

    public function save()
    {
        $this->validate();

        if ($this->file_berita && !$this->file_berita->isValid()) {
            $this->addError('file_berita', 'Gambar gagal diunggah. Silakan coba lagi.');
            return;
        }

        $data = $this->form;
        $data['slug'] = Str::slug($data['judul']);

        $berita = ModelBerita::findOrFail($this->beritaId);
        if ($this->file_berita && $berita->file_berita) {
            Storage::disk('public')->delete($berita->file_berita);
        }
        if ($this->file_berita) {
            $data['file_berita'] = $this->file_berita->store('berita', 'public');
        }

        $berita->update($data);

        $redirectUrl = route('master.berita-index');
        $this->js(<<<JS
            Swal.fire({
                title: 'Berhasil!',
                text: 'Berita berhasil diperbarui!',
                icon: 'success',
            }).then(() => {
                window.location.href = '$redirectUrl';
            });
        JS);
    }

    public function render()
    {
        return view('livewire.berita-edit');
    }
}