<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;

class TanggapanController extends Controller
{
    public function index() {
        $petugas = auth()->user();
        $pengaduan = Pengaduan::where('status', 'proses')
                              ->where('kategori', $petugas->divisi)
                              ->get();
        return view('tanggapan.index', compact('pengaduan'));
    }    

    public function show($id) {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('tanggapan.show', compact('pengaduan'));
    }

    public function verify($id) {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'proses']);
        return redirect('/tanggapan')->with('success', 'Pengaduan diverifikasi!');
    }

    public function store(Request $request, $id) {
        $request->validate([
            'tanggapan' => 'required',
        ]);

        Tanggapan::create([
            'id_pengaduan' => $id,
            'tgl_tanggapan' => now(),
            'tanggapan' => $request->tanggapan,
            'id_petugas' => session('user')->id_petugas,
        ]);

        Pengaduan::where('id_pengaduan', $id)->update(['status' => 'selesai']);

        return redirect('/tanggapan')->with('success', 'Tanggapan berhasil dikirim!');
    }
}
