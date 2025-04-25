<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class HasilPembahasanKegiatanPersiapanPengadaan extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">NOTULEN <br>
                RAPAT PEMBAHASAN KEGIATAN</p>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                    <tr>
                        <td style="width:25%;">Tempat Pelaksanaan</td>
                        <td style="width:2%;">:</td>
                        <td>__________</td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td>____________</td>
                    </tr>
                    <tr>
                        <td>Waktu Pelaksanaan</td>
                        <td>:</td>
                        <td>___________</td>
                    </tr>
                    <tr>
                        <td>Agenda</td>
                        <td>:</td>
                        <td>_____________</td>
                    </tr>
                </table>
                <br><br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial;">
                    <tr>
                        <td style="width:2%;vertical-align:top;">A.</td>
                        <td>Latar Belakang </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>____________</td>
                    </tr>
                    <tr>
                        <td>B.</td>
                        <td>Pembahasan</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>____________</td>
                    </tr>
                    <tr>
                        <td>C.</td>
                        <td>Tindak Lanjut </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>____________</td>
                    </tr>
                </table>

                <br><br>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                <tr>
                    <td style="width:50%; text-align:center;">
                        <br>
                        <span style="font-weight:bold;">Ketua TPK</span><br><br>
                        [ttd]<br><br>
                        Nama Lengkap
                    </td>
                    <td style="width:50%; text-align:center;">
                        Mengetahui,<br>
                        <span style="font-weight:bold;">Kepala Desa __________</span><br><br>
                        [ttd]<br><br>
                        Nama Lengkap
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
        return view('livewire.generator.swakelola.hasil-pembahasan-kegiatan-persiapan-pengadaan');
    }
}
