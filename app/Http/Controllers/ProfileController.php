<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Masyarakat;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::guard('masyarakat')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masyarakat,username,' . $user->id_masyarakat . ',id_masyarakat',
            'telp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|max:2048', // Maks 2MB
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            $fotoPath = $request->file('foto')->store('profile', 'public');
            $user->foto = $fotoPath;
        }

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->telp = $request->telp;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
