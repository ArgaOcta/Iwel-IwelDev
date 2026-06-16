<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Rute Halaman Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/how-it-works', 'how-it-works')->name('how-it-works');
Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');

Route::get('/notifikasi', function () {
    return view('mahasiswa.notification');
})->name('notifications.index');

// Rute Dashboard Utama (Multi-Role)
// Hanya gunakan pemanggilan Controller, hapus versi rute closure (fungsi) lama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/pengaduan/riwayat', [ComplaintController::class, 'index'])
    ->name('complaint.history');
Route::get('/pengaduan/{id}/detail', [ComplaintController::class, 'show'])
    ->name('complaint.show');
Route::get('/pengaduan/baru', [ComplaintController::class, 'create'])
    ->name('complaint.create');
Route::post('/pengaduan', [ComplaintController::class, 'store'])
    ->name('complaint.store');

// Rute Panel Admin
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // Complaints Management
        Route::prefix('complaints')
            ->name('complaints.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'complaints'])->name('index');
                Route::get('/{id}', [AdminController::class, 'show'])->name('show');
                Route::put('/{id}', [AdminController::class, 'update'])->name('update');
            });
    });

// Rute Tambahan untuk Panel Super Admin
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
});

// Rute Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('mahasiswa.profile');
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
