<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarPengaduan;
use Illuminate\Support\Facades\Auth;

class KomentarPengaduanController extends Controller
{
    public function store(Request $request, $id)
    {
        $masyarakat = Auth::guard('masyarakat')->user();

        if (!$masyarakat) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        KomentarPengaduan::create([
            'pengaduan_id' => $id,
            'masyarakat_id' => $masyarakat->id_masyarakat,
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
