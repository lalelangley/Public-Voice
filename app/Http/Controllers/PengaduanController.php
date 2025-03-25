<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaduan;
use App\Models\Masyarakat;

class PengaduanController extends Controller
{
    public function index() {
        // Pastikan menggunakan session key yang konsisten
        $masyarakat = session('masyarakat');
        
        if (!$masyarakat) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $pengaduan = Pengaduan::where('id_masyarakat', $masyarakat->id_masyarakat)->get();
        return view('pengaduan.index', compact('pengaduan'));
    }

    public function create() {
        return view('pengaduan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required', // Tambahkan validasi untuk judul
            'isi_laporan' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $masyarakat = session('masyarakat');
        
        if (!$masyarakat) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        $fileName = null;
        if ($request->hasFile('foto')) {
            $fileName = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'id_masyarakat' => $masyarakat->id_masyarakat,
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'foto' => $fileName,
            'status' => 'pending', // Sesuaikan dengan enum di migrasi
        ]);

        return redirect('/pengaduan')->with('success', 'Pengaduan berhasil dikirim');
    }
}