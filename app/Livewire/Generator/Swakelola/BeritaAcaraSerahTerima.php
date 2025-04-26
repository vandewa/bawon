<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BeritaAcaraSerahTerima extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">BERITA ACARA SERAH TERIMA</p>
        
                <p style="text-align:center;">Nomor: ________________________</p>
        
                <p style="margin:3px;text-align:justify;">Pada hari ini ________ Tanggal ______ Bulan _______________ Tahun ______, Kami selaku Tim Pelaksana Kegiatan (TPK) Pengadaan Barang/Jasa Desa _______________ yang ditetapkan dengan Surat Keputusan Kepala Desa _______________ Nomor: _______________ tanggal _______________ Tahun Anggaran _____, telah menyelesaikan 100% (seratus persen) pekerjaan secara Swakelola dan menyerahkan seluruh hasil kegiatan pengadaan kepada Kasi/Kaur* _______________ Desa _______________ dengan baik sesuai yang dipersyaratkan dalam dokumen persiapan. Selanjutnya Kasi/Kaur* _______________ menerima hasil kegiatan pengadaan yaitu berupa:</p>

                <table class="no-border" style="width: 100%; font-size: 10pt; font-family: Arial; border-collapse: collapse; margin: 0; padding: 0;">
                    <tr>
                        <td style="width: 3%; margin: 0; padding: 0;">1.</td>
                        <td style="width: 20%; margin: 0; padding: 0;">Nama Kegiatan</td>
                        <td style="width: 2%; margin: 0; padding: 0;">:</td>
                        <td style="width: 75%; margin: 0; padding: 0;text-align:justify;"> __________________________ [diisi dengan nama pekerjaan] </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;">2.</td>
                        <td style="margin: 0; padding: 0;">Nilai Pengadaan</td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;"> Rp _________(________) [diisi dengan nominal dan terbilang] </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;">3.</td>
                        <td style="margin: 0; padding: 0;">Keluaran/Output </td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">_________________________ [terdiri dari volume dan satuan]</td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;">4.</td>
                        <td style="margin: 0; padding: 0;" colspan="3">Nama TPK</td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;"></td>
                        <td style="margin: 0; padding: 0;"><li>Ketua</li></td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">________________________________ [diisi nama sesuai KTP]</td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;"></td>
                        <td style="margin: 0; padding: 0;"><li>Sekretaris</li></td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">________________________________ [diisi nama sesuai KTP]</td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;"></td>
                        <td style="margin: 0; padding: 0;"><li>Anggota</li></td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">________________________________ [diisi nama sesuai KTP]</td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;">5.</td>
                        <td style="margin: 0; padding: 0;">Lokasi Pekerjaan</td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">____________________________ [diisi nama lokasi pekerjaan] </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding: 0;">6.</td>
                        <td style="margin: 0; padding: 0;">Periode Pekerjaan</td>
                        <td style="margin: 0; padding: 0;">:</td>
                        <td style="margin: 0; padding: 0;text-align:justify;">_________________________ [diisi tanggal mulai dan selesai]</td>
                    </tr>
                
                </table>
        
                <p>Demikian Berita Acara Serah Terima ini dibuat dengan sebenar-benarnya untuk digunakan sebagaimana mestinya.</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                <tr>
                    <td style="width:50%; text-align:center;vertical-align:top;">
                        Yang menerima,<br>
                        <span style="font-weight:bold;">
                            Kasi/Kaur _______________ 
                        </span><br>
                        <span style="font-weight:bold;">
                            Desa _______________ 
                        </span>
                        <br><br><br>

                        ttd
                       
                        <br><br><br>
                        (nama lengkap)
                       
                    </td>
                    <td style="width:50%;text-align:center;">
                        <span>
                            Yang menyerahkan, 
                        </span><br>
                        <span style="font-weight:bold;">
                            Tim Pelaksana Kegiatan (TPK) 
                        </span> <br>
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
            
            <p>
                Tembusan: <br>
                Kepala Desa
            </p>
        
                
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
        return view('livewire.generator.swakelola.berita-acara-serah-terima');
    }
}
