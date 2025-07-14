<?php

namespace Database\Factories;

use App\Models\Motorista;
use App\Models\Veiculo;
use App\Models\Viagem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Viagem>
 */
class ViagemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $dataInicial = $this->faker->dateTimeBetween('-10 days', 'now');
        $dataFinal = (clone $dataInicial)->modify('+'.rand(1, 5).' hours');

        $kmInicial = $this->faker->numberBetween(10000, 50000);
        $kmFinal = $kmInicial + $this->faker->numberBetween(10, 500);

        return [
            'veiculo_id' => Veiculo::factory(),     
            'km_inicial' => $kmInicial,
            'km_final' => $kmFinal,
            'data_hora_inicial' => $dataInicial,
            'data_hora_final' => $dataFinal,
        ];
    }
}
