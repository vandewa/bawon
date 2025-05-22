<?php

namespace App\Livewire\Desa;

use App\Models\Tpk;
use App\Models\Tim;
use App\Models\ComCode;
use Livewire\Component;
use App\Models\Aparatur;
use Livewire\WithPagination;

class TpkCreate extends Component
{
    use WithPagination;

    public $desa_id, $aparatur_id, $tpk_type, $tahun, $cari, $tim_type, $idHapus, $nama;
    public $tim_id, $tpk_id;
    public $isEdit = false;

    public function mount($id = '')
    {
        $this->tim_id = $id;
        $tim = Tim::find($this->tim_id);
        $this->desa_id = $tim->desa_id;

    }

    public function render()
    {
        $data = Tpk::with(['aparatur', 'jenis'])
            ->where('tim_id', $this->tim_id)
            ->orderBy('tpk_type', 'asc')
            ->paginate(10);

        $tim = Tim::find($this->tim_id);

        $aparatur = Aparatur::where('desa_id', $this->desa_id)->get();
        $jenis = ComCode::where('code_group', 'TPK_TYPE')->get();

        return view('livewire.desa.tpk-create', [
            'data' => $data,
            'aparaturs' => $aparatur,
            'jenis' => $jenis,
            'tim' => $tim,
        ]);
    }

    public function store()
    {
        // Custom validation untuk memastikan hanya ada satu TPK_TYPE_01 dan TPK_TYPE_02 dalam tahun yang sama
        $this->validate([
            'aparatur_id' => 'required',
            'tpk_type' => 'required',
        ]);

        Tpk::create([
            'aparatur_id' => $this->aparatur_id,
            'tpk_type' => $this->tpk_type,
            'tim_id' => $this->tim_id,
            'desa_id' => $this->desa_id,
        ]);

        session()->flash('message', 'Data TPK berhasil disimpan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $tpk = Tpk::findOrFail($id);
        $this->aparatur_id = $tpk->aparatur_id;
        $this->tpk_type = $tpk->tpk_type;
        $this->isEdit = true;
        $this->tpk_id = $id;
    }

    public function update()
    {
        // Validasi yang sama dengan store
        $this->validate([
            'aparatur_id' => 'required',
            'tpk_type' => 'required',
        ]);

        $tim = Tpk::findOrFail($this->tpk_id);
        $tim->update([
            'aparatur_id' => $this->aparatur_id,
            'tpk_type' => $this->tpk_type,
        ]);

        session()->flash('message', 'Data TPK berhasil diperbarui.');
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
        Tpk::destroy($this->idHapus);
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
        $this->aparatur_id = '';
        $this->tpk_type = '';
        $this->isEdit = false;
    }
}
