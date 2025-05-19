<?php

namespace App\Livewire\Penyedia;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Vendor;

class VendorIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $vendorId;
    public $idHapus;

    public $nama_perusahaan, $nib, $npwp, $alamat, $email, $telepon;
    public $nama_direktur, $jenis_usaha, $klasifikasi, $kualifikasi;
    public $provinsi, $kabupaten, $kode_pos;
    public $akta_pendirian, $nib_file, $npwp_file, $siup, $izin_usaha_lain, $ktp_direktur, $rekening_perusahaan;

    public function render()
    {
        $vendors = Vendor::with(['jenisUsaha'])
            ->where(function ($query) {
                $query->where('nama_perusahaan', 'like', "%{$this->search}%")
                    ->orWhere('nib', 'like', "%{$this->search}%");
            })
            ->where('daftar_hitam', 0)
            ->orderBy('nama_perusahaan')
            ->paginate(10);

        return view('livewire.penyedia.vendor-index', compact('vendors'));
    }

    public function showDetail($id)
    {
        $this->vendorId = $id;
        $this->isEdit = false;
        $this->showModal = true;
        $vendor = \App\Models\Vendor::findOrFail($id);
        $this->fill($vendor->toArray());
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $this->vendorId = $vendor->id;
        $this->fill($vendor->toArray());
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nama_perusahaan' => 'required|string',
            'nib' => 'required|unique:vendors,nib,' . $this->vendorId,
            'alamat' => 'required',
            'nama_direktur' => 'required',
            'akta_pendirian' => 'nullable|file|mimes:pdf,doc,docx',
            'nib_file' => 'nullable|file|mimes:pdf,doc,docx',
            'npwp_file' => 'nullable|file|mimes:pdf,doc,docx',
            'siup' => 'nullable|file|mimes:pdf,doc,docx',
            'izin_usaha_lain' => 'nullable|file|mimes:pdf,doc,docx',
            'ktp_direktur' => 'nullable|file|mimes:pdf,doc,docx',
            'rekening_perusahaan' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data = $this->only([
            'nama_perusahaan',
            'nib',
            'npwp',
            'alamat',
            'email',
            'telepon',
            'nama_direktur',
            'jenis_usaha',
            'klasifikasi',
            'kualifikasi',
            'provinsi',
            'kabupaten',
            'kode_pos'
        ]);

        $vendor = Vendor::updateOrCreate(['id' => $this->vendorId], $data);

        foreach (['akta_pendirian', 'nib_file', 'npwp_file', 'siup', 'izin_usaha_lain', 'ktp_direktur', 'rekening_perusahaan'] as $field) {
            if ($this->$field) {
                $vendor->$field = $this->$field->store("dokumen/vendor/$field");
            }
        }

        $vendor->save();
        $this->resetForm();
        session()->flash('message', 'Data vendor berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Apakah kamu ingin menghapus data ini? proses ini tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.hapus()
                }
            })
        JS);
    }

    public function hapus()
    {
        Vendor::destroy($this->idHapus);
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data vendor berhasil dihapus.',
                icon: 'success'
            })
        JS);
        session()->flash('message', 'Data vendor berhasil dihapus.');
    }

    public function daftarHitam($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Apakah kamu ingin menambahkan ke daftar hitam? proses ini tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.aksiDaftarHitam()
                }
            })
        JS);
    }

    public function aksiDaftarHitam()
    {
        Vendor::find($this->idHapus)->update([
            'daftar_hitam' => '1'
        ]);

        $this->js(<<<'JS'
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data dimasukkan ke daftar hitam.',
                icon: 'success'
            })
        JS);
        session()->flash('message', 'Data vendor berhasil diupdate.');
    }

    public function resetForm()
    {
        $this->reset([
            'vendorId',
            'nama_perusahaan',
            'nib',
            'npwp',
            'alamat',
            'email',
            'telepon',
            'nama_direktur',
            'jenis_usaha',
            'klasifikasi',
            'kualifikasi',
            'provinsi',
            'kabupaten',
            'kode_pos',
            'akta_pendirian',
            'nib_file',
            'npwp_file',
            'siup',
            'izin_usaha_lain',
            'ktp_direktur',
            'rekening_perusahaan',
            'isEdit',
            'showModal',
            'idHapus'
        ]);
    }
}
