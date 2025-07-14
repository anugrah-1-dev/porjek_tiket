<?php

// database/seeders/ProgramOfflineSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProgramOnlineSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addWeeks(rand(1, 4));

            ProgramOffline::create([
                'nama' => 'Program Offline ' . $i,
                'slug' => Str::slug('Program Offline ' . $i),
                'lama_program' => rand(1, 6) . ' Minggu',
                'kategori' => 'Public Speaking',
                'harga' => rand(1000000, 3000000),
                'features_program' => 'Asrama, Modul, Sertifikat',
                'lokasi' => 'Pare, Kediri',
                'jadwal_mulai' => $startDate,
                'jadwal_selesai' => $endDate,
                'kuota' => rand(10, 40),
                'is_active' => 1,
                'thumbnail' => 'https://via.placeholder.com/150',
                'created_at' => Carbon::now()->subMonths(rand(0, 11)),
                'updated_at' => now(),
            ]);
        }
    }
}
