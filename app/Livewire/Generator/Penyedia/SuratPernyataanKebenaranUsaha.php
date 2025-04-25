<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class SuratPernyataanKebenaranUsaha extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt; line-height:1.2; margin:0; padding:0;">
                <p style="text-align:center;">[Kop Penyedia] </p>
                <p style="text-align:center; font-weight:bold;">SURAT PERNYATAAN KEBENARAN USAHA</p>

                <p>Yang bertanda tangan di bawah ini:</p>

                <table class="no-border" style="width:100%; border-collapse:collapse; font-family:Arial; font-size:10pt; margin:0; padding:0;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:30%; margin:0; padding:0;">Nama</td>
                        <td style="width:2%; margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi sesuai KTP/SIM]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">NIK</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi sesuai KTP/SIM]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">Tempat, Tanggal Lahir</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi sesuai KTP/SIM]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">Alamat Tempat Tinggal</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi sesuai KTP/SIM]</td>
                    </tr>
                </table>

                <p>Dengan ini menyatakan bahwa saya adalah benar pemilik perusahaan/toko/pemasok/penyedia* yang bergerak di bidang jasa/perdagangan* ________________________ di Desa __________________, yaitu:</p>

                <table class="no-border" style="width:100%; border-collapse:collapse; font-family:Arial; font-size:10pt; margin:0; padding:0;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:30%; margin:0; padding:0;">Nama Toko</td>
                        <td style="width:2%; margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi dengan nama usaha]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">Alamat</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [diisi dengan alamat usaha]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">No. Telepon</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">_____________ [diisi dengan nomor telepon usaha]</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding:0;">NPWP</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">________________________ [bila ada]</td>
                    </tr>
                </table>

                <p>Selanjutnya saya bersedia untuk melaksanakan pekerjaan pengadaan barang/jasa* ______________ sesuai dengan yang dipesankan oleh TPK.</p>

                <p>Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan penuh rasa tanggung jawab untuk dapat dipergunakan sebagaimana mestinya.</p>

                <p style="font-family:Arial; font-size:8pt;"><i>*) pilih salah satu</i></p>

                <br>

                <table class="no-border" style="width:100%; border-collapse:collapse; font-family:Arial; font-size:10pt; margin:0; padding:0;">
                    <tr style="margin:0; padding:0;">
                        <td style="width:60%; margin:0; padding:0;"></td>
                        <td style="text-align:center; margin:0; padding:0;">
                            ________, __________________ 20____<br><br>
                            Yang membuat pernyataan,<br><br>
                            [materai Rp10.000]<br><br>
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
        return view('livewire.generator.penyedia.surat-pernyataan-kebenaran-usaha');
    }
}
