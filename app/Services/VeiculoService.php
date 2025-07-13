<?php

namespace App\Services;

use App\Repositories\VeiculoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VeiculoService
{
    protected $repository;

    public function __construct(VeiculoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
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
            'modelo' => ['required', 'string', 'max:255'],
            'ano' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'data_aquisicao' => ['required', 'date'],
            'km_aquisicao' => ['required', 'integer', 'min:0'],
            'renavam' => ['required', 'string', 'size:11', 'unique:veiculos,renavam'],
            'placa' => ['required', 'string', 'regex:/^[A-Z]{3}[0-9]{1}[A-Z]{1}[0-9]{2}$/', 'max:7', 'unique:veiculos,placa'],
        ]);

        $validator->validate();

        $data['data_aquisicao'] = Carbon::parse($data['data_aquisicao'])->format('Y-m-d');

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'modelo' => ['required', 'string', 'max:255'],
            'ano' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'data_aquisicao' => ['required', 'date'],
            'km_aquisicao' => ['required', 'integer', 'min:0'],
            'renavam' => 'required|digits:11|unique:veiculos,renavam,' . $id,
            'placa' => ['required', 'string', 'regex:/^[A-Z]{3}[0-9]{1}[A-Z]{1}[0-9]{2}$/', 'max:7', 'unique:veiculos,placa,' . $id],
        ]);

        $validator->validate();

        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function getAllVeiculos()
    {
        return $this->repository->all();
    }
}
