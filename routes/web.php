<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DuedateController;
use App\Http\Controllers\NotificationController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/siswa', [StudentController::class, 'index'])->name('siswa.index');
Route::get('/siswa/{nis}', [StudentController::class, 'show'])->name('siswa.show');

Route::get('/tunggakan', [DuedateController::class, 'index'])->name('tunggakan.index'); 

Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');

Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');

// Route Halaman Laporan (Index)
Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index'); 

// Route untuk Proses Export (menggunakan parameter {type} dari jenis laporan)
Route::get('/laporan/export/{type}', [ReportController::class, 'export'])->name('report.export');

});