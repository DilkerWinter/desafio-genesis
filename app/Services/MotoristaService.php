<?php

namespace App\Services;

use App\Repositories\MotoristaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MotoristaService
{
    protected $repository;

    public function __construct(MotoristaRepository $repository)
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
            'cnh' => ['required', 'digits:11', 'unique:motoristas,cnh'. $id] 
        ]);

        $validator->validate();

        $data['data_nascimento'] = Carbon::parse($data['data_nascimento'])->format('Y-m-d');

        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
