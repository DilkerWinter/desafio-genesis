<?php

namespace Tests\Unit;

use App\DataTables\ViagemDataTable;
use App\Models\Motorista;
use App\Models\Veiculo;
use App\Models\Viagem;
use App\Repositories\ViagemRepository;
use App\Services\ViagemService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ViagemServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ViagemService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new ViagemRepository();
        $dataTable = new ViagemDataTable($repository);

        $this->service = new ViagemService($repository, $dataTable);
    }

    /**
     * @test
     */
    public function deve_cadastrar_viagem_com_dados_validos()
    {
        $motorista = Motorista::factory()->create();
        $veiculo = Veiculo::factory()->create();

        $dados = [
            'motorista_id' => $motorista->id,
            'veiculo_id' => $veiculo->id,
            'km_inicial' => 10000,
            'km_final' => 10500,
            'data_hora_inicial' => now()->subHours(2)->toDateTimeString(),
            'data_hora_final' => now()->toDateTimeString(),
        ];

        $viagem = $this->service->store($dados);

        $this->assertDatabaseHas('viagens', [
            'id' => $viagem->id,
            'motorista_id' => $motorista->id,
            'veiculo_id' => $veiculo->id,
        ]);
    }

    /**
     * @test
     */
    public function nao_deve_cadastrar_viagem_com_km_final_menor_que_km_inicial()
    {
        $this->expectException(ValidationException::class);

        $motorista = Motorista::factory()->create();
        $veiculo = Veiculo::factory()->create();

        $dados = [
            'motorista_id' => $motorista->id,
            'veiculo_id' => $veiculo->id,
            'km_inicial' => 20000,
            'km_final' => 19000,
            'data_hora_inicial' => now()->subHours(2)->toDateTimeString(),
            'data_hora_final' => now()->toDateTimeString(),
        ];

        $this->service->store($dados);

        $this->assertDatabaseMissing('viagens', ['km_final' => 19000]);
    }

    /**
     * @test
     */
    public function deve_atualizar_viagem_com_sucesso()
    {
        $motorista = Motorista::factory()->create();
        $veiculo = Veiculo::factory()->create();

        $viagem = Viagem::factory()->create([
            'motorista_id' => $motorista->id,
            'veiculo_id' => $veiculo->id,
        ]);

        $dadosAtualizados = [
            'motorista_id' => $motorista->id,
            'veiculo_id' => $veiculo->id,
            'km_inicial' => 12345,
            'km_final' => 12400,
            'data_hora_inicial' => now()->subHours(3)->toDateTimeString(),
            'data_hora_final' => now()->toDateTimeString(),
        ];

        $this->service->update($viagem->id, $dadosAtualizados);

        $this->assertDatabaseHas('viagens', [
            'id' => $viagem->id,
            'km_inicial' => 12345,
        ]);
    }

    /**
     * @test
     */
    public function deve_excluir_viagem_com_sucesso()
    {
        $viagem = Viagem::factory()->create();

        $this->service->destroy($viagem->id);

        $this->assertSoftDeleted('viagens', ['id' => $viagem->id]);
    }

    /**
     * @test
     */
    public function deve_retornar_uma_viagem_pelo_id()
    {
        $viagem = Viagem::factory()->create();

        $result = $this->service->show($viagem->id);

        $this->assertEquals($viagem->id, $result->id);
    }
}
