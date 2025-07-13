<?php

namespace App\Http\Controllers;

use App\Services\MotoristaService;
use App\Services\VeiculoService;
use App\Services\ViagemService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViagemController extends Controller
{
    protected $viagemService;
    protected $motoristaService;
    protected $veiculoService;

    public function __construct(ViagemService $viagemService, MotoristaService $motoristaService, VeiculoService $veiculoService)
    {
        $this->viagemService = $viagemService;
        $this->motoristaService = $motoristaService;
        $this->veiculoService = $veiculoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Sei que nao e tao performatico, ate daria pra adicionar um Redis 
        //com cache caso tenha uma quantidade enorme de Motoristas/Veiculos
        //mas partindo do principio que Motoristas seriam funcinarios da empresa
        //e veiculos a frota (empresas de medio pequeno porte) nao teria tanto problema em performace (eu acho)

        $viagens = $this->viagemService->index($request->all());

        //Buscando para adicionar no cadastro de viagem as opcoes de motoristas e veiculos
        $motoristas = $this->motoristaService->getAllMotoristas();
        $veiculos = $this->veiculoService->getAllVeiculos();

        return Inertia::render('Viagens/Index', [
            'viagens' => $viagens,
            'veiculos' => $veiculos,
            'motoristas' => $motoristas,
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
        $motoristas = $this->motoristaService->getAllMotoristas();
        $veiculos = $this->veiculoService->getAllVeiculos();

        return Inertia::render('Viagens/Show', [
            'viagem' => $viagem,
            'motoristas' => $motoristas,
            'veiculos' => $veiculos,
        ]);
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
