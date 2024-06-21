<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docter>
 */
class DocterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->Str::uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'specialties' => $this->faker->randomElements(['Anesthesiologist', 'Cardiologist', 'Geneticist', 'Nephrologist', 'Surgeon', 'Orthopedist']),
            'amount' => $this->faker->randomFloat(50, 200),

        ];
    }
}
