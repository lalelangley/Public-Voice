<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        // Admin tidak memiliki divisi
        Petugas::create([
            'nama' => 'Admin Public Voice',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@example.com',
            'telp' => '081234567890',
            'level' => 'admin',
            'divisi' => null, // Admin tidak perlu divisi
        ]);

        // Petugas divisi Kriminal
        Petugas::create([
            'nama' => 'Petugas Kriminal',
            'username' => 'petugas_kriminal',
            'password' => Hash::make('kriminal123'),
            'email' => 'kriminal1@example.com',
            'telp' => '081234567891',
            'level' => 'petugas',
            'divisi' => 'kriminal',
        ]);

        // Petugas divisi Bencana Alam
        Petugas::create([
            'nama' => 'Petugas Bencana',
            'username' => 'petugas_bencana',
            'password' => Hash::make('bencana123'),
            'email' => 'bencana1@example.com',
            'telp' => '081234567892',
            'level' => 'petugas',
            'divisi' => 'bencana',
        ]);

        // Petugas divisi Fasilitas Rusak
        Petugas::create([
            'nama' => 'Petugas Fasilitas',
            'username' => 'petugas_fasilitas',
            'password' => Hash::make('fasilitas123'),
            'email' => 'fasilitas1@example.com',
            'telp' => '081234567893',
            'level' => 'petugas',
            'divisi' => 'fasilitas',
        ]);
    }
}
