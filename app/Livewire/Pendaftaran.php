<?php

namespace App\Livewire;

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

class Pendaftaran extends Component
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
        'pkp' => '',
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
        'vendor.masa_berlaku_nib' => 'required|date',
        'vendor.instansi_pemberi_nib' => 'nullable|string|max:255',
        'vendor.website' => 'nullable|string|max:255',
        'vendor.latitude' => 'nullable|numeric',
        'vendor.longitude' => 'nullable|numeric',
        'vendor.bank_st' => 'nullable|string|max:255',
        'vendor.no_rekening' => 'nullable|numeric',
        'vendor.atas_nama_rekening' => 'nullable|string|max:255',
        'vendor.pkp' => 'required|in:0,1', // PKP is required and must be 0 or 1
        'foto_vendor.*' => 'image|max:2048',
        'akta_pendirian' => 'nullable|file|mimes:pdf|max:2048',
        'nib_file' => 'nullable|file|mimes:pdf|max:2048',
        'npwp_file' => 'nullable|file|mimes:pdf|max:2048',
        'siup' => 'nullable|file|mimes:pdf|max:2048',
        'izin_usaha_lain' => 'nullable|file|mimes:pdf|max:2048',
        'ktp_direktur' => 'nullable|file|mimes:pdf|max:2048',
        'dok_kebenaran_usaha_file' => 'nullable|file|mimes:pdf|max:2048',
        'bukti_setor_pajak_file' => 'nullable|file|mimes:pdf|max:2048',
        'pkp_file' => 'nullable|file|mimes:pdf|max:2048|required_if:vendor.pkp,1', // Required if vendor.pkp is 1
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|max:255',
        'user.password' => 'required|string|min:6|same:user.password_confirmation',
        'user.password_confirmation' => 'required|string|min:6',
    ];

    public function messages()
    {
        return [
            // Validasi Vendor
            'vendor.nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'vendor.nama_perusahaan.max' => 'Nama perusahaan tidak boleh lebih dari 255 karakter.',

            'vendor.nib.required' => 'NIB wajib diisi.',
            'vendor.nib.max' => 'NIB tidak boleh lebih dari 100 karakter.',

            'vendor.alamat.required' => 'Alamat wajib diisi.',
            'vendor.alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',

            'vendor.email.email' => 'Email harus berupa alamat email yang valid.',

            'vendor.nama_direktur.required' => 'Nama direktur wajib diisi.',
            'vendor.nama_direktur.max' => 'Nama direktur tidak boleh lebih dari 255 karakter.',

            'vendor.masa_berlaku_nib.required' => 'Masa berlaku NIB wajib diisi.',
            'vendor.masa_berlaku_nib.date' => 'Tanggal masa berlaku NIB tidak valid.',

            'vendor.pkp.required' => 'Status PKP wajib dipilih.',
            'vendor.pkp.in' => 'Status PKP harus bernilai Ya (1) atau Tidak (0).',

            // Upload file
            'foto_vendor.*.image' => 'Foto vendor harus berupa gambar (JPG, JPEG, PNG).',
            'foto_vendor.*.max' => 'Ukuran foto vendor tidak boleh melebihi 2MB.',

            'akta_pendirian.file' => 'Dokumen Akta Pendirian harus berupa file.',
            'akta_pendirian.mimes' => 'Akta pendirian harus berupa file PDF.',
            'akta_pendirian.max' => 'Ukuran akta pendirian tidak boleh melebihi 2MB.',

            'nib_file.mimes' => 'File NIB harus berupa file PDF.',
            'nib_file.max' => 'Ukuran file NIB tidak boleh melebihi 2MB.',

            'npwp_file.mimes' => 'File NPWP harus berupa file PDF.',
            'npwp_file.max' => 'Ukuran file NPWP tidak boleh melebihi 2MB.',

            'siup.mimes' => 'SIUP harus berupa file PDF.',
            'siup.max' => 'Ukuran SIUP tidak boleh melebihi 2MB.',

            'izin_usaha_lain.mimes' => 'Izin usaha lain harus berupa file PDF.',
            'izin_usaha_lain.max' => 'Ukuran izin usaha lain tidak boleh melebihi 2MB.',

            'ktp_direktur.mimes' => 'File KTP direktur harus berupa file PDF.',
            'ktp_direktur.max' => 'Ukuran file KTP direktur tidak boleh melebihi 2MB.',

            'dok_kebenaran_usaha_file.mimes' => 'Dokumen kebenaran usaha harus berupa file PDF.',
            'dok_kebenaran_usaha_file.max' => 'Ukuran dokumen kebenaran usaha tidak boleh melebihi 2MB.',

            'bukti_setor_pajak_file.mimes' => 'Bukti setor pajak harus berupa file PDF.',
            'bukti_setor_pajak_file.max' => 'Ukuran bukti setor pajak tidak boleh melebihi 2MB.',

            'pkp_file.required_if' => 'File PKP wajib diunggah jika status PKP adalah Ya.',
            'pkp_file.mimes' => 'File PKP harus berupa file PDF.',
            'pkp_file.max' => 'Ukuran file PKP tidak boleh melebihi 2MB.',

            // User
            'user.name.required' => 'Nama pengguna wajib diisi.',
            'user.name.max' => 'Nama pengguna tidak boleh lebih dari 255 karakter.',

            'user.email.required' => 'Email pengguna wajib diisi.',
            'user.email.email' => 'Email harus berupa alamat email yang valid.',
            'user.email.max' => 'Email tidak boleh lebih dari 255 karakter.',

            'user.password.required' => 'Password wajib diisi.',
            'user.password.min' => 'Password minimal terdiri dari 6 karakter.',
            'user.password.same' => 'Password dan konfirmasi password harus sama.',

            'user.password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'user.password_confirmation.min' => 'Konfirmasi password minimal terdiri dari 6 karakter.',
        ];
    }

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
        return redirect()->route('login');
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

        return view('livewire.pendaftaran', [
            'listKualifikasi' => $kualifikasi,
            'listJenisUsaha' => $jenisUsaha,
            'listKlasifikasi' => $klasifikasi,
            'listBank' => $bank,
        ])->layout('layouts.pendaftaran-page');
    }
}