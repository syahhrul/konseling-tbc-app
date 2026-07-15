<?php

// file: database/factories/CheckHarianFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CheckHarianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tanggal' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'suhu' => fake()->randomFloat(1, 36.5, 38.0),
            'berat' => fake()->randomFloat(1, 50, 95),
            'nafsu_makan' => fake()->randomElement(['Baik', 'Menurun', 'Normal']),
            'minum_obat' => fake()->randomElement(['Ya', 'Tidak']),
            'catatan_pete' => fake()->sentence(4),
        ];
    }
}