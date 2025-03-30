<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Masyarakat;
use App\Models\Petugas;

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
        $request->validate([
            'nik' => 'required|unique:masyarakat,nik',
            'nama' => 'required',
            'username' => 'required|unique:masyarakat,username',
            'password' => 'required|min:6',
            'telp' => 'required|max:15',
        ]);

        $masyarakat = Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
        ]);

        Auth::guard('masyarakat')->login($masyarakat);
        $request->session()->regenerate();

        return redirect()->route('masyarakat.dashboard')->with('success', 'Registrasi berhasil.');
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
