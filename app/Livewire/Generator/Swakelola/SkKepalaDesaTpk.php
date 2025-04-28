<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SkKepalaDesaTpk extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">SURAT KEPUTUSAN KEPALA DESA</p>

                <p style="text-align:center;">NOMOR : _______ TAHUN _______</p>

                <p style="text-align:center;">TENTANG <br>
                PENETAPAN TIM PELAKSANA KEGIATAN (TPK) <br>
                SEBAGAI PELAKSANA PENGADAAN BARANG/JASA <br>
                PERIODE TAHUN _________
                </p>
                

                <p style="text-align:center;">KEPALA DESA ________</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; margin:0; padding:0; border-collapse:collapse;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%; margin:0; padding:0; vertical-align:top;">Menimbang</td>
                        <td style="width:2%; margin:0; padding:0; vertical-align:top;">:</td>
                        <td style="width:2%; margin:0; padding:0; vertical-align:top;">a.</td>
                        <td style="width:79%; margin:0; padding:0; text-align:justify; vertical-align:top;">
                            Bahwa untuk kelancaran proses kegiatan pengadaan barang dan jasa yang bersumber dari Anggaran Pendapatan dan Belanja Desa di Desa -------- serta membantu tugas Kepala Seksi (Kasi) dan Kepala Urusan (Kaur), perlu menetapkan Tim Pelaksana Kegiatan (TPK);
                        </td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;"></td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">b.</td>
                        <td style="margin:0; padding:0;text-align:justify;">Bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, maka dipandang perlu menetapkan Surat Keputusan Kepala Desa -------- Kecamatan -------- Kabupaten/Kota Wonosobo tentang Penetapan Tim Pelaksana Kegiatan (TPK) sebagai pelaksana pengadaan barang/jasa periode tahun -----;
                        </td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;">Mengingat</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;text-align:justify;" colspan="2">
                        (diisi dengan peraturan perundang-undangan terkait pelaksanaan 
                        pengadaan barang/jasa di desa) 
                        </td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;vertical-align:top;text-align:center;font-weight:bold;" colspan="4">MEMUTUSKAN</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;">Menetapkan</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td style="margin:0; padding:0; text-align:justify;" colspan="2">Keputusan Kepala Desa ________ tentang Penetapan Tim Pelaksana 
                        Kegiatan (TPK) Pengadaan Barang/Jasa Desa ______ Tahun ____ 
                        </td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;">KESATU</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td style="margin:0; padding:0; text-align:justify;" colspan="2">Menetapkan nama-nama terlampir sebagai Tim Pelaksana Kegiatan 
                        (TPK) Pemerintah Desa ___________ untuk Tahun Anggaran _____ 
                        </td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;">KEDUA</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td colspan="2">Tim Pelaksana Kegiatan (TPK) sebagaimana dimaksud dalam Diktum 
                        Kesatu keputusan ini memiliki tugas: <br>
                        1.__________; <br>
                        2.__________; <br>
                        3.__________ 
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="width:15%;margin:0; padding:0;vertical-align:top;">KETIGA</td>
                        <td style="width:2%;margin:0; padding:0;vertical-align:top;">:</td>
                        <td style="margin:0; padding:0; text-align:justify;" colspan="2">Keputusan ini mulai berlaku sejak tanggal ditetapkan.
                    </tr>
                </table>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse: collapse;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:60%; vertical-align:top; padding:0;"></td>
                        <td style="vertical-align:top; padding:0; text-align:left;">
                        <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;margin:0;padding:0;">
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Ditetapkan di</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">_________</td>
                            </tr>
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Tanggal</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">____________</td>
                            </tr>
                        </table>
                        <br>
                        <span style="font-weight:bold;">Kepala Desa </span><br><br><br>

                            tanda tangan, <br>
                            nama lengkap
                        </td>
                    </tr>
                </table>

                <br>


                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                <tr style="margin:0; padding:0;">
                    <td style="width:50%;"></td>
                    <td style="width:50%;">
                        <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;" colspan="3">Lampiran Surat Keputusan Kepala Desa</td>
                            </tr>
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Nomor</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">______________</td>
                            </tr>
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Tanggal</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">______________</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br><br>


            <div style="text-align:center;font-weight:bold;">
                DAFTAR TIM PELAKSANA KEGIATAN (TPK) <br>
                DESA ________________________ <br>
                TAHUN ____________ <br>
            </div>

            <br><br>

            <table border="1" style="width:100%; font-family:Arial; font-size:10pt;">
                <tr>
                    <td style="margin:0;padding:0;text-align:center;width:4%;font-weight:bold;">No</td>
                    <td style="margin:0;padding:0;text-align:center;width:50%;vertical-align:bottom;line-height:20px;font-weight:bold;">Nama</td>
                    <td style="margin:0;padding:0;text-align:center;width:15%;vertical-align:bottom;line-height:20px;font-weight:bold;">Unsur*</td>
                    <td style="margin:0;padding:0;text-align:center;width:15%;vertical-align:bottom;line-height:20px;font-weight:bold;">Kedudukan dalam Tim</td>
                    <td style="margin:0;padding:0;text-align:center;width:16%;vertical-align:bottom;line-height:20px;font-weight:bold;">Keterangan</td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;text-align:center;vertical-align:bottom;line-height:20px;">
                        Ketua
                    </td>

                    <td style="margin:0;padding:0;"></td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;text-align:center;vertical-align:bottom;line-height:20px;">
                        Sekretaris
                    </td>
                    <td style="margin:0;padding:0;"></td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;"></td>
                    <td style="margin:0;padding:0;text-align:center;vertical-align:bottom;line-height:20px;">
                        Anggota
                    </td>
                    <td style="margin:0;padding:0;"></td>
                </tr>
            </table>
            <span style="font-size:8pt;"><i>
                *) diisi dengan kedudukan/asal organisasi di desa tersebut, misalnya: perangkat desa/lembaga kemasyarakatan 
                desa/masyarakat dan lain-lain. </i>
            </span>

            <br><br>

            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse: collapse;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:60%; vertical-align:top; padding:0;"></td>
                        <td style="vertical-align:top; padding:0; text-align:left;">
                        <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;margin:0;padding:0;">
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Ditetapkan di</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">_________</td>
                            </tr>
                            <tr style="margin:0; padding:0;">
                                <td style="margin:0;padding:0;">Tanggal</td>
                                <td style="margin:0;padding:0;">:</td>
                                <td style="margin:0;padding:0;">____________</td>
                            </tr>
                        </table>
                        <br>
                        <span style="font-weight:bold;">Kepala Desa </span><br><br><br>

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
        return view('livewire.generator.swakelola.sk-kepala-desa-tpk');
    }
}
