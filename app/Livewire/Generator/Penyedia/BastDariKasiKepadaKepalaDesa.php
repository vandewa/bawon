<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\Surat;
use Carbon\Carbon;
use Exception;

class BastDariKasiKepadaKepalaDesa extends Component
{
    /**
     * Properti untuk menampung isi surat dalam format HTML.
     * @var string
     */
    public string $isiSurat;

    /**
     * Flag untuk menandai apakah surat sudah disimpan ke database.
     * Berguna untuk mengontrol UI, misalnya mengaktifkan tombol download.
     * @var bool
     */
    public bool $sudahDisimpan = false;

    /**
     * Properti untuk menampung instance model PaketKegiatan yang sedang diproses.
     * @var \App\Models\PaketKegiatan
     */
    public $paketKegiatan;

    /**
     * Metode 'mount' adalah konstruktor untuk komponen Livewire.
     * Metode ini dijalankan saat komponen pertama kali diinisialisasi.
     *
     * @param int $paketKegiatanId ID dari paket kegiatan yang akan dibuatkan BAST-nya.
     * @return void
     */
    public function mount($paketkegiatanid)
    {
        $tahun  =PaketKegiatan::with(['paketPekerjaan'])->findOrFail($paketkegiatanid);
        // try {
            // 1. Ambil data dari database dengan Eager Loading untuk efisiensi.
            // Ini akan mengambil semua data yang dibutuhkan dalam beberapa query saja.
          $this->paketKegiatan = PaketKegiatan::with([
                'paketPekerjaan.desa.kepalaDesa', // Relasi ini tetap sama
                'tim' => function($a) use($tahun) {
                    $a->with('ketua')->where('tahun', $tahun->paketPekerjaan->tahun);
                }                       // Memuat tim, dan dari tim itu hanya memuat relasi ketuanya.
            ])->findOrFail($paketkegiatanid);

            // 2. Ekstrak data dari model dan relasinya ke dalam variabel yang mudah dibaca.
            // Asumsi relasi tidak null untuk data yang valid.
          $pekerjaan = $this->paketKegiatan->paketPekerjaan;
            $desa = $pekerjaan->desa;
            $kepalaDesa = $desa->kepalaDesa; // Pihak Kedua (Kepala Desa)

            // --- PENYESUAIAN PELAKSANA ---
            // Pelaksana (Ketua Tim) didapat dari relasi: paketKegiatan -> tim -> ketuaTim
            // Menggunakan nullsafe operator (?->) untuk mencegah error jika relasi 'tim' tidak ada.
            $pelaksana = $this->paketKegiatan->tim->ketua?->first(); // Pihak Pertama (Ketua Tim Pelaksana)

            // 3. Atur format tanggal dan mata uang ke Bahasa Indonesia.
            Carbon::setLocale('id');
            $tanggalSurat = Carbon::now();
            $nilaiKesepakatanFormatted = "Rp " . number_format($this->paketKegiatan->nilai_kesepakatan, 0, ',', '.');

            // Data untuk diisi ke dalam template
            $nomorSurat = 'BAST/' . $this->paketKegiatan->id . '/' . $desa->kode_desa . '/' . $tanggalSurat->format('Y');
            $hariIni = $tanggalSurat->translatedFormat('l');
            $tanggalTeks = $tanggalSurat->translatedFormat('d F Y');
            $lokasiSerahTerima = "Kantor Desa " . ucwords(strtolower($desa->nama));

            // 4. Masukkan semua data ke dalam template HTML menggunakan sintaks Heredoc.
            $this->isiSurat = <<<HTML
            <div style="font-family:Arial, sans-serif; font-size:11pt; line-height: 1.5;">
                <p style="text-align:center; font-weight:bold; margin:0;padding:0;font-size:12pt;"><u>BERITA ACARA SERAH TERIMA</u></p>
                <p style="text-align:center; margin:0;padding:0;">Nomor: {$nomorSurat}</p>
                <br>

                <p style="text-align:justify; margin:0; text-indent: 2em;">
                    Pada hari ini <b>{$hariIni}</b> tanggal <b>{$tanggalSurat->day}</b> bulan <b>{$tanggalSurat->translatedFormat('F')}</b> tahun <b>{$tanggalSurat->year}</b> ({$tanggalTeks}), bertempat di {$lokasiSerahTerima}, kami yang bertandatangan di bawah ini:
                </p><br>

                <table style="width:100%; font-size:11pt; font-family:Arial, sans-serif; margin-left: 2em;">
                    <tr><td style="width:25%;">Nama</td><td style="width:2%;">:</td><td style="width:73%; font-weight:bold;">{$pelaksana->nama}</td></tr>
                    <tr><td>NIK</td><td>:</td><td>{$pelaksana->nik}</td></tr>
                    <tr><td style="vertical-align: top;">Jabatan</td><td style="vertical-align: top;">:</td><td>{$pelaksana->jabatan}</td></tr>
                </table>

                <p style="margin-left: 2em; text-align:justify;">
                    Selaku Pelaksana Kegiatan Anggaran (PKA) Desa {$desa->nama_desa} yang selanjutnya disebut sebagai <b style="font-weight:bold;">PIHAK PERTAMA</b>.
                </p><br>

                <table style="width:100%; font-size:11pt; font-family:Arial, sans-serif; margin-left: 2em;">
                    <tr><td style="width:25%;">Nama</td><td style="width:2%;">:</td><td style="width:73%; font-weight:bold;">{$kepalaDesa->nama}</td></tr>
                    <tr><td>NIK</td><td>:</td><td>{$kepalaDesa->nik}</td></tr>
                    <tr><td style="vertical-align: top;">Jabatan</td><td style="vertical-align: top;">:</td><td>Kepala Desa {$desa->nama_desa}</td></tr>
                </table>

                <p style="margin-left: 2em; text-align:justify;">
                    Selaku Pemegang Kekuasaan Pengelolaan Keuangan Desa (PKPKD) {$desa->nama_desa} yang selanjutnya disebut sebagai <b style="font-weight:bold;">PIHAK KEDUA</b>.
                </p><br>

                <p style="text-align:justify; margin:0;">
                    <b>PIHAK PERTAMA</b> telah menyerahkan hasil pekerjaan kepada <b>PIHAK KEDUA</b>, dan <b>PIHAK KEDUA</b> telah menerima hasil pekerjaan tersebut dengan rincian sebagai berikut:
                </p>
                <table style="width:100%; font-size:11pt; font-family:Arial, sans-serif; margin-top: 1em; margin-bottom: 1em;">
                    <tr><td style="width:5%;"></td><td style="width:30%; vertical-align: top;">Nama Pekerjaan</td><td style="width:2%; vertical-align: top;">:</td><td style="width:63%; font-weight:bold;">{$pekerjaan->nama_kegiatan}</td></tr>
                    <tr><td></td><td>Nilai Kesepakatan</td><td>:</td><td><b>{$nilaiKesepakatanFormatted}</b></td></tr>
                </table>
                <p style="text-align:justify; margin:0;">
                    Hasil pekerjaan tersebut telah diperiksa dan dinyatakan selesai 100% (seratus persen) sesuai dengan volume dan spesifikasi teknis sebagaimana tertuang dalam Laporan Hasil Pemeriksaan.
                </p><br>

                <p style="text-align:justify; margin:0; text-indent: 2em;">
                    Demikian Berita Acara Serah Terima ini dibuat dengan sebenarnya dalam rangkap secukupnya untuk dapat dipergunakan sebagaimana mestinya.
                </p><br><br>

                <table style="width:100%; font-size:11pt; font-family:Arial, sans-serif; border-collapse:collapse;">
                    <tr>
                        <td style="width:50%; text-align:center;">
                            <p style="margin:0;">Yang Menerima,</p>
                            <p style="margin:0;"><b>PIHAK KEDUA</b></p>
                            <p style="margin:0;">Kepala Desa {$desa->nama_desa}</p>
                            <br><br><br><br>
                            <p style="margin:0;font-weight:bold;text-decoration:underline;">{$kepalaDesa->nama}</p>
                        </td>
                        <td style="width:50%; text-align:center;">
                            <p style="margin:0;">Wonosobo, {$tanggalTeks}</p>
                            <p style="margin:0;">Yang Menyerahkan,</p>
                            <p style="margin:0;"><b>PIHAK PERTAMA</b></p>
                            <p style="margin:0;">{$pelaksana->jabatan}</p>
                            <br><br><br><br>
                            <p style="margin:0;font-weight:bold;text-decoration:underline;">{$pelaksana->nama}</p>
                        </td>
                    </tr>
                </table>
            </div>
            HTML;

        // } catch (Exception $e) {
        //     dd($e->getMessage());
        //     // Tangani error jika data tidak ditemukan atau ada masalah relasi
        //     // Redirect atau tampilkan pesan error yang user-friendly
        //     session()->flash('error', 'Gagal memuat data. Pastikan data kegiatan dan relasinya lengkap. Error: ' . $e->getMessage());
        //     $this->isiSurat = "<p style='color:red;'>Terjadi kesalahan saat memuat data. Silakan hubungi administrator.</p>";
        // }
    }

    /**
     * Metode untuk menyimpan data surat ke dalam database.
     *
     * @return void
     */
    public function simpan()
    {
        $this->validate([
            'isiSurat' => 'required|string',
        ]);

        Surat::create([
            'judul' => 'BAST dari Kasi kepada Kepala Desa - ' . $this->paketKegiatan->paketPekerjaan->nama_pekerjaan,
            'isi' => $this->isiSurat,
            'paket_kegiatan_id' => $this->paketKegiatan->id,
            // Tambahkan kolom lain yang relevan seperti nomor surat, tanggal, dll.
            // 'nomor_surat' => $this->nomorSurat, // Anda perlu membuat properti ini jika ingin menyimpannya
            'tanggal_surat' => now(),
        ]);

        $this->sudahDisimpan = true;
        session()->flash('message', 'Berita Acara Serah Terima berhasil disimpan!');
    }

    /**
     * Merender view Blade yang terkait dengan komponen ini.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.generator.penyedia.bast-dari-kasi-kepada-kepala-desa');
    }
}
