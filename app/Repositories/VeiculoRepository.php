<?php

namespace App\Repositories;

use App\Models\Veiculo;

class VeiculoRepository
{
    public function getModel()
    {
        return Veiculo::class;
    }

    public function all()
    {
        return $this->getModel()::all();
    }

    public function find($id)
    {
        return $this->getModel()::with(['viagens.motorista'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->getModel()::create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->getModel()::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->getModel()::findOrFail($id);
        return $model->delete();
    }

    /**
     * Retorna os dados para usar na DataTable
     */
    public function searchAndPaginate(array $params)
    {
        $perPage = data_get($params, 'perPage', 5);
        $page = data_get($params, 'page', 1);
        $sortKey = data_get($params, 'sortKey', 'id');
        $sortOrder = data_get($params, 'sortOrder', 'asc');

        $query = $this->getModel()::query();

        if (in_array($sortKey, ['modelo', 'ano', 'data_aquisicao', 'km_aquisicao', 'renavam', 'placa'])) {
            $query->orderBy($sortKey, $sortOrder);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
