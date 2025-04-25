<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BastDariPenyediaKepadaKasi extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <div style="font-family:Arial; font-size:10pt;">
            <p style="text-align:center; font-weight:bold; margin:0;">BERITA ACARA SERAH TERIMA</p>
            <p style="text-align:center; margin:0;">Nomor: _________________</p>
            <br>
        
            <p style="text-align:justify;">Pada hari ini ________ tanggal ______________ bulan _________ tahun ________ bertempat di _________, Kami yang bertandatangan di bawah ini:</p>
        
            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; margin:0; padding:0;">
                <tr>
                    <td style="width:20%;margin:0; padding:0;">&nbsp;&nbsp;Nama</td>
                    <td style="width:2%;margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
                <tr>
                    <td style="margin:0; padding:0;">&nbsp;&nbsp;NIK</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
                <tr>
                    <td style="margin:0; padding:0;">&nbsp;&nbsp;Alamat</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
            </table>
        
            <p style="text-align:justify;">Selaku Pemilik Toko/CV/BUMDes/lainnya* __________ yang selanjutnya disebut sebagai <strong>Pihak Pertama</strong>, dan</p>
        
            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; margin:0; padding:0;">
                <tr>
                    <td style="width:20%;margin:0; padding:0;">&nbsp;&nbsp;Nama</td>
                    <td style="width:2%;margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
                <tr>
                    <td style="margin:0; padding:0;">&nbsp;&nbsp;NIK</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
                <tr>
                    <td style="margin:0; padding:0;">&nbsp;&nbsp;Kasi/Kaur</td>
                    <td style="margin:0; padding:0;">:</td>
                    <td style="margin:0; padding:0;">__________________________________________</td>
                </tr>
            </table>
        
            <p style=" text-align:justify;">Selaku Pelaksana Kegiatan Anggaran (PKA) Desa ________ yang selanjutnya disebut sebagai <strong>Pihak Kedua</strong>.</p>
        
            <p style=" text-align:justify;">Berdasarkan Surat Perjanjian Nomor ______________ tanggal ______________ bulan _________ tahun _________ telah dilaksanakan pemeriksaan dan penerimaan hasil pekerjaan dan dinyatakan selesai 100% (seratus persen) sesuai volume dan spesifikasi teknis.</p>
        
            <p style=" text-align:justify;">Demikian Berita Acara Serah Terima pekerjaan ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
            <p style="font-size:8pt;"><i>*) pilih salah satu</i></p>
        
            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                <tr>
                    <td style="width:50%; text-align:center;">
                        <br><br>
                        <strong>Pihak Kedua,</strong><br>
                        Kasi/Kaur __________________<br>
                        Desa __________________<br><br>
                        [ttd]<br><br>
                        Nama Lengkap<br>
                        <span style="font-size:8pt;">Stempel (bila ada)</span>
                    </td>
                    <td style="width:50%; text-align:center;">
                        __________, __________________ 20____<br><br>
                        <strong>Pihak Pertama,</strong><br>
                        Penyedia<br>
                        Perusahaan/Toko/CV/BUMDes/BUMDesma/lainnya* ________________<br><br>
                        [ttd]<br><br>
                        Nama Lengkap
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
        return view('livewire.generator.penyedia.bast-dari-penyedia-kepada-kasi');
    }
}
