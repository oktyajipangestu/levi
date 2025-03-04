<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Definisikan role dan department
        $roles = ['employee', 'supervisor', 'hr'];
        $departments = ['IT', 'Operational', 'Marketing'];

        // Pilih role secara acak
        $role = $this->faker->randomElement($roles);

        // Pilih department secara acak
        $department = $this->faker->randomElement($departments);

        // Inisialisasi supervisor_id jika role adalah 'employee'
        $supervisor_id = null;
        if ($role === 'employee') {
            // Ambil semua supervisor
            $supervisors = User::where('role', 'supervisor')->get();
            if ($supervisors->count() > 0) {
                $supervisor_id = $supervisors->random()->id;
            }
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => $role,
            'department' => $department,
            'supervisor_id' => $supervisor_id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Pastikan ada supervisor untuk employee
            if ($user->role === 'employee' && $user->supervisor_id === null) {
                // Buat supervisor jika tidak ada
                $supervisor = User::factory()->create([
                    'role' => 'supervisor',
                    'department' => $user->department,
                ]);
                $user->supervisor_id = $supervisor->id;
                $user->save();
            }
        });
    }
}
