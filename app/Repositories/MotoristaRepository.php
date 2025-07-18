<?php

namespace App\Repositories;

use App\Models\Motorista;

class MotoristaRepository
{
    public function getModel()
    {
        return Motorista::class;
    }

    public function all()
    {
        return $this->getModel()::all();
    }

    public function find($id)
    {
        return $this->getModel()::with(['viagens.veiculo'])->findOrFail($id);
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
        $sortKey = data_get($params, 'sortKey', 'nome');
        $sortOrder = data_get($params, 'sortOrder', 'asc');

        $query = $this->getModel()::query();

        if (in_array($sortKey, ['nome', 'data_nascimento', 'cnh'])) {
            $query->orderBy($sortKey, $sortOrder);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
