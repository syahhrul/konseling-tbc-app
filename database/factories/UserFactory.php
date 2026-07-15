<?php

// file: database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'role' => 'pengguna',
            'password' => static::$password ??= Hash::make('password'),
            // 'remember_token' => Str::random(10), // HAPUS ATAU KOMENTARI BARIS INI
        ];
    }
}