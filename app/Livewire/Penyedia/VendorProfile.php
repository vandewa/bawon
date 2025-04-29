<?php

namespace App\Livewire\Penyedia;

use Livewire\Component;
use App\Models\Vendor;

class VendorProfile extends Component
{
    public $vendor;

    public function mount($id = null)
    {
        if ($id) {
            $this->vendor = Vendor::findOrFail($id);
        }
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-profile');
    }
}
