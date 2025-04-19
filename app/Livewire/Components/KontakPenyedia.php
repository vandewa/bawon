<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Vendor;

class KontakPenyedia extends Component
{
    public Vendor $penyedia;

    public function render()
    {
        return view('livewire.components.kontak-penyedia');
    }
}
