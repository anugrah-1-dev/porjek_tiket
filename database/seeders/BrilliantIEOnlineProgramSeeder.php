<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOnline;
use Illuminate\Support\Str;

class BrilliantIEOnlineProgramSeeder extends Seeder
{
    public function run(): void
    {
        ProgramOnline::where('kursus', 'brilliant')->delete();

        $fasilitas = [
            'Biaya Admin : Gratis',
            '20x Meeting',
            '60 Menit/Pertemuan',
            '2x Ujian',
            'E-Certificate',
        ];

        $programs = [
            [
                'nama'             => 'SHORT LEARNING ONLINE',
                'lama_program'     => '14 Hari',
                'kategori'         => 'Short Learning',
                'harga'            => 400000,
                'features_program' => json_encode($fasilitas),
            ],
            [
                'nama'             => 'REGULER 1 ONLINE',
                'lama_program'     => '30 Hari',
                'kategori'         => 'Reguler',
                'harga'            => 650000,
                'features_program' => json_encode($fasilitas),
            ],
            [
                'nama'             => 'REGULER 2 ONLINE',
                'lama_program'     => '60 Hari',
                'kategori'         => 'Reguler',
                'harga'            => 1200000,
                'features_program' => json_encode($fasilitas),
            ],
        ];

        foreach ($programs as $data) {
            ProgramOnline::create([
                'nama'             => $data['nama'],
                'slug'             => Str::slug($data['nama']),
                'program_bahasa'   => 'Inggris',
                'kursus'           => 'brilliant',
                'lama_program'     => $data['lama_program'],
                'kategori'         => $data['kategori'],
                'harga'            => $data['harga'],
                'features_program' => $data['features_program'],
                'is_active'        => 1,
                'thumbnail'        => null,
            ]);
        }
    }
}
