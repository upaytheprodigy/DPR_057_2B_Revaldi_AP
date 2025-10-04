<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/login');
});

Route::middleware('auth')->group(function () {
    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('public.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Public Routes
Route::middleware(['auth', 'role:Public'])->prefix('public')->name('public.')->group(function () {
    Route::get('/dashboard', function () {
        return view('public.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';