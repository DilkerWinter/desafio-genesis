<?php

namespace App\Services;

use App\DataTables\ViagemDataTable;
use App\Repositories\ViagemRepository;
use Illuminate\Support\Facades\Validator;

class ViagemService
{
    protected $repository;
    protected $dataTable;

    public function __construct(ViagemRepository $repository,ViagemDataTable $dataTable)
    {
        $this->repository = $repository;
        $this->dataTable = $dataTable;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, [
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'km_inicial' => 'required|integer|min:0',
            'km_final' => 'nullable|integer|gt:km_inicial',
            'data_hora_inicial' => 'required|date',
            'data_hora_final' => 'nullable|date|after:data_saida',
        ]);

        $validator->validate();

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'km_inicial' => 'required|integer|min:0',
            'km_final' => 'nullable|integer|gt:km_inicial',
            'data_hora_inicial' => 'required|date',
            'data_hora_final' => 'nullable|date|after:data_saida',
        ]);

        $validator->validate();

        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Pega os dados da dataTable
     */
    public function dataTable(array $params): array
    {
        return $this->dataTable->getTableData($params);
    }
}
