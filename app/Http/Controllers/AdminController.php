<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all(); 
    
        // if (!$role) {
        //     return redirect()->route('admin.dashboard')->with('error', 'Role petugas tidak ditemukan.');
        // }
    
        $petugas = Petugas::where('level', 'petugas')->get();
    
        return view('admin.dashboard', compact('petugas'));
    }
    

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:petugas,username',
            'email' => 'required|email|unique:petugas,email',
            'password' => 'required|min:6',
            'telp' => 'required|string|max:15',
            'divisi' => 'required|string|max:255',
        ]);
    
        Petugas::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'level' => 'petugas',
            'divisi' => $request->divisi,
        ]);
    
        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('admin.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:petugas,username,' . $id,
            'email' => 'required|email|unique:petugas,email,' . $id,
            'telp' => 'nullable|string|max:15',
            'divisi' => 'nullable|string|max:255',
        ]);

        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'telp' => $request->telp,
            'divisi' => $request->divisi,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Data petugas berhasil diperbarui');
    }
   

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas = Petugas::where('username', $petugas->username)->first();

        if ($petugas) {
            $petugas->delete();
        }

        $petugas->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil dihapus');
    }
}
