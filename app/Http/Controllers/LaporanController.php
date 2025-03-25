<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::all();
        return view('laporan.index', compact('pengaduan'));
    }

    public function generatePDF()
    {
        $pengaduan = Pengaduan::all();
        $pdf = Pdf::loadView('laporan.pdf', compact('pengaduan'));

        return $pdf->download('laporan_pengaduan.pdf');
    }
}

