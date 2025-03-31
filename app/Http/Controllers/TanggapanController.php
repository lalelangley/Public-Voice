<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $pengaduan = Pengaduan::find($id);
        
        if (!$pengaduan) {
            return redirect()->route('pengaduan.index')->with('error', 'Pengaduan tidak ditemukan.');
        }
    
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
    public function store(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id', // Sesuaikan dengan nama tabel yang benar
            'tanggapan' => 'required',
        ]);
    
        // Simpan tanggapan baru
        Tanggapan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'tanggapan' => $request->tanggapan,
            'tgl_tanggapan' => now(),
            'id_petugas' => Auth::guard('petugas')->id(),
        ]);
    
        // **Update status pengaduan jadi "selesai"**
        $pengaduan = DB::table('pengaduan')->where('id', $request->pengaduan_id)->first();
        if ($pengaduan) {
            DB::table('pengaduan')->where('id', $request->pengaduan_id)->update(['status' => 'selesai']);
        }
    
        return redirect()->route('tanggapan.show', $request->pengaduan_id)
            ->with('success', 'Tanggapan berhasil dikirim dan status diperbarui.');
    }
    
}
