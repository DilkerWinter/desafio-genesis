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
}
