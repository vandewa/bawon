<?php

namespace App\Livewire\Desa;

use App\Models\ComCode;
use Livewire\Component;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use App\Models\PaketPekerjaan;

class PaketKegiatanForm extends Component
{
    use WithFileUploads;

    public $paketPekerjaan;
    public $jumlah_anggaran;
    public $spek_teknis, $kak, $jadwal_pelaksanaan, $rencana_kerja, $hps;
    public $paket_type;
    public $paketTypes = [];

    public function mount($paketPekerjaanId)
    {
        $this->paketPekerjaan = PaketPekerjaan::findOrFail($paketPekerjaanId);
        $this->paketTypes = ComCode::paketTypes();

        // Set default paket_type jika belum ada
        $this->paket_type = $this->paketKegiatan->paket_type ?? null;

    }

    public function save()
    {
        $this->validate([
            'jumlah_anggaran' => 'required|numeric|max:' . $this->paketPekerjaan->pagu_pak,
            'paket_type' => 'required',
            'spek_teknis' => 'nullable|file|mimes:pdf,doc,docx',
            'kak' => 'nullable|file|mimes:pdf,doc,docx',
            'jadwal_pelaksanaan' => 'nullable|file|mimes:pdf,doc,docx',
            'rencana_kerja' => 'nullable|file|mimes:pdf,doc,docx',
            'hps' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $kegiatan = new PaketKegiatan();
        $kegiatan->paket_pekerjaan_id = $this->paketPekerjaan->id;
        $kegiatan->paket_type = $this->paket_type;
        $kegiatan->jumlah_anggaran = $this->jumlah_anggaran;

        // Upload dokumen
        $kegiatan->spek_teknis = $this->spek_teknis?->store('dokumen/spek_teknis');
        $kegiatan->kak = $this->kak?->store('dokumen/kak');
        $kegiatan->jadwal_pelaksanaan = $this->jadwal_pelaksanaan?->store('dokumen/jadwal');
        $kegiatan->rencana_kerja = $this->rencana_kerja?->store('dokumen/rencana');
        $kegiatan->hps = $this->hps?->store('dokumen/hps');

        $kegiatan->save();

        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Dokumen berhasil di simpan',
            icon: 'success',
          })
        JS);

        // return redirect()->route('desa.paket-kegiatan', $kegiatan->paket_pekerjaan_id);

        session()->flash('message', 'Dokumen berhasil disimpan.');
        // return redirect()->route('desa.paket-pekerjaan');
    }

    public function render()
    {
        return view('livewire.desa.paket-kegiatan-form');
    }
}
