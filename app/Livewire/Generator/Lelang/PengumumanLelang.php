<?php

namespace App\Livewire\Generator\Lelang;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class PengumumanLelang extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold; margin:0;">[Kop Surat TPK/Desa]</p>
                <p style="text-align:center; font-weight:bold; margin:0;"><u>PENGUMUMAN LELANG</u></p>
                <p style="text-align:center; margin-bottom:6pt;">Nomor: _________________</p>

                <p style="text-align:justify; margin:0;">
                    Tim Pelaksana Kegiatan (TPK) Desa _______________ Tahun Anggaran _____ dengan ini mengumumkan dan mengundang Penyedia (Perusahaan/Toko/CV/BUMDes/BUMDesma) untuk mengikuti pengadaan yang dilakukan dengan cara Lelang, sebagai berikut:
                </p>

                <br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr><td style="width:1%;">1.</td><td style="width:25%;">Nama Pekerjaan</td><td style="width:2%;">:</td><td></td></tr>
                    <tr>
                        <td style="vertical-align:top;">2.</td>
                        <td colspan="3"> Nama TPK</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;"></td>
                        <td><li>Ketua</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;"></td>
                        <td><li>Sekretaris</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;"></td>
                        <td><li>Anggota</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr><td>3.</td><td>Lokasi Pekerjaan</td><td>:</td><td></td></tr>
                    <tr><td>4.</td><td>Lingkup Pekerjaan</td><td>:</td><td></td></tr>
                    <tr><td>5.</td><td>Nilai HPS</td><td>:</td><td></td></tr>
                    <tr><td>6.</td><td>Waktu Pelaksanaan</td><td>:</td><td>______ (___________________________) hari kalender</td></tr>
                </table>
                <p style="margin:0;">7. Jadwal Lelang</p>
                <table style="width:100%; border-collapse:collapse; font-size:10pt; font-family:Arial; margin:0; padding:0;" border="1">
                    <thead>
                        <tr style="text-align:center;">
                            <th style="width:30%;" rowspan="2">Kegiatan</th>
                            <th colspan="3">Waktu Pelaksanaan </th>
                            <th rowspan="2">Tempat</th>
                        </tr>
                        <tr style="text-align:center;">
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Pukul</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>&nbsp;&nbsp;&nbsp;Pengumuman</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>&nbsp;&nbsp;&nbsp;Pendaftaran dan Pengambilan Dokumen Lelang</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>&nbsp;&nbsp;&nbsp;Pemasukan Dokumen Penawaran</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>&nbsp;&nbsp;&nbsp;Evaluasi Penawaran</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>&nbsp;&nbsp;&nbsp;Negosiasi</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>&nbsp;&nbsp;&nbsp;Penetapan Pemenang</td><td></td><td></td><td></td><td></td></tr>
                    </tbody>
                </table>

                <br>

                <p style="text-align:justify; margin:0;">
                    Demikian agar maklum, atas perhatiannya kami ucapkan terima kasih.
                </p>

                <br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            ________, __________________ 20____<br><br>
                            An. Tim Pelaksana Kegiatan<br>
                            Desa ____________________<br>
                            Tahun Anggaran _______<br>
                            Ketua:<br><br><br>
                            tanda tangan,<br>
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
        return view('livewire.generator.lelang.pengumuman-lelang');
    }
}
