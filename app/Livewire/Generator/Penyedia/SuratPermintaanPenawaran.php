<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SuratPermintaanPenawaran extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">

                <p style="text-align:center;"><strong>[Kop Surat TPK/Desa]</strong></p>
                
                <table class="no-border" style="width:100%; border:0; font-size:10pt; font-family:Arial; border-collapse:collapse; line-height:1;">
                    <tr style="line-height:1; vertical-align:top;">
                        <td style="width:15%; padding:0; margin:0; line-height:1; vertical-align:top;">Nomor</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">:</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">__________________________</td>
                        <td style="text-align:right; padding:0; margin:0; line-height:1; vertical-align:top;" colspan="2">_______, ___________ 20___</td>
                    </tr>
                    <tr style="line-height:1; vertical-align:top;">
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">Lampiran</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">:</td>
                        <td colspan="3" style="padding:0; margin:0; line-height:1; vertical-align:top;"></td>
                    </tr>
                </table>

                <br>

                <p style="margin: 0;">Kepada Yth.</p>
                <p style="margin: 0;"><i>Dir/Pemilik Perusahaan/Toko*</i></p>
                <p style="margin: 0;">________________________</p>
                <p style="margin: 0;">di Tempat</p>


                <p>Perihal: Permintaan Penawaran Pekerjaan</p>

                <p>
                    Tim Pelaksana Kegiatan (TPK) Desa _______________________ Tahun _______, 
                    dengan ini mengundang Toko/BUMDes/CV/Pemasok* Saudara untuk mengikuti 
                    proses pengadaan barang/jasa dengan cara permintaan penawaran tertulis 
                    untuk pekerjaan:
                </p>

                <table class="no-border" style="width:100%; border:0;font-size:10pt; font-family:Arial;">
                    <tr>
                        <td style="margin:0; padding:0;">1.</td>
                        <td style="margin:0; padding:0;">Nama Pekerjaan</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Lingkup pekerjaan</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">Terlampir</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Spesifikasi Teknis*</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Nilai total HPS</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">Rp ____________________________ (_________________)</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Sumber Dana</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">APBDesa Tahun Anggaran _______________</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">2.</td>
                        <td colspan="3" style="text-align:justify;">
                            Kami harapkan penawaran tertulis dari Saudara dan Surat Pernyataan Kebenaran Usaha dapat disampaikan kepada Tim Pelaksana Kegiatan (TPK) Desa _______________ beralamat di ______________________________, paling lambat pada hari _______________ tanggal _______________ Pukul _______________ WIB/WITA/WIT*.
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">3.</td>
                        <td colspan="3">
                            Jangka waktu pelaksanaan pekerjaan selama _______ ( _______________ ) hari kalender.
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">4.</td>
                        <td colspan="3">
                            Jadwal pelaksanaan kegiatan pengadaan barang/jasa dengan cara Permintaan Penawaran selengkapnya sebagai berikut:
                        </td>
                    </tr>
                    
                </table>

                <table border="1" style="width:100%; border-collapse:collapse; text-align:center;font-size:10pt; font-family:Arial;">
                        <thead>
                            <tr>
                                <th style="width:5%;" rowspan="2">No</th>
                                <th style="width:30%;" rowspan="2">Kegiatan</th>
                                <th style="width:35%;" colspan="3">Pelaksanaan Pengadaan </th>
                                <th style="width:30%;" rowspan="2">Keterangan</th>
                            </tr>
                            <tr>
                                <th style="width:20%;">Hari/Tanggal</th>
                                <th style="width:15%;">Pukul</th>
                                <th style="width:15%;">Tempat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Pemasukan dan Pembukaan Dokumen Penawaran</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Evaluasi Teknis dan Biaya</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Negosiasi Harga</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                <p style="font-size:10pt; font-family:Arial;">Demikian surat Permintaan Penawaran ini kami buat, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
                <p style="font-size:7pt; font-family:Arial; font-style:italic;">*) coret yang tidak perlu</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            An. Tim Pelaksana Kegiatan <br>
                            Desa _______________  <br>
                            Tahun Anggaran ______   <br>
                            Ketua:<br><br><br><br>
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
        return view('livewire.generator.penyedia.surat-permintaan-penawaran');
    }
}
