<?php

namespace App\Livewire\Penyedia;

use App\Models\ComCode;
use App\Models\Tag;
use App\Models\TagVendor;
use App\Models\User;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class VendorEdit extends Component
{
    use WithFileUploads;

    public $vendorId;
    public $foto_vendor = [];
    public $foto;
    public $userExists;

    // Properties for coordinates
    public $latitude;
    public $longitude;

    public $user = [
        'id' => null,
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public $vendor = [
        'nama_perusahaan' => '',
        'nib' => '',
        'npwp' => '',
        'alamat' => '',
        'email' => '',
        'telepon' => '',
        'nama_direktur' => '',
        'jenis_usaha' => '',
        'klasifikasi' => '',
        'kualifikasi' => '',
        'provinsi' => '',
        'kabupaten' => '',
        'kode_pos' => '',
        'masa_berlaku_nib' => '',
        'instansi_pemberi_nib' => '',
        'website' => '',
        'latitude' => null,
        'longitude' => null,
        'bank_st' => '',
        'no_rekening' => '',
        'atas_nama_rekening' => '',
        'pkp' => '',
        'daftar_hitam' => '',
    ];

    // Properties for document uploads
    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur, $dok_kebenaran_usaha_file, $bukti_setor_pajak_file, $pkp_file;

    public $klasifikasiUsaha = [];

    protected $rules = [
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
        'vendor.masa_berlaku_nib' => 'nullable|date',
        'vendor.instansi_pemberi_nib' => 'nullable|string|max:255',
        'vendor.website' => 'nullable|string|max:255',
        'vendor.latitude' => 'nullable|numeric',
        'vendor.longitude' => 'nullable|numeric',
        'vendor.bank_st' => 'nullable|string|max:255',
        'vendor.no_rekening' => 'nullable|numeric',
        'vendor.atas_nama_rekening' => 'nullable|string|max:255',
        'vendor.pkp' => 'required|in:0,1',
        'vendor.daftar_hitam' => 'required|in:0,1',
        'foto_vendor.*' => 'image|max:2048',
        'akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nib_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'siup' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'izin_usaha_lain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'ktp_direktur' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'dok_kebenaran_usaha_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'bukti_setor_pajak_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pkp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048|required_if:vendor.pkp,1',
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|max:255',
        'user.password' => 'nullable|string|min:6|same:user.password_confirmation',
        'user.password_confirmation' => 'nullable|string|min:6',
    ];

    protected function messages()
    {
        return [
            'vendor.pkp.required' => 'Status PKP wajib dipilih.',
            'vendor.pkp.in' => 'Status PKP harus Ya atau Tidak.',
            'pkp_file.required_if' => 'Dokumen PKP wajib diunggah jika status PKP adalah Ya.',
            'pkp_file.mimes' => 'Dokumen PKP harus berupa PDF, JPG, JPEG, atau PNG.',
            'pkp_file.max' => 'Dokumen PKP tidak boleh lebih dari 2MB.',
        ];
    }

    public function mount($vendorId)
    {
        $this->vendorId = $vendorId;
        $vendor = Vendor::findOrFail($vendorId);
        $this->vendor = $vendor->toArray();

        // Load user data if exists
        $user = User::where('vendor_id', $vendorId)->first();
        if ($user) {
            $this->userExists = true;
            $this->user = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
            ];
        }

        // Load klasifikasi usaha
        $tagVendors = TagVendor::where('vendor_id', $vendorId)->get();
        foreach ($tagVendors as $tagVendor) {
            $klasifikasiName = Tag::find($tagVendor->tag_id)->nama ?? 'Unknown';
            $this->klasifikasiUsaha[] = [
                'nama' => $tagVendor->tag_id,
                'nama_text' => $klasifikasiName,
                'foto' => $tagVendor->photo_path,
                'long' => $tagVendor->longitude,
                'lat' => $tagVendor->latitude,
            ];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // Dynamic validation for email uniqueness
        $rules = array_merge($this->rules, [
            'user.email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user['id']),
            ],
        ]);

        // Remove password validation if not updated
        if (empty($this->user['password'])) {
            unset($rules['user.password']);
            unset($rules['user.password_confirmation']);
        }

        $this->validate($rules);

        // Update vendor record
        $vendor = Vendor::findOrFail($this->vendorId);

        // Check if pkp is changed to 0
        if ($this->vendor['pkp'] == '0' && $vendor->pkp != '0') {
            // Delete existing pkp_file from storage if it exists
            if ($vendor->pkp_file) {
                Storage::disk('public')->delete($vendor->pkp_file);
            }
            // Set pkp_file to null
            $this->vendor['pkp_file'] = null;
        }

        $vendor->update($this->vendor);

        // Process document uploads (will skip pkp_file if no new file is uploaded)
        $this->processDocumentUploads($vendor);

        // Update or create klasifikasi usaha
        if (!empty($this->klasifikasiUsaha)) {
            // Delete existing TagVendor records
            TagVendor::where('vendor_id', $vendor->id)->delete();
            foreach ($this->klasifikasiUsaha as $klasifikasi) {
                TagVendor::create([
                    'vendor_id' => $vendor->id,
                    'tag_id' => $klasifikasi['nama'],
                    'latitude' => $klasifikasi['lat'],
                    'longitude' => $klasifikasi['long'],
                    'photo_path' => $klasifikasi['foto'],
                ]);
            }
        }

        // Update or create user
        if (!empty($this->user['email'])) {
            $userData = [
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'vendor_id' => $vendor->id,
            ];
            if (!empty($this->user['password'])) {
                $userData['password'] = Hash::make($this->user['password']);
            }
            $user = User::updateOrCreate(
                ['id' => $this->user['id']],
                $userData
            );
            $user->syncRoles(['vendor']);
        }

        session()->flash('message', 'Vendor berhasil diperbarui.');
        if(auth()->user()->vendor_id) {
            return redirect()->route('penyedia.vendor-profile', auth()->user()->vendor_id);
        }
        return redirect()->route('penyedia.vendor-index');
    }

    private function processDocumentUploads($vendor)
    {
        $documentFields = [
            'akta_pendirian',
            'nib_file',
            'npwp_file',
            'siup',
            'izin_usaha_lain',
            'ktp_direktur',
            'dok_kebenaran_usaha_file',
            'bukti_setor_pajak_file',
            'pkp_file',
        ];

        foreach ($documentFields as $field) {
            if ($this->$field) {
                // Delete old file if exists
                if ($vendor->$field) {
                    Storage::disk('public')->delete($vendor->$field);
                }
                $path = $this->$field->store('vendor/dokumen', 'public');
                $vendor->$field = $path;
            }
        }

        $vendor->save();
    }

    public function simpanKlasifikasiUsaha()
    {
        $this->validate([
            'vendor.klasifikasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'nullable|image|max:2048',
        ], [
            'vendor.klasifikasi.required' => 'Klasifikasi bidang usaha harus dipilih',
            'latitude.required' => 'Lokasi (latitude) harus ditentukan',
            'longitude.required' => 'Lokasi (longitude) harus ditentukan',
            'foto.image' => 'File harus berupa gambar',
        ]);

        $foto_path = null;
        if ($this->foto) {
            $foto_path = $this->foto->store('vendor/foto', 'public');
        }

        $klasifikasiName = Tag::find($this->vendor['klasifikasi'])->nama ?? $this->vendor['klasifikasi'];

        $this->klasifikasiUsaha[] = [
            'nama' => $this->vendor['klasifikasi'],
            'nama_text' => $klasifikasiName,
            'foto' => $foto_path,
            'long' => $this->longitude,
            'lat' => $this->latitude,
        ];

        $this->resetKlasifikasi();
        $this->dispatch('render-map');
    }

    public function resetKlasifikasi()
    {
        $this->vendor['klasifikasi'] = null;
        $this->foto = null;
        $this->latitude = null;
        $this->longitude = null;
    }

    public function deleteKlasifikasi($index)
    {
        if (isset($this->klasifikasiUsaha[$index]['foto']) && $this->klasifikasiUsaha[$index]['foto']) {
            Storage::disk('public')->delete($this->klasifikasiUsaha[$index]['foto']);
        }

        unset($this->klasifikasiUsaha[$index]);
        $this->klasifikasiUsaha = array_values($this->klasifikasiUsaha);
    }

    public function getKlasifikasiName($id)
    {
        return Tag::find($id)->nama ?? 'Unknown';
    }

    public function render()
    {
        $kualifikasi = ComCode::where('code_group', 'KUALIFIKASI_ST')->get();
        $jenisUsaha = ComCode::where('code_group', 'JENIS_USAHA_ST')->get();
        $klasifikasi = Tag::all();
        $bank = ComCode::where('code_group', 'BANK_ST')->get();

        return view('livewire.penyedia.vendor-edit', [
            'listKualifikasi' => $kualifikasi,
            'listJenisUsaha' => $jenisUsaha,
            'listKlasifikasi' => $klasifikasi,
            'listBank' => $bank,
        ]);
    }
}
