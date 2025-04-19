<?php

use App\Livewire\Dashboard;
use App\Livewire\Master\Role;
use App\Livewire\Master\User;
use App\Livewire\Desa\DesaIndex;
use App\Livewire\Master\RoleIndex;
use App\Livewire\Master\UserIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Desa\PaketKegiatanForm;
use App\Livewire\Desa\PaketKegiatanIndex;
use App\Http\Controllers\HelperController;
use App\Livewire\Desa\PaketPekerjaanIndex;
use App\Http\Controllers\PasswordResetController;
use App\Livewire\Penyedia\VendorIndex;
use App\Models\PaketKegiatan;

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

    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::get('user-index', UserIndex::class)->name('user-index');
        Route::get('user/{id?}', User::class)->name('user');
        Route::get('role/{id?}', Role::class)->name('role');
        Route::get('role-index', RoleIndex::class)->name('role.index');


    });

    Route::group(['prefix' => 'desa', 'as' => 'desa.'], function () {
        Route::get('desa-index', DesaIndex::class)->name('desa-index');
        Route::get('paket-pekerjaan-index', PaketPekerjaanIndex::class)->name('paket-pekerjaan-index');
        Route::get('paket-kegiatan/{paketPekerjaanId}/persiapan', PaketKegiatanForm::class)->name('paket-kegiatan.persiapan');
        Route::get('paket-pekerjaan-index/paket-kegiatan/{paketPekerjaanId}', PaketKegiatanIndex::class)->name('paket-kegiatan');
    });
    Route::group(['prefix' => 'penyedia', 'as' => 'penyedia.'], function () {
        Route::get('vendor-index', VendorIndex::class)->name('vendor-index');

    });
});


