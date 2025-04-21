<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LikePengaduanController;
use App\Http\Controllers\KomentarPengaduanController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LogTestController;
use App\Http\Controllers\FeedbackController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// ========================
// AUTH (Login, Register, Logout)
// ========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================
// MASYARAKAT
// ========================
Route::middleware('auth:masyarakat')->group(function () {

    Route::get('/masyarakat/dashboard', [PengaduanController::class, 'dashboard'])->name('masyarakat.dashboard');

    // Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password-form');
    Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});


// ========================
// PETUGAS & ADMIN
// ========================
Route::middleware('auth:petugas')->group(function () {

    // Dashboard Petugas
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    // Dashboard Admin (pakai controller supaya $petugas bisa dikirim)
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Tanggapan
    Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('tanggapan.index');
    Route::get('/tanggapan/{id}/create', [TanggapanController::class, 'create'])->name('tanggapan.create');
    Route::get('/tanggapan/{id}', [TanggapanController::class, 'show'])->name('tanggapan.show');
    Route::post('/tanggapan', [TanggapanController::class, 'store'])->name('tanggapan.store');

    // Admin Management (akun petugas yg bisa login sbg admin)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/tambah', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Petugas Management (khusus buat tambah & list petugas baru)
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/tambah', [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
});


// ========================
// LAPORAN (Semua user login)
// ========================
Route::middleware('auth')->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('laporan.pdf');
});


// ========================
// Google OAuth
// ========================
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('logout', [GoogleAuthController::class, 'logout'])->name('logout');

// ========================
// Like pengaduan
// ========================
Route::post('/pengaduan/{id}/like', [PengaduanController::class, 'like'])->name('pengaduan.like');
Route::post('/pengaduan/{id}/like', [LikePengaduanController::class, 'toggle'])->name('pengaduan.like');

// ========================
// Komentar pengaduan
// ========================
Route::post('/pengaduan/{id}/komentar', [KomentarPengaduanController::class, 'store'])->name('pengaduan.komentar');


// ========================
// Download pengaduan
// ========================
Route::get('/pengaduan/{id}/download', [PengaduanController::class, 'download'])->name('pengaduan.download');

// Route untuk menampilkan form forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');

// Route untuk mengirimkan link reset password
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Route untuk menampilkan form reset password menggunakan token
Route::get('/forgot-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

// Route untuk menghandle reset password (POST)
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('/log-test', [LogTestController::class, 'testLog']);
Route::post('/feedback', [FeedbackController::class, 'store']);
Route::get('/ml/status', function () {
    $response = Http::post('https://became-employers-hybrid-sunglasses.trycloudflare.com/predict', [
        'judul' => 'Cek status',
        'isi_laporan' => 'Ini hanya pengujian status koneksi',
        'kategori' => 'Cek',
    ]);

    if ($response->successful()) {
        $data = $response->json();
        $data['message'] = 'Machine Learning aktif dan terkoneksi!';
        return response()->json($data);
    }

    return response()->json(['message' => 'ML API tidak merespons'], 500);
});

Route::get('/cek-ml', [App\Http\Controllers\MLController::class, 'cekStatus']);
