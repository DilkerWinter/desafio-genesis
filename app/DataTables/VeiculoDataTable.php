<?php

namespace App\DataTables;

use App\Repositories\VeiculoRepository;
use Carbon\Carbon;

class VeiculoDataTable
{
    protected $repository;

    public function __construct(VeiculoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Retorna os dados formatados para usar na DataTable
     */
    public function getTableData(array $params): array
    {
        $data = $this->repository->searchAndPaginate($params);

        $formattedData = $data->map(function ($veiculo) {
            return [
                'id' => $veiculo->id,
                'modelo' => $veiculo->modelo,
                'ano' => $veiculo->ano,
                'data_aquisicao' => $this->formatarData($veiculo->data_aquisicao),
                'km_aquisicao' => $veiculo->km_aquisicao,
                'renavam' => $veiculo->renavam,
                'placa' => $veiculo->placa,
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
