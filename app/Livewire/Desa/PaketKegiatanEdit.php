<?php

namespace App\Livewire\Desa;

use App\Models\ComCode;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PaketKegiatanEdit extends Component
{
    use WithFileUploads;

    public $paketKegiatan;
    public $paketPekerjaan;
    public $jumlah_anggaran;
    public $paket_type;
    public $spek_teknis, $kak, $jadwal_pelaksanaan, $rencana_kerja, $hps;

    public $paketTypes = [];

    public function mount($id)
    {
        $this->paketKegiatan = PaketKegiatan::with('paketPekerjaan')->findOrFail($id);
        $this->paketPekerjaan = $this->paketKegiatan->paketPekerjaan;

        if (!$this->paketPekerjaan) {
            abort(404, 'Paket Pekerjaan tidak ditemukan.');
        }

        $this->jumlah_anggaran = $this->paketKegiatan->jumlah_anggaran;
        $this->paket_type = $this->paketKegiatan->paket_type;
        $this->paketTypes = ComCode::paketTypes();
    }

    public function update()
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

        $this->paketKegiatan->jumlah_anggaran = $this->jumlah_anggaran;
        $this->paketKegiatan->paket_type = $this->paket_type;

        // Simpan file jika diupload baru
        if ($this->spek_teknis) {
            $this->deleteOldFile($this->paketKegiatan->spek_teknis);
            $this->paketKegiatan->spek_teknis = $this->spek_teknis->store('dokumen/spek_teknis');
        }

        if ($this->kak) {
            $this->deleteOldFile($this->paketKegiatan->kak);
            $this->paketKegiatan->kak = $this->kak->store('dokumen/kak');
        }

        if ($this->jadwal_pelaksanaan) {
            $this->deleteOldFile($this->paketKegiatan->jadwal_pelaksanaan);
            $this->paketKegiatan->jadwal_pelaksanaan = $this->jadwal_pelaksanaan->store('dokumen/jadwal');
        }

        if ($this->rencana_kerja) {
            $this->deleteOldFile($this->paketKegiatan->rencana_kerja);
            $this->paketKegiatan->rencana_kerja = $this->rencana_kerja->store('dokumen/rencana');
        }

        if ($this->hps) {
            $this->deleteOldFile($this->paketKegiatan->hps);
            $this->paketKegiatan->hps = $this->hps->store('dokumen/hps');
        }

        $this->paketKegiatan->save();

        session()->flash('message', 'Dokumen berhasil diperbarui.');
    }

    protected function deleteOldFile($path)
    {
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public function render()
    {
        return view('livewire.desa.paket-kegiatan-edit');
    }
}
