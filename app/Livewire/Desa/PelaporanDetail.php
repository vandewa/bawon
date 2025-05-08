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
    public $laporan_hasil_pemeriksaan;
    public $bast_penyedia;
    public $bast_kades;

    public function mount($id)
    {
        $this->paketKegiatan = PaketKegiatan::with([
            'paketPekerjaan',
            'negosiasi.vendor',
            'penawaranTerpilih',
            'statusKegiatan'
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
        $fields = [
            'laporan_hasil_pemeriksaan',
            'bast_penyedia',
            'bast_kades'
        ];

        foreach ($fields as $field) {
            if ($this->{$field}) {
                $path = $this->{$field}->store('dokumen/pelaporan');
                $this->paketKegiatan->{$field} = $path;
            }
        }

        $this->paketKegiatan->save();
        session()->flash('message', 'Dokumen berhasil disimpan.');
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
        $this->paketKegiatan->paket_kegiatan = 'KEGIATAN_ST_02';
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
        $this->paketKegiatan->paket_kegiatan = 'KEGIATAN_ST_01';
        $this->paketKegiatan->save();

        session()->flash('message', 'Penutupan kegiatan telah dibatalkan.');
        $this->js("
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Penutupan kegiatan telah dibatalkan.',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '" . route('desa.pelaporan.index') . "';
    });
");
        // return redirect()->route('desa.pelaporan.index');
    }

    public function render()
    {
        return view('livewire.desa.pelaporan-detail');
    }
}
