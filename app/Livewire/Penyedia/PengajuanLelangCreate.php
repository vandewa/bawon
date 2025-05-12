<?php

namespace App\Livewire\Penyedia;

use App\Models\Penawaran;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PengajuanLelangCreate extends Component
{
    use WithFileUploads;

    public $penawaranId;
    public $penawaran;
    public $nilai;
    public $bukti_setor_pajak;
    public $dok_penawaran;
    public $dok_kebenaran_usaha;
    public $keterangan;

    public function mount($paketKegiatanId, $vendorId)
    {
        $this->penawaran = Penawaran::with('paketKegiatan.paketPekerjaan.desa')
            ->where('paket_kegiatan_id', $paketKegiatanId)
            ->where('vendor_id', $vendorId)
            ->first();

        if ($this->penawaran) {
            $this->nilai = $this->penawaran->nilai;
            $this->keterangan = $this->penawaran->keterangan;
        }

    }

    public function save()
    {
        $this->validate([
            'nilai' => ['required', 'numeric', 'lte:' . $this->penawaran->paketKegiatan->jumlah_anggaran],
            'bukti_setor_pajak' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dok_penawaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dok_kebenaran_usaha' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $this->penawaran->nilai = $this->nilai;
        $this->penawaran->tanggal_upload_dok = now();
        $this->penawaran->keterangan = $this->keterangan;

        if ($this->bukti_setor_pajak) {
            $this->penawaran->bukti_setor_pajak = $this->bukti_setor_pajak->store('penawaran/bukti_setor', 'public');
        }
        if ($this->dok_penawaran) {
            $this->penawaran->dok_penawaran = $this->dok_penawaran->store('penawaran/dok_penawaran', 'public');
        }
        if ($this->dok_kebenaran_usaha) {
            $this->penawaran->dok_kebenaran_usaha = $this->dok_kebenaran_usaha->store('penawaran/dok_kebenaran', 'public');
        }

        $this->penawaran->save();

        session()->flash('message', 'Penawaran berhasil diperbarui.');

        $this->js(<<<'JS'
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Penawaran berhasil disimpan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "/penyedia/penawaran-index";
        });
    JS);
    }

    public function render()
    {
        return view('livewire.penyedia.pengajuan-lelang-create');
    }
}
