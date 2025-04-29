<?php

namespace App\Livewire\Penyedia;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class VendorEdit extends Component
{
    use WithFileUploads;

    public $vendorId;
    public $vendor = [];
    public $user = [];
    public $userExists = false;

    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur;

    public function mount($id)
    {
        $vendor = Vendor::findOrFail($id);
        $this->vendorId = $vendor->id;
        $this->vendor = $vendor->toArray();

        $user = User::where('vendor_id', $vendor->id)->first();
        if ($user) {
            $this->userExists = true;
            $this->user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        }
    }

    public function save()
    {
        $this->validate([
            'vendor.nama_perusahaan' => 'required|string',
            'vendor.nib' => 'required|string|unique:vendors,nib,' . $this->vendorId,
            'vendor.alamat' => 'required|string',
            'vendor.nama_direktur' => 'required|string',
            'user.name' => 'nullable|string',
            'user.email' => 'nullable|email',
            'user.password' => 'nullable|string|min:6|confirmed',
            'akta_pendirian' => 'nullable|file|mimes:pdf,doc,docx',
            'nib_file' => 'nullable|file|mimes:pdf,doc,docx',
            'npwp_file' => 'nullable|file|mimes:pdf,doc,docx',
            'siup' => 'nullable|file|mimes:pdf,doc,docx',
            'izin_usaha_lain' => 'nullable|file|mimes:pdf,doc,docx',
            'ktp_direktur' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $vendor = Vendor::findOrFail($this->vendorId);
        $vendor->update($this->vendor);

        foreach ([
            'akta_pendirian', 'nib_file', 'npwp_file', 'siup', 'izin_usaha_lain', 'ktp_direktur'
        ] as $field) {
            if ($this->$field) {
                $vendor->$field = $this->$field->store("dokumen/vendor/$field", 'public');
            }
        }

        $vendor->save();

        if (!empty($this->user['email'])) {
            if ($this->userExists) {
                $user = User::findOrFail($this->user['id']);
                $user->name = $this->user['name'];
                $user->email = $this->user['email'];
                if (!empty($this->user['password'])) {
                    $user->password = Hash::make($this->user['password']);
                }
                $user->save();
            } else {
                User::create([
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'password' => Hash::make($this->user['password']),
                    'vendor_id' => $this->vendorId,
                ]);
            }
        }

        session()->flash('message', 'Data Vendor dan User berhasil diperbarui.');
        return redirect()->route('penyedia.vendor-index');
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-edit');
    }
}
