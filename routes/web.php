<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ComplaintManageController;
use App\Http\Controllers\Admin\UserController;
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

// Rute Dashboard Utama (Mahasiswa)
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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('admin.reports');
    Route::get('/performance-report', [AdminDashboardController::class, 'performanceReports'])->name('admin.performance');
    Route::get('/complaints', [ComplaintManageController::class, 'index'])->name('admin.complaints.index');
    Route::get('/complaints/{id}', [ComplaintManageController::class, 'show'])->name('admin.complaints.show');
    Route::post('/complaints/{id}/response', [ComplaintManageController::class, 'storeResponse'])->name('admin.complaints.response');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});

// Rute Panel Super Admin
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
});

// Rute Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';