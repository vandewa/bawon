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

class VendorCreate extends Component
{
    use WithFileUploads;

    public $foto_vendor = [];
    public $foto;
    public $userExists;

    // Properties for coordinates - accessible directly in view
    public $latitude;
    public $longitude;

    public $user = [
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

    ];

    // Properties for document uploads
    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur, $dok_kebenaran_usaha_file, $bukti_setor_pajak_file;

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
        'foto_vendor.*' => 'image|max:2048',
        'akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nib_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'siup' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'izin_usaha_lain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'ktp_direktur' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'dok_kebenaran_usaha_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'bukti_setor_pajak_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|max:255',
        'user.password' => 'required|string|min:6|same:user.password_confirmation',
        'user.password_confirmation' => 'required|string|min:6',
    ];

    public function mount()
    {
        // Initialize any default values here
    }

    public function updated($propertyName)
    {
        // Validate specific fields when they're updated
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // Dynamic validation rules based on userExists status
        $passwordRules = $this->userExists
            ? ['user.password' => 'nullable|string|min:6|same:user.password_confirmation']
            : ['user.password' => 'required|string|min:6|same:user.password_confirmation'];

        // Merge validation rules
        $rules = array_merge($this->rules, $passwordRules);

        // Remove user.password_confirmation from validation
        unset($rules['user.password_confirmation']);

        // Add Rule::unique for email
        $rules['user.email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($this->user['id'] ?? null),
        ];

        $this->validate($rules);

        // Copy coordinates from component properties to vendor array
        // $this->vendor['latitude'] = $this->latitude;
        // $this->vendor['longitude'] = $this->longitude;

        // Create vendor record
        $vendor = Vendor::create($this->vendor);

        // Add klasifikasiUsaha to vendor if available
        if (!empty($this->klasifikasiUsaha)) {
            $this->vendor['klasifikasi_usaha'] = json_encode($this->klasifikasiUsaha);

            // Corrected TagVendor creation:
            foreach ($this->klasifikasiUsaha as $klasifikasi) {
                TagVendor::create([
                    'vendor_id' => $vendor->id, // This should refer to the created vendor ID
                    'tag_id' => $klasifikasi['nama'],
                    'latitude' => $klasifikasi['lat'],
                    'longitude' => $klasifikasi['long'],
                    'photo_path' => $klasifikasi['foto'],
                ]);
            }
        }

        // Upload and save documents
        $this->processDocumentUploads($vendor);

        // Create user account if provided
        if (!empty($this->user['email'])) {
            $user = User::create([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'password' => Hash::make($this->user['password']),
                'vendor_id' => $vendor->id,
            ]);

            $user->syncRoles(['vendor']);
        }

        session()->flash('message', 'Vendor berhasil ditambahkan.');
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
        ];

        foreach ($documentFields as $field) {
            if ($this->$field) {
                $path = $this->$field->store('vendor/dokumen', 'public');
                $vendor->$field = $path;
            }
        }

        $vendor->save();
    }

    public function simpanKlasifikasiUsaha()
    {
        // Validate input for klasifikasi fields
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

        // Get klasifikasi name from Tag model
        $klasifikasiName = Tag::find($this->vendor['klasifikasi'])->nama ?? $this->vendor['klasifikasi'];

        $isian = [
            'nama' => $this->vendor['klasifikasi'],
            'nama_text' => $klasifikasiName,
            'foto' => $foto_path,
            'long' => $this->longitude,
            'lat' => $this->latitude,
        ];

        // Save klasifikasi usaha data
        array_push($this->klasifikasiUsaha, $isian);
        $this->resetKlasifikasi();

        // Emit event to re-render map
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
        // Delete stored file if exists
        if (isset($this->klasifikasiUsaha[$index]['foto']) && $this->klasifikasiUsaha[$index]['foto']) {
            Storage::disk('public')->delete($this->klasifikasiUsaha[$index]['foto']);
        }

        unset($this->klasifikasiUsaha[$index]);
        $this->klasifikasiUsaha = array_values($this->klasifikasiUsaha); // Re-index array
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

        return view('livewire.penyedia.vendor-create', [
            'listKualifikasi' => $kualifikasi,
            'listJenisUsaha' => $jenisUsaha,
            'listKlasifikasi' => $klasifikasi,
            'listBank' => $bank,
        ]);
    }
}