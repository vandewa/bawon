<?php

namespace App\Livewire;

use App\Models\Berita as ModelBerita;
use App\Models\ComCode;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BeritaCreate extends Component
{
    use WithFileUploads;
    public $photo;

    public $form = [
        'judul' => '',
        'isi_berita' => '',
        'status_berita_st' => 'STATUS_BERITA_ST_01',
    ];

    public $file_berita;

    protected $rules = [
        'form.judul' => 'required|string|max:255',
        'form.isi_berita' => 'required|string',
        'form.status_berita_st' => 'required|string',
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
            'form.status_berita_st.required' => 'Status berita wajib diisi.',
            'file_berita.image' => 'File harus berupa gambar.',
            'file_berita.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'file_berita.max' => 'Gambar tidak boleh lebih dari 2MB.',
        ];
    }

    public function mount()
    {
        $this->resetForm();
        $this->dispatch('init-summernote'); // Dispatch saat mount
    }

    public function resetForm()
    {
        $this->form = [
            'judul' => '',
            'isi_berita' => '',
            'status_berita_st' => 'STATUS_BERITA_ST_01',
        ];
        $this->file_berita = null;
        $this->resetValidation();
    }

    public function updatedFileBerita()
    {
        // Dispatch event setelah upload gambar untuk inisialisasi ulang Summernote
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
        $data['created_by'] = Auth::id();

        if ($this->file_berita) {
            $data['file_berita'] = $this->file_berita->store('berita', 'public');
        }

        ModelBerita::create($data);

        // Generate URL untuk route master.berita-index
        $redirectUrl = route('master.berita-index');

        $this->js(<<<JS
        Swal.fire({
            title: 'Berhasil!',
            text: 'Berita berhasil disimpan!',
            icon: 'success',
        }).then(() => {
            window.location.href = '$redirectUrl';
        });
    JS);

        $this->resetForm();
        $this->dispatch('init-summernote');
    }

    public function render()
    {
        return view('livewire.berita-create', [
        ]);
    }
}