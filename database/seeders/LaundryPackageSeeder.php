<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaundryPackage;

class LaundryPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'nama_paket' => '1 Minggu',
                'harga'      => 56000,
                'jenis'      => 'mingguan',
                'periode'    => '1 Minggu',
                'status'     => 'active',
                'deskripsi'  => 'Max 7 kg',
                'thumbnail'  => null,
            ],
            [
                'nama_paket' => '2 Minggu',
                'harga'      => 112000,
                'jenis'      => 'mingguan',
                'periode'    => '2 Minggu',
                'status'     => 'active',
                'deskripsi'  => 'Max 14 kg',
                'thumbnail'  => null,
            ],
            [
                'nama_paket' => '1 Bulan',
                'harga'      => 240000,
                'jenis'      => 'bulanan',
                'periode'    => '1 Bulan',
                'status'     => 'active',
                'deskripsi'  => 'Max 30 kg',
                'thumbnail'  => null,
            ],
            [
                'nama_paket' => '2 Bulan',
                'harga'      => 480000,
                'jenis'      => 'bulanan',
                'periode'    => '2 Bulan',
                'status'     => 'active',
                'deskripsi'  => 'Max 60 kg',
                'thumbnail'  => null,
            ],
            [
                'nama_paket' => '3 Bulan',
                'harga'      => 720000,
                'jenis'      => 'bulanan',
                'periode'    => '3 Bulan',
                'status'     => 'active',
                'deskripsi'  => 'Max 90 kg',
                'thumbnail'  => null,
            ],
        ];

        foreach ($packages as $package) {
            LaundryPackage::firstOrCreate(
                ['nama_paket' => $package['nama_paket'], 'periode' => $package['periode']],
                $package
            );
        }
    }
}
