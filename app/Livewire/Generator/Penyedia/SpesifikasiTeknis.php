<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\SpesifikasiTeknis as GeneratorSpesifikasiTeknis;
use App\Models\PaketKegiatan;
use Livewire\Component;
use App\Models\PaketPekerjaan;

class SpesifikasiTeknis extends Component
{
    public $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan, $paketKegiatan, $cekData;

    public function mount($id)
    {
        // Ambil data PaketPekerjaan beserta relasi yang dibutuhkan
        $this->paketPekerjaan = PaketPekerjaan::with(['desa', 'paketKegiatans'])->findOrFail($id);

        // Ambil PaketKegiatan terkait
        $this->paketKegiatan = PaketKegiatan::where('paket_pekerjaan_id', $this->paketPekerjaan->id)->first();

        // Jika ada, cek apakah sudah ada data spesifikasi teknis
        if ($this->paketKegiatan) {
            $this->cekData = GeneratorSpesifikasiTeknis::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // Isi surat: dari DB atau template
        $this->isiSurat = $this->cekData->isi_surat ?? $this->getDefaultIsiSurat();
    }

    protected function getDefaultIsiSurat(): string
{
    $namaKegiatan = ucwords(strtolower($this->paketPekerjaan->nama_kegiatan ?? ''));
    $namaDesa     = ucwords(strtolower($this->paketPekerjaan->desa->name ?? ''));
    $tahun        = $this->paketPekerjaan->tahun ?? '';
    $namaBidang   = ucwords(strtolower($this->paketPekerjaan->nama_bidang ?? ''));
    $nmPptkd      = ucwords(strtolower($this->paketPekerjaan->nm_pptkd ?? ''));


    // Baris contoh a b c d e
    $rowHeader = "
        <tr style='font-size: 8pt; font-style: italic;'>
            <td style='text-align: center;'>a</td>
            <td style='text-align: center;'>b</td>
            <td style='text-align: center;'>c</td>
            <td style='text-align: center;'>d</td>
            <td style='text-align: center;'>e</td>
        </tr>";

    // Data rincian
    $rows = '';
    if ($this->paketKegiatan && $this->paketKegiatan->rincian->count()) {
        foreach ($this->paketKegiatan->rincian as $i => $rinci) {
            $uraian      = $rinci->uraian ?? '';
            $quantity    = $rinci->pivot->quantity ?? '';
            $satuan      = $rinci->satuan ?? '';
            $spesifikasi = $rinci->spesifikasi ?? '';

            $rows .= "
                <tr>
                    <td style='text-align: center;'>".($i+1).".</td>
                    <td>{$uraian}</td>
                    <td style='text-align: center;'>{$quantity}</td>
                    <td style='text-align: center;'>{$satuan}</td>
                    <td>{$spesifikasi}</td>
                </tr>";
        }
    } else {
        $rows = "
            <tr>
                <td style='text-align: center;'>1.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
    }

    return <<<HTML
        <h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold;">
            Spesifikasi Teknis
        </h4>
        <p style="font-family: Arial, sans-serif; font-size: 10pt; text-align: center; line-height: 18pt;">
            Paket Pengadaan {$namaKegiatan}<br>
             {$namaDesa}<br>
            Tahun {$tahun}
        </p>
        <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt;">
            <thead style="font-weight: bold;">
                <tr>
                    <td style="width: 5%; text-align: center;">No</td>
                    <td style="width: 35%; text-align: center;">Deskripsi Barang/Jasa</td>
                    <td style="width: 10%; text-align: center;">Volume</td>
                    <td style="width: 10%; text-align: center;">Satuan</td>
                    <td style="width: 40%; text-align: center;">Spesifikasi</td>
                </tr>
            </thead>
            <tbody>
                {$rowHeader}
                {$rows}
            </tbody>
        </table>
        <br><br>
        <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt;border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <span style="font-weight:bold;">
                        Kepala Seksi/Kepala Urusan*
                    </span> <br>
                    <span style="font-weight:bold;">
                        Bidang {$namaBidang}
                    </span> <br>
                    <span>
                        <i>*) pilih salah satu </i>
                    </span> <br><br>

                    <br><br>
                    <span style="font-weight:bold;">
                    ({$nmPptkd})
                    </span>
                </td>
            </tr>
        </table>
    HTML;
}

public function resetIsiSurat()
{
    $this->isiSurat = $this->getDefaultIsiSurat();
    $this->sudahDisimpan = false; // opsional: hilangkan tombol download setelah reset
    $this->simpan();
    session()->flash('message', 'Dokumen di-reset ke template awal.');
}



    public function simpan()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;

        // Sederhanakan proses update/create
        GeneratorSpesifikasiTeknis::updateOrCreate(
            ['paket_kegiatan_id' => $paketId],
            ['isi_surat' => $this->isiSurat]
        );

        $this->sudahDisimpan = true;
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.spesifikasi-teknis');
    }
}
