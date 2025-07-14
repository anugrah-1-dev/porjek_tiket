<?php
// database/seeders/ProgramOnlineSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOnline;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProgramOfflineSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            ProgramOnline::create([
                'nama' => 'Program Online ' . $i,
                'slug' => Str::slug('Program Online ' . $i),
                'lama_program' => rand(2, 12) . ' Minggu',
                'kategori' => 'Bahasa',
                'harga' => rand(500000, 2000000),
                'features_program' => 'Fitur A, Fitur B, Fitur C',
                'is_active' => 1,
                'thumbnail' => 'https://via.placeholder.com/150',
                'created_at' => Carbon::now()->subMonths(rand(0, 11)),
                'updated_at' => now(),
            ]);
        }
    }
}
