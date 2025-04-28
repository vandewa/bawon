<?php

namespace App\Livewire\Generator\Lelang;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SuratPenawaranPenyedia extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">[Kop Penyedia]</p>

                <p style="text-align:right;">__________, __________________ 20____</p>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;">Nomor</td>
                        <td style="width:2%;margin:0; padding:0;">:</td>
                        <td style="width:83%;margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">Lampiran</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">Perihal</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">Penawaran Pengadaan _________</td>
                    </tr>
                </table>

                <br>

                <p style="margin:0;">
                    Kepada Yth. <br>
                    Tim Pelaksana Kegiatan (TPK) <br>
                    Desa _______________ <br>
                    Tahun ______________ <br>
                    di Tempat
                </p>

                <br>

                <p style="text-align:justify;">
                    &nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan Pengumuman Lelang Nomor: _______________ tanggal _______________, dengan ini kami mengajukan penawaran untuk pengadaan _______________ [diisi dengan nama pekerjaan] sebesar Rp _______________ (_______________) termasuk keuntungan dan PPN.
                </p>

                <p style="text-align:justify;">
                    &nbsp;&nbsp;&nbsp;&nbsp;Penawaran ini sudah memperhatikan ketentuan dan persyaratan yang tercantum dalam Pengumuman Lelang untuk melaksanakan pekerjaan tersebut di atas. Kami akan melaksanakan pekerjaan tersebut dengan jangka waktu pelaksanaan pekerjaan selama ___ (_______________) hari kalender. Penawaran ini berlaku selama ___ (_______________) hari kalender sejak tanggal surat penawaran ini. Surat pernyataan beserta lampirannya kami sampaikan sebanyak 1 (satu) rangkap dokumen asli.
                </p>

                <p style="text-align:justify;">
                    &nbsp;&nbsp;&nbsp;&nbsp;Dengan disampaikannya Surat Penawaran ini, maka kami menyatakan sanggup dan akan tunduk pada semua ketentuan dalam proses Lelang.
                </p>

                <br><br>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            Penyedia,<br><br><br><br>
                            tanda tangan, <br>
                            nama lengkap
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
        return view('livewire.generator.lelang.surat-penawaran-penyedia');
    }
}
