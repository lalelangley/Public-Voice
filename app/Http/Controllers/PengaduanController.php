<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pengaduan;
use App\Models\Masyarakat;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with('tanggapan.petugas')->get(); // Tambahkan 'petugas' di dalam 'tanggapan'
        return view('pengaduan.index', compact('pengaduan'));
    }
    
    

    public function create()
    {
        return view('pengaduan.create');
    }
    
    public function show($id)
    {
        $pengaduan = Pengaduan::with('tanggapan')->findOrFail($id);
        return view('pengaduan.show', compact('pengaduan'));
    }


public function store(Request $request) {
    $masyarakat = Auth::guard('masyarakat')->user(); // Pakai Auth

    if (!$masyarakat) {
        return back()->with('error', 'Silakan login terlebih dahulu');
    }

    $request->validate([
        'judul' => 'required',
        'isi_laporan' => 'required',
        'kategori' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $fileName = null;
    if ($request->hasFile('foto')) {
        $fileName = $request->file('foto')->store('pengaduan', 'public');
    }

    Pengaduan::create([
        'id_masyarakat' => $masyarakat->id_masyarakat,
        'judul' => $request->judul,
        'isi_laporan' => $request->isi_laporan,
        'kategori' => $request->kategori,
        'foto' => $fileName,
        'status' => 'pending',
    ]);

    return redirect('/pengaduan')->with('success', 'Pengaduan berhasil dikirim');
}
};
