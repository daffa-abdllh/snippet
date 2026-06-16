<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rute Publik (Bisa diakses tanpa login)
Route::post('/note', [NoteController::class, 'store'])->name('notes.store'); // Proses simpan catatan
Route::get('/note/{slug}', [NoteController::class, 'show'])->name('notes.show'); // Halaman baca catatan publik

// Rute Terproteksi (Wajib Login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Daftar catatan milik user login
    Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('notes.destroy'); // Hapus catatan milik sendiri
});

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
