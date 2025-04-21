<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pengaduan;
use App\Models\Masyarakat;
use Illuminate\Support\Facades\Auth;
use App\Models\LikePengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // Ambil filter status dari URL

        $query = Pengaduan::with(['tanggapan.petugas', 'masyarakat', 'likes', 'komentar.masyarakat']);

        if ($status && in_array($status, ['pending', 'proses', 'selesai'])) {
            $query->where('status', $status);
        }

        $pengaduan = $query->get();

        return view('pengaduan.index', compact('pengaduan', 'status'));
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

   
public function store(Request $request)
{
    $masyarakat = Auth::guard('masyarakat')->user();

    if (!$masyarakat) {
        return back()->with('error', 'Silakan login terlebih dahulu');
    }

    $request->validate([
        'judul' => 'required',
        'isi_laporan' => 'required',
        'kategori' => 'required',
        'tanggal_kejadian' => 'required|date',
        'lokasi_kejadian' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $fileName = null;
    if ($request->hasFile('foto')) {
        $fileName = $request->file('foto')->store('pengaduan', 'public');
    }

    $divisi = null;
    try {
        $mlResponse = Http::post('https://ml-divisi.yourdomain.workers.dev/predict', [
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'kategori' => $request->kategori,
        ]);

        if ($mlResponse->successful()) {
            $divisi = $mlResponse->json()['divisi'] ?? null;
        }
    } catch (\Exception $e) {
        Log::error('ML API Error: ' . $e->getMessage());
    }

    Pengaduan::create([
        'id_masyarakat' => $masyarakat->id_masyarakat,
        'judul' => $request->judul,
        'isi_laporan' => $request->isi_laporan,
        'kategori' => $request->kategori,
        'foto' => $fileName,
        'tanggal_kejadian' => $request->tanggal_kejadian,
        'lokasi_kejadian' => $request->lokasi_kejadian,
        'anonim' => $request->has('anonim'),
        'status' => 'pending',
        'divisi' => $divisi,
    ]);

    return redirect('/pengaduan')->with('success', 'Pengaduan berhasil dikirim');
}
    public function like($id)
    {
        $masyarakat = Auth::guard('masyarakat')->user();

        if (!$masyarakat) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $alreadyLiked = LikePengaduan::where('pengaduan_id', $id)
            ->where('masyarakat_id', $masyarakat->id_masyarakat)
            ->exists();

        if (!$alreadyLiked) {
            LikePengaduan::create([
                'pengaduan_id' => $id,
                'masyarakat_id' => $masyarakat->id_masyarakat,
            ]);
        }

        return back();
    }

    public function download($id)
    {
        $pengaduan = Pengaduan::with('masyarakat')->findOrFail($id);

        $pdf = PDF::loadView('pengaduan.pdf', compact('pengaduan'));
        return $pdf->download('Laporan-Pengaduan-' . $pengaduan->id . '.pdf');
    }
    public function dashboard()
    {
        $masyarakat = Auth::guard('masyarakat')->user();

        $total = Pengaduan::where('id_masyarakat', $masyarakat->id_masyarakat)->count();
        $pending = Pengaduan::where('id_masyarakat', $masyarakat->id_masyarakat)->where('status', 'pending')->count();
        $proses = Pengaduan::where('id_masyarakat', $masyarakat->id_masyarakat)->where('status', 'proses')->count();
        $selesai = Pengaduan::where('id_masyarakat', $masyarakat->id_masyarakat)->where('status', 'selesai')->count();

        return view('masyarakat.dashboard', compact('total', 'pending', 'proses', 'selesai'));
    }

}
