<?php

use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ViagemController;
use App\Models\Veiculo;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Receber json de todos os Veiculos/Motoristas
Route::get('/motoristas/list', [MotoristaController::class, 'list'])->name('motoristas.list');
Route::get('/veiculos/list', [VeiculoController::class, 'list'])->name('veiculos.list');

//Cria todas as Rotas dos Controllers Ex: Index, Show, Create, Store, Edit, Update e Destroy
Route::resource('veiculos', VeiculoController::class);
Route::resource('motoristas', MotoristaController::class);
Route::resource('viagens', ViagemController::class);


require __DIR__.'/auth.php';
