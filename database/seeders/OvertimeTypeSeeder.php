<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OvertimeType;
use Carbon\Carbon;

class OvertimeTypeSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $overtimeTypes = [
            [
                'type' => 'Weekday Overtime',
                'hourly_rate' => 1.5,
                'maximum_hour_limit' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'Weekend Overtime',
                'hourly_rate' => 2.0,
                'maximum_hour_limit' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'Holiday Overtime',
                'hourly_rate' => 2.5,
                'maximum_hour_limit' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        OvertimeType::insert($overtimeTypes);
    }
}
