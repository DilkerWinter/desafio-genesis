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
        return $this->getModel()::findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->getModel()::create($data);
    }

    public function update($id, array $data)
    {
        $veiculo = $this->getModel()::findOrFail($id);
        $veiculo->update($data);
        return $veiculo;
    }

    public function delete($id)
    {
        $veiculo = $this->getModel()::findOrFail($id);
        return $veiculo->delete();
    }
}
