<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BastDariKasiKepadaKepalaDesa extends Component
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

                <p style="text-align:justify; margin:0;">
                    Pada hari ini ________ tanggal ______________ bulan _________ tahun ________ bertempat di _________, Kami yang bertandatangan di bawah ini:
                </p>
                
                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr>
                        <td style="width:25%;">Nama</td>
                        <td style="width:2%;">:</td>
                        <td style="width:73%;">________________________</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>________________________</td>
                    </tr>
                    <tr>
                        <td>Kasi/Kaur Bidang</td>
                        <td>:</td>
                        <td>________________________</td>
                    </tr>
                </table>

                <p style="margin:0; text-align:justify;">
                    Selaku Pelaksana Kegiatan Anggaran (PKA) Desa __________ yang selanjutnya disebut sebagai <strong>Pihak Pertama</strong>, dan
                </p>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr>
                        <td style="width:25%;margin:0; padding:0;">Nama</td>
                        <td style="width:2%;margin:0; padding:0;">:</td>
                        <td style="width:73%;margin:0; padding:0;">________________________</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">NIK</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;">Kasi/Kaur</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________</td>
                    </tr>
                </table>

                <p style="margin:0; text-align:justify;">
                    Selaku Pemegang Kekuasaan Pengelolaan Keuangan Desa (PKPKD) ________ yang selanjutnya disebut sebagai <strong>Pihak Kedua</strong>.
                </p>

                <br>

                <p style="text-align:justify; margin:0;">
                    Berdasarkan Berita Acara Serah Terima Nomor ______________ tanggal ______________ bulan _________ tahun _________ telah dilaksanakan pemeriksaan dan penerimaan hasil pekerjaan dan dinyatakan selesai 100% (seratus persen) sesuai volume dan spesifikasi teknis.
                </p>

                <br>

                <p style="text-align:justify; margin:0;">
                    Demikian Berita Acara Serah Terima pekerjaan ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.
                </p>

                <br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;margin:0; padding:0;">
                    <tr>
                        <td style="width:50%; text-align:center;">
                            <br><br><br>
                            <p style="margin:0;">Pihak Kedua,</p>
                            <p style="margin:0;">Kepala Desa __________________</p>
                            <br><br><br>
                            <p style="margin:0;">[ttd]</p>
                            <p style="margin:0;">Nama Lengkap</p>
                        </td>
                        <td style="width:50%; text-align:center;">
                            <p style="margin:0;">__________, __________________ 20____</p><br><br>
                            <p style="margin:0;">Pihak Pertama,</p>
                            <p style="margin:0;">Kasi/Kaur ________________</p>
                            <br><br><br>
                            <p style="margin:0;">[ttd]</p>
                            <p style="margin:0;">Nama Lengkap</p>
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
        return view('livewire.generator.penyedia.bast-dari-kasi-kepada-kepala-desa');
    }
}
