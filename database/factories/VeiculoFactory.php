<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veiculo>
 */
class VeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'modelo' => $this->faker->randomElement([
                'Gol', 'Uno', 'Palio', 'Civic', 'Corolla', 'HB20', 'Ka', 'Fox', 'Onix', 'Cruze'
            ]),
            'ano' => $this->faker->numberBetween(1990, 2025),
            'data_aquisicao' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'km_aquisicao' => $this->faker->numberBetween(0, 200000),
            'renavam' => $this->faker->unique()->numerify('###########'),
            'placa' => strtoupper($this->faker->regexify('[A-Z]{3}[0-9][A-Z]{2}[0-9]')),
        ];
    }
}
