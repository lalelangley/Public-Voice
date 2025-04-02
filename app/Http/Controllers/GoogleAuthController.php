<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Masyarakat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek apakah user sudah ada
            $masyarakat = Masyarakat::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if (!$masyarakat) {
                // Jika belum ada, buat user baru
                $masyarakat = Masyarakat::create([
                    'nik'       => '00000', // NIK otomatis 00000
                    'nama'      => $googleUser->name,
                    'username'  => strtolower(str_replace(' ', '', $googleUser->name)) . rand(100, 999),
                    'email'     => $googleUser->email,
                    'password'  => Hash::make(uniqid()), // Password random
                    'telp'      => '00000', // No. telepon otomatis 00000
                    'google_id' => $googleUser->id,
                ]);
            }

            // Login user
            Auth::guard('masyarakat')->login($masyarakat);

            if (Auth::guard('masyarakat')->check()) {
                Log::info('User logged in successfully: ', (array) Auth::guard('masyarakat')->user());
                return redirect()->route('masyarakat.dashboard')->with('success', 'Login berhasil!');
            } else {
                Log::error('Login gagal! User tidak berhasil login.');
                return redirect()->route('login')->with('error', 'Login gagal!');
            }   
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google!'  /*. $e->getMessage()*/);
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
