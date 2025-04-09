<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengaduanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengaduan')->insert([
            [
                'judul' => 'Laporan Jalan Rusak',
                'isi_laporan' => 'Jalan utama rusak parah.',
                'divisi' => 'Infrastruktur',
                'foto' => 'jalan_rusak.jpg',
                'status' => 'pending',
                'id_masyarakat' => 1, // Ganti dengan ID masyarakat yang valid
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Lampu Jalan Mati',
                'isi_laporan' => 'Lampu jalan di perempatan mati.',
                'divisi' => 'Penerangan Jalan',
                'foto' => 'lampu_jalan.jpg',
                'status' => 'proses',
                'id_masyarakat' => 2, // Ganti dengan ID masyarakat yang valid
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);        
    }
}
