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
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'telp' => 'required|string|max:15',
            'divisi' => 'required|string|max:255',
        ]);

        $role = Role::where('name', 'petugas')->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Role petugas tidak ditemukan');
        }

        Petugas::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'level' => 'petugas',
            'divisi' => $request->divisi,
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'telp' => 'nullable|string|max:15',
            'divisi' => 'nullable|string|max:255',
        ]);
    
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
        ]);
    
        $petugas = Petugas::where('username', $user->username)->first();
        if ($petugas) {
            $petugas->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'telp' => $request->telp,
                'divisi' => $request->divisi,
            ]);
        }
    
        return redirect()->route('admin.dashboard')->with('success', 'Data petugas berhasil diperbarui');
    }    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $petugas = Petugas::where('username', $user->username)->first();

        if ($petugas) {
            $petugas->delete();
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil dihapus');
    }
}
