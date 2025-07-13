<?php

namespace App\Http\Controllers;

use App\Services\ViagemService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViagemController extends Controller
{
    protected $viagemService;

    public function __construct(ViagemService $viagemService)
    {
        $this->viagemService = $viagemService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $viagens = $this->viagemService->dataTable($request->all());

        return Inertia::render('Viagens/Index', [
            'viagens' => $viagens,
            'filters' => $request->only(['search', 'sortKey', 'sortOrder', 'perPage', 'page']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Viagens/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->viagemService->store($request->all());

        return redirect()->route('viagens.index')->with('success', 'Viagem criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $viagem = $this->viagemService->show($id);
        return Inertia::render('Viagens/Show', ['viagem' => $viagem]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $viagem = $this->viagemService->show($id);
        return Inertia::render('Viagens/Edit', ['viagem' => $viagem]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->viagemService->update($id, $request->all());

        return redirect()->route('viagens.show', $id)
            ->with('success', 'Viagem atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->viagemService->destroy($id);

        return redirect()->route('viagens.index')
            ->with('success', 'Viagem excluído com sucesso!');
    }
}
