<?php

namespace App\Livewire\Penyedia;

use App\Models\Vendor;
use App\Models\User;
use App\Models\VendorPhoto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class VendorEdit extends Component
{
    use WithFileUploads;

    public $vendorId;
    public $vendor = [];
    public $user = [];
    public $userExists = false;

    public $foto_vendor = [];
    public $single_foto;

    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur;

    public function mount($id)
    {
        $vendor = Vendor::with('photos')->findOrFail($id);
        $this->vendorId = $vendor->id;
        $this->vendor = $vendor->only([
            'nama_perusahaan', 'nib', 'npwp', 'alamat', 'email', 'telepon',
            'nama_direktur', 'jenis_usaha', 'klasifikasi', 'kualifikasi',
            'provinsi', 'kabupaten', 'kode_pos', 'rekening_perusahaan',
            'akta_pendirian', 'nib_file', 'npwp_file', 'siup', 'izin_usaha_lain',
            'ktp_direktur', 'latitude', 'longitude'
        ]);

        $this->foto_vendor = [];

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

    public function addDroppedFile($file)
    {
        $this->foto_vendor[] = $file;
    }

    public function removeFotoVendor($index)
    {
        unset($this->foto_vendor[$index]);
        $this->foto_vendor = array_values($this->foto_vendor);
    }

    public function deleteExistingPhoto($photoId)
    {
        $photo = VendorPhoto::find($photoId);
        if ($photo && $photo->vendor_id == $this->vendorId) {
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }
    }

    public function save()
    {
        $this->validate([
            'vendor.nama_perusahaan' => 'required|string|max:255',
            'vendor.nib' => 'required|string|max:100',
            'vendor.npwp' => 'nullable|string|max:100',
            'vendor.alamat' => 'required|string|max:255',
            'vendor.email' => 'nullable|email',
            'vendor.telepon' => 'nullable|string|max:20',
            'vendor.nama_direktur' => 'required|string|max:255',
            'vendor.jenis_usaha' => 'nullable|string|max:255',
            'vendor.klasifikasi' => 'nullable|string|max:255',
            'vendor.kualifikasi' => 'nullable|string|max:255',
            'vendor.provinsi' => 'nullable|string|max:100',
            'vendor.kabupaten' => 'nullable|string|max:100',
            'vendor.kode_pos' => 'nullable|string|max:10',
            'vendor.latitude' => 'nullable|numeric',
            'vendor.longitude' => 'nullable|numeric',
            'foto_vendor.*' => 'image|max:2048',
            'akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nib_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'siup' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'izin_usaha_lain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_direktur' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $vendor = Vendor::findOrFail($this->vendorId);

        foreach ([
            'akta_pendirian', 'nib_file', 'npwp_file', 'siup', 'izin_usaha_lain', 'ktp_direktur'
        ] as $field) {
            if ($this->$field) {
                $path = $this->$field->store('vendor/dokumen');
                $vendor->$field = $path;
            }
        }

        $vendor->update($this->vendor);

        if ($this->userExists) {
            $user = User::find($this->user['id']);
            $user->name = $this->user['name'];
            $user->email = $this->user['email'];
            $user->save();
        }

        if ($this->foto_vendor && is_array($this->foto_vendor)) {
            foreach ($this->foto_vendor as $foto) {
                $path = $foto->store('vendor/foto', 'public');
                VendorPhoto::create([
                    'vendor_id' => $vendor->id,
                    'photo_path' => $path,
                ]);
            }
        }

        session()->flash('message', 'Vendor berhasil diperbarui.');
        return redirect()->route('penyedia.vendor-index');
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-edit');
    }
}
