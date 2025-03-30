<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // Pastikan role 'petugas' ada di database
        $role = Role::where('name', 'petugas')->first();
        if (!$role) {
            return redirect()->route('admin.dashboard')->with('error', 'Role petugas tidak ditemukan.');
        }

        // Ambil user yang punya role 'petugas'
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $role = Role::where('name', 'petugas')->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Role petugas tidak ditemukan');
        }
        
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Petugas berhasil ditambahkan');
    }
}
