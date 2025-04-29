<?php

namespace App\Livewire\Penyedia;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;


class VendorCreate extends Component
{
    use WithFileUploads;

    public $vendor = [];
    public $user = [];

    // Tambah properti untuk upload file
    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur;

    public function save()
    {
        $this->validate([
            'vendor.nama_perusahaan' => 'required|string',
            'vendor.nib' => 'required|string|unique:vendors,nib',
            'vendor.alamat' => 'required|string',
            'vendor.nama_direktur' => 'required|string',
            'user.name' => 'required|string',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|string|min:6|confirmed',
            'akta_pendirian' => 'nullable|file|mimes:pdf,doc,docx',
            'nib_file' => 'nullable|file|mimes:pdf,doc,docx',
            'npwp_file' => 'nullable|file|mimes:pdf,doc,docx',
            'siup' => 'nullable|file|mimes:pdf,doc,docx',
            'izin_usaha_lain' => 'nullable|file|mimes:pdf,doc,docx',
            'ktp_direktur' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $vendor = Vendor::create([
            'nama_perusahaan' => $this->vendor['nama_perusahaan'],
            'nib' => $this->vendor['nib'],
            'npwp' => $this->vendor['npwp'] ?? null,
            'alamat' => $this->vendor['alamat'],
            'email' => $this->vendor['email'] ?? null,
            'telepon' => $this->vendor['telepon'] ?? null,
            'nama_direktur' => $this->vendor['nama_direktur'],
            'jenis_usaha' => $this->vendor['jenis_usaha'] ?? null,
            'klasifikasi' => $this->vendor['klasifikasi'] ?? null,
            'kualifikasi' => $this->vendor['kualifikasi'] ?? null,
            'provinsi' => $this->vendor['provinsi'] ?? null,
            'kabupaten' => $this->vendor['kabupaten'] ?? null,
            'kode_pos' => $this->vendor['kode_pos'] ?? null,
        ]);

        foreach ([
            'akta_pendirian', 'nib_file', 'npwp_file', 'siup', 'izin_usaha_lain', 'ktp_direktur'
        ] as $field) {
            if ($this->$field) {
                $vendor->$field = $this->$field->store("dokumen/vendor/$field", 'public');
            }
        }

        $vendor->save();

        User::create([
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => Hash::make($this->user['password']),
            'vendor_id' => $vendor->id,
        ]);

        session()->flash('message', 'Vendor dan User berhasil dibuat.');
        return redirect()->route('penyedia.vendor-index');
    }

    public function render()
    {
        return view('livewire.penyedia.vendor-create');
    }
}
