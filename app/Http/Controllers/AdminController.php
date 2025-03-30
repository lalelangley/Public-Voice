<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua petugas berdasarkan role_id
        $role = Role::where('name', 'petugas')->first();
        if (!$role) {
            return redirect()->route('admin.dashboard')->with('error', 'Role petugas tidak ditemukan.');
        }

        $petugas = User::where('role_id', $role->id)->get();

        return view('admin.dashboard', compact('petugas'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255', // Ubah dari 'name' ke 'nama'
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'telp' => 'required|string|max:15',
            'divisi' => 'required|string|max:255',
        ]);

        // Cek role 'petugas'
        $role = Role::where('name', 'petugas')->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Role petugas tidak ditemukan');
        }

        // Simpan ke tabel 'petugas'
        $petugas = Petugas::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'level' => 'petugas',
            'divisi' => $request->divisi,
        ]);

        // Simpan ke tabel 'users'
        User::create([
            'name' => $request->nama, // Sesuaikan dengan Petugas
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil ditambahkan');
    }
}
