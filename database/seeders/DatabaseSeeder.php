<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PetugasSeeder; // Pastikan ini ada!

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil semua seeder yang diperlukan
        $this->call([
            PetugasSeeder::class,
        ]);
    }
}
