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
    public function index()
    {
        $veiculos = $this->veiculoService->index();

        return Inertia::render('Veiculos/Index', [
            'veiculos' => $veiculos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
