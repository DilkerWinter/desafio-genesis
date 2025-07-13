<?php

namespace App\Http\Controllers;

use App\Services\MotoristaService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MotoristaController extends Controller
{
    protected $motoristaService;

    public function __construct(MotoristaService $motoristaService)
    {
        $this->motoristaService = $motoristaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $motoristas = $this->motoristaService->index($request->all());

        return Inertia::render('Motoristas/Index', [
            'motoristas' => $motoristas,
            'filters' => $request->only(['sortKey', 'sortOrder', 'perPage', 'page']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Motoristas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->motoristaService->store($request->all());

        return redirect()->route('motoristas.index')->with('success', 'Motorista criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motorista = $this->motoristaService->show($id);
        return Inertia::render('Motoristas/Show', ['motorista' => $motorista]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $motorista = $this->motoristaService->show($id);
        return Inertia::render('Motoristas/Edit', ['motorista' => $motorista]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->motoristaService->update($id, $request->all());

        return redirect()->route('motoristas.index')
            ->with('success', 'Motorista atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->motoristaService->destroy($id);

        return redirect()->route('motoristas.index')
            ->with('success', 'Motorista excluído com sucesso!');
    }

}
