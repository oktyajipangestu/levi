<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, 28), // Mengaitkan dengan model User
            'nip' => $this->faker->unique()->numerify('########'), // Format nomor karyawan
            'position' => $this->faker->randomElement(["Software Developer","Data Analyst","Marketing Specialist","Graphic Designer","Accountant","Customer Service Representative"]), // Posisi
            'join_date' => $this->faker->date(), // Tanggal bergabung
            'status' => $this->faker->randomElement(['CPNS', 'PNS', 'PPPK']), // Status karyawan
        ];
    }
}
