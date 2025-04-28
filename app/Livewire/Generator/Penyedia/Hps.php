<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class Hps extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <p style="text-align:center; line-height:150%; font-size:10pt;"><strong><span style="font-family:Arial;"><b>HARGA PERKIRAAN SENDIRI</b></span></strong></p>
            <p style="text-align:center; font-size:10pt;"><span style="font-family:Arial;">
                Pekerjaan \${pekerjaan} <br>
                Desa \${desa} <br>
                Tahun \${tahun}
            </span></p>
           
            <table style="width:100%; font-family:Arial; font-size:10pt; border:1pt solid #000; border-collapse:collapse;" cellpadding="5">
            <thead>
                <tr style="text-align:center;">
                    <th style="border:1pt solid #000;">No</th>
                    <th style="border:1pt solid #000;">Uraian Kegiatan/ Nama barang/jasa*</th>
                    <th style="border:1pt solid #000;">Spesifikasi</th>
                    <th style="border:1pt solid #000;">Volume</th>
                    <th style="border:1pt solid #000;">Satuan</th>
                    <th style="border:1pt solid #000;">Harga Satuan (Rp)</th>
                    <th style="border:1pt solid #000;">Jumlah Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
            <tr style="font-size: 8pt; font-style: italic;">
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">a</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">b</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">c</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">d</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">e</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">f</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">g</p>
                </td>
            </tr>

                <tr>
                    <td style="border:1pt solid #000;">\${no}.</td>
                    <td style="border:1pt solid #000;">\${uraian}</td>
                    <td style="border:1pt solid #000;">\${spesifikasi}</td>
                    <td style="border:1pt solid #000;">\${volume}</td>
                    <td style="border:1pt solid #000;">\${satuan}</td>
                    <td style="border:1pt solid #000;">\${hrg_satuan}</td>
                    <td style="border:1pt solid #000;">\${jml_satuan}</td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Jumlah Harga</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;">&nbsp;&nbsp;\${jml_harga}</td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">PPN (%)</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Total Harga</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;">&nbsp;&nbsp;\${total_harga}</td>
                </tr>
            </tbody>
        </table>
        <span style=" font-family: Arial, sans-serif; font-size:8pt;">
        <i>*) pilih salah satu </i>
        </span> 

    
        <br><br>
        <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt;border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <span style="font-weight:bold;">
                        Kepala Seksi/Kepala Urusan*
                    </span> <br>
                    <span style="font-weight:bold;">
                        Bidang _____________
                    </span> <br>
                    <span style="font-size:8pt;">
                    <i>*) pilih salah satu </i>
                    </span> <br><br>

                    ttd

                    <br><br>

                    <span style="font-weight:bold;">
                Nama Lengkap
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
        return view('livewire.generator.penyedia.hps');
    }
}
