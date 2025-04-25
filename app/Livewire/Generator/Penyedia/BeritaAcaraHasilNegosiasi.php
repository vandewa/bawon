<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BeritaAcaraHasilNegosiasi extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {

        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center;">[Kop Surat TPK/Desa] </p>
                <p style="text-align:center; font-weight:bold; margin:0;"><u>BERITA ACARA HASIL NEGOSIASI</u></p>
                <p style="text-align:center; margin:0 0 10px;">Nomor: _________________</p>

                <p style="text-align:justify; margin:0 0 10px;">
                    Pada hari ini _________________ tanggal ___ bulan _________________ tahun ______, kami selaku Tim Pelaksana Kegiatan (TPK) Desa _________________ yang ditetapkan dengan Surat Keputusan Kepala Desa _________________ Nomor: _________________ tanggal _________________, telah melaksanakan negosiasi harga untuk:
                </p>

                <table class="no-border" style="width:100%; border:0; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:25%; padding:0; margin:0;">Kegiatan</td>
                        <td style="width:2%; padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">__________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Lingkup Pekerjaan</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">__________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Lokasi</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">__________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Penawaran harga dari</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">Perusahaan/Toko/Pemasok*</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Alamat</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">__________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Harga Penawaran</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">Rp ______________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding:0; margin:0;">Terbilang</td>
                        <td style="padding:0; margin:0;">:</td>
                        <td style="padding:0; margin:0;">__________________________________________________</td>
                    </tr>
                </table>
                <p style="text-align:justify; margin-top:10px;">
                    Setelah dilakukan negosiasi menjadi sebesar Rp _____________ (______________). Rincian negosiasi terlampir.
                </p>

                <p style="text-align:justify;">
                    Selanjutnya untuk proses transaksi akan dituangkan dalam bentuk Surat Perjanjian antara Kasi/Kaur* _________________ sebagai Pelaksana Kegiatan Anggaran (PKA) dengan Pimpinan/Pemilik* Perusahaan/Toko/Pemasok* _________________.
                </p>

                <p style="text-align:justify;">
                    Demikian Berita Acara Hasil Negosiasi ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.
                </p>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; margin-top:20px;">
                    <tr>
                        <td style="width:50%;"></td>
                        <td style="text-align:center;">__________, __________________ 20____</td>
                    </tr>
                </table>

                <br><br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial;">
                    <tr>
                        <td style="width:50%; text-align:center;">
                            Tim Pelaksana Kegiatan (TPK)
                        </td>
                        <td style="text-align:center;">
                            Perusahaan/Toko/Pemasok*
                        </td>
                    </tr>
                    <tr><td colspan="2"><br><br></td></tr>
                    <tr>
                        <td style="text-align:center;">1. Ketua</td>
                        <td style="text-align:center;">Nama Lengkap<br>Stempel (bila ada)</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">2. Sekretaris</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">3. Anggota</td>
                        <td></td>
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
        return view('livewire.generator.penyedia.berita-acara-hasil-negosiasi');
    }
}
