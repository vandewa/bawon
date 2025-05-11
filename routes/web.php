<?php

use App\Livewire\Dashboard;
use App\Livewire\Desa\TpkIndex;
use App\Livewire\Master\Role;
use App\Livewire\Master\User;
use App\Livewire\Desa\DesaEdit;
use App\Livewire\NegosiasiPage;

use App\Livewire\Desa\DesaIndex;
use App\Livewire\Desa\DesaCreate;
use App\Livewire\Master\RoleIndex;
use App\Livewire\Master\UserIndex;
use App\Livewire\Desa\AparaturIndex;
use App\Livewire\Desa\PelaporanIndex;
use App\Livewire\Desa\PenawaranIndex;
use App\Livewire\Desa\PenawaranPaket;
use App\Livewire\Penyedia\VendorEdit;
use Illuminate\Support\Facades\Route;
use App\Livewire\Desa\PelaporanDetail;
use App\Livewire\Penyedia\VendorIndex;
use App\Livewire\Desa\PenawaranPreview;
use App\Livewire\Penyedia\VendorCreate;
use App\Livewire\Desa\PaketKegiatanEdit;
use App\Livewire\Desa\PaketKegiatanForm;

use App\Livewire\Penyedia\VendorProfile;
use App\Livewire\Desa\PaketKegiatanIndex;
use App\Http\Controllers\HelperController;
use App\Livewire\Desa\PaketPekerjaanIndex;
use App\Http\Controllers\PasswordResetController;
use App\Livewire\Penyedia\PengajuanPenawaranCreate;
use App\Livewire\Penyedia\PaketPekerjaanPenyediaIndex;
use App\Livewire\Generator\Penyedia\Hps as PenyediaHps;
use App\Livewire\Generator\Penyedia\Kak as PenyediaKak;
use App\Livewire\Generator\Penyedia\Spk as PenyediaSpk;
use App\Livewire\Generator\Swakelola\Kak as SwakelolaKak;
use App\Livewire\Generator\Penyedia\JadwalPelaksanaanPekerjaan;
use App\Livewire\Generator\Lelang\PengumumanLelang as LelangPengumumanLelang;

use App\Livewire\Generator\Penyedia\SkKepalaDesaTpk as PenyediaSkKepalaDesaTpk;
use App\Livewire\Generator\Penyedia\SuratPerjanjian as PenyediaSuratPerjanjian;
use App\Livewire\Generator\Swakelola\SkKepalaDesaTpk as SwakelolaSkKepalaDesaTpk;
use App\Livewire\Generator\Penyedia\PenetapanPemenang as PenyediaPenetapanPemenang;
use App\Livewire\Generator\Penyedia\SpesifikasiTeknis as PenyediaSpesifikasiTeknis;
use App\Livewire\Generator\Swakelola\SpesifikasiTeknis as SwakelolaSpesifikasiTeknis;
use App\Livewire\Generator\Penyedia\SuratPermintaanPenawaran as PenyediaSuratPenawaran;
use App\Livewire\Generator\Lelang\SuratPenawaranPenyedia as LelangSuratPenawaranPenyedia;
use App\Livewire\Generator\Swakelola\RencanaAnggaranBiaya as SwakelolaRencanaAnggaranBiaya;
use App\Livewire\Generator\Swakelola\BeritaAcaraSerahTerima as SwakelolaBeritaAcaraSerahTerima;
use App\Livewire\Generator\Penyedia\BeritaAcaraHasilEvaluasi as PenyediaBeritaAcaraHasilEvaluasi;
use App\Livewire\Generator\Swakelola\LaporanEvaluasiKegiatan as SwakelolaLaporanEvaluasiKegiatan;
use App\Livewire\Generator\Penyedia\BeritaAcaraHasilNegosiasi as PenyediaBeritaAcaraHasilNegosiasi;
use App\Livewire\Generator\Penyedia\JadwalPelaksanaanPekerjaan as PenyediaJadwalPelaksaaanPekerjaan;
use App\Livewire\Generator\Penyedia\BastDariPenyediaKepadaKasi as PenyediaBastDariPenyediaKepadaKasi;
use App\Livewire\Generator\Swakelola\BeritaAcaraPenyerahanHasil as SwakelolaBeritaAcaraPenyerahanHasil;
use App\Livewire\Generator\Penyedia\BastDariKasiKepadaKepalaDesa as PenyediaBastDariKasiKepadaKepalaDesa;
use App\Livewire\Generator\Swakelola\LaporanPenggunaanSumberdaya as SwakelolaLaporanPenggunaanSumberdaya;
use App\Livewire\Generator\Penyedia\SuratPernyataanKebenaranUsaha as PenyediaSuratPernyataanKebenaranUsaha;
use App\Livewire\Generator\Penyedia\PengumumanPerencanaanPengadaan as PenyediaPengumumanPerencanaanPengadaan;
use App\Livewire\Generator\Swakelola\PengumumanPerencanaanPengadaan as SwakelolaPengumumanPerencanaanPengadaan;
use App\Livewire\Generator\Swakelola\PengumumanHasilKegiatanPengadaan as SwakelolaPengumumanHasilKegiatanPengadaan;
use App\Livewire\Generator\Swakelola\SuratPenyampaianDokumenPersiapan as SwakelolaSuratPenyampaianDokumenPersiapan;
use App\Livewire\Generator\Penyedia\LaporanHasilPemeriksaanOlehKasiKaur as PenyediaLaporanHasilPemeriksaanOlehKasiKaur;
use App\Livewire\Generator\Swakelola\HasilPembahasanKegiatanPersiapanPengadaan as SwakelolaHasilPembahasanKegiatanPersiapanPengadaan;

use App\Livewire\Generator\Desa\Tpk as GeneratorTpk;


// use App\Livewire\Generator\SpesifikasiTeknisEditor;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('show-picture', [HelperController::class, 'showPicture'])->name('helper.show-picture');
Route::get('password-reset', [PasswordResetController::class, 'index'])->name('password.index');
Route::post('password-reset', [PasswordResetController::class, 'updatePassword'])->name('password.post');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {
    Route::get('/', Dashboard::class)->name('index');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::group(['prefix' => 'generator', 'as' => 'generator.'], function () {
        Route::group(['prefix' => 'penyedia', 'as' => 'penyedia.'], function () {
            Route::get('/sk-kades-tpk/{id?}', PenyediaSkKepalaDesaTpk::class)->name('sk-kades-tpk');
            Route::get('/pengumuman-perencanaan-pengadaan/{id?}', PenyediaPengumumanPerencanaanPengadaan::class)->name('pengumuman-perencanaan-pengadaan');
            Route::get('/spesifikasi-teknis/{id?}', PenyediaSpesifikasiTeknis::class)->name('spesifikasi-teknis');
            Route::get('/kak/{id?}', PenyediaKak::class)->name('kak');
            Route::get('/jadwal-pelaksanaan-pekerjaan/{id?}', PenyediaJadwalPelaksaaanPekerjaan::class)->name('jadwal-pelaksanaan');
            Route::get('/rencana-kerja/{id?}', PenyediaSpesifikasiTeknis::class)->name('rencana-kerja'); //belum
            Route::get('/hps/{id?}', PenyediaHps::class)->name('hps');
            Route::get('/spk/{id?}', PenyediaSpk::class)->name('spk');
            Route::get('/surat-perjanjian/{paketId?}', PenyediaSuratPerjanjian::class)->name('surat-perjanjian');
            Route::get('/surat-penawaran/{paketKegiatan}/{vendorId}', PenyediaSuratPenawaran::class)->name('surat-penawaran');
            Route::get('/surat-pernyataan-kebenaran-usaha/{id?}', PenyediaSuratPernyataanKebenaranUsaha::class)->name('surat-pernyataan-kebenaran-usaha');
            Route::get('/berita-acara-hasil-evaluasi/{id?}', PenyediaBeritaAcaraHasilEvaluasi::class)->name('berita-acara-hasil-evaluasi');
            Route::get('/berita-acara-hasil-negosiasi/{id?}', PenyediaBeritaAcaraHasilNegosiasi::class)->name('berita-acara-hasil-negosiasi');
            Route::get('/penetapan-pemenang/{id?}', PenyediaPenetapanPemenang::class)->name('penetapan-pemenang');
            Route::get('/laporan-hasil-pemeriksaan/{id?}', PenyediaLaporanHasilPemeriksaanOlehKasiKaur::class)->name('laporan-hasil-pemeriksaan');
            Route::get('/bast-dari-penyedia-kepada-kasi/{id?}', PenyediaBastDariPenyediaKepadaKasi::class)->name('bast-dari-penyedia-kepada-kasi');
            Route::get('/bast-dari-kasi-kepada-kades/{id?}', PenyediaBastDariKasiKepadaKepalaDesa::class)->name('bast-dari-kasi-kepada-kades');
        });

        Route::group(['prefix' => 'swakelola', 'as' => 'swakelola.'], function () {
            Route::get('/spesifikasi-teknis/{id?}', SwakelolaSpesifikasiTeknis::class)->name('spesifikasi-teknis');
            Route::get('/kak/{id?}', SwakelolaKak::class)->name('kak');
            Route::get('/jadwal-pelaksanaan-pekerjaan/{id?}', JadwalPelaksanaanPekerjaan::class)->name('jadwal-pelaksanaan');
            Route::get('/rencana-kerja/{id?}', PenyediaSpesifikasiTeknis::class)->name('rencana-kerja'); //belum
            Route::get('/hps/{id?}', PenyediaHps::class)->name('hps');
            Route::get('/sk-kades-tpk/{id?}', SwakelolaSkKepalaDesaTpk::class)->name('sk-kades-tpk');
            Route::get('/pengumuman-perencanaan-pengadaan/{id?}', SwakelolaPengumumanPerencanaanPengadaan::class)->name('pengumuman-perencanaan-pengadaan');
            Route::get('/rab/{id?}', SwakelolaRencanaAnggaranBiaya::class)->name('rab'); //be;um fix
            Route::get('/surat-penyampaian-dokumen-persiapan/{id?}', SwakelolaSuratPenyampaianDokumenPersiapan::class)->name('surat-penyampaian-dokumen-persiapan');
            Route::get('/hasil-pembahasan/{id?}', SwakelolaHasilPembahasanKegiatanPersiapanPengadaan::class)->name('hasil-pembahasan');
            Route::get('/laporan-penggunaan-sumber-daya/{id?}', SwakelolaLaporanPenggunaanSumberdaya::class)->name('laporan-penggunaan-sumber-daya');
            Route::get('/laporan-evaluasi-kegiatan/{id?}', SwakelolaLaporanEvaluasiKegiatan::class)->name('laporan-evaluasi-kegiatan');
            Route::get('/pengumuman-hasil-kegiatan/{id?}', SwakelolaPengumumanHasilKegiatanPengadaan::class)->name('pengumuman-hasil-kegiatan');
            Route::get('/bast/{id?}', SwakelolaBeritaAcaraSerahTerima::class)->name('bast');
            Route::get('/berita-acara-penyerahan-hasil/{id?}', SwakelolaBeritaAcaraPenyerahanHasil::class)->name('berita-acara-penyerahan-hasil');
        });

        Route::group(['prefix' => 'lelang', 'as' => 'lelang.'], function () {
            Route::get('/kak/{id?}', PenyediaKak::class)->name('kak');
            Route::get('/jadwal-pelaksanaan-pekerjaan/{id?}', JadwalPelaksanaanPekerjaan::class)->name('jadwal-pelaksanaan');
            Route::get('/rencana-kerja/{id?}', PenyediaSpesifikasiTeknis::class)->name('rencana-kerja'); //belum
            Route::get('/hps/{id?}', PenyediaHps::class)->name('hps');


            Route::get('/spesifikasi-teknis/{id?}', PenyediaSpesifikasiTeknis::class)->name('spesifikasi-teknis');
            Route::get('/pengumuman-lelang/{id?}', LelangPengumumanLelang::class)->name('pengumuman-lelang');
            Route::get('/surat-penawaran-penyedia/{id?}', LelangSuratPenawaranPenyedia::class)->name('surat-penawaran-penyedia');
            Route::get('/berita-acara-hasil-evaluasi/{id?}', PenyediaBeritaAcaraHasilEvaluasi::class)->name('berita-acara-hasil-evaluasi');
            Route::get('/berita-acara-hasil-negosiasi/{id?}', PenyediaBeritaAcaraHasilNegosiasi::class)->name('berita-acara-hasil-negosiasi');
            Route::get('/penetapan-pemenang/{id?}', PenyediaPenetapanPemenang::class)->name('penetapan-pemenang');
        });
    });

    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::get('user-index', UserIndex::class)->name('user-index');
        Route::get('user/{id?}', User::class)->name('user');
        Route::get('role/{id?}', Role::class)->name('role');
        Route::get('role-index', RoleIndex::class)->name('role.index');


    });

    Route::group(['prefix' => 'desa', 'as' => 'desa.'], function () {
        Route::get('desa-create', DesaCreate::class)
            ->middleware(['auth', 'role:superadministrator|dinsos']) // hanya admin/dinsos
            ->name('desa-create');
        Route::get('desa-edit/{id}', DesaEdit::class)->name('desa-edit');
        Route::get('desa-index', DesaCreate::class)
            ->middleware(['auth', 'role:superadministrator|dinsos']) // hanya admin/dinsos
            ->name('desa-create');

        Route::get('desa-index', DesaIndex::class)->name('desa-index')->middleware('role:superadministrator|dinsos');
        Route::get('paket-pekerjaan-index', PaketPekerjaanIndex::class)->name('paket-pekerjaan-index');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{paketPekerjaanId}/persiapan/create', PaketKegiatanForm::class)->name('paket-kegiatan.persiapan.create');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{id}/persiapan/edit', PaketKegiatanEdit::class)->name('paket-kegiatan.persiapan.edit');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{paketPekerjaanId}', PaketKegiatanIndex::class)->name('paket-kegiatan');
        Route::get('paket-kegiatan/penawaran/{paketKegiatanId}', PenawaranPaket::class)->name('penawaran.paket');
        Route::get('pelaksanaan-index/', PenawaranIndex::class)->name('penawaran.pelaksanaan.index');
        Route::get('pelaksanaan-index/{penawaranId}/penawaran-preview', PenawaranPreview::class)->name('penawaran.pelaksanaan.preview');
        Route::get('pelaksanaan-index/negoisasi/{paket_kegiatan_id}', NegosiasiPage::class)->name('penawaran.pelaksanaan.negosiasi');
        Route::get('pelaporan-index', PelaporanIndex::class)->name('pelaporan.index');

        Route::get('aparatur-index/{id?}', AparaturIndex::class)->name('aparatur-index');
        Route::get('pelaporan-index/{id?}', PelaporanDetail::class)->name('pelaporan-detail');
        Route::get('tpk-index/{id?}', TpkIndex::class)->name('tpk-index');
        Route::get('generator-tpk/{desaId?}/{tahun?}', GeneratorTpk::class)->name('generator-tpk');


    });
    Route::group(['prefix' => 'penyedia', 'as' => 'penyedia.'], function () {
        Route::get('vendor-index', VendorIndex::class)->name('vendor-index')->middleware('role:superadministrator|dinsos');
        Route::get('vendor-profile/{id?}', VendorProfile::class)->name('vendor-profile');
        Route::get('vendor-index/vendor-create', VendorCreate::class)->name('vendor-create');
        Route::get('vendor-index/vendor-edit/{id}', VendorEdit::class)->name('vendor-edit');
        Route::get('penawaran-index', PaketPekerjaanPenyediaIndex::class)->name('penawaran-index');
        Route::get('penawaran-index/{penawaranId}/create', PengajuanPenawaranCreate::class)->name('penawaran.create');


    });
});


