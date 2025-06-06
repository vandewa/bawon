<?php

namespace App\Livewire\Desa;

use App\Models\ComCode;
use App\Models\Tpk;
use App\Models\Desa;
use Livewire\Component;
use App\Models\Aparatur;
use App\Models\Tim;
use Livewire\WithPagination;

class TpkIndex extends Component
{
    use WithPagination;

    public $desa_id, $aparatur_id, $tpk_type, $tahun, $cari, $tim_type, $idHapus, $nama;
    public $tim_id;
    public $isEdit = false;

    public function mount($id = '')
    {
        $this->desa_id = $id;
        $this->tahun = date('Y');
    }

    public function render()
    {
        $tim = Tim::paginate(10);

        $aparatur = Aparatur::where('desa_id', $this->desa_id)->get();
        $jenis = ComCode::where('code_group', 'TPK_TYPE')->get();

        // Ambil daftar tahun yang ada pada tabel 'tpks' dan mengurutkannya secara descending
        $tahunList = Tim::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get()
            ->pluck('tahun');

        return view('livewire.desa.tpk-index', [
            'tim' => $tim,
            'aparaturs' => $aparatur,
            'jenis' => $jenis,
            'tahunList' => $tahunList,
        ]);
    }

    public function store()
    {
        // Custom validation untuk memastikan hanya ada satu TPK_TYPE_01 dan TPK_TYPE_02 dalam tahun yang sama
        $this->validate([
            'tahun' => 'required',
            'nama' => 'required',
        ]);

        Tim::create([
            'desa_id' => $this->desa_id,
            'nama' => $this->nama,
            'tahun' => $this->tahun,
        ]);

        session()->flash('message', 'Data Tim berhasil disimpan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $tim = Tim::findOrFail($id);
        $this->desa_id = $tim->desa_id;
        $this->nama = $tim->nama;
        $this->tahun = $tim->tahun;
        $this->isEdit = true;
        $this->tim_id = $id;
    }

    public function update()
    {
        // Validasi yang sama dengan store
        $this->validate([
            'tahun' => 'required',
            'nama' => 'required',
        ]);

        $tim = Tim::findOrFail($this->tim_id);
        $tim->update([
            'nama' => $this->nama,
            'tahun' => $this->tahun,
        ]);

        session()->flash('message', 'Data Tim berhasil diperbarui.');
        $this->resetForm();
    }

    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Apakah Anda yakin?',
                text: "Apakah kamu ingin menghapus data ini? proses ini tidak dapat dikembalikan.",
                type: 'warning',
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
        Tim::destroy($this->idHapus);
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Good job!',
            text: 'You clicked the button!',
            icon: 'success',
          })
        JS);
    }

    public function resetForm()
    {
        $this->nama = '';
        $this->isEdit = false;
    }
}
