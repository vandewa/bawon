<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use App\Models\Aparatur;
use App\Models\Desa;
use Livewire\WithPagination;

class AparaturIndex extends Component
{
    use WithPagination;

    public $nama, $nik, $jabatan, $bidang, $alamat, $telp,
    $tempat_lahir, $tanggal_lahir, $tmt_awal, $tmt_akhir, $desa_id;
    public $aparat_id;
    public $isEdit = false;
    protected $rules = [
        'desa_id' => 'required',
        'nama' => 'required|string',
        'nik' => 'required|string',
        'jabatan' => 'required|string',
        'bidang' => 'required|string',
        'alamat' => 'required|string',
        'telp' => 'nullable|string',
        'tempat_lahir' => 'nullable|string',
        'tanggal_lahir' => 'nullable|date',
        'tmt_awal' => 'nullable|date|before_or_equal:tmt_akhir',
        'tmt_akhir' => 'nullable|date|after_or_equal:tmt_awal',
    ];

    protected $messages = [
        'desa_id.required' => 'Desa wajib dipilih.',
        'nama.required' => 'Nama wajib diisi.',
        'nik.required' => 'NIK wajib diisi.',
        'nik.string' => 'NIK harus berupa teks.',
        'jabatan.required' => 'Jabatan wajib diisi.',
        'jabatan.string' => 'Jabatan harus berupa teks.',
        'bidang.required' => 'Bidang wajib diisi.',
        'bidang.string' => 'Bidang harus berupa teks.',
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.string' => 'Alamat harus berupa teks.',
        'telp.string' => 'Nomor telepon harus berupa teks.',
        'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
        'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
        'tmt_awal.date' => 'Tanggal mulai tugas harus berupa tanggal yang valid.',
        'tmt_awal.before_or_equal' => 'Tanggal mulai tugas tidak boleh setelah tanggal akhir.',
        'tmt_akhir.date' => 'Tanggal akhir tugas harus berupa tanggal yang valid.',
        'tmt_akhir.after_or_equal' => 'Tanggal akhir tugas tidak boleh sebelum tanggal mulai.',
    ];

    public function mount($id = '')
    {
        $this->desa_id = $id;
    }

    public function render()
    {
        $data = Aparatur::with('desa')->where('desa_id', $this->desa_id)->orderBy('id', 'desc')->paginate(10);

        return view('livewire.desa.aparatur-index', [
            'lists' => $data
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'nama',
            'nik',
            'jabatan',
            'bidang',
            'alamat',
            'telp',
            'tempat_lahir',
            'tanggal_lahir',
            'tmt_awal',
            'tmt_akhir',
            'aparat_id'
        ]);
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        Aparatur::create($this->only(array_keys($this->rules)));
        session()->flash('message', 'Data berhasil disimpan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $aparat = Aparatur::findOrFail($id);
        $this->fill($aparat->toArray());
        $this->aparat_id = $id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        Aparatur::findOrFail($this->aparat_id)->update($this->only(array_keys($this->rules)));
        session()->flash('message', 'Data berhasil diperbarui.');
        $this->resetForm();
    }

    public function destroy($id)
    {
        Aparatur::destroy($id);
        session()->flash('message', 'Data berhasil dihapus.');
    }
}