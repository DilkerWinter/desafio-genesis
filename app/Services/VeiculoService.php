<?php

namespace App\Services;

use App\Repositories\VeiculoRepository;

class VeiculoService
{
    protected $repository;

    public function __construct(VeiculoRepository $repository)
    {
        $this->repository = $repository;
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
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}