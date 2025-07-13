<?php

namespace Tests\Unit;

use App\DataTables\MotoristaDataTable;
use App\Models\Motorista;
use App\Repositories\MotoristaRepository;
use App\Services\MotoristaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class MotoristaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MotoristaService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new MotoristaRepository();
        $dataTable = new MotoristaDataTable($repository);

        $this->service = new MotoristaService($repository, $dataTable);
    }

    /**
     * @test
     */
    public function deve_cadastrar_motorista_com_dados_validos()
    {
        $dados = Motorista::factory()->make()->toArray();

        $motorista = $this->service->store($dados);

        $this->assertDatabaseHas('motoristas', [
            'id' => $motorista->id,
            'nome' => $dados['nome'],
        ]);
    }

    /**
     * @test
     */
    public function nao_deve_cadastrar_motorista_com_cnh_invalida()
    {
        $this->expectException(ValidationException::class);

        $dados = Motorista::factory()->make([
            'cnh' => '123',
        ])->toArray();

        $this->service->store($dados);

        $this->assertDatabaseMissing('motoristas', ['cnh' => '123']);
    }

    /**
     * @test
     */
    public function deve_atualizar_motorista_com_sucesso()
    {
        $motorista = Motorista::factory()->create();

        $dadosAtualizados = [
            'nome' => 'Nome Atualizado',
            'data_nascimento' => '1990-01-01',
            'cnh' => $motorista->cnh,
        ];

        $this->service->update($motorista->id, $dadosAtualizados);

        $this->assertDatabaseHas('motoristas', [
            'id' => $motorista->id,
            'nome' => 'Nome Atualizado',
            'data_nascimento' => '1990-01-01',
        ]);
    }

    /**
     * @test
     */
    public function nao_deve_atualizar_motorista_com_cnh_invalida()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $motorista = Motorista::factory()->create([
            'nome' => 'Original',
            'data_nascimento' => '1985-01-01',
            'cnh' => '12345678900',
        ]);

        $dadosAtualizados = [
            'nome' => 'Nome Atualizado',
            'data_nascimento' => '1990-01-01',
            'cnh' => '123',
        ];

        $this->service->update($motorista->id, $dadosAtualizados);

        $this->assertDatabaseHas('motoristas', [
            'id' => $motorista->id,
            'nome' => 'Original',
            'cnh' => '12345678900',
        ]);
    }


    /**
     * @test
     */
    public function deve_excluir_motorista_com_sucesso()
    {
        $motorista = Motorista::factory()->create();

        $this->service->destroy($motorista->id);

        $this->assertSoftDeleted('motoristas', ['id' => $motorista->id]);
    }

    /**
     * @test
     */
    /**
     * @test
     */
    public function deve_retornar_datatable_de_motoristas()
    {
        Motorista::factory()->count(3)->create();

        $params = [];
        $resultado = $this->service->index($params);

        $this->assertArrayHasKey('data', $resultado);
        $this->assertCount(3, $resultado['data']);

        $this->assertArrayHasKey('id', $resultado['data'][0]);
        $this->assertArrayHasKey('nome', $resultado['data'][0]);
        $this->assertArrayHasKey('data_nascimento', $resultado['data'][0]);
        $this->assertArrayHasKey('cnh', $resultado['data'][0]);

        $this->assertArrayHasKey('total', $resultado);
        $this->assertArrayHasKey('lastPage', $resultado);
        $this->assertArrayHasKey('currentPage', $resultado);
        $this->assertArrayHasKey('perPage', $resultado);

        $this->assertEquals(3, $resultado['total']);
    }


    /**
     * @test
     */
    public function deve_retornar_um_motorista_pelo_id()
    {
        $motorista = Motorista::factory()->create();

        $result = $this->service->show($motorista->id);

        $this->assertEquals($motorista->id, $result->id);
    }
}
