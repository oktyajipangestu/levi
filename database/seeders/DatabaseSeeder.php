<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\OvertimeType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Buat supervisor terlebih dahulu
        User::factory()->count(5)->state(function (array $attributes) {
            return ['role' => 'supervisor'];
        })->create();

        // Buat HR personnel
        User::factory()->count(3)->state(function (array $attributes) {
            return ['role' => 'hr'];
        })->create();

        // Buat employee
        User::factory()->count(20)->state(function (array $attributes) {
            return ['role' => 'employee'];
        })->create();

        $this->call([
            UserProfileSeeder::class,
            OvertimeTypeSeeder::class,
        ]);
    }
}
