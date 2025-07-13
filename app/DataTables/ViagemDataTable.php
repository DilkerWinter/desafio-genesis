<?php

namespace App\DataTables;

use App\Models\Viagem;
use App\Repositories\ViagemRepository;
use Carbon\Carbon;

class ViagemDataTable
{
    protected $repository;

    public function __construct(ViagemRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Retorna os dados formatados para usar na DataTable
     */
    public function getTableData(array $params): array
    {
        $data = $this->repository->searchAndPaginate($params);

        $formattedData = $data->map(function ($viagem) {
            return [
                'id' => $viagem->id,
                'motorista' => $viagem->motorista->nome,
                'veiculo' => $viagem->veiculo->modelo,
                'km_inicial' => $viagem->km_inicial,
                'km_final' => $viagem->km_final,
                'distancia_total' => $viagem->distancia_total,
                'data_inicial' => $this->formatarData($viagem->data_hora_inicial),
                'data_final' => $this->formatarData($viagem->data_hora_final),
                'duracao_total' => $viagem->duracaoTotal,
            ];
        });

        return [
            'data' => $formattedData,
            'total' => $data->total(),
            'lastPage' => $data->lastPage(),
            'currentPage' => $data->currentPage(),
            'perPage' => $data->perPage(),
        ];
    }

    private function formatarData($data)
    {
        if (!$data) {
            return null;
        }

        try {
            return Carbon::parse($data)->format('d/m/Y');
        } catch (\Exception $e) {
            return $data;
        }
    }

}
