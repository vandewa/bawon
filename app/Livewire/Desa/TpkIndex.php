<?php

namespace App\Livewire\Desa;

use App\Models\ComCode;
use App\Models\Tpk;
use App\Models\Desa;
use Livewire\Component;
use App\Models\Aparatur;
use Livewire\WithPagination;

class TpkIndex extends Component
{
    use WithPagination;

    public $desa_id, $aparatur_id, $tpk_type, $tahun, $cari;
    public $tpk_id;
    public $isEdit = false;

    public function mount($id = '')
    {
        $this->desa_id = $id;
        $this->tahun = date('Y');

    }

    public function render()
    {
        $tahunDefault = date('Y'); // Tahun sekarang
        $tpk = Tpk::with(['desa', 'aparatur', 'jenis'])
            ->when(empty($this->cari), function ($query) use ($tahunDefault) {
                // Jika $this->cari kosong, gunakan tahun ini
                $query->where('tahun', $tahunDefault);
            }, function ($query) {
                // Jika $this->cari tidak kosong, lakukan pencarian dengan $this->cari
                $query->where('tahun', 'like', '%' . $this->cari . '%');
            })
            ->where('desa_id', $this->desa_id)
            ->paginate(10);


        $aparatur = Aparatur::where('desa_id', $this->desa_id)->get();
        $jenis = ComCode::where('code_group', 'TPK_TYPE')->get();
        // Ambil daftar tahun yang ada pada tabel 'tpks' dan mengurutkannya secara descending
        $tahunList = Tpk::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get()
            ->pluck('tahun'); // Ambil hanya kolom tahun

        return view('livewire.desa.tpk-index', [
            'tpks' => $tpk,
            'aparaturs' => $aparatur,
            'jenis' => $jenis,
            'tahunList' => $tahunList,
        ]);
    }

    public function store()
    {
        // Custom validation untuk memastikan hanya ada satu TPK_TYPE_01 dan TPK_TYPE_02 dalam tahun yang sama
        $this->validate([
            'desa_id' => 'required|exists:desas,id',
            'aparatur_id' => 'required|exists:aparaturs,id',
            'tpk_type' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        // Cek apakah ada TPK_TYPE_01 atau TPK_TYPE_02 yang sudah ada dalam tahun yang sama
        if ($this->tpk_type == 'TPK_TYPE_01' || $this->tpk_type == 'TPK_TYPE_02') {
            $existingTpk = Tpk::where('tpk_type', $this->tpk_type)
                ->where('tahun', $this->tahun)
                ->where('desa_id', $this->desa_id)
                ->first();

            if ($existingTpk) {
                session()->flash('error', 'Hanya boleh ada satu Ketua atau Sekretaris dalam tahun yang sama.');
                return;
            }
        }

        Tpk::create([
            'desa_id' => $this->desa_id,
            'aparatur_id' => $this->aparatur_id,
            'tpk_type' => $this->tpk_type,
            'tahun' => $this->tahun,
        ]);

        session()->flash('message', 'Data TPK berhasil disimpan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $tpk = Tpk::findOrFail($id);
        $this->desa_id = $tpk->desa_id;
        $this->aparatur_id = $tpk->aparatur_id;
        $this->tpk_type = $tpk->tpk_type;
        $this->tahun = $tpk->tahun;
        $this->tpk_id = $id;
        $this->isEdit = true;
    }

    public function update()
    {
        // Validasi yang sama dengan store
        $this->validate([
            'desa_id' => 'required|exists:desas,id',
            'aparatur_id' => 'required|exists:aparaturs,id',
            'tpk_type' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        if ($this->tpk_type == 'TPK_TYPE_01' || $this->tpk_type == 'TPK_TYPE_02') {
            $existingTpk = Tpk::where('tpk_type', $this->tpk_type)
                ->where('tahun', $this->tahun)
                ->where('id', '!=', $this->tpk_id) // Menghindari pengecekan pada data yang sedang diupdate
                ->where('desa_id', $this->desa_id)
                ->exists();
            if ($existingTpk) {
                session()->flash('error', 'Hanya boleh ada satu Ketua atau Sekretaris dalam tahun yang sama.');
                return;
            }
        }

        $tpk = Tpk::findOrFail($this->tpk_id);
        $tpk->update([
            'desa_id' => $this->desa_id,
            'aparatur_id' => $this->aparatur_id,
            'tpk_type' => $this->tpk_type,
            'tahun' => $this->tahun,
        ]);

        session()->flash('message', 'Data TPK berhasil diperbarui.');
        $this->resetForm();
    }

    public function destroy($id)
    {
        Tpk::destroy($id);
        session()->flash('message', 'Data TPK berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->aparatur_id = '';
        $this->tpk_type = '';
        $this->isEdit = false;
    }
}
