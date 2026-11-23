<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use Illuminate\Support\Facades\Route;

// AUTH ROUTES
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.user')->group(function () {
    Route::get('/', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/status/{status}', [KegiatanController::class, 'filter'])->name('kegiatan.filter');
    Route::get('/akan-datang', [KegiatanController::class, 'akanDatang'])->name('kegiatan.akan');
    Route::get('/selesai', [KegiatanController::class, 'selesai'])->name('kegiatan.selesai');
    Route::get('/kalender', [KegiatanController::class, 'kalender'])->name('kegiatan.kalender');
    Route::get('/semua-kegiatan', [KegiatanController::class, 'semua'])->name('kegiatan.semua');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [KegiatanController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::get('/tambah', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/edit/{id}', [KegiatanController::class, 'edit'])->whereNumber('id')->name('kegiatan.edit');
        Route::put('/update/{id}', [KegiatanController::class, 'update'])->whereNumber('id')->name('kegiatan.update');
        Route::delete('/delete/{id}', [KegiatanController::class, 'destroy'])->whereNumber('id')->name('kegiatan.destroy');
    });

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.view');
});
