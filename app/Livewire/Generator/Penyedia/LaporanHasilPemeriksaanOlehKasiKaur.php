<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class LaporanHasilPemeriksaanOlehKasiKaur extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center;"><strong>[Kop Penyedia]</strong></p>

                <br>

                <p style="margin:0;">
                    Kepada Yth. <br>
                    Kepala Seksi/Kepala Urusan _______________<br>
                    Desa _______________<br>
                    Tahun _______________<br>
                    di Tempat
                </p>

                <br>

                <p style="text-align:justify; margin:0;">
                    Sehubungan dengan telah dilaksanakannya kegiatan pengadaan _______________ 
                    [diisi dengan nama kegiatan], oleh _______________ 
                    [diisi dengan nama Perusahaan/Toko/CV/BUMDes/BUMDesma/lainnya] yang beralamat di 
                    _______________ pada tanggal __ bulan _______________ tahun _____ yang telah 
                    selesai 100% (seratus persen) sesuai dengan dokumen pengadaan, dengan ini mohon 
                    dapat dilakukan pemeriksaan dan penerimaan hasil pekerjaan.
                </p>

                <br>

                <p style="text-align:justify; margin:0;">
                    Demikian surat ini kami buat, atas perhatian dan kerjasamanya diucapkan terima kasih.
                </p>

                <br><br>

                <table class="no-border" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            ________, __________________ 20____<br><br>
                            Penyedia __________________<br><br>
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
        return view('livewire.generator.penyedia.laporan-hasil-pemeriksaan-oleh-kasi-kaur');
    }
}
