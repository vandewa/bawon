<?php

namespace App\Livewire\Desa;

use Livewire\Component;


use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;
use App\Models\PaketPekerjaanRinci;

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
         $user = auth()->user();

         if (!$user->hasRole(['superadministrator', 'desa', 'dinsos'])) {
                abort(403, 'Unauthorized access.');
            }
        if ($user->desa_id) {
            $paket = \App\Models\PaketPekerjaan::findOrFail($paketPekerjaanId);

        if ($user->desa_id != $paket->desa_id) {
            abort(403, 'Anda tidak berhak mengakses data desa lain.');
            }
            $this->paketPekerjaanId = $paketPekerjaanId;
        }


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

        // Ambil rincian yang terkait sebelum menghapus
        $rincianList = $kegiatan->rincian()->get();

        foreach ($rincianList as $rinci) {
            // Kurangi quantity di PaketPekerjaanRinci
            PaketPekerjaanRinci::where('id', $rinci->paket_pekerjaan_rinci_id)
                ->decrement('quantity', $rinci->quantity);
        }

        // Ambil ID rincian untuk reset use_st
        $rincianIds = $rincianList->pluck('paket_pekerjaan_rinci_id')->toArray();

        // Hapus relasi dari paket_kegiatan_rincis
        $kegiatan->rincian()->delete();

        // Reset use_st ke false
        if (!empty($rincianIds)) {
            PaketPekerjaanRinci::whereIn('id', $rincianIds)->update(['use_st' => false]);
        }

        // Hapus paket_kegiatan
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
            text: 'Kegaitan berada di proses pelaksanaan.'
        });
    JS);
}

    public function render()
    {
        $this->paketPekerjaan = PaketPekerjaan::with(['desa', 'paketKegiatans' => function($a){
            $a->with(['paketKegiatan', 'paketType', 'tim']);
        }])->findOrFail($this->paketPekerjaanId);
        $this->paketKegiatans = $this->paketPekerjaan->paketKegiatans;

        $this->totalNilaiKesepakatan = $this->paketKegiatans->sum(function($item) {
            return $item->nilai_kesepakatan ?? 0;
        });
        return view('livewire.desa.paket-kegiatan-index');
    }
}
