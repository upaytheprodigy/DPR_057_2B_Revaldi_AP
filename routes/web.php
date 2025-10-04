<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaDprController;
use App\Http\Controllers\KomponenGajiController;

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
    
    // Routes untuk Komponen Gaji
    Route::resource('komponen-gaji', KomponenGajiController::class)->except(['show']);
    
    // Routes khusus Admin untuk Anggota DPR
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/anggota/create', [AnggotaDprController::class, 'create'])->name('anggota.create');
        Route::post('/anggota', [AnggotaDprController::class, 'store'])->name('anggota.store');
        Route::get('/anggota/{id}/edit', [AnggotaDprController::class, 'edit'])->name('anggota.edit');
        Route::put('/anggota/{id}', [AnggotaDprController::class, 'update'])->name('anggota.update');
        Route::delete('/anggota/{id}', [AnggotaDprController::class, 'destroy'])->name('anggota.destroy');
    });
});