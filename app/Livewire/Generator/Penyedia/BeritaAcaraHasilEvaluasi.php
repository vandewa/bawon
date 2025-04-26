<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BeritaAcaraHasilEvaluasi extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <div style="font-family:Arial; font-size:10pt;">
            <p style="text-align:center; font-weight:bold;margin:0;padding:0;"><u>BERITA ACARA HASIL EVALUASI PENAWARAN</u></p>
            <p style="text-align:center;margin:0;padding:0;">Nomor: _________________</p>
        
            <p style="text-align:justify; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pada hari ini _________________ tanggal ___ bulan _________________ tahun ______, kami selaku Tim Pelaksana Kegiatan (TPK) Desa _________________ yang ditetapkan dengan Surat Keputusan Kepala Desa _________________ Nomor: _________________ tanggal _________________, telah melaksanakan evaluasi penawaran untuk:</p>
        
            <table class="no-border" style="width:100%; border-collapse:collapse;font-family:Arial; font-size:10pt;">
                <tr style="margin:0; padding:0;">
                    <td style="width:20%;margin:0; padding:0;">Kegiatan</td>
                    <td style="width:1%;">:</td>
                    <td></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;">Lingkup Pekerjaan</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;">Lokasi</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;">Nilai HPS</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">Rp</td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;">Sumber Dana</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;">Tahun Anggaran</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;"></td>
                </tr>
            </table>
        
            <p style="margin:0; padding:0;">Dengan rincian sebagai berikut:</p>

            <p style="text-align:justify;margin:0;">
                1. Perusahaan/Toko/Pemasok* yang telah memasukan penawaran dalam proses pengadaan dengan cara permintaan penawaran sebanyak _____________ dan memenuhi persyaratan untuk dievaluasi, yaitu: 
            </p>

            <table border="1" style="width:100%; border-collapse:collapse;font-family:Arial; font-size:10pt;">
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;width:50%;">Nama Perusahaan/Toko/Pemasok* </td>
                    <td style="margin:0; padding:0;text-align:center;width:50%;">Alamat</td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;vertical-align:top;">
                        <p class="ml-2"> 1. [diisi nama penyedia]</p>
                        <p class="ml-2">2. [diisi nama penyedia]</p>
                        <p class="ml-2">3. dst </p>
                    </td>
                    <td style="margin:0; padding:0;">
                    <p class="ml-2">1. ... </p>
                    <p class="ml-2">2. ... </p>
                    <p class="ml-2">3. dst </p>
                    </td>
                </tr>
            </table>

            <br>

            <p style="text-align:justify;margin:0;">
                2. Unsur-unsur yang dinilai dalam evaluasi penawaran adalah sebagai berikut: 
            </p>

            <table border="1" style="width:100%; border-collapse:collapse;font-family:Arial; font-size:10pt;">
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;font-weight:bold;">
                        No
                    </td>
                    <td style="margin:0; padding:0;text-align:center;font-weight:bold;">
                        Uraian
                    </td>
                    <td style="margin:0; padding:0;text-align:center;font-weight:bold;">
                        Ada/Tidak Ada 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;font-weight:bold;">
                        Hasil Evaluasi
                    </td>
                </tr>

                <tr style="margin:0; padding:0;">
                    <td style="text-align:center;">
                        1.
                    </td>
                    <td colspan="3" style="text-align:center;font-weight:bold;">
                        Evaluasi Administrasi 
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td rowspan="2"></td>
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;">
                        Surat Pernyataan Kebenaran Usaha 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        Ada/Tidak Ada 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        <i>[memenuhi syarat/tidak memenuhi]*</i>
                    </td>
                    
                </tr>
                <tr style="margin:0; padding:0;">
                    <td>
                        1. [diisi nama penyedia] <br>
                        2. [diisi nama penyedia] <br>
                        3. dst
                    </td>
                    <td>
        
                    </td>
                    <td>
                        
                    </td>
                </tr>

                <tr style="margin:0; padding:0;">
                    <td style="text-align:center;">
                        2.
                    </td>
                    <td colspan="3" style="text-align:center;font-weight:bold;">
                        Evaluasi Teknis 
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td rowspan="2"></td>
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;">
                        Spesifikasi teknis 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        Ada/Tidak Ada 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        <i>[memenuhi syarat/tidak memenuhi]*</i>
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td>
                        1. [diisi nama penyedia] <br>
                        2. [diisi nama penyedia] <br>
                        3. dst
                    </td>
                    <td>
        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td rowspan="2"></td>
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;">
                        Jadwal pelaksanaan pekerjaan  
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        Ada/Tidak Ada 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td>
                        1. [diisi nama penyedia] <br>
                        2. [diisi nama penyedia] <br>
                        3. dst
                    </td>
                    <td>
        
                    </td>
                    <td>
                        
                    </td>
                </tr>

                <tr style="margin:0; padding:0;">
                    <td style="text-align:center;">
                        3.
                    </td>
                    <td colspan="3" style="text-align:center;font-weight:bold;">
                        Evaluasi Harga (diurutkan dari harga penawaran terendah) 
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td rowspan="2"></td>
                    <td style="margin:0; padding:0;vertical-align:top;text-align:center;">
                        Daftar kuantitas dan harga 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        Ada/Tidak Ada 
                    </td>
                    <td style="margin:0; padding:0;text-align:center;">
                        <i>[Lulus/tidak lulus, _____% dari HPS]</i>
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td>
                        1. [diisi nama penyedia] <br>
                        2. [diisi nama penyedia] <br>
                        3. dst
                    </td>
                    <td>
        
                    </td>
                    <td>
                        
                    </td>
                </tr>

            </table>
            <br>
        
            <p>Dari hasil evaluasi Penawaran, Penyedia _________________ (diisi dengan penawaran terendah hasil evaluasi penawaran harga) dinyatakan lulus memenuhi persyaratan, selanjutnya TPK akan mengadakan negosiasi terhadap penyedia yang lulus tersebut sebelum ditetapkan menjadi pelaksana pekerjaan. </p>
        
            <p>Demikian Berita Acara Hasil Evaluasi Penawaran ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
        
            <p style="text-align:right;">__________, __________________ 20____</p>

            <table class="no-border" style="width:100%; border-collapse:collapse; font-family:Arial; font-size:10pt; margin:0;">
                <tr>
                    <td></td>
                    <td>Tim Pelaksana Kegiatan (TPK)</td>
                </tr>
                <br><br>
                <tr style="margin:0; padding:0;">
                    <td style="text-align:right;">________________[nama Ketua]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>1. __________________: </td> <br>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td></td>
                    <td>Ketua</td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="text-align:right;">________________[nama Sekretaris]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>2. __________________: </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td></td>
                    <td>Sekretaris</td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="text-align:right;">________________[nama Anggota]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>3. __________________: </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td></td>
                    <td>Anggota</td>
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
        return view('livewire.generator.penyedia.berita-acara-hasil-evaluasi');
    }
}
