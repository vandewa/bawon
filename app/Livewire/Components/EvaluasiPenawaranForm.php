<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\EvaluasiPenawaran;
use App\Models\Penawaran;

class EvaluasiPenawaranForm extends Component
{
    public $penawaranId;
    public $suratKebenaranAda, $suratKebenaranHasil;
    public $spesifikasiAda, $spesifikasiHasil;
    public $jadwalAda, $jadwalHasil;
    public $hargaAda, $hargaHasil;

    public function mount($penawaranId)
    {
        $this->penawaranId = $penawaranId;

        // Cek apakah sudah ada evaluasi untuk penawaran ini
        $evaluasi = EvaluasiPenawaran::where('penawaran_id', $this->penawaranId)->first();

        if ($evaluasi) {
            $this->suratKebenaranAda = $evaluasi->surat_kebenaran_ada;
            $this->suratKebenaranHasil = $evaluasi->surat_kebenaran_hasil;
            $this->spesifikasiAda = $evaluasi->spesifikasi_ada;
            $this->spesifikasiHasil = $evaluasi->spesifikasi_hasil;
            $this->jadwalAda = $evaluasi->jadwal_ada;
            $this->jadwalHasil = $evaluasi->jadwal_hasil;
            $this->hargaAda = $evaluasi->harga_ada;
            $this->hargaHasil = $evaluasi->harga_hasil;
        } else {
            
        }
    }

    public function simpanEvaluasi()
    {
        // Validasi input
        $this->validate([
            'suratKebenaranAda' => 'required|boolean',
            'suratKebenaranHasil' => 'required|string|max:255',
            'spesifikasiAda' => 'required|boolean',
            'spesifikasiHasil' => 'required|string|max:255',
            'jadwalAda' => 'required|boolean',
            'jadwalHasil' => 'required|string|max:255',
            'hargaAda' => 'required|boolean',
            'hargaHasil' => 'required|string|max:255',
        ]);

        // Simpan atau update evaluasi penawaran
        EvaluasiPenawaran::updateOrCreate(
            ['penawaran_id' => $this->penawaranId],
            [
                'surat_kebenaran_ada' => $this->suratKebenaranAda,
                'surat_kebenaran_hasil' => $this->suratKebenaranHasil,
                'spesifikasi_ada' => $this->spesifikasiAda,
                'spesifikasi_hasil' => $this->spesifikasiHasil,
                'jadwal_ada' => $this->jadwalAda,
                'jadwal_hasil' => $this->jadwalHasil,
                'harga_ada' => $this->hargaAda,
                'harga_hasil' => $this->hargaHasil,
            ]
        );

        session()->flash('message', 'Evaluasi Penawaran berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.components.evaluasi-penawaran-form');
    }
}
