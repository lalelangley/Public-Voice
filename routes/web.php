<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:masyarakat')->group(function() {
    Route::get('/pengaduan', [PengaduanController::class, 'index']);
    Route::get('/pengaduan/create', [PengaduanController::class, 'create']);
    Route::post('/pengaduan', [PengaduanController::class, 'store']);
});
Route::middleware('auth:petugas')->group(function() {
    Route::get('/tanggapan', [TanggapanController::class, 'index']);
    Route::get('/tanggapan/{id}', [TanggapanController::class, 'show']);
    Route::post('/tanggapan/{id}/verify', [TanggapanController::class, 'verify']);
    Route::post('/tanggapan/{id}', [TanggapanController::class, 'store']);
});
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('laporan.pdf');