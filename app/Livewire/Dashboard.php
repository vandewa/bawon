<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use App\Models\Peralatan;
use App\Models\User;
use App\Models\Uttp;
use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {
        //
    }
    public function render()
    {

        return view('livewire.dashboard', [
            
        ]);
    }
}
