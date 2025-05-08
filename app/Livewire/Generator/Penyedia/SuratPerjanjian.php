<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\SuratPerjanjian as GeneratorSuratPerjanjian;
use App\Models\PaketKegiatan;
use Livewire\Component;
use App\Models\PaketPekerjaan;

class SuratPerjanjian extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;

    public $paketPekerjaan, $paketKegiatan, $cekData;

    public function mount($paketId)
    {
        $this->paketKegiatan = PaketKegiatan::with(['paketPekerjaan.desa'])->find($paketId);

        // dd($this->paketKegiatan);

        if ($this->paketKegiatan) {
            $this->cekData = GeneratorSuratPerjanjian::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {

            $this->isiSurat = <<<HTML
            <div style="font-family: Arial; font-size: 10pt; text-align: justify;">
                <p style="text-align: center;margin:0;font-weight:bold;">SURAT PERJANJIAN</p>
                <p style="text-align: center;margin:0;">Untuk melaksanakan</p>
                <p style="text-align: center;margin:0;">Pekerjaan {$this->paketKegiatan->paketPekerjaan->nama_kegiatan}</p>
                <p style="text-align: center;margin:0;">Nomor: ____________</p>

                <p>SURAT PERJANJIAN ini berikut semua lampirannya dibuat dan ditandatangani di Desa {$this->paketKegiatan->paketPekerjaan->desa->name} Kecamatan ___________ Kabupaten Wonosobo, pada hari \${hari} tanggal \${tanggal} bulan \${bulan} tahun \${tahun} [tanggal, bulan dan tahun diisi dengan huruf], antara {$this->paketKegiatan->paketPekerjaan->nm_pptkd} selaku Kasi/Kaur* {$this->paketKegiatan->paketPekerjaan->nama_subbidang} yang bertugas sebagai Pelaksana Kegiatan Anggaran, bertindak untuk dan atas nama Desa {$this->paketKegiatan->paketPekerjaan->desa->name} Kecamatan ________ yang berkedudukan di _________ selanjutnya disebut "<b>PKA</b>" dan ___________________ selaku Pimpinan/Pemilik* Perusahaan/Pemasok/Toko* _______ yang bertindak untuk dan atas nama Perusahaan/Pemasok/Toko* ______ yang berkedudukan di ___________________, selanjutnya disebut "<b>Penyedia</b>".</p>

                <p>
                PKA dan Penyedia sesuai dengan kewenangannya masing-masing bersepakat dan menyetujui 
                hal-hal sebagai berikut: 
                </p>
                
            </div>

                <ol style="font-size:10pt; font-family:Arial;">
                    <li style="margin-bottom:6pt;">Ruang Lingkup Pekerjaan<br>
                        <span style="text-align: justify;">
                            Ruang lingkup pekerjaan dari Surat Perjanjian ini adalah {$this->paketKegiatan->paketPekerjaan->nama_kegiatan} dengan spesifikasi ______________ _____________________. 
                        </span>
                    </li>
                    <li style="margin-bottom:6pt;">Ruang Lingkup Pekerjaan<br>
                        <span style="text-align: justify;">
                            Total nilai pekerjaan termasuk Pajak Pertambahan Nilai (PPN) yang diperoleh berdasarkan jumlah dan harga satuan pekerjaan sebagaimana tercantum dalam hasil negosiasi adalah sebesar Rp _______________ (___________________ rupiah). Pembayaran pekerjaan ini melalui rekening Bank ____ Cabang ____ nomor rekening __________________ atas nama pimpinan/pemilik* Perusahaan/Pemasok/Toko* __________________.
                        </span>
                    </li>
                    <li style="margin-bottom:6pt;">Hak dan Kewajiban baik PKA dan Penyedia dinyatakan dalam Surat Perjanjian ini meliputi khususnya: <br>
                    a. PKA mempunyai hak dan kewajiban: <br>
                    &nbsp;&nbsp; 1) Meminta laporan secara berkala mengenai pelaksanaan pekerjaan yang dilakukan oleh Penyedia; <br>
                    &nbsp;&nbsp; 2) Mengawasi dan memeriksa pekerjaan yang dilaksanakan oleh Penyedia; <br>
                    &nbsp;&nbsp; 3) Memberikan fasilitas berupa sarana dan prasarana (contoh: tempat pertemuan, tempat penyimpanan peralatan, perizinan, dll) yang dibutuhkan oleh Penyedia untuk kelancaran pelaksanaan pekerjaan sesuai Surat Perjanjian; <br>
                    &nbsp;&nbsp; 4) Membayar sesuai dengan nilai pekerjaan yang tercantum dalam Surat Perjanjian yang telah ditetapkan kepada Penyedia. <br>

                    b. Penyedia mempunyai hak dan kewajiban: <br>
                    &nbsp;&nbsp; 1) Melaporkan pelaksanaan pekerjaan secara berkala kepada PKA;  <br>
                    &nbsp;&nbsp; 2) Melaksanakan dan menyelesaikan pekerjaan sesuai dengan jadwal pelaksanaan 
                    pekerjaan yang telah ditetapkan dalam Surat Perjanjian;  <br>
                    &nbsp;&nbsp; 3) Meminta fasilitas-fasilitas dalam bentuk sarana dan prasarana dari PKA untuk kelancaran pelaksanaan pekerjaan sesuai dengan Surat Perjanjian; <br>
                    &nbsp;&nbsp; 4) Menerima pembayaran untuk pelaksanaan pekerjaan sesuai dengan harga yang telah ditentukan dalam Surat Perjanjian; <br>
                    &nbsp;&nbsp; 5) Melaksanakan dan menyelesaikan seluruh butir-butir pekerjaan secara cermat, akurat, dan dapat dipertanggungjawabkan sesuai dengan rincian pekerjaan dalam Surat Perjanjian; <br>
                    &nbsp;&nbsp; 6) Memberikan keterangan-keterangan yang diperlukan untuk pemeriksaan pelaksanaan yang dilakukan PKA; <br>
                    &nbsp;&nbsp; 7) Menyerahkan hasil pekerjaan sesuai dengan jadwal penyerahan pekerjaan yang telah ditetapkan dalam Surat Perjanjian.

                    <li style="margin-bottom:6pt;">Jangka Waktu Pelaksanaan Pekerjaan<br>
                        <span style="text-align: justify;">
                        Masa pelaksanaan pekerjaan mulai berlaku efektif terhitung sejak tanggal yang ditetapkan dalam Surat Perjanjian dan Penyedia sanggup menyelesaikan keseluruhan pekerjaan selama ____ (__________) hari kalender terhitung sejak terbitnya Surat Perjanjian. 
                        </span>
                    </li>
                    <li style="margin-bottom:6pt;">Tata Cara Pembayaran<br>
                        &nbsp;&nbsp;a. Pembayaran dilaksanakan secara sekaligus/termin/berkala* sesuai kemajuan pekerjaan. <br> 
                        &nbsp;&nbsp; b. PKA membayar kepada Penyedia sebesar Rp__________ (__________ rupiah) setelah pekerjaan selesai sesuai dengan ketentuan huruf a. <br>
                        &nbsp;&nbsp; c. Pembayaran atas prestasi pekerjaan kepada Penyedia sebagaimana dimaksud pada huruf b diberikan setelah Kasi/Kaur melakukan pemeriksaan yang dituangkan dalam Laporan Hasil Kegiatan Penyedia dan Berita Acara Serah Terima Hasil Pekerjaan.
                    </li>
                    <li style="margin-bottom:6pt;">Garansi/Jaminan<br>
                        a. Penyedia memberikan garansi terhadap seluruh barang/bahan* yang diserahkan dengan masa garansi selama __________ (_____________) bulan sejak barang/bahan* tersebut diserahkan. <br>
                        b. Garansi terhadap kerusakan barang/bahan* ______ tidak berlaku apabila: <br>
                        &nbsp;&nbsp; 1) Diluar masa garansi <br>
                        &nbsp;&nbsp; 2) Kerusakan yang diakibatkan oleh: <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; a) Kesalahan dan/atau kelalaian penggunaan <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; b) Penyimpanan yang tidak sesuai dengan ketentuan <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; c) Penggunaan suku cadang dan sistem operasi tidak resmi <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; d) Suhu atau tekanan luar <br>
                        c. Jaminan Pemeliharaan (untuk pekerjaan konstruksi) <br>
                        &nbsp;&nbsp; 1) Jaminan Pemeliharaan sebesar 5% (lima persen) dari nilai pekerjaan. <br>
                        &nbsp;&nbsp; 2) Jaminan Pemeliharaan dikembalikan setelah ditandatanganinya Berita Acara Serah Terima akhir. 
                    </li>
                    <li style="margin-bottom:6pt;">Ketentuan Keadaan Kahar<br>
                        a. Keadaan kahar merupakan salah satu keadaan yang terjadi diluar kehendak para pihak dan tidak dapat diperkirakan sebelumnya, sehingga kewajiban yang ditentukan dalam Surat Perjanjian menjadi tidak dapat dipenuhi. Keadaan kahar tidak terbatas pada: <br>
                        &nbsp;&nbsp; 1) Bencana alam; <br>
                        &nbsp;&nbsp; 2) Bencana non alam; <br>
                        &nbsp;&nbsp; 3) Bencana sosial; <br>
                        &nbsp;&nbsp; 4) Pemogokan; <br>
                        &nbsp;&nbsp; 5) Kebakaran; dan/atau <br>
                        &nbsp;&nbsp; 6) Kondisi cuaca ekstrim. <br>
                        b. Dalam hal terjadi keadaan kahar, Penyedia memberitahukan tentang terjadinya keadaan 
                        kahar kepada PKA secara tertulis dalam waktu paling lambat 7 (tujuh) hari kalender sejak 
                        terjadinya keadaan kahar dengan menyertakan salinan asli pernyataan kahar yang 
                        dikeluarkan oleh pihak/instansi yang berwenang sesuai ketentuan peraturan perundang
                        undangan yang berlaku. <br>
                        c. Keterlambatan pelaksanaan pekerjaan yang diakibatkan terjadinya keadaan kahar tidak dikenakan sanksi. <br>
                        d. Setelah terjadinya keadaan kahar, para pihak dapat melakukan kesepakatan kembali, dan selanjutnya dituangkan dalam perubahan Surat Perjanjian Kerja.
                    </li>
                    <li style="margin-bottom:6pt;">Sanksi dan Denda Keterlambatan<br>
                        a. Sanksi <br>
                        &nbsp;&nbsp; 1) Penyedia dapat diberikan Sanksi berupa peringatan/teguran tertulis; gugatan secara perdata; dan/atau pelaporan secara pidana kepada pihak yang berwenang, jika terbukti melakukan dengan sengaja perbuatan atau tindakan sebagai berikut: <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a) Berusaha mempengaruhi Kasi/Kaur atau pihak lain yang berwenang dalam bentuk dan cara apapun, baik langsung maupun tidak langsung guna memenuhi keinginannya yang bertentangan dengan ketentuan prosedur yang telah ditetapkan dalam Surat Perjanjian, dan/atau ketentuan peraturan perundang-undangan yang berlaku; <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b) Mengundurkan diri dari pelaksanaan Surat Perjanjian dengan alasan yang tidak dapat dipertanggungjawabkan dan/atau tidak dapat diterima oleh Kasi/Kaur; dan/atau <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c) Tidak dapat menyelesaikan pekerjaan sesuai dengan Surat Perjanjian.  <br>
                        &nbsp;&nbsp; 2) Apabila ditemukan penipuan/pemalsuan atas informasi yang disampaikan Penyedia, dikenakan sanksi pembatalan sebagai Penyedia. <br>
                        b. Denda Keterlambatan <br>
                        Apabila penyedia wanprestasi dikarenakan keterlambatan dalam menyelesaikan pekerjaan sesuai Surat Perjanjian, maka kepada penyedia dikenakan denda untuk setiap hari  keterlambatan sebesar ... (...) [contoh: 1‰]  (satu perseribu) dari nilai pekerjaan/bagian pekerjaan apabila bagian pekerjaan yang sudah selesai dapat dimanfaatkan* (pilih salah satu) diluar PPN. 
                    </li>
                    <li style="margin-bottom:6pt;">Penyelesaian Perselisihan<br>
                        Dalam hal terjadi perselisihan antara PKA dan Penyedia dalam Pengadaan, maka terlebih dahulu menyelesaikan perselisihan tersebut melalui musyawarah untuk mufakat. Jika penyelesaian perselisihan secara musyawarah tidak mencapai mufakat, maka penyelesaian perselisihan dilakukan melalui musyawarah yang dipimpin oleh Kepala desa atau dapat dilakukan melalui Layanan Penyelesaian Sengketa Kontrak Pengadaan atau Pengadilan Negeri dalam wilayah hukum Republik Indonesia.
                    </li>
                </ol>
                <div style="font-family: Arial; font-size: 10pt; text-align: justify;">
                    Demikian Surat Perjanjian ini dibuat dan ditandatangani oleh PKA dan Penyedia pada hari, tanggal, bulan dan tahun tersebut di awal Surat Perjanjian dalam rangkap ___ (_____), 2 (dua) diantaranya bermeterai cukup untuk PKA dan Penyedia. 
                </div>

                <table class="no-border" style="width:100%; border:0; border-collapse:collapse;">
                    <tr>
                        <td style="width:50%; padding:10pt; vertical-align:top;">
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Untuk dan atas nama</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Desa</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Kasi/Kaur Selaku Pelaksana</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Kegiatan Anggaran</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">&nbsp;</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">[tanda tangan dan cap sekretariat Desa] </p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">&nbsp;</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">{$this->paketKegiatan->paketPekerjaan->nm_pptkd},</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">{$this->paketKegiatan->paketPekerjaan->jbt_pptkd}</p>
                        </td>
                        <td style="width:50%; padding:10pt; vertical-align:top;">
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Untuk dan atas nama</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Penyedia</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">Perusahaan/Pemasok/Toko*</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">&nbsp;</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">[tanda tangan dan cap (apabila ada)]</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">&nbsp;</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">[nama lengkap],</p>
                            <p style="margin:0; text-align:center; font-size:10pt; font-family:Arial;">[jabatan]</p>
                        </td>
                    </tr>
                </table>

                <div style="font-family: Arial; font-size: 10pt;">
                    <p>Catatan : <br>
                        - Surat Perjanjian dengan meterai Rp10.000,00 pada bagian tanda tangan Pelaksana 
                            Kegiatan Anggaran diserahkan untuk Penyedia; dan - <br>
                        - Surat Perjanjian dengan meterai Rp10.000,00 pada bagian tanda tangan Penyedia 
                            diserahkan untuk Pelaksana Kegiatan Anggaran. 
                        </tr>               
                    </p>
                </div>

            HTML;
        }

    }


    public function simpan()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;

        if ($this->cekData) {
            // Update ke database
            GeneratorSuratPerjanjian::where('paket_kegiatan_id', $paketId)->update([
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        } else {
            // Simpan data baru
            GeneratorSuratPerjanjian::create([
                'paket_kegiatan_id' => $paketId,
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        }


        $this->sudahDisimpan = true; // aktifkan tombol download setelah simpan
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.surat-perjanjian');
    }
}
