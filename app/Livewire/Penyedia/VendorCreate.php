<?php

namespace App\Livewire\Penyedia;

use App\Models\User;
use App\Models\Vendor;
use Livewire\Component;
use App\Models\VendorPhoto;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithTemporaryFiles;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;


class VendorCreate extends Component
{
    use WithFileUploads;

    public $foto_vendor = [];
    public $single_foto;

    public $userExists;



    public $user = [];

    public $vendor = [
        'latitude' => null,
        'longitude' => null,
    ];

    // Tambah properti untuk upload file
    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur;

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
        'user.name' => 'required|string|max:255',
    'user.email' => [
        'required',
        'email',
        'max:255',
        Rule::unique('users', 'email')->ignore($this->user['id'] ?? null),
    ],
    'user.password' => $this->userExists
        ? 'nullable|string|min:6' // update → boleh kosong
        : 'required|string|min:6', // create → wajib diisi
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

    // ✅ Tambahkan atau update user
    if (!empty($this->user['email'])) {
        if ($this->userExists) {
            // Update user yang sudah ada
            $user = User::findOrFail($this->user['id']);
            $user->name = $this->user['name'];
            $user->email = $this->user['email'];

            if (!empty($this->user['password'])) {
                $user->password = Hash::make($this->user['password']);
            }

            $user->save();
        } else {
            // Buat user baru
            $user = User::create([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'password' => Hash::make($this->user['password'] ?? 'password123'), // fallback jika password tidak diisi
                'vendor_id' => $vendor->id,
            ]);

            $user->syncRoles(['vendor']);
        }
    }

    // Simpan foto vendor
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


    public function updatedSingleFoto()
    {
        if ($this->single_foto) {
            $this->validateOnly('single_foto', [
                'single_foto' => 'image|max:2048',
            ]);

            $this->foto_vendor[] = $this->single_foto;
            $this->single_foto = null;
        }
    }

    public function removeFotoVendor($index)
    {
        unset($this->foto_vendor[$index]);
        $this->foto_vendor = array_values($this->foto_vendor);
    }

    // Untuk drag & drop manual
    public function addDroppedFile($file)
    {
        $this->validate([
            'file' => 'image|max:2048',
        ]);

        $this->foto_vendor[] = $file;
    }

    #[On('setCoordinate')]
    public function setCoordinate($lat, $lng)
    {

        $this->vendor['latitude'] = $lat;
        $this->vendor['longitude'] = $lng;
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-create');
    }
}
