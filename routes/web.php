<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PromptController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\CompartidoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\PromptUsoController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard (evita 404 cuando Breeze no lo registró o lo reemplazaste)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('prompts', PromptController::class);

    // Versiones
    Route::get('/prompts/{prompt}/versiones', [VersionController::class, 'index'])
        ->name('prompts.versiones.index');

    Route::get('/prompts/{prompt}/versiones/{version}', [VersionController::class, 'show'])
        ->name('prompts.versiones.show');

    // Compartidos
    Route::get('/prompts/{prompt}/compartidos', [CompartidoController::class, 'index'])
        ->name('prompts.compartidos.index');

    Route::get('/prompts/{prompt}/compartidos/create', [CompartidoController::class, 'create'])
        ->name('prompts.compartidos.create');

    Route::post('/prompts/{prompt}/compartidos', [CompartidoController::class, 'store'])
        ->name('prompts.compartidos.store');

    Route::delete('/prompts/{prompt}/compartidos/{compartido}', [CompartidoController::class, 'destroy'])
        ->name('prompts.compartidos.destroy');

    // Usar prompt (auditoría + incremento)
    Route::post('/prompts/{prompt}/usar', [PromptUsoController::class, 'store'])
        ->name('prompts.usar');

    // Actividades
    Route::get('/actividades', [ActividadController::class, 'index'])
        ->name('actividades.index');

    // CRUD apoyo
    Route::resource('categorias', CategoriaController::class)->except(['show']);
    Route::resource('etiquetas', EtiquetaController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';