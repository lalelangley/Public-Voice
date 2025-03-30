<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    // Menampilkan daftar laporan yang berstatus "proses"
    public function index() {
        $petugas = Auth::guard('petugas')->user(); // Ambil data petugas yang login
        $pengaduan = Pengaduan::where('status', 'proses')
                              ->where('kategori', $petugas->divisi)
                              ->get();
        return view('tanggapan.index', compact('pengaduan'));
    }    

    // Menampilkan halaman detail laporan dan form tanggapan
    public function create($id) {
        $pengaduan = Pengaduan::with('masyarakat')->findOrFail($id);
        return view('tanggapan.create', compact('pengaduan'));
    }

    // Menampilkan detail laporan tanpa form tanggapan
    public function show($id) {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('tanggapan.show', compact('pengaduan'));
    }

    // Memverifikasi laporan (mengubah status menjadi 'proses')
    public function verify($id) {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->status === '0') {
            $pengaduan->update(['status' => 'proses']);
            return redirect()->route('tanggapan.index')->with('success', 'Pengaduan berhasil diverifikasi!');
        }
        
        return redirect()->route('tanggapan.index')->with('error', 'Pengaduan sudah diverifikasi sebelumnya!');
    }

    // Menyimpan tanggapan dari petugas
    public function store(Request $request, $id) {
        $request->validate([
            'tanggapan' => 'required',
        ]);
    
        Tanggapan::create([
            'id_pengaduan' => $id,
            'tgl_tanggapan' => now(),
            'tanggapan' => $request->tanggapan,
            'id_petugas' => Auth::guard('petugas')->user()->id, // Pastikan pakai guard 'petugas'
        ]);
    
        Pengaduan::where('id', $id)->update(['status' => 'selesai']);
    
        return redirect()->route('laporan.index')->with('success', 'Tanggapan berhasil dikirim!');
    }    
}
