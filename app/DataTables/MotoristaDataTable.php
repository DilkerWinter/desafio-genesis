<?php

namespace App\DataTables;

use App\Repositories\MotoristaRepository;
use Carbon\Carbon;

class MotoristaDataTable
{
    protected $repository;

    public function __construct(MotoristaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTableData(array $params): array
    {
        $data = $this->repository->searchAndPaginate($params);

        $formattedData = $data->map(function ($motorista) {
            return [
                'id' => $motorista->id,
                'nome' => $motorista->nome,
                'data_nascimento' => $this->formatarData($motorista->data_nascimento),
                'cnh' => $motorista->cnh,
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
