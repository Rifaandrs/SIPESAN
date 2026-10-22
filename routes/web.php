<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIPESAN (Sistem Pelayanan Saran Eksternal SMPN 2 Purwakarta)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PIHAK EKSTERNAL / USER (PUBLIK)
// ==========================================
// Beranda (Desain Panel 1)
Route::get('/', [UserController::class, 'home'])->name('user.home');

// Form Penyampaian Saran (Desain Panel 2)
Route::get('/saran', [UserController::class, 'createSaran'])->name('user.saran.create');
Route::post('/saran', [UserController::class, 'storeSaran'])->name('user.saran.store');

// Kode Saran Setelah Submit (Desain Panel 3)
Route::get('/saran/sukses/{kode}', [UserController::class, 'suksesSaran'])->name('user.saran.sukses');

// Cek Status Saran (Desain Panel 4)
Route::get('/cek-status', [UserController::class, 'cekStatus'])->name('user.saran.status');

// ==========================================
// 2. RUTE AUTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// 3. RUTE KHUSUS USER (PIHAK EKSTERNAL TERDAFTAR)
// ==========================================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

// ==========================================
// 4. RUTE KHUSUS ADMIN (WAKASEK HUMAS)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin (Desain Panel 5)
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Manajemen Saran (Daftar & Detail Desain Panel 6)
    Route::get('/saran', [AdminController::class, 'saran'])->name('saran.index');
    Route::get('/saran/{saran}', [AdminController::class, 'showSaran'])->name('saran.show');
    Route::post('/saran/{saran}/status', [AdminController::class, 'updateSaran'])->name('saran.updateStatus');

    // Manajemen Kategori
    Route::get('/kategori', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/kategori', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/kategori/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Laporan & Rekap Saran
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan.index');

    // Manajemen Pengguna & Peran
    Route::get('/pengguna', [AdminController::class, 'users'])->name('users');
    Route::post('/pengguna/{user}/role', [AdminController::class, 'updateRole'])->name('users.updateRole');
});
