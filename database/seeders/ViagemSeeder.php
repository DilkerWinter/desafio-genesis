<?php

namespace Database\Seeders;

use App\Models\Motorista;
use App\Models\Veiculo;
use App\Models\Viagem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViagemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motoristaIds = Motorista::pluck('id')->toArray();
        $veiculoIds = Veiculo::pluck('id')->toArray();

        Viagem::factory()->count(20)->make()->each(function ($viagem) use ($motoristaIds, $veiculoIds) {
            $viagem->motorista_id = fake()->randomElement($motoristaIds);
            $viagem->veiculo_id = fake()->randomElement($veiculoIds);
            $viagem->save();
        });
    }
}
