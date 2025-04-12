<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('masyarakat')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('masyarakat.dashboard');
        }

        if (Auth::guard('petugas')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $petugas = Auth::guard('petugas')->user();

            if ($petugas->level == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($petugas->level == 'petugas') {
                return redirect()->route('petugas.dashboard');
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|unique:masyarakat,nik',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masyarakat,username',
            'password' => 'required|string|min:6|confirmed',
            'telp' => 'required|string|max:20',
            'tempat_tinggal' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'required|string',
            'disabilitas' => 'required|string',
            'email' => 'required|email|unique:masyarakat,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Masyarakat::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'telp' => $request->telp,
                'tempat_tinggal' => $request->tempat_tinggal,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pekerjaan' => $request->pekerjaan,
                'disabilitas' => $request->disabilitas,
                'email' => $request->email,
            ]);

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        if (Auth::guard('masyarakat')->check()) {
            Auth::guard('masyarakat')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
