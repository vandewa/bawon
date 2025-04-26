<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SuratPenyampaianDokumenPersiapan extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:right;">[tempat], ___[tanggal] _________[bulan]_____[tahun]</p><br>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                    <tr style="padding:0; margin:0;">
                        <td style="width:10%; margin:0; padding:0;"><p style="margin:0;padding:0;">Nomor</p></td>
                        <td style="width:1%; margin:0; padding:0;"><p style="margin:0;padding:0;">:</p></td> 
                        <td style="width:55%; margin:0; padding:0;"><p style="margin:0;padding:0;">&nbsp;</td> 
                        <td style="width:34%; margin:0; padding:0;"><p style="margin:0;padding:0;">Kepada Yth: </td> 
                    </tr>
                    <tr style="padding:0; margin:0;">
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">Lampiran</p></td>
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">:</p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">3 berkas</p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">Tim Pelaksana Kegiatan (TPK) </p></td> 
                    </tr>
                    <tr style="padding:0; margin:0;">
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">Perihal</p></td>
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">:</p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">&nbsp;</p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">Pelaksanaan Pengadaan Desa</p></td> 
                    </tr>
                    <tr style="padding:0; margin:0;">
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td>
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">_____________</p></td> 
                    </tr>
                    
                    <tr style="padding:0; margin:0;">
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td>
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">secara Swakelola tahun ________</p></td> 
                    </tr>
                    <tr style="padding:0; margin:0;">
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td>
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;"></p></td> 
                        <td style="margin:0; padding:0;"><p style="margin:0;padding:0;">di-</p></td> 
                    </tr>
                    
                </table>
                </div>

                <br>

                <div style="line-height:15pt;font-family:Arial; font-size:10pt;">
                    <p style="text-align:justify;margin:0;padding:0;">Menindaklanjuti Keputusan Kepala Desa _________________ Nomor ____________ tanggal _______________ tentang Pengesahan Dokumen Pelaksanaan Anggaran (DPA) Desa ____________ Tahun Anggaran ______, dengan ini kami sampaikan dokumen persiapan pengadaan secara Swakelola untuk kegiatan _____________ , yang terdiri dari:</p>
                
                    <p style="margin:0;padding:0;">
                        1. &nbsp;&nbsp;Spesifikasi Teknis/Kerangka Acuan Kerja (KAK);<br>
                        2. &nbsp;&nbsp;Rencana Anggaran Biaya (RAB); dan <br>
                        3. &nbsp;&nbsp;Gambar rencana kerja (apabila diperlukan). <br>
                    </p>
                    
                    <p style="text-align:justify;margin:0;padding:0;">
                    Untuk itu, kami minta agar TPK dapat mempersiapkan pelaksanaan proses pengadaan secara Swakelola kegiatan dimaksud dengan mengacu pada Peraturan Bupati Nomor _______________ tentang Pengadaan Barang/Jasa di Desa.</p>
                </div>
               
            
                <br><br>
            
                <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt;border: none; border-collapse: collapse;">
                    <tr>
                        <td style="width: 60%;"></td>
                        <td>
                             ________, __________________ <br><br>
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
        return view('livewire.generator.swakelola.surat-penyampaian-dokumen-persiapan');
    }
}
