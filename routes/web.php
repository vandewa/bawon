<?php

use App\Livewire\Dashboard;
use App\Livewire\Master\Role;
use App\Livewire\Master\User;
use App\Livewire\Master\RoleIndex;
use App\Livewire\Master\UserIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\PasswordResetController;

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
});


