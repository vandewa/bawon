<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class Spk extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <p style='margin:0; font-family:Arial; font-size:10pt;text-align:center;'>[Kop Surat Kasi/Kaur]</p>
        <table style='border-collapse:collapse; width:100%; border:1pt solid #000;'>
        <tr>
            <td style='width:30%; border:1pt solid #000; padding:5pt; font-family:Arial; font-size:10pt;'>SURAT PERINTAH KERJA (SPK)</td>
            <td colspan="2" style='border:1pt solid #000; padding:5pt; font-family:Arial; font-size:10pt;'>NOMOR DAN TANGGAL SPK : \${nomor} \${tanggal_spk}</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td style='border:1pt solid #000; padding:5pt;text-align:center;'>Nama PKA:</td>
            <td colspan="2" style='border:1pt solid #000; padding:5pt;'>\${pka}</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td style='border:1pt solid #000; padding:5pt;text-align:center;'>Nama Penyedia:</td>
            <td colspan="2" style='border:1pt solid #000; padding:5pt;'>\${penyedia}</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td rowspan="2" style='border:1pt solid #000; padding:5pt;'>PAKET PENGADAAN: \${paket_pengadaan}</td>
            <td colspan="2" style='border:1pt solid #000; padding:5pt;'>NOMOR SURAT UNDANGAN PENGADAAN MELALUI PERMINTAAN PENAWARAN: \${nomor_surat_undangan}<br><br>TANGGAL SURAT UNDANGAN PENGADAAN: \${tanggal_surat_undangan}</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td colspan="2" style='border:1pt solid #000; padding:5pt;'>NOMOR BERITA ACARA PENETAPAN PEMENANG:: \${nomor_surat_undangan}<br><br>TANGGAL BERITA ACARA PENETAPAN PEMENANG: \${tanggal_surat_undangan}</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td colspan="3" style='border:1pt solid #000; padding:5pt;'>SUMBER DANA: [contoh: “dibebankan atas APBDes ...”]</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td colspan="3" style='border:1pt solid #000; padding:5pt;'>Nilai Pekerjaan termasuk Pajak Pertambahan Nilai (PPN) adalah sebesar Rp \${nominal} (\${terbilang} rupiah).</td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td colspan="3" style='border:1pt solid #000; padding:5pt;'>WAKTU PELAKSANAAN PEKERJAAN: \${hari} (\${terbilang_hari}) hari kalender</td>
        </tr>
        <tr>
            <td colspan="2" style="width:50%; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Untuk dan atas nama&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Desa&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Kasi/Kaur Selaku Pelaksana</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">Kegiatan Anggaran&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">[tanda tangan dan cap (jika salinan asli ini 
                    untuk Penyedia maka rekatkan meterai 
                    Rp10.000,-)] &nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">tanda tangan,</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">nama lengkap</span></p>
            </td>
            <td style="width:50%; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Untuk dan atas nama</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Penyedia</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;"><span style="font-family:Arial;">Perusahaan/Pemasok/Toko*</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:150%; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:10pt;"><span style="font-family:Arial;">[tanda tangan dan cap (jika salinan asli ini 
                untuk Kasi/Kaur maka rekatkan meterai 
                Rp10.000,-)]</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:10pt;"><span style="font-family:Arial;">tanda tangan,&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:115%; font-size:10pt;"><span style="font-family:Arial;">nama lengkap</span></p>
            </td>
        </tr>
        <tr style="font-family:Arial; font-size:10pt;">
            <td colspan="3" style='border:1pt solid #000; padding:5pt;'>
               <strong><span style="font-family:Arial;margin-top:0pt; margin-bottom:8pt; font-size:10pt;"><u>SYARAT UMUM</u></span></strong>
                <p style="margin-top:0pt; margin-bottom:8pt; font-size:10pt;"><strong><span style="font-family:Arial;">SURAT PERINTAH KERJA (SPK)</span></strong></p>

                <ol style="font-size:10pt; font-family:Arial;">
                    <li style="margin-bottom:6pt;"><strong>LINGKUP PEKERJAAN</strong><br>
                        Penyedia yang ditunjuk berkewajiban untuk menyelesaikan pekerjaan dalam jangka waktu 
                        yang ditentukan, dengan mutu sesuai Kerangka Acuan Kerja dan harga sesuai SPK.
                    </li>
                    <li style="margin-bottom:6pt;"><strong>HUKUM YANG BERLAKU </strong><br>
                       Keabsahan, interpretasi, dan pelaksanaan SPK ini didasarkan kepada hukum Republik Indonesia. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>BIAYA SPK</strong><br>
                        a. PKA membayarkan kepada penyedia atas pelaksanaan pekerjaan dalam SPK sebesar nilai 
                        SPK; dan  <br>
                        b. Harga SPK telah memperhitungkan keuntungan, beban pajak, dan biaya tidak 
                        langsung/<i>overhead</i>. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>HAK KEPEMILIHAN </strong><br>
                        a. PKA berhak atas kepemilikan semua barang/bahan yang terkait langsung atau disediakan 
                        sehubungan dengan jasa yang diberikan oleh penyedia kepada PKA. Jika diminta oleh 
                        PKA maka penyedia berkewajiban untuk membantu secara optimal pengalihan hak dan 
                        kepemilikan tersebut kepada PKA sesuai dengan hukum yang berlaku.  <br>
                        b. Hak kepemilikan atas peralatan dan barang/bahan dan disediakan oleh PKA tetap pada 
                        PKA, dan semua peralatan tersebut harus dikembalikan kepada PKA pada saat SPK 
                        berakhir atau jika tidak diperlukan lagi oleh Penyedia. Semua peralatan tersebut harus 
                        dikembalikan dalam kondisi yang sama pada saat diberikan kepada penyedia dengan 
                        pengecualian keausan akibat pemakaian yang wajar. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>CACAT MUTU </strong><br>
                        PKA akan memeriksa setiap hasil pekerjaan penyedia dan memberitahukan secara tertulis 
                        penyedia atas setiap cacat mutu yang ditemukan. PKA dapat memerintahkan penyedia 
                        untuk menguji pekerjaan yang dianggap oleh PKA mengandung cacat mutu. Penyedia 
                        bertanggung jawab atas cacat mutu selama masa garansi. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PERPAJAKAN</strong><br>
                        Penyedia berkewajiban untuk membayar semua pajak, bea, retribusi dan pungutan lain 
                        yang sah dibebankan oleh hukum yang berlaku atas pelaksanaan SPK. Semua pengeluaran 
                        perpajakan ini dianggap telah termasuk dalam biaya SPK.
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PENGALIHAN DAN/ATAU SUBKONTRAK</strong><br>
                        Penyedia dilarang untuk mengalihkan dan/atau mensubkontrakkan sebagian atau seluruh 
                        pekerjaan. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>JADWAL</strong><br>
                        a. SPK ini berlaku efektif pada tanggal penandatanganan oleh para pihak. <br>
                        b. Waktu pelaksanaan SPK adalah sejak tanggal mulai kerja yang tercantum dalam SPK ini. <br>
                        c. Penyedia harus menyelesaikan pekerjaan sesuai jadwal yang ditentukan.  <br>
                        d. Apabila penyedia tidak dapat menyelesaikan pekerjaan sesuai jadwal karena keadaan 
                        diluar pengendaliannya dan penyedia telah melaporkan kejadian tersebut kepada PKA, 
                        maka PKA dapat melakukan penjadwalan kembali pelaksanaan tugas dengan adendum 
                        SPK. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PENANGGUNGAN DAN RISIKO</strong><br>
                    a. Penyedia berkewajiban untuk melindungi, membebaskan, dan menanggung tanpa batas 
                        PKA beserta instansinya terhadap semua bentuk tuntutan, tanggung jawab, kewajiban, 
                        kehilangan, kerugian, denda, gugatan atau tuntutan hukum, proses pemeriksaan hukum, 
                        dan biaya yang dikenakan terhadap PKA beserta instansinya (kecuali kerugian yang 
                        mendasari tuntutan tersebut disebabkan kesalahan atau kelalaian berat PKA) 
                        sehubungan dengan klaim yang timbul dari hal-hal berikut terhitung sejak tanggal mulai 
                        kerja sampai dengan tanggal penandatanganan berita acara penyerahan akhir: <br>
                        &nbsp; 1) kehilangan atau kerusakan peralatan dan harta benda penyedia dan Personel; <br>
                        &nbsp; 2) cidera tubuh, sakit atau kematian Personel; dan/atau <br>
                        &nbsp; 3) kehilangan atau kerusakan harta benda, cidera tubuh, sakit atau kematian pihak lain. <br>
                        b. Terhitung sejak tanggal awal mulai kerja sampai dengan tanggal penandatanganan 
                        berita acara serah terima, semua risiko kehilangan atau kerusakan hasil pekerjaan ini 
                        merupakan risiko penyedia, kecuali kerugian atau kerusakan tersebut diakibatkan oleh 
                        kesalahan atau kelalaian PKA.  <br>
                        c. Kehilangan atau kerusakan terhadap Hasil Pekerjaan atau Bahan yang menyatu dengan 
                        Hasil Pekerjaan selama tanggal mulai kerja dan batas akhir masa pemeliharaan harus 
                        diganti atau diperbaiki oleh penyedia atas tanggungannya sendiri jika kehilangan atau 
                        kerusakan tersebut terjadi akibat tindakan atau kelalaian penyedia.
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PENGAWASAN DAN PEMERIKSAAN</strong><br>
                        PKA berwenang melakukan pengawasan dan pemeriksaan terhadap pelaksanaan pekerjaan 
                        yang dilaksanakan oleh penyedia. PKA dapat memerintahkan kepada pihak ketiga untuk 
                        melakukan pengawasan dan pemeriksaan atas semua pelaksanaan pekerjaan yang 
                        dilaksanakan oleh Penyedia.
                    </li>
                    <li style="margin-bottom:6pt;"><strong>LAPORAN HASIL PEKERJAAN</strong><br>
                        a. Pemeriksaan pekerjaan dilakukan oleh PKA selama pelaksanaan kegiatan terhadap 
                        kemajuan pekerjaan dalam rangka pengawasan kualitas dan waktu pelaksanaan 
                        pekerjaan. Hasil pemeriksaan pekerjaan dituangkan dalam laporan kemajuan hasil 
                        pekerjaan. <br>
                        b. Untuk kepentingan pengendalian dan pengawasan pelaksanaan pekerjaan, seluruh 
                        aktivitas kegiatan pekerjaan di lokasi pekerjaan dicatat dalam buku harian sebagai bahan 
                        laporan harian pekerjaan yang berisi rencana dan realisasi pekerjaan harian. <br>
                        c. Laporan harian berisi: <br>
                        &nbsp;&nbsp; 1) penempatan tenaga kerja untuk tiap macam tugasnya; <br>
                        &nbsp;&nbsp; 2) jenis, jumlah dan kondisi peralatan; <br>
                        &nbsp;&nbsp; 3) jenis dan jumlah pekerjaan yang dilaksanakan; <br>
                        &nbsp;&nbsp; 4) keadaan cuaca termasuk hujan, banjir dan peristiwa alam lainnya yang berpengaruh terhadap kelancaran pekerjaan; dan <br>
                        &nbsp;&nbsp; 5) catatan-catatan lain yang berkenaan dengan pelaksanaan. <br>
                        d. Laporan harian dibuat oleh penyedia. <br>
                        e. Laporan mingguan terdiri dari rangkuman laporan harian yang berisi hasil kemajuan fisik 
                        pekerjaan dalam periode satu minggu, serta hal-hal penting yang perlu ditonjolkan. <br>
                        f. Laporan bulanan terdiri dari rangkuman laporan mingguan yang berisi hasil kemajuan 
                        fisik pekerjaan dalam periode satu bulan, serta hal-hal penting yang perlu ditonjolkan. <br>
                        g. Untuk rekaman kegiatan pelaksanaan konstruksi, PKA atau pihak yang didelegasikan oleh 
                        PKA membuat foto-foto dokumentasi pelaksanaan pekerjaan di lokasi kegiatan.
                    </li>
                    <li style="margin-bottom:6pt;"><strong>WAKTU PENYELESAIAN PEKERJAAN</strong><br>
                        a. Kecuali SPK diputuskan lebih awal, penyedia berkewajiban untuk memulai pelaksanaan 
                        pekerjaan pada tanggal mulai kerja, dan melaksanakan sesuai dengan program mutu, 
                        serta menyelesaikan pekerjaan selambat-lambatnya pada tanggal penyelesaian yang 
                        ditetapkan dalam SPK. <br>
                        b. Jika pekerjaan tidak selesai pada tanggal penyelesaian disebabkan karena kesalahan 
                        atau kelalaian penyedia maka penyedia dikenakan sanksi berupa denda keterlambatan. <br>
                        c. Jika keterlambatan tersebut disebabkan oleh Peristiwa Kompensasi maka PKA 
                        memberikan tambahan perpanjangan waktu penyelesaian pekerjaan. <br>
                        d. Tanggal penyelesaian yang dimaksud dalam ketentuan ini adalah tanggal penyelesaian 
                        semua pekerjaan. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>SERAH TERIMA PEKERJAAN </strong><br>
                        a. Setelah pekerjaan selesai 100% (seratus persen), penyedia mengajukan permintaan 
                        secara tertulis kepada PKA untuk menyerahkan pekerjaan. <br>
                        b. Sebelum melakukan serah terima, PKA melakukan pemeriksaan terhadap hasil 
                        pekerjaan. <br>
                        c. PKA dalam melakukan pemeriksaan hasil pekerjaan dapat dibantu oleh pengawas 
                        pekerjaan dan/atau tim teknis. <br>
                        d. Apabila terdapat kekurangan-kekurangan dan/atau cacat hasil pekerjaan, penyedia wajib 
                        memperbaiki/menyelesaikannya atas perintah PKA. <br>
                        e. PKA menerima hasil pekerjaan setelah seluruh hasil pekerjaan dilaksanakan sesuai 
                        dengan ketentuan SPK. <br>
                        f. Pembayaran dilakukan sebesar 100% (seratus persen) dari biaya SPK setelah pekerjaan 
                        selesai. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PERUBAHAN SPK</strong><br>
                        a. SPK hanya dapat diubah melalui adendum SPK. <br>
                        b. Perubahan SPK dapat dilaksanakan dalam hal terdapat perbedaan antara kondisi 
                        lapangan pada saat pelaksanaan dengan SPK dan disetujui oleh para pihak, meliputi: <br> 
                        &nbsp;&nbsp; 1) menambah atau mengurangi volume yang tercantum dalam SPK; <br>
                        &nbsp;&nbsp; 2) menambah dan/atau mengurangi jenis kegiatan; <br>
                        &nbsp;&nbsp; 3) mengubah Kerangka Acuan Kerja sesuai dengan kondisi lapangan; dan/atau <br>
                        &nbsp;&nbsp; 4) mengubah jadwal pelaksanaan pekerjaan. <br>
                        c. Untuk kepentingan perubahan SPK, PKA dapat dibantu oleh Tim Pelaksana Kegiatan 
                        (TPK). 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PERISTIWA KOMPENSASI</strong><br>
                        a. Peristiwa Kompensasi dapat diberikan kepada penyedia dalam hal sebagai berikut: <br>
                        &nbsp;&nbsp; 1) PKA mengubah jadwal yang dapat mempengaruhi pelaksanaan pekerjaan; <br>
                        &nbsp;&nbsp; 2) PKA memerintahkan penundaan pelaksanaan pekerjaan; <br>
                        &nbsp;&nbsp; 3) ketentuan lain dalam SPK. <br>
                        b. Jika Peristiwa Kompensasi mengakibatkan pengeluaran tambahan dan/atau 
                        keterlambatan penyelesaian pekerjaan maka PKA berkewajiban untuk membayar ganti 
                        rugi dan/atau perpanjangan waktu penyelesaian pekerjaan. <br>
                        c. Ganti rugi hanya dapat dibayarkan jika berdasarkan data penunjang dan perhitungan 
                        kompensasi yang diajukan penyedia kepada PKA, dapat dibuktikan kerugian nyata akibat 
                        Peristiwa Kompensasi. <br>
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PERPANJANGAN WAKTU</strong><br>
                        Jika terjadi peristiwa diluar kendali penyedia sehingga penyelesaian pekerjaan akan 
                        melampaui tanggal penyelesaian maka penyedia berhak untuk meminta perpanjangan 
                        tanggal penyelesaian berdasarkan data penunjang. PKA berdasarkan pertimbangan 
                        memperpanjang tanggal penyelesaian pekerjaan secara tertulis. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PENGHENTIAN DAN PEMUTUSAN SPK </strong><br>
                        a. Penghentian SPK dapat dilakukan karena terjadi Keadaan Kahar. <br>
                        b. Dalam hal SPK dihentikan, PKA wajib membayar kepada penyedia sesuai dengan prestasi 
                        pekerjaan yang telah dicapai, termasuk: <br>
                        &nbsp;&nbsp; 1) biaya langsung pengadaan bahan dan perlengkapan untuk pekerjaan ini. Bahan dan perlengkapan ini harus diserahkan oleh Penyedia kepada PKA, dan selanjutnya 
                        menjadi hak milik PKA; <br>
                        &nbsp;&nbsp; 2) biaya langsung demobilisasi personel. <br>
                        c. Pemutusan SPK dapat dilakukan oleh pihak PKA atau pihak penyedia. <br>
                        d. Pemutusan SPK melalui pemberitahuan tertulis dapat dilakukan apabila: <br>
                        &nbsp;&nbsp; 1) penyedia terbukti melakukan korupsi, kolusi, dan/atau nepotisme, kecurangan 
                        dan/atau pemalsuan dalam proses Pengadaan; <br>
                        &nbsp;&nbsp; 2) penyedia lalai/cidera janji dalam melaksanakan kewajibannya dan tidak memperbaiki 
                        kelalaiannya dalam jangka waktu yang telah ditetapkan; <br>
                        &nbsp;&nbsp; 3) penyedia tanpa persetujuan PKA, tidak memulai pelaksanaan pekerjaan; <br>
                        &nbsp;&nbsp; 4) penyedia menghentikan pekerjaan dan penghentian ini tanpa persetujuan PKA; <br>
                        &nbsp;&nbsp; 5) penyedia berada dalam masa pailit; <br>
                        &nbsp;&nbsp; 6) PKA memerintahkan penyedia untuk menunda pelaksanaan atau kelanjutan 
                        pekerjaan, dan perintah tersebut tidak ditarik selama 28 (dua puluh delapan) hari; 
                        dan/atau <br>
                        &nbsp;&nbsp; 7) PKA tidak menerbitkan surat perintah pembayaran untuk pembayaran tagihan 
                        angsuran sesuai dengan yang disepakati sebagaimana tercantum dalam SPK. <br>
                        e. Dalam hal pemutusan SPK dilakukan karena kesalahan penyedia: <br>
                        &nbsp;&nbsp; 1) sisa uang muka (apabila ada) harus dilunasi oleh Penyedia; dan/atau <br>
                        &nbsp;&nbsp; 2) penyedia membayar denda keterlambatan (apabila ada);  <br>
                        f. Dalam hal pemutusan SPK dilakukan karena PKA terlibat penyimpangan prosedur, 
                        melakukan korupsi, kolusi, dan/atau nepotisme, dan/atau pelanggaran persaingan sehat 
                        dalam pelaksanaan pengadaan, maka PKA dikenakan sanksi berdasarkan beraturan 
                        perundang-undangan. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PEMBAYARAN</strong><br>
                        a. Pembayaran prestasi hasil pekerjaan disepakati dilakukan oleh PKA, dengan ketentuan: <br> 
                        &nbsp;&nbsp; 1) penyedia telah mengajukan tagihan disertai laporan kemajuan hasil pekerjaan; <br>
                        &nbsp;&nbsp; 2) pembayaran dilakukan dengan <i> [sistem bulanan/sistem termin/pembayaran secara sekaligus]; </i> <br>
                        3) pembayaran harus dipotong denda (apabila ada), dan pajak <br>
                        b. pembayaran terakhir hanya dilakukan setelah pekerjaan selesai 100% (seratus persen) 
                        dan Berita Acara Serah Terima ditandatangani. <br>
                        c. PKA dalam kurun waktu 7 (tujuh) hari kerja setelah pengajuan permintaan pembayaran 
                        dari penyedia harus sudah mengajukan surat permintaan pembayaran kepada Kaur 
                        Keuangan. <br>
                        d. Bila terdapat ketidaksesuaian dalam perhitungan angsuran, tidak akan menjadi alasan 
                        untuk menunda pembayaran. PKA dapat meminta penyedia untuk menyampaikan 
                        perhitungan prestasi sementara dengan mengesampingkan hal-hal yang sedang menjadi 
                        perselisihan. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>DENDA</strong><br>
                        a. Apabila penyedia wanprestasi dikarenakan keterlambatan dalam menyelesaikan 
                        pekerjaan sesuai SPK, maka kepada penyedia dikenakan denda untuk setiap hari keterlambatan sebesar ... (...) [contoh: 1‰] dari nilai pekerjaan/bagian pekerjaan 
                        apabila bagian pekerjaan yang sudah selesai dapat dimanfaatkan* (pilih salah satu) 
                        diluar PPN. <br>
                        b. PKA mengenakan Denda dengan memotong pembayaran prestasi kerja penyedia. 
                        Pembayaran Denda tidak mengurangi tanggung jawab kontraktual penyedia. 
                    </li>
                    <li style="margin-bottom:6pt;"><strong>PENYELESAIAN PERSELISIHAN</strong><br>
                        Dalam hal terjadi perselisihan antara PKA dan Penyedia dalam pengadaan, maka terlebih 
                        dahulu menyelesaikan perselisihan tersebut melalui musyawarah untuk mufakat. Jika 
                        penyelesaian perselisihan secara musyawarah tidak mencapai mufakat, maka penyelesaian 
                        perselisihan dilakukan melalui musyawarah yang dipimpin oleh Kepala Desa atau dapat 
                        dilakukan melalui Layanan Penyelesaian Sengketa Kontrak Pengadaan atau Pengadilan 
                        Negeri dalam wilayah hukum Republik Indonesia.
                    </li>
                </ol>
            </td>
        </tr>

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
        return view('livewire.generator.penyedia.spk');
    }
}
