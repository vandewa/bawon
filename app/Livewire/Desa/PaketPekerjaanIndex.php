<?php

namespace App\Livewire\Desa;

use App\Models\PaketPekerjaan;
use App\Models\Desa;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PaketPekerjaanIndex extends Component
{
    use WithPagination;

    public $cari = '';
    public $idHapus;
    public $showModal = false;
    public $isEdit = false;

    public $paketId, $desa_id, $nama_kegiatan, $tahun, $sumberdana;

    public function render()
    {
        $posts = PaketPekerjaan::with('desa');
        if(auth()->user()->desa_id){
            $posts->where('desa_id', auth()->user()->desa_id);
        }

        $posts->where('nama_kegiatan', 'like', '%' . $this->cari . '%')
        ->latest();
        $posts=  $posts->paginate(10);

        $desas = Desa::all();

        return view('livewire.desa.paket-pekerjaan-index',  compact('posts', 'desas'));
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $paket = PaketPekerjaan::findOrFail($id);
        $this->paketId = $paket->id;
        $this->desa_id = $paket->desa_id;
        $this->tahun = $paket->tahun;
        $this->nama_kegiatan = $paket->nama_kegiatan;
        $this->sumberdana = $paket->sumberdana;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'desa_id' => 'required',
            'tahun' => 'required|numeric',
            'nama_kegiatan' => 'required',
            'sumberdana' => 'required',
        ]);

        PaketPekerjaan::updateOrCreate(
            ['id' => $this->paketId],
            [
                'desa_id' => $this->desa_id,
                'tahun' => $this->tahun,
                'nama_kegiatan' => $this->nama_kegiatan,
                'sumberdana' => $this->sumberdana,
                'kd_desa' => '',
                'kd_keg' => '',
                'nilaipak' => '0',
                'satuan' => '-',
                'pagu_pak' => '0',
                'nm_pptkd' => '',
                'jbt_pptkd' => '',
                'nama_bidang' => '',
                'nama_subbidang' => '',
                'kegiatan_st' => 'KEGIATAN_ST_01'
            ]
        );

        $this->resetForm();
        $this->js("Swal.fire('Berhasil', 'Data berhasil disimpan', 'success')");
    }

    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.hapus()
                }
            })
        JS);
    }

    #[On('hapus')]
    public function hapus()
    {
        PaketPekerjaan::destroy($this->idHapus);
        $this->js("Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')");
    }

    public function resetForm()
    {
        $this->reset(['paketId', 'desa_id', 'tahun', 'nama_kegiatan', 'sumberdana', 'isEdit', 'showModal']);
    }
}
