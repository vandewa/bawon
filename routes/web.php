<?php

use App\Livewire\Dashboard;
use App\Livewire\Master\Role;
use App\Livewire\Master\User;
use App\Livewire\NegosiasiPage;
use App\Livewire\Desa\DesaIndex;
use App\Livewire\Master\RoleIndex;
use App\Livewire\Master\UserIndex;
use App\Livewire\Desa\PenawaranIndex;
use App\Livewire\Desa\PenawaranPaket;
use Illuminate\Support\Facades\Route;
use App\Livewire\Penyedia\VendorIndex;
use App\Livewire\Desa\PenawaranPreview;
use App\Livewire\Desa\PaketKegiatanEdit;
use App\Livewire\Desa\PaketKegiatanForm;
use App\Livewire\Desa\PaketKegiatanIndex;
use App\Http\Controllers\HelperController;
use App\Livewire\Desa\PaketPekerjaanIndex;
use App\Http\Controllers\PasswordResetController;
use App\Livewire\Generator\SpesifikasiTeknisEditor;
use App\Livewire\Generator\Penyedia\SpesifikasiTeknis as PenyediaSpesifikasiTeknis;
use App\Livewire\Generator\Swakelola\SpesifikasiTeknis as SwakelolaSpesifikasiTeknis;
use App\Livewire\Penyedia\PaketPekerjaanPenyediaIndex;

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
            Route::get('/spesifikasi-teknis/{id?}', PenyediaSpesifikasiTeknis::class)->name('spesifikasi-teknis');
            Route::get('/kak/{id?}', PenyediaSpesifikasiTeknis::class)->name('kak');
            Route::get('/jadwal-pelaksanaan/{id?}', PenyediaSpesifikasiTeknis::class)->name('jadwal-pelaksanaan');
            Route::get('/rencana-kerja/{id?}', PenyediaSpesifikasiTeknis::class)->name('rencana-kerja');
            Route::get('/hps/{id?}', PenyediaSpesifikasiTeknis::class)->name('hps');
        });

        Route::group(['prefix' => 'swakelola', 'as' => 'swakelola.'], function () {
            Route::get('/spesifikasi-teknis/{id?}', SwakelolaSpesifikasiTeknis::class)->name('spesifikasi-teknis');
            Route::get('/kak/{id?}', PenyediaSpesifikasiTeknis::class)->name('kak');
            Route::get('/jadwal-pelaksanaan/{id?}', PenyediaSpesifikasiTeknis::class)->name('jadwal-pelaksanaan');
            Route::get('/rencana-kerja/{id?}', PenyediaSpesifikasiTeknis::class)->name('rencana-kerja');
            Route::get('/hps/{id?}', PenyediaSpesifikasiTeknis::class)->name('hps');
        });

        Route::group(['prefix' => 'lelang', 'as' => 'lelang.'], function () {
            Route::get('/spesifikasi-teknis/{id?}', SpesifikasiTeknisEditor::class)->name('spesifikasi-teknis');
        });
    });

    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::get('user-index', UserIndex::class)->name('user-index');
        Route::get('user/{id?}', User::class)->name('user');
        Route::get('role/{id?}', Role::class)->name('role');
        Route::get('role-index', RoleIndex::class)->name('role.index');


    });

    Route::group(['prefix' => 'desa', 'as' => 'desa.'], function () {
        Route::get('desa-index', DesaIndex::class)->name('desa-index');
        Route::get('paket-pekerjaan-index', PaketPekerjaanIndex::class)->name('paket-pekerjaan-index');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{paketPekerjaanId}/persiapan/create', PaketKegiatanForm::class)->name('paket-kegiatan.persiapan.create');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{id}/persiapan/edit', PaketKegiatanEdit::class)->name('paket-kegiatan.persiapan.edit');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{paketPekerjaanId}', PaketKegiatanIndex::class)->name('paket-kegiatan');
        Route::get('paket-kegiatan/penawaran/{paketKegiatanId}', PenawaranPaket::class)->name('penawaran.paket');
        Route::get('pelaksanaan-index/', PenawaranIndex::class)->name('penawaran.pelaksanaan.index');
        Route::get('pelaksanaan-index/{penawaranId}/penawaran-preview', PenawaranPreview::class)->name('penawaran.pelaksanaan.preview');
        Route::get('pelaksanaan-index/negoisasi/{paket_kegiatan_id}', NegosiasiPage::class)->name('penawaran.pelaksanaan.negosiasi');
    });
    Route::group(['prefix' => 'penyedia', 'as' => 'penyedia.'], function () {
        Route::get('vendor-index', VendorIndex::class)->name('vendor-index');
        Route::get('penawaran-index', PaketPekerjaanPenyediaIndex::class)->name('penawaran-index');

    });
});


