<?php
namespace App\Livewire\Desa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Desa;

class DesaIndex extends Component
{
    use WithPagination;

    public $cari = '';
    public $desaId, $name, $kode_desa, $kecamatan_id, $alamat;
    public $isEdit = false;
    public $showModal = false;
    public $idHapus;


    public function render()
    {
        $query = Desa::where('name', 'like', '%' . $this->cari . '%');

        if (!is_null(auth()->user()->desa_id)) {
            $query->where('id', auth()->user()->desa_id);
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.desa.desa-index', [
            'posts' => $data
        ]);
    }
    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $desa = Desa::findOrFail($id);
        $this->desaId = $desa->id;
        $this->name = $desa->name;
        $this->kode_desa = $desa->kode_desa;
        $this->kecamatan_id = $desa->kecamatan_id;
        $this->alamat = $desa->alamat;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'kode_desa' => 'required',
            'kecamatan_id' => 'required',
        ]);

        Desa::updateOrCreate(
            ['id' => $this->desaId],
            [
                'name' => $this->name,
                'kode_desa' => $this->kode_desa,
                'kecamatan_id' => $this->kecamatan_id,
                'alamat' => $this->alamat,
            ]
        );

        $this->resetForm();
        $this->dispatch('close-modal');
        session()->flash('message', 'Data desa berhasil disimpan.');
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
        });
    JS);
    }

    public function hapus()
    {
        $desa = Desa::find($this->idHapus);

        if (!$desa) {
            return;
        }

        // Cek apakah memiliki relasi ke paket pekerjaan
        if ($desa->paketPekerjaans()->exists()) {
            $this->js(<<<'JS'
            Swal.fire({
                title: 'Gagal!',
                text: 'Data desa tidak dapat dihapus karena sudah terdapat paket yang dibuat.',
                icon: 'error'
            });
        JS);
            return;
        }

        // Jika aman dihapus
        $desa->delete();
        $this->reset('idHapus');

        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data desa berhasil dihapus.',
            icon: 'success'
        });
    JS);
    }
    public function resetForm()
    {
        $this->reset(['desaId', 'name', 'kode_desa', 'kecamatan_id', 'alamat', 'isEdit', 'showModal']);
    }
}

