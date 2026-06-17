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

Route::get('/notifikasi', [App\Http\Controllers\DashboardController::class, 'notifications'])->name('notifications.index');

// Rute Dashboard Utama (Mahasiswa)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/pengaduan/riwayat', [ComplaintController::class, 'index'])->name('complaint.history');
Route::get('/pengaduan/{id}/detail', [ComplaintController::class, 'show'])->name('complaint.show');
Route::get('/pengaduan/baru', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('complaint.store');
Route::post('/pengaduan/{id}/response', [ComplaintController::class, 'storeResponse'])->name('complaint.response');

// Rute Notifikasi Mahasiswa
Route::get('/notifikasi', [DashboardController::class, 'notifications'])->name('notifications.index');
// --- PANEL MANAJEMEN (ADMIN & SUPER ADMIN BERSATU) ---
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->group(function () {
    
    // Analytics & Dashboard (Bisa diakses keduanya)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('admin.reports');
    Route::get('/performance-report', [AdminDashboardController::class, 'performanceReports'])->name('admin.performance');
    
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
    Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('admin.notifications');
    Route::post('/notifications/mark-all-read', [AdminDashboardController::class, 'markAllNotificationsRead'])->name('admin.notifications.markRead');
    // --- HALAMAN SETTING (KELOLA KATEGORI) ---
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminDashboardController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminDashboardController::class, 'destroyCategory'])->name('admin.categories.destroy');
    // Manage Complaints & Resolusi (Bisa diakses keduanya)
    Route::get('/complaints', [ComplaintManageController::class, 'index'])->name('admin.complaints.index');
    Route::get('/complaints/{id}', [ComplaintManageController::class, 'show'])->name('admin.complaints.show');
    Route::post('/complaints/{id}/response', [ComplaintManageController::class, 'storeResponse'])->name('admin.complaints.response');
    Route::put('/complaints/{id}/update-status', [ComplaintManageController::class, 'updateStatus'])->name('admin.complaints.update');

    // --- FITUR EKSKLUSIF: KELOLA USER (HANYA SUPER ADMIN) ---
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    });
});

// Penyelamat Error: Jika sistem otomatis mengarahkan login Super Admin ke /superadmin/dashboard, 
// kita belokkan arahnya ke dashboard gabungan tadi.
Route::get('/superadmin/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('superadmin.dashboard');

// Rute Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';