<?php

namespace App\Services;

use App\Repositories\MotoristaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MotoristaService
{
    protected $repository;

    public function __construct(MotoristaRepository $repository)
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
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'cnh' => ['required', 'digits:11', 'unique:motoristas,cnh'],
        ]);

        $validator->validate();

        $data['data_nascimento'] = Carbon::parse($data['data_nascimento'])->format('Y-m-d');

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'cnh' => ['required', 'digits:11', Rule::unique('motoristas', 'cnh')->ignore($id)],
        ]);

        $validator->validate();

        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function getAllMotoristas()
    {
        return $this->repository->all();
    }
}
