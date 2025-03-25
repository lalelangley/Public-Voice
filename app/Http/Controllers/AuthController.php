<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Masyarakat;
use App\Models\Petugas;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $masyarakat = Masyarakat::where('username', $request->username)->first();
        if ($masyarakat && Hash::check($request->password, $masyarakat->password)) {
            session(['user' => $masyarakat, 'role' => 'masyarakat']);
            return redirect('/dashboard');
        }

        $petugas = Petugas::where('username', $request->username)->first();
        if ($petugas && Hash::check($request->password, $petugas->password)) {
            session(['user' => $petugas, 'role' => $petugas->level]);
            return redirect('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nik' => 'required|unique:masyarakat',
            'nama' => 'required',
            'username' => 'required|unique:masyarakat',
            'password' => 'required|min:6',
            'telp' => 'required',
        ]);

        Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout() {
        session()->flush();
        return redirect('/login');
    }
}
