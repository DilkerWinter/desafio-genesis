<?php

namespace Database\Seeders;

use App\Models\Viagem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VeiculoSeeder::class,
            MotoristaSeeder::class,
            ViagemSeeder::class,
        ]);
    }
}
