<?php

namespace App\Livewire\Desa;

use Livewire\Component;


use App\Models\PaketPekerjaan;
use App\Models\PaketKegiatan;

class PaketKegiatanIndex extends Component
{
    public $paketPekerjaan;
    public $paketKegiatans;
    public $idHapus;
    public $totalNilaiKesepakatan = 0;
    public $idUbahStatus;
    public $paketPekerjaanId;

    public function mount($paketPekerjaanId)
    {
        $this->paketPekerjaanId = $paketPekerjaanId;
    }



    public function delete($id)
    {
        $this->idHapus = $id;

        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus permanen dan tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
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
        $kegiatan = PaketKegiatan::find($this->idHapus);

        if (!$kegiatan) return;

        // Misal validasi relasi (jika diperlukan)
        // if ($kegiatan->detail()->exists()) {
        //     $this->js(<<<'JS'
        //         Swal.fire({
        //             title: 'Gagal!',
        //             text: 'Tidak dapat dihapus karena memiliki data terkait.',
        //             icon: 'error'
        //         });
        //     JS);
        //     return;
        // }

        $kegiatan->delete();
        $this->reset('idHapus');

        $this->js(<<<'JS'
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil dihapus.',
                icon: 'success'
            });
        JS);
    }

    public function confirmChangeStatus($id)
{
    $this->idUbahStatus = $id;

    $this->js(<<<'JS'
        Swal.fire({
            title: 'Selanjutnya?',
            text: "Anda yakin akan beralih ke tahap pengadaan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.changeStatusToSt02()
            }
        });
    JS);
}

public function changeStatusToSt02()
{
    $item = \App\Models\PaketKegiatan::find($this->idUbahStatus);

    if (!$item) return;

    $item->paket_kegiatan = 'PAKET_KEGIATAN_ST_02';
    $item->save();

    $this->reset('idUbahStatus');

    $this->js(<<<'JS'
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Status berhasil diubah ke ST_02.'
        });
    JS);
}

    public function render()
    {
        $this->paketPekerjaan = PaketPekerjaan::with(['desa', 'paketKegiatans' => function($a){
            $a->with(['paketKegiatan', 'paketType']);
        }])->findOrFail($this->paketPekerjaanId);
        $this->paketKegiatans = $this->paketPekerjaan->paketKegiatans;

        $this->totalNilaiKesepakatan = $this->paketKegiatans->sum(function($item) {
            return $item->nilai_kesepakatan ?? 0;
        });
        return view('livewire.desa.paket-kegiatan-index');
    }
}
