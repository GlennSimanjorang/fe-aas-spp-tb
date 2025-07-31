<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/siswa', function () {
    return view('siswa.index');
});

Route::get('/tunggakan', function () {
    return view('tunggakan.index');
})->name('tunggakan.index');