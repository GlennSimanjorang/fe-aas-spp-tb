<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DuedateController;
use App\Http\Controllers\NotificationController;

// Route Login & Logout (Tidak ada middleware)
Route::get('/', [AuthController::class, 'showLogin'])->name('login'); // Ganti /login menjadi /
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup route yang memerlukan middleware 'auth.token'
// PASTIKAN 'auth.token' sudah terdaftar di Kernel.php menunjuk ke CheckToken::class
Route::middleware('auth.token')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Resource SISWA
    Route::resource('siswa', StudentController::class)->only([
        'index', 'show', 'create', 'store',
    ]);

    // Route Resource PEMBAYARAN (Resource sudah mencakup index, create, store, show)
    // Hapus grup middleware ganda di sini.
    Route::resource('pembayaran', PaymentController::class)->only([
        'index', 
        'create', 
        'store',
        'show', 
    ]);
    
    // Route Tunggakan
    Route::get('/tunggakan', [DuedateController::class, 'index'])->name('tunggakan.index'); 
    
    // Route Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    
    // Route Laporan (Index)
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index'); 
    // Route untuk Proses Export
    Route::get('/laporan/export/{type}', [ReportController::class, 'export'])->name('report.export');
    
    // HAPUS DEFINISI ULANG INI KARENA SUDAH DICAKUP OLEH Route::resource('pembayaran', ...)
    // Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index'); 
});