<?php

namespace Tests\Unit;

use App\DataTables\VeiculoDataTable;
use App\Models\Veiculo;
use App\Repositories\VeiculoRepository;
use App\Services\VeiculoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class VeiculoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected VeiculoService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new VeiculoRepository();
        $dataTable = new VeiculoDataTable($repository);

        $this->service = new VeiculoService($repository, $dataTable);
    }

    /**
     * @test
     */
    public function deve_cadastrar_veiculo_com_dados_validos()
    {
        $dados = Veiculo::factory()->make()->toArray();

        $veiculo = $this->service->store($dados);

        $this->assertDatabaseHas('veiculos', [
            'id' => $veiculo->id,
            'modelo' => $dados['modelo'],
        ]);
    }

    /**
     * @test
     */
    public function nao_deve_cadastrar_veiculo_com_renavam_invalido()
    {
        $this->expectException(ValidationException::class);

        $dados = Veiculo::factory()->make([
            'renavam' => '123',
        ])->toArray();

        $this->service->store($dados);

        $this->assertDatabaseMissing('veiculos', ['renavam' => '123']);
    }

    /**
     * @test
     */
    public function nao_deve_cadastrar_veiculo_com_placa_invalida()
    {
        $this->expectException(ValidationException::class);

        $dados = Veiculo::factory()->make([
            'placa' => 'ABC1234',
        ])->toArray();

        $this->service->store($dados);

        $this->assertDatabaseMissing('veiculos', ['placa' => 'ABC1234']);
    }

    /**
     * @test
     */
    public function deve_atualizar_veiculo_com_sucesso()
    {
        $veiculo = Veiculo::factory()->create();

        $dadosAtualizados = [
            'modelo' => 'Modelo Editado',
            'ano' => 2022,
            'data_aquisicao' => now()->subYears(2)->format('Y-m-d'),
            'km_aquisicao' => 50000,
            'renavam' => $veiculo->renavam,
            'placa' => $veiculo->placa,
        ];

        $this->service->update($veiculo->id, $dadosAtualizados);

        $this->assertDatabaseHas('veiculos', [
            'id' => $veiculo->id,
            'modelo' => 'Modelo Editado',
            'ano' => 2022,
        ]);
    }

    /**
     * @test
     */
    public function deve_excluir_veiculo_com_sucesso()
    {
        $veiculo = Veiculo::factory()->create();

        $this->service->destroy($veiculo->id);

        $this->assertSoftDeleted('veiculos', ['id' => $veiculo->id]);
    }

    /**
     * @test
     */
    public function deve_retornar_um_veiculo_pelo_id()
    {
        $veiculo = Veiculo::factory()->create();

        $result = $this->service->show($veiculo->id);

        $this->assertEquals($veiculo->id, $result->id);
    }
}
