<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// **Authentication (Login, Register, Logout)**
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// **Masyarakat Only** (Tidak dialihkan setelah login)
Route::middleware('auth:masyarakat')->group(function() {
    Route::get('/masyarakat/dashboard', function () {
        return view('masyarakat.dashboard');
    })->name('masyarakat.dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // ✅ Route Update
    });
    
});

/// **Petugas & Admin (Pakai auth:petugas, Cek Level)**
Route::middleware('auth:petugas')->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    Route::get('/admin/dashboard', function () {
        $user = Auth::guard('petugas')->user();
        if ($user->level !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/tanggapan/{id}/create', [TanggapanController::class, 'create'])->name('tanggapan.create');
    Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('tanggapan.index');
    Route::get('/tanggapan/create/{id}', [TanggapanController::class, 'create'])->name('tanggapan.create');
    Route::get('/tanggapan/{id}', [TanggapanController::class, 'show'])->name('tanggapan.show');
    Route::post('/tanggapan', [TanggapanController::class, 'store'])->name('tanggapan.store'); // Pastikan ada ini!


    Route::get('/admin/tambah', [AdminController::class, 'create'])
        ->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])
        ->name('admin.store');

    Route::get('/petugas', [PetugasController::class, 'index'])
        ->name('petugas.index');
    Route::get('/petugas/tambah', [PetugasController::class, 'create'])
        ->name('petugas.create');
    Route::post('/petugas', [PetugasController::class, 'store'])
        ->name('petugas.store');
});


// **Laporan (Bisa diakses oleh semua user yang login)**
Route::middleware('auth')->group(function() {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('laporan.pdf');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('logout', [GoogleAuthController::class, 'logout'])->name('logout');