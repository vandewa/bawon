<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class PenetapanPemenang extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {

        $this->isiSurat = <<<HTML
        <div style="font-family:Arial; font-size:10pt; line-height:1; margin:0; padding:0;">
            <p style="text-align:center; font-weight:bold;">[Kop Surat TPK/Desa]</p>
        
            <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                <tr style="margin:0; padding:0;">
                    <td style="width:15%; padding:0; margin:0;">Nomor</td>
                    <td style="width:2%; padding:0; margin:0;">:</td>
                    <td style="width:83%; padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Lampiran</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Perihal</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;">Penetapan Pemenang Paket Pekerjaan</td>
                </tr>
            </table>
        
            <p style="text-align:justify;">Berdasarkan Berita Acara Hasil Negosiasi Nomor _______________ tanggal _______________, maka dengan ini kami tetapkan sebagai pemenang penawaran untuk:</p>
        
            <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                <tr style="margin:0; padding:0;">
                    <td style="width:25%; padding:0; margin:0;">Kegiatan</td>
                    <td style="width:2%; padding:0; margin:0;">:</td>
                    <td style="width:73%; padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Paket Pekerjaan</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Nilai HPS</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Sumber Dana</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Tahun Anggaran</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
            </table>
        
            <p style="text-align:justify;">Adalah sebagai berikut,</p>
        
            <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; padding:0;">
                <tr style="margin:0; padding:0;">
                    <td style="width:25%; padding:0; margin:0;">Nama Penyedia</td>
                    <td style="width:2%; padding:0; margin:0;">:</td>
                    <td style="width:73%; padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Alamat</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;"></td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;">Nilai Kontrak</td>
                    <td style="padding:0; margin:0;">:</td>
                    <td style="padding:0; margin:0;">Rp ____________________</td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="padding:0; margin:0;"></td>
                    <td style="padding:0; margin:0;"></td>
                    <td style="padding:0; margin:0;">(_________________________________)</td>
                </tr>
            </table>
        
            <p style="margin:0; text-align:justify;">Selanjutnya untuk proses transaksi akan dituangkan dalam bentuk SPK antara Kasi/Kaur* __________________________________ sebagai Pelaksana Kegiatan Anggaran (PKA) dengan Penyedia __________________________________.</p>
        
            <br><br>
        
            <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                <tr>
                    <td style="width:50%;"></td>
                    <td style="text-align:center;">
                        ________, __________________ 20____<br><br><br>
                        An. Tim Pelaksana Kegiatan<br>
                        Desa ____________________<br>
                        Tahun Anggaran _______<br><br>
                        Ketua:<br><br>
                        tanda tangan,<br><br>
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
        return view('livewire.generator.penyedia.penetapan-pemenang');
    }
}
