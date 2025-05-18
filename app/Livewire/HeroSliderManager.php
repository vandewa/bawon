<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\HeroSlide;

class HeroSliderManager extends Component
{
    use WithFileUploads;

    public $image;
    public $slides;

    protected $rules = [
        'image' => 'required|image|max:2048',
    ];

    public function mount()
    {
        $this->loadSlides();
    }

    public function loadSlides()
    {
        $this->slides = HeroSlide::all();
    }

    public function addSlide()
    {
        $this->validate();

        $path = $this->image->store('hero-slides', 'public');

        HeroSlide::create([
            'image' => $path,
        ]);

        $this->loadSlides();
        $this->reset(['image']); // Reset variabel Livewire
        $this->dispatch('fileInputReset'); // Kirim event ke JS untuk reset input
        session()->flash('message', 'Foto berhasil ditambahkan.');
    }

    public function deleteSlide($id)
    {
        $slide = HeroSlide::find($id);
        Storage::disk('public')->delete($slide->image);
        $slide->delete();
        $this->loadSlides();
        session()->flash('message', 'Foto berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.hero-slider-manager');
    }
}
