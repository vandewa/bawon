<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class Kak extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
                <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><strong><span style="font-family:Arial;"><b>Kerangka Acuan Kerja (KAK)</b></span></strong></p>
            <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Paket Pengadaan \${paket_pengadaan}</span></p>
            <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Desa \${desa}</span></p>
            <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Tahun \${tahun}</span></p><br>
            
            <table style="width: 100%; font-family: Arial; font-size: 10pt; border-collapse: collapse;" border="1" cellpadding="5">
                <thead style="background-color: #d9e2f3; text-align: center;">
                    <tr>
                        <th colspan="3">Uraian Pendahuluan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:2%; font-weight: bold;">1.</td>
                        <td style="width:20%; font-weight: bold;">Latar Belakang</td>
                        <td style="width:78%;">\${latar_belakang}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">2.</td>
                        <td style="font-weight: bold;">Maksud dan Tujuan</td>
                        <td>
                            <table class="no-border" style="width:100%; font-family: Arial; font-size: 10pt;" border="0">
                                <tr>
                                    <td style="width:70px;">Maksud</td>
                                    <td style="width:10px;">:</td>
                                    <td>\${maksud}</td>
                                </tr>
                                <tr>
                                    <td>Tujuan</td>
                                    <td>:</td>
                                    <td>\${tujuan}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">3.</td>
                        <td style="font-weight: bold;">Sasaran / Output</td>
                        <td>\${sasaran}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">4.</td>
                        <td style="font-weight: bold;">Lokasi Pengerjaan</td>
                        <td>\${lokasi}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">5.</td>
                        <td style="font-weight: bold;">Sumber Pendanaan</td>
                        <td>Pekerjaan ini dibiayai dari sumber pendanaan: \${sumber_pendanaan}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">6.</td>
                        <td style="font-weight: bold;">Nilai Pekerjaan</td>
                        <td>Rp \${rupiah} (\${terbilang})</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">7.</td>
                        <td style="font-weight: bold;">Kode Rekening</td>
                        <td>\${kode_rekening}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">8.</td>
                        <td style="font-weight: bold;">Kasi / Kaur</td>
                        <td>
                            <table class="no-border" style="width:100%; font-family: Arial; font-size: 10pt;" border="0">
                                <tr>
                                    <td style="width:70px;">Nama</td>
                                    <td style="width:10px;">:</td>
                                    <td>\${nama_kasi_kaur}</td>
                                </tr>
                                <tr>
                                    <td>Bidang</td>
                                    <td>:</td>
                                    <td>\${bidang}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">9.</td>
                        <td style="font-weight: bold;">TPK</td>
                        <td>\${tpk}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">10.</td>
                        <td style="font-weight: bold;">Lingkup Pekerjaan</td>
                        <td>\${lingkup_pekerjaan}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">11.</td>
                        <td style="font-weight: bold;">Spesifikasi Teknis</td>
                        <td>\${spesifikasi_teknis}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">12.</td>
                        <td style="font-weight: bold;"> Peralatan, Material, Personel dan Fasilitas dari Kasi/Kaur </td>
                        <td>\${peralatan}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">13.</td>
                        <td style="font-weight: bold;">Jangka Waktu  Jangka Waktu Penyelesaian Pekerjaan</td>
                        <td>Pengadaan ini dilaksanakan selama \${jangka_waktu} hari kalender/bulan.</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center; font-weight: bold; background-color: #d9e2f3;">Laporan</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">14.</td>
                        <td style="font-weight: bold;">Laporan Kemajuan Pelaksanaan Pekerjaan</td>
                        <td>
                            Laporan kemajuan pelaksanaan pekerjaan: \${laporan_kemajuan}<br>
                            Diserahkan paling lambat (\${durasi_laporan_kemajuan}) sejak pekerjaan dimulai sebanyak \${jml_laporan_kemajuan} laporan.
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">15.</td>
                        <td style="font-weight: bold;">Laporan pelaksanaan pengadaan yang telah selesai 100%</td>
                        <td>
                            Laporan pelaksanaan pengadaan: \${laporan_pelaksanaan}<br>
                            Diserahkan paling lambat (\${durasi_laporan_pelaksanaan}) sejak selesai 100%, sebanyak \${jml_laporan_kemajuan} laporan.
                        </td>
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
                                Bidang _____________
                            </span> <br>
                            <span>
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
        return view('livewire.generator.swakelola.kak');
    }
}
