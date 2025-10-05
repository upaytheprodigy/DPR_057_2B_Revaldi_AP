<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaDprController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\PenggajianController;

// Redirect root ke login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Routes untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Routes untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Routes untuk Data Anggota DPR (Public bisa lihat, Admin bisa CRUD)
    Route::get('/anggota', [AnggotaDprController::class, 'index'])->name('anggota.index');
    
    // Routes untuk Komponen Gaji (Public bisa lihat)
    Route::get('/komponen-gaji', [KomponenGajiController::class, 'index'])->name('komponen-gaji.index');
    
    // Routes untuk Penggajian (Public bisa lihat)
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
    Route::get('/penggajian/{id}', [PenggajianController::class, 'show'])->name('penggajian.show');
    
    // Routes khusus Admin
    Route::middleware(['role:Admin'])->group(function () {
        // Anggota DPR
        Route::get('/anggota/create', [AnggotaDprController::class, 'create'])->name('anggota.create');
        Route::post('/anggota', [AnggotaDprController::class, 'store'])->name('anggota.store');
        Route::get('/anggota/{id}/edit', [AnggotaDprController::class, 'edit'])->name('anggota.edit');
        Route::put('/anggota/{id}', [AnggotaDprController::class, 'update'])->name('anggota.update');
        Route::delete('/anggota/{id}', [AnggotaDprController::class, 'destroy'])->name('anggota.destroy');
        
        // Komponen Gaji
        Route::get('/komponen-gaji/create', [KomponenGajiController::class, 'create'])->name('komponen-gaji.create');
        Route::post('/komponen-gaji', [KomponenGajiController::class, 'store'])->name('komponen-gaji.store');
        Route::get('/komponen-gaji/{id}/edit', [KomponenGajiController::class, 'edit'])->name('komponen-gaji.edit');
        Route::put('/komponen-gaji/{id}', [KomponenGajiController::class, 'update'])->name('komponen-gaji.update');
        Route::delete('/komponen-gaji/{id}', [KomponenGajiController::class, 'destroy'])->name('komponen-gaji.destroy');
        
        // Penggajian
        Route::get('/penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
        Route::post('/penggajian', [PenggajianController::class, 'store'])->name('penggajian.store');
        Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
        Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
        Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');
        
        // AJAX route untuk get komponen by jabatan
        Route::get('/penggajian/get-komponen/{id}', [PenggajianController::class, 'getKomponenByJabatan']);
    });
}); 