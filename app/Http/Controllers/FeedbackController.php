<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'feedback' => 'required|string',
        ]);

        // Ambil data divisi dari API eksternal
        $response = Http::get('https://api.eksternal.com/divisi'); // URL API eksternal
        $divisi = $response->json()['divisi'];  // Misalnya data divisi ada di key 'divisi'

        // Simpan data feedback ke database
        $feedback = Feedback::create([
            'name' => $validated['name'],
            'feedback' => $validated['feedback'],
            'divisi' => $divisi,  // Kolom divisi diisi dari API eksternal
        ]);

        // Kembalikan response JSON
        return response()->json(['message' => 'Feedback submitted successfully!', 'data' => $feedback], 201);
    }
}
