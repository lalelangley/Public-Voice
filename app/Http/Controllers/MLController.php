<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MLController extends Controller
{
    public function cekStatus()
    {
        ini_set('max_execution_time', 70); // Meningkatkan waktu eksekusi jadi 60 detik
        
        try {
            $response = Http::post('http://localhost:8000/ml/status', [
                'divisi' => 'kerusakan_fasilitas',
                'message' => 'Machine Learning aktif dan terkoneksi!'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menghubungi ML API',
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}