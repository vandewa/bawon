<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class LaporanEvaluasiKegiatan extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <div style="font-family: Arial; font-size: 10pt;">
            <p style="text-align: center; font-weight: bold;">LAPORAN EVALUASI KEGIATAN</p>
        
            <p style="text-align: center;">Pada pengadaan ___________________</p>
            <p style="text-align: right;">__________[tempat], ___[tanggal] _________[bulan]_____[tahun]</p>
            
            <table class="no-border" style="width: 100%; font-size: 10pt; font-family: Arial; border-collapse: collapse; margin: 0; padding: 0;">
                <tr>
                    <td style="width: 15%; margin: 0; padding: 0;">Nomor</td>
                    <td style=" margin: 0; padding: 0;">:</td>
                    <td style=" margin: 0; padding: 0;"></td>
                </tr>
                <tr>
                    <td style=" margin: 0; padding: 0;">Lampiran</td>
                    <td style=" margin: 0; padding: 0;">:</td>
                    <td style=" margin: 0; padding: 0;">1 (satu) berkas</td>
                </tr>
                <tr>
                    <td style=" margin: 0; padding: 0;">Perihal</td>
                    <td style=" margin: 0; padding: 0;">:</td>
                    <td style=" margin: 0; padding: 0;">Laporan Evaluasi Kegiatan Swakelola Berdasarkan Hasil Pengendalian</td>
                </tr>
            </table>

            <p>Kepada Yth: <br>
            Tim Pelaksana Kegiatan (TPK)
            <br>di-</p>
        
            <p style="text-align:justify;">Menindaklanjuti hasil pengendalian pelaksanaan kegiatan Swakelola periode __________ s.d. _______________, berikut kami sampaikan laporan pengendalian pelaksanaan kegiatan sebagaimana terlampir (Laporan Kemajuan Pekerjaan dan Laporan Penggunaan Sumber Daya). Hal-hal yang perlu diperhatikan sebagai berikut:</p>
        
            <table class="no-border" style="width: 100%; font-size: 10pt; font-family: Arial; border-collapse: collapse; margin: 0; padding: 0;">
                <tr>
                    <td style="margin:0;padding:0;">1.</td>
                    <td style="margin:0;padding:0;">Terkait Jadwal ...........</td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;">2.</td>
                    <td style="margin:0;padding:0;">Terkait Biaya .............</td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;">3.</td>
                    <td style="margin:0;padding:0;">Terkait persentase kemajuan ............</td>
                </tr>
                <tr>
                    <td style="margin:0;padding:0;">4.</td>
                    <td style="margin:0;padding:0;">Hal lainnya (misalnya terkait penggunaan sumber daya/material/peralatan).</td>
                </tr>
           </table>
        
            <p>Untuk itu, kami minta agar TPK dapat melakukan perbaikan/tindak lanjut berdasarkan hal-hal tersebut di atas.</p>

            <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                <tr>
                    <td style="width:60%;"></td>
                    <td style="text-align:center;">
                        <span style="font-weight:bold;">
                        Kepala Seksi/Kepala Urusan*
                        </span><br>
                        <span style="font-weight:bold;">
                        Bidang ________
                        </span><br>
                        <span style="font-size:8pt;">
                        <i>*) pilih salah satu</i> 
                        </span><br><br>
                        (tanda tangan)  
                        <br><br>  
                        <span style="font-weight:bold;">
                        (Nama Lengkap)
                        </span><br>
                    </td>
                </tr>
            </table>

        <p>
        Tembusan:<br>
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
        return view('livewire.generator.swakelola.laporan-evaluasi-kegiatan');
    }
}
