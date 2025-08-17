<?php

// database/seeders/ProgramOfflineSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline; // Pastikan model ini mengarah ke tabel 'program_offline'
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProgramOfflineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Array contoh untuk kategori program offline
        $categories = ['Public Speaking', 'TOEFL Preparation', 'IELTS Preparation', 'Grammar Focus'];
        // Array contoh untuk lokasi
        $locations = ['Pare, Kediri', 'Surabaya', 'Jakarta', 'Bandung'];

        for ($i = 1; $i <= 10; $i++) {
            // Membuat jadwal mulai dan selesai secara acak
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addWeeks(rand(1, 4));
            $namaProgram = 'Program Offline ' . $i;

            ProgramOffline::create([
                'nama' => $namaProgram,
                'slug' => Str::slug($namaProgram),
                'lama_program' => rand(1, 6) . ' Minggu',
                'kategori' => $categories[array_rand($categories)],
                'harga' => rand(1000000, 3000000),
                'features_program' => 'Asrama, Modul, Sertifikat',
                'lokasi' => $locations[array_rand($locations)],
                'jadwal_mulai' => $startDate,
                'jadwal_selesai' => $endDate,
                'kuota' => rand(10, 40),
                'is_active' => 1,
                'thumbnail' => 'https://placehold.co/600x400/31343C/EEE?text=Program+Offline+' . $i,
                'created_at' => Carbon::now()->subMonths(rand(0, 11)),
                'updated_at' => now(),
            ]);
        }
    }
}
