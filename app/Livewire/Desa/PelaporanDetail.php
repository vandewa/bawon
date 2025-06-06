<?php

namespace App\Livewire\Desa;

use App\Models\PaketKegiatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class PelaporanDetail extends Component
{
    use WithFileUploads;

    public PaketKegiatan $paketKegiatan;
    // public $laporan_hasil_pemeriksaan; // REMOVED
    public $bast_penyedia;
    public $bast_kades;
    public $bukti_bayar;

    public function mount($id)
    {
        $this->paketKegiatan = PaketKegiatan::with([
            'paketPekerjaan',
            'negosiasi.vendor',
            'penawaranTerpilih',
            'statusKegiatan',
            'penawarans.vendor'
        ])->findOrFail($id);
    }

    public function generateDummy($field)
    {
        $dummyPath = 'dummy/' . Str::random(10) . '.pdf';
        Storage::put($dummyPath, 'Dummy content for ' . $field);
        $this->{$field} = new \Illuminate\Http\File(Storage::path($dummyPath));
    }

    public function save()
    {
       if ($this->bukti_bayar) {
            $path = $this->bukti_bayar->store('dokumen/pelaporan');
            $this->paketKegiatan->bukti_bayar = $path;
        }

        // REMOVED block for laporan_hasil_pemeriksaan
        /*
        if ($this->laporan_hasil_pemeriksaan) {
            $path = $this->laporan_hasil_pemeriksaan->store('dokumen/pelaporan');
            $this->paketKegiatan->laporan_hasil_pemeriksaan = $path;
        }
        */

        if ($this->bast_penyedia) {
            $path = $this->bast_penyedia->store('dokumen/pelaporan');
            $this->paketKegiatan->bast_penyedia = $path;
        }

        if ($this->bast_kades) {
            $path = $this->bast_kades->store('dokumen/pelaporan');
            $this->paketKegiatan->bast_kades = $path;
        }

        $this->paketKegiatan->save();
        session()->flash('message', 'Dokumen berhasil disimpan.');
        $this->js("
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Dokumen berhasil disimpan.',
            showConfirmButton: false,
            timer: 2000
        });
    ");
    }

    public function konfirmasiTutupKegiatan()
    {
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kegiatan akan ditutup dan tidak dapat diedit kembali.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tutup!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.tutupKegiatan()
                }
            })
        JS);
    }

    #[On('tutupKegiatan')]
    public function tutupKegiatan()
    {
        $this->paketKegiatan->paket_kegiatan = 'PAKET_KEGIATAN_ST_03';
        $this->paketKegiatan->save();

        session()->flash('message', 'Kegiatan berhasil ditutup.');
        $this->js("
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Penutupan kegiatan telah dilakukan.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '" . route('desa.pelaporan.index') . "';
            });
        ");
    }

    public function konfirmasiBatalPenutupan()
    {
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Batalkan penutupan?',
                text: "Kegiatan akan dibuka kembali untuk pengeditan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f0ad4e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.batalkanPenutupan()
                }
            })
        JS);
    }

    public function batalkanPenutupan()
    {
        $this->paketKegiatan->paket_kegiatan = 'PAKET_KEGIATAN_ST_02';
        $this->paketKegiatan->save();

        session()->flash('message', 'Penutupan kegiatan telah dibatalkan.');
        $this->js("
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Penutupan kegiatan telah dibatalkan.',
                timer: 2000,
                showConfirmButton: false
            });
        ");
        // return redirect()->route('desa.pelaporan.index');
    }

    public function render()
    {
        return view('livewire.desa.pelaporan-detail');
    }
}
