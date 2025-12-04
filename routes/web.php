<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// GROUP 1: GUEST (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// GROUP 2: AUTH (Sudah Login)
Route::middleware('auth')->group(function () {
    
    // Logout & Dashboard (Bisa diakses Admin & Staff)
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // ---------------------------------------------------------------------
    // FITUR PROFIL (Bisa diakses Admin & Staff)
    // ---------------------------------------------------------------------
    // Hanya Edit & Update. Tidak ada Delete, agar user tidak menghapus diri sendiri.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ---------------------------------------------------------------------
    // MANAJEMEN PENGGUNA (HANYA ADMIN)
    // ---------------------------------------------------------------------
    // Kita tambahkan middleware('admin') di sini.
    // Jika staff mencoba akses URL ini, akan ditolak (403 Forbidden).
    Route::middleware('admin')
        ->prefix('users')
        ->name('users.')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::delete('/{user}', 'destroy')->name('destroy'); // Admin hapus user lain
            Route::get('/{user}/edit', 'edit')->name('edit');     // Admin edit user lain
            Route::put('/{user}', 'update')->name('update');
    });

    // ---------------------------------------------------------------------
    // APLIKASI SANTUNAN (Bisa diakses Admin & Staff)
    // ---------------------------------------------------------------------
    // Staff perlu akses ini untuk input data sehari-hari.
    
    // 1. Santunan Kematian - Tahapan
    Route::prefix('tahapans')->name('tahapans.')->controller(TahapanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        
        // RUTE BARU: EDIT TAHAPAN
        Route::get('/{tahapan}/edit', 'edit')->name('edit');
        Route::put('/{tahapan}', 'update')->name('update');

        Route::post('/{tahapan}/toggle-status', 'toggleStatus')->name('toggleStatus');
        Route::delete('/{tahapan}', 'destroy')->name('destroy');
    });

    // 2. Santunan Kematian - Permohonan (Nested)
    Route::prefix('tahapans/{tahapan}/permohonans')->name('permohonans.')->controller(PermohonanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        
        Route::get('/{permohonan}/edit', 'edit')->name('edit');
        Route::put('/{permohonan}', 'update')->name('update');
        Route::delete('/{permohonan}', 'destroy')->name('destroy');
    });

    Route::prefix('tahapans')->name('tahapans.')->controller(TahapanController::class)->group(function () {
    // ... route lainnya ...
    
    // Route Export Excel
    Route::get('/{tahapan}/export', 'export')->name('export');
    });
});