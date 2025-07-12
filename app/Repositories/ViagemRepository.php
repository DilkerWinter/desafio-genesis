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
        return $this->getModel()::with(['motorista', 'veiculo'])->get();
    }

    public function find($id)
    {
        return $this->getModel()::with(['motorista', 'veiculo'])->findOrFail($id);
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
