<?php

namespace App\Repositories;

use App\Models\Viagem;

class ViagemRepository
{
    public function getModel()
    {
        return Viagem::class;
    }

    public function all()
    {
        return $this->getModel()::get();
    }

    public function find($id)
    {
        return $this->getModel()::findOrFail($id);
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
        $sortKey = data_get($params, 'sortKey', 'data_hora_inicial');
        $sortOrder = data_get($params, 'sortOrder', 'asc');

        $query = $this->getModel()::query();

        if (in_array($sortKey, ['id', 'data_hora_inicial'])) {
            $query->orderBy($sortKey, $sortOrder);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
