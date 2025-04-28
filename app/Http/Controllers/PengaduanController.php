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
        $kategori = $request->query('kategori');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');
        $search = $request->query('search');
        $sort = $request->query('sort');

        $query = Pengaduan::with(['tanggapan.petugas', 'masyarakat', 'likes', 'komentar.masyarakat']);

        if ($status && in_array($status, ['pending', 'proses', 'selesai'])) {
            $query->where('status', $status);
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }
    
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }
    
        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%$search%")
                  ->orWhere('isi_laporan', 'LIKE', "%$search%");
            });
        }
    
        if ($sort == 'like') {
            $query->withCount('likes')->orderByDesc('likes_count');
        } elseif ($sort == 'komentar') {
            $query->withCount('komentar')->orderByDesc('komentar_count');
        } elseif ($sort == 'baru') {
            $query->orderByDesc('created_at');
        } elseif ($sort == 'lama') {
            $query->orderBy('created_at');
        }

        $pengaduan = $query->paginate(9);
        $kategoriList = Pengaduan::select('kategori')->distinct()->pluck('kategori');

        return view('pengaduan.index', compact('pengaduan', 'status', 'kategoriList'));
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
        Log::info('Mulai proses store pengaduan');
    
        $masyarakat = Auth::guard('masyarakat')->user();
    
        if (!$masyarakat) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }
    
        // Validasi dengan pesan error custom (opsional)
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'lokasi_kejadian' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Judul laporan wajib diisi.',
            'isi_laporan.required' => 'Isi laporan tidak boleh kosong.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.date' => 'Format tanggal kejadian tidak valid.',
            'lokasi_kejadian.required' => 'Lokasi kejadian tidak boleh kosong.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Gambar harus berformat jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $fileName = null;
        if ($request->hasFile('foto')) {
            $fileName = $request->file('foto')->store('pengaduan', 'public');
        }
    
        // Kirim ke ML API
        $divisi = null;
        try {
            $mlResponse = Http::timeout(10) // Timeout dalam detik
            ->post('https://became-employers-hybrid-sunglasses.trycloudflare.com/predict', [
                'judul' => $request->judul,
                'isi_laporan' => $request->isi_laporan,
                'kategori' => $request->kategori,
            ]);
    
            if ($mlResponse->successful()) {
                Log::info('ML Response: ', $mlResponse->json());
                $divisi = $mlResponse->json()['divisi'] ?? null;
            } else {
                Log::warning('ML Response tidak berhasil: ' . $mlResponse->body());
            }
        } catch (\Exception $e) {
            Log::error('ML API Error: ' . $e->getMessage());
        }
    
        // Simpan ke database
        $pengaduan = Pengaduan::create([
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
    
        Log::info('Pengaduan berhasil dibuat', ['id' => $pengaduan->id]);
    
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
