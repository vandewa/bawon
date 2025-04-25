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
                <p style="text-align:center; font-weight:bold;">PENYAMPAIAN DOKUMEN PERSIAPAN SWAKELOLA</p>
            
                <p style="text-align:left;">[tempat], ___[tanggal] _________[bulan]_____[tahun]</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt; border-collapse:collapse;">
                    <tr>
                        <td style="width:50%; vertical-align:top;">
                            Nomor       : <br>
                            Lampiran    : 3 berkas <br>
                            Perihal    : 3 berkas <br>
                        </td>
                        <td style="width:50%;">
                            Kepada Yth: <br>
                            Tim Pelaksana Kegiatan (TPK) <br>
                            Pelaksanaan Pengadaan Desa <br>
                            ___________________<br>
                            secara Swakelola Tahun ______<br>
                            di-<br>
                        </td>
                    </tr>
                </table>

                <p style="text-align:justify;">Menindaklanjuti Keputusan Kepala Desa _________________ Nomor ____________ tanggal _______________ tentang Pengesahan Dokumen Pelaksanaan Anggaran (DPA) Desa ____________ Tahun Anggaran ______, dengan ini kami sampaikan dokumen persiapan pengadaan secara Swakelola untuk kegiatan _____________ , yang terdiri dari:</p>
            
                <ul style="font-size:10pt;">
                    <li>Spesifikasi Teknis/Kerangka Acuan Kerja (KAK);</li>
                    <li>Rencana Anggaran Biaya (RAB); dan</li>
                    <li>Gambar rencana kerja (apabila diperlukan).</li>
                </ul>
            
                <p style="text-align:justify;">Untuk itu, kami minta agar TPK dapat mempersiapkan pelaksanaan proses pengadaan secara Swakelola kegiatan dimaksud dengan mengacu pada Peraturan Bupati Nomor _______________ tentang Pengadaan Barang/Jasa di Desa.</p>
            
                <br><br>
            
                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;font-weight: bold;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            ___________________ <br><br>
                            Kepala \${jenis_kepala}<br>
                            Bidang \${bidang}<br><br><br><br>
                            (\${nama_lengkap})
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
        return view('livewire.generator.swakelola.surat-penyampaian-dokumen-persiapan');
    }
}
