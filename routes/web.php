<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DuedateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AcademicYearWebController;


Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup route yang memerlukan middleware 'auth.token'
Route::middleware('auth.token')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // ----------------------------------------------------
    // START: Perubahan untuk SISWA (Menggunakan Route Resource)
    // Kita gunakan Route::resource() dan hanya ambil method yang dibutuhkan
    Route::resource('siswa', StudentController::class)->only([
        'index',    // GET /siswa
        'show',     // GET /siswa/{siswa}
        'create',   // GET /siswa/create  <-- BARU
        'store',    // POST /siswa        <-- BARU
        // Tambahkan 'edit' dan 'update' jika nanti diperlukan
    ]);
    // END: Perubahan untuk SISWA
    // ----------------------------------------------------
    Route::resource('academic-years', AcademicYearWebController::class);


    Route::get('/tunggakan', [DuedateController::class, 'index'])->name('tunggakan.index');
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');


    // Route Halaman Laporan (Index)
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    // Route untuk Proses Export
    Route::get('/laporan/export/{type}', [ReportController::class, 'export'])->name('report.export');

    // 🔥 Tambahkan route untuk Daftar User
    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::resource('users', App\Http\Controllers\UsersController::class);

    // route delete dan edit
    Route::get('/siswa/{id}/edit', [StudentController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [StudentController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [StudentController::class, 'destroy'])->name('siswa.destroy');
});
