<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikePengaduan;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class LikePengaduanController extends Controller
{
    public function toggle($id)
    {
        $masyarakat = Auth::guard('masyarakat')->user();
    
        if (!$masyarakat) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $like = LikePengaduan::where('pengaduan_id', $id)
                ->where('masyarakat_id', $masyarakat->id_masyarakat)
                ->first();
    
        if ($like) {
            $like->delete();
            return back()->with('success', 'Dukungan dibatalkan.');
        } else {
            LikePengaduan::create([
                'pengaduan_id' => $id,
                'masyarakat_id' => $masyarakat->id_masyarakat,
            ]);
            return back()->with('success', 'Terima kasih atas dukungannya.');
        }
    }
    
}

