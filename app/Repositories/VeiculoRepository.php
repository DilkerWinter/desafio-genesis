<?php

namespace App\Repositories;

use App\Models\Veiculo;
use App\Repositories\Interfaces\VeiculoRepositoryInterface;

class VeiculoRepository implements VeiculoRepositoryInterface
{
    public function all()
    {
        return Veiculo::all();
    }

    public function find($id)
    {
        return Veiculo::findOrFail($id);
    }

    public function create(array $data)
    {
        return Veiculo::create($data);
    }

    public function update($id, array $data)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->update($data);
        return $veiculo;
    }

    public function delete($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return $veiculo->delete();
    }
}
