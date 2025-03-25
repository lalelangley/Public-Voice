<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        Petugas::create([
            'nama' => 'Admin Public Voice',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'telp' => '081234567890',
            'level' => 'admin',
            'divisi' => 'admin', // Admin tidak perlu divisi
        ]);

        Petugas::create([
            'nama' => 'p1',
            'username' => 'p1',
            'password' => Hash::make('p123456'),
            'telp' => '081234567890',
            'level' => 'petugas',
            'divisi' => 'lingkungan', // Admin tidak perlu divisi
        ]);
    }
}
