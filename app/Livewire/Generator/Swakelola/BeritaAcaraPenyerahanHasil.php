<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class BeritaAcaraPenyerahanHasil extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;margin:0;padding:0;"><u>BERITA ACARA PENYERAHAN HASIL SWAKELOLA</u></p>
                <p style="text-align:center; font-weight:bold;margin:0;padding:0;">Nomor : ______________________</p>

                <p style="text-align:justify;">Berdasarkan Berita Acara Serah Terima Nomor _________ [diisi nomor Berita Acara Serah Terima] tanggal _____________ (sebagaimana terlampir), dengan ini dilaporkan bahwa Pengadaan Barang/Jasa __________ [ditulis nama pekerjaan Swakelola] telah selesai dilaksanakan berdasarkan dokumen persiapan Swakelola nomor _________ [diisi nomor dokumen persiapan Swakelola] tanggal _________ [diisi tanggal dokumen persiapan].</p>
                
                 <p style="text-align:justify;">Selanjutnya, Kepala Seksi/Kepala Urusan* Bidang ____________ menyerahkan hasil pekerjaan beserta dokumen Pengadaan Barang/Jasa kepada Kepala Desa _________.</p>

                 <p style="text-align:justify;">Demikian Berita Acara Penyerahan Hasil Pengadaan dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
                
                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                <tr>
                    <td style="width:50%; text-align:center;">
                        <br><br>
                        Yang menerima,<br>
                        <span style="font-weight:bold;">
                            Kepala Desa _______     
                        </span><br>
                        <span>
                        Selaku Pemegang Kekuasaan <br>
                        Pengelolaan Keuangan Desa <br>
                        (PKPKD) 
                        </span>
                        <br><br>
                        [ttd]<br><br>
                        <span style="font-weight:bold;">
                        (Nama Lengkap)       
                        </span>
                    </td>
                    <td style="width:50%; text-align:center;">
                        <br><br>
                            Yang menyerahkan,<br>
                        <span style="font-weight:bold;">
                            Kasi/Kaur* _______    
                        </span><br>
                        <span style="font-weight:bold;">
                            Desa _______     
                        </span><br>
                        <span>
                        Selaku Pelaksana Pengelolaan <br>
                        Keuangan Desa (PPKD)
                        </span>
                        <br><br>
                        [ttd]<br><br>
                        <span style="font-weight:bold;">
                        (Nama Lengkap)       
                        </span>
                    </td>
                </tr>
            </table>
                <p style="font-size:8pt;"><i>*) pilih salah satu</i></p>
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
        return view('livewire.generator.swakelola.berita-acara-penyerahan-hasil');
    }
}
