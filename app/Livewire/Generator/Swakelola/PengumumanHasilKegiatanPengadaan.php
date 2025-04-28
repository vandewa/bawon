<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class PengumumanHasilKegiatanPengadaan extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center;"><i>[Kop Surat TPK]  </i></p>
                <p style="text-align:center; font-weight:bold;margin:0;padding:0;"><u>PENGUMUMAN HASIL KEGIATAN PENGADAAN SECARA SWAKELOLA</u></p>
                <p style="text-align:center;">Nomor: ______________________</p>

                <p>Tim Pelaksana Kegiatan (TPK) Desa ________________ dengan ini menyampaikan hasil pelaksanaan kegiatan Pengadaan secara Swakelola Tahun Anggaran ______, sebagai berikut:</p>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr>
                        <td style="width:30%;margin:0; padding:0;">1. Nama Kegiatan</td>
                        <td style="width:2%;margin:0; padding:0;">:</td>
                        <td style="width:68%;margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">2. Nilai Pengadaan sebesar</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">Rp_________________ (_________________)</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">3. Keluaran/Output</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">[terdiri dari volume dan satuan]</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">4. Lokasi</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">5. Waktu Pelaksanaan</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">[tanggal mulai dan tanggal selesai]</td>
                    </tr>
                </table>

                <p style="text-align:justify;">Demikian pengumuman ini kami sampaikan untuk dapat diketahui bersama.</p><br>

                <p style="text-align:right;">_______[tempat], ___[tanggal] ____________[bulan] _____[tahun]</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                <tr>
                    <td style="width:60%;"></td>
                    <td style="text-align:center;">
                        <span style="font-weight:bold;">
                        Tim Pelaksana Kegiatan (TPK) <br><br>
                        </span>

                        <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                            <tr>
                                <td>1.</td>
                                <td>________________ </td>
                                <td>:</td>
                                <td>________________ </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Nama Ketua</td>
                                <td></td>
                                <td>ttd </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>________________ </td>
                                <td>:</td>
                                <td>________________ </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Nama Sekretaris</td>
                                <td></td>
                                <td>ttd </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>________________ </td>
                                <td>:</td>
                                <td>________________ </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Nama Anggota</td>
                                <td></td>
                                <td>ttd </td>
                            </tr>
                        </table>
                        
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
        return view('livewire.generator.swakelola.pengumuman-hasil-kegiatan-pengadaan');
    }
}
