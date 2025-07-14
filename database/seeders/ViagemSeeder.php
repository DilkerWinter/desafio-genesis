<?php

namespace Database\Seeders;

use App\Models\Motorista;
use App\Models\Veiculo;
use App\Models\Viagem;
use Illuminate\Database\Seeder;

class ViagemSeeder extends Seeder
{
    public function run(): void
    {
        $motoristaIds = Motorista::pluck('id')->toArray();
        $veiculoIds = Veiculo::pluck('id')->toArray();

        Viagem::factory()->count(20)->make()->each(function ($viagem) use ($motoristaIds, $veiculoIds) {
            $viagem->veiculo_id = fake()->randomElement($veiculoIds);
            $viagem->save();

            $motoristasParaAssociar = fake()->randomElements($motoristaIds, rand(1, 3));
            $viagem->motoristas()->attach($motoristasParaAssociar);
        });
    }
}
