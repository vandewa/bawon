<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class LaporanPenggunaanSumberdaya extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <div style="font-family:Arial; font-size:10pt;">
            <p style="margin:3px;;text-align:center;font-weight:bold;">LAPORAN PENGGUNAAN SUMBER DAYA</p>
            <p style="margin:3px;;text-align:center;">Pada pengadaan ___________________</p>
            <p style="margin:3px;;text-align:center;">Periode: _______________ s.d. ______________</p>
            
            <br><br>

            <table border="1" style="width:100%; border-collapse:collapse; font-family:Arial; font-size:10pt;margin:0;padding:0;">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align:center;margin:0;padding:0;">No</th>
                        <th rowspan="2" style="text-align:center;margin:0;padding:0;">Sumber Daya</th>
                        <th colspan="2" style="text-align:center;margin:0;padding:0;">Rencana</th>
                        <th colspan="2" style="text-align:center;margin:0;padding:0;">Realisasi</th>
                        <th rowspan="2" style="text-align:center;margin:0;padding:0;">Keterangan</th>
                    </tr>
                    <tr>
                        <th style="text-align:center;margin:0;padding:0;">Volume</th>
                        <th style="text-align:center;margin:0;padding:0;">Total Biaya</th>
                        <th style="text-align:center;margin:0;padding:0;">Volume</th>
                        <th style="text-align:center;margin:0;padding:0;">Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>a</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>b</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>c</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>d</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>e</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>f</i></td>
                        <td style="font-size:8pt; text-align:center;margin:0;padding:0;"><i>g</i></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">1.</td>
                        <td>Tenaga Kerja</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">2.</td>
                        <td>Material/Bahan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">3.</td>
                        <td>Sarana Prasarana/Peralatan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <p style="font:size:8pt;"><i>*) periode diisi dengan rentang tanggal pelaporan secara harian/mingguan/bulanan pada setiap tahapan kegiatan sesuai ketentuan yang diatur dalam surat perjanjian/kesepakatan.</i></p>

            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                <tr>
                    <td style="width:50%; text-align:center;">
                   <br>
                       <span style="font-weight:bold;">Ketua TPK</span><br><br>
                        [ttd]<br><br>
                        (Nama Lengkap)
                    </td>
                    <td style="width:50%; text-align:center;">
                       Diverifikasi oleh<br>
                       <span style="font-weight:bold;">Kasi/Kaur__________</span><br><br>
                        [ttd]<br><br>
                        (Nama Lengkap)
                    </td>
                </tr>
            </table>
        </div>
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
        return view('livewire.generator.swakelola.laporan-penggunaan-sumberdaya');
    }
}
