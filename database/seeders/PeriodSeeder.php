<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        $dates = [
            '2026-09-07',
            '2026-09-10',
            '2026-09-14',
            '2026-09-21',
            '2026-09-25',
            '2026-09-28',
            '2026-10-05',
            '2026-10-10',
            '2026-10-12',
            '2026-10-19',
            '2026-10-25',
            '2026-10-26',
            '2026-11-02',
            '2026-11-10',
            '2026-11-16',
            '2026-11-23',
            '2026-11-25',
            '2026-11-30',
            '2026-12-07',
            '2026-12-10',
            '2026-12-14',
            '2026-12-18',
            '2026-12-21',
            '2026-12-25',
            '2026-12-28',
        ];

        foreach ($dates as $date) {
            Period::firstOrCreate(
                ['date' => $date],
                ['is_active' => true]
            );
        }
    }
}
