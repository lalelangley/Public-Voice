<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan ini!

class PetugasController extends Controller
{
    public function create()
    {
        return view('admin.create'); // Ganti dari petugas.tambah ke admin.create
    }

    public function store(Request $request)
    {
        // Pastikan hanya admin yang bisa menambah admin
        if (Auth::petugas()->level !== 'admin' && $request->level === 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambahkan admin!');
        }

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:petugas',
            'password' => 'required|string|min:6',
            'telp' => 'required|string|max:15',
            'level' => 'required|in:admin,petugas',
            'divisi' => 'required|string',
        ]);

        // Simpan ke database
        DB::table('petugas')->insert([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Menggunakan Hash
            'telp' => $request->telp,
            'level' => $request->level,
            'divisi' => $request->divisi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index')->with('success', 'Petugas berhasil ditambahkan!');
    }
}
