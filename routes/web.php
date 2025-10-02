<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Tambahkan Middleware 'auth' ke semua route Admin:
Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/siswa', [StudentController::class, 'index'])->name('siswa.index');
Route::get('/siswa/{nis}', [StudentController::class, 'show'])->name('siswa.show');

Route::get('/tunggakan', function () {
    return view('tunggakan.index');
})->name('tunggakan.index');

Route::get('/notifikasi', function () {
    return view('notifikasi.index');
})->name('notifikasi.index');

Route::get('/pembayaran', function () {
    return view('pembayaran.index');
})->name('pembayaran.index');

Route::get('/laporan', function () {
    return view('laporan.index');
})->name('laporan.index');

});