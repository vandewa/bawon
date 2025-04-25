<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SpesifikasiTeknis extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount($id)
    {
        $this->paketPekerjaan = PaketPekerjaan::with(['desa'])->findOrFail($id);

        $this->isiSurat = <<<HTML
        <h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold;">
            Spesifikasi Teknis
        </h4>
        
        <p style="font-family: Arial, sans-serif; font-size: 10pt; text-align: center; line-height: 18pt; font-weight:bold;">
            Pekerjaan {$this->paketPekerjaan->nama_kegiatan}<br> 
            Desa {$this->paketPekerjaan->desa->name}<br>
            Tahun {$this->paketPekerjaan->tahun}
        </p>
        
        <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt;">
            <thead style="font-weight: bold;">
                <tr>
                    <td style="width: 5%; text-align: center;">No</td>
                    <td style="width: 46%; text-align: center;">Uraian</td>
                    <td style="width: 46%; text-align: center;">Spesifikasi</td>
                </tr>
            </thead>
            <tbody>
                <tr style="font-size: 8pt; font-style: italic;">
                    <td style="text-align: center;">a</td>
                    <td style="text-align: center;">b</td>
                    <td style="text-align: center;">c</td>
                </tr>
                <tr>
                    <td style="text-align: center;">1.</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;">2.</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;">3.</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;">dst.</td>
                    <td></td>
                    <td></td>
                </tr>
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
                        Bidang {$this->paketPekerjaan->nama_bidang}
                    </span> <br>
                    <span>
                       <i>*) pilih salah satu </i>
                    </span> <br><br>

                    ttd

                    <br><br>

                    <span style="font-weight:bold;">
                    ({$this->paketPekerjaan->nm_pptkd})
                    </span>
                </td>
            </tr>
        </table>
        
        HTML;
    }



    public function simpan()
    {
        // Simpan ke database sebagai HTML
        //  \App\Models\Surat::create([
        //     'judul' => 'Surat dari Summernote',
        //     'isi' => $this->isiSurat, // disimpan dalam format HTML
        // ]);

        $this->sudahDisimpan = true; // aktifkan tombol download setelah simpan
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.swakelola.spesifikasi-teknis');
    }
}
