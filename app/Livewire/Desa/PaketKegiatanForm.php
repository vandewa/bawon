<?php

namespace App\Livewire\Desa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ComCode;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;
use App\Models\PaketPekerjaanRinci;
use App\Models\PaketKegiatanRinci;

class PaketKegiatanForm extends Component
{
    use WithFileUploads;

    public $paketPekerjaan;
    public $jumlah_anggaran = 0;
    public $spek_teknis, $kak, $jadwal_pelaksanaan, $rencana_kerja, $hps;
    public $paket_type;
    public $paketTypes = [];

    public $rincianList = [];
    public $selectedRincian = [];

    public function mount($paketPekerjaanId)
    {
        $this->paketPekerjaan = PaketPekerjaan::findOrFail($paketPekerjaanId);
        $this->paketTypes = ComCode::paketTypes();

        $this->rincianList = PaketPekerjaanRinci::where('paket_pekerjaan_id', $paketPekerjaanId)
        ->where('use_st', false)

            ->get()
            ->toArray();
    }

    public function updatedSelectedRincian()
    {
        $this->jumlah_anggaran = collect($this->rincianList)
            ->whereIn('id', $this->selectedRincian)
            ->sum('anggaran_stlh_pak');
    }

    public function save()
    {
        $this->validate([
            'paket_type' => 'required',
            'selectedRincian' => 'required|array|min:1',
            'spek_teknis' => 'nullable|file|mimes:pdf,doc,docx',
            'kak' => 'nullable|file|mimes:pdf,doc,docx',
            'jadwal_pelaksanaan' => 'nullable|file|mimes:pdf,doc,docx',
            'rencana_kerja' => 'nullable|file|mimes:pdf,doc,docx',
            'hps' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $jumlah = collect($this->rincianList)
            ->whereIn('id', $this->selectedRincian)
            ->sum('anggaran_stlh_pak');

        $kegiatan = new PaketKegiatan();
        $kegiatan->paket_pekerjaan_id = $this->paketPekerjaan->id;
        $kegiatan->paket_type = $this->paket_type;
        $kegiatan->jumlah_anggaran = $jumlah;

        $kegiatan->save();
        foreach ($this->selectedRincian as $rinciId) {
            PaketKegiatanRinci::create([
                'paket_kegiatan_id' => $kegiatan->id,
                'paket_pekerjaan_rinci_id' => $rinciId,
            ]);
        }

        // Tandai rincian sebagai sudah digunakan
       // Set true untuk yang dipakai
        PaketPekerjaanRinci::where('paket_pekerjaan_id', $this->paketPekerjaan->id)
        ->whereIn('id', function ($query) {
            $query->select('paket_pekerjaan_rinci_id')->from('paket_kegiatan_rincis');
        })->update(['use_st' => true]);

        // Set false untuk yang tidak dipakai
        PaketPekerjaanRinci::where('paket_pekerjaan_id', $this->paketPekerjaan->id)
        ->whereNotIn('id', function ($query) {
            $query->select('paket_pekerjaan_rinci_id')->from('paket_kegiatan_rincis');
        })->update(['use_st' => false]);



        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Dokumen berhasil disimpan.',
            icon: 'success',
        })
        JS);

        session()->flash('message', 'Dokumen berhasil disimpan.');
        return redirect()->route('desa.paket-kegiatan.persiapan.edit', $kegiatan->id);
    }

    public function render()
    {
        return view('livewire.desa.paket-kegiatan-form');
    }
}
