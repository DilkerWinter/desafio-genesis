<?php

use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ViagemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ViagemController::class, 'index'])->name('home');


//Receber json de todos os Veiculos/Motoristas
Route::get('/motoristas/list', [MotoristaController::class, 'list'])->name('motoristas.list');
Route::get('/veiculos/list', [VeiculoController::class, 'list'])->name('veiculos.list');

//Cria todas as Rotas dos Controllers Ex: Index, Show, Create, Store, Edit, Update e Destroy
Route::resource('veiculos', VeiculoController::class);
Route::resource('motoristas', MotoristaController::class);
Route::resource('viagens', ViagemController::class);

