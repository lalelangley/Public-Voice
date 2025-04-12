<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\Masyarakat;

class ForgotPasswordController extends Controller
{

    // Menampilkan form untuk reset password
    public function showForgotForm()
{
    return view('auth.forgot-password');
}

public function showResetForm(Request $request, $token = null)
{
    return view('auth.reset-password')->with(['token' => $token, 'email' => $request->email]);
}


public function sendResetLink(Request $request)
{
    // Validasi email
    $request->validate([
        'email' => 'required|email',
    ]);

    // Cek email pada model masyarakat
    $masyarakat = Masyarakat::where('email', $request->email)->first();

    if (!$masyarakat) {
        return back()->withErrors(['email' => 'Email tidak terdaftar di sistem kami.']);
    }

    // Kirimkan link reset password
    $response = Password::broker('masyarakat')->sendResetLink(
        $request->only('email')
    );

    if ($response === Password::RESET_LINK_SENT) {
        return back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda.');
    } else {
        return back()->withErrors(['email' => 'Terjadi kesalahan. Silakan coba lagi.']);
    }
}

    // Memproses reset password
    public function reset(Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);
    
        // Ambil token dari URL
        $token = $request->input('token');
    
        // Proses reset password
        $response = Password::broker('masyarakat')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );
    
        return $response === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah!')
            : back()->withErrors(['email' => [__($response)]]);
    }    
    
    protected function broker()
    {
        return Password::broker('masyarakat');
    }
    
}
