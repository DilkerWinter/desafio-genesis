<?php

namespace App\Http\Controllers;

use App\Services\VeiculoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VeiculoController extends Controller
{
    protected $veiculoService;

    public function __construct(VeiculoService $veiculoService)
    {
        $this->veiculoService = $veiculoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $veiculos = $this->veiculoService->dataTable($request->all());

        return Inertia::render('Veiculos/Index', [
            'veiculos' => $veiculos,
            'filters' => $request->only(['search', 'sortKey', 'sortOrder', 'perPage', 'page']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Veiculos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->veiculoService->store($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $veiculo = $this->veiculoService->show($id);
        return Inertia::render('Veiculos/Show', ['veiculo' => $veiculo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $veiculo = $this->veiculoService->show($id);
        return Inertia::render('Veiculos/Edit', ['veiculo' => $veiculo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->veiculoService->update($id, $request->all());

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->veiculoService->destroy($id);

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo excluído com sucesso!');
    }
}
