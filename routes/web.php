<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PromptController;
use App\Http\Controllers\PromptDashboardController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\CompartidoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\PromptUsoController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPromptController;
use App\Http\Middleware\CheckAdmin;

Route::get('/', function () {
    $query = \App\Models\Prompt::where('es_publico', 1)
        ->with(['categoria', 'user', 'etiquetas']);

    if (request('q')) {
        $searchTerm = request('q');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('titulo', 'like', '%' . $searchTerm . '%')
                ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                ->orWhere('contenido', 'like', '%' . $searchTerm . '%');
        });
    }

    $prompts = $query->latest()->paginate(12);

    return view('welcome-dashboard', ['prompts' => $prompts]);
});

// ✅ Login Personalizado
Route::get('/login-custom', function () {
    return view('auth.login-custom');
})->name('login.custom')->middleware('guest');

// ✅ Diagnóstico
Route::get('/diagnostico', function () {
    return view('diagnostico');
})->name('diagnostico');

// ✅ Dashboard (evita 404 cuando Breeze no lo registró o lo reemplazaste)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Dashboard de Prompts - Primera pantalla después del login
    Route::get('/prompts-dashboard', [PromptDashboardController::class, 'index'])
        ->name('prompts.dashboard');

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

    // AI Chat - Con rate limiter (comentado por ahora, testear sin limiter)
    Route::post('/ai/chat', [AiChatController::class, 'send'])
        // ->middleware('throttle:ai-chat')
        ->name('ai.chat.send');

    // AI Chat Debug
    Route::post('/ai/chat-debug', function (\Illuminate\Http\Request $request) {
        try {
            return response()->json([
                'status' => 'debug',
                'mock_mode' => env('OPENAI_MOCK_MODE'),
                'debug' => config('app.debug'),
                'message' => 'Testing...'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    })->name('ai.chat.debug');

    // AI Test - Verificar configuración
    Route::get('/ai/test', function () {
        return response()->json([
            'mock_mode_env' => env('OPENAI_MOCK_MODE'),
            'api_key_exists' => !!config('services.openai.key'),
            'model' => config('services.openai.model'),
            'debug' => config('app.debug'),
            'message' => 'Config OK'
        ]);
    })->name('ai.test');

    // AI Debug (diagnóstico)
    Route::get('/ai/debug', function () {
        return view('ai-debug');
    })->name('ai.debug');
});

// --- PANEL DE ADMINISTRACIÓN ---
// Grupo de rutas protegido por el middleware de autenticación y de admin.
Route::middleware(['auth', CheckAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal del admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestión completa de Prompts
    Route::get('/prompts', [AdminPromptController::class, 'index'])->name('prompts.index');
    Route::get('/prompts/{prompt}/edit', [AdminPromptController::class, 'edit'])->name('prompts.edit');
    Route::put('/prompts/{prompt}', [AdminPromptController::class, 'update'])->name('prompts.update');
    Route::delete('/prompts/{prompt}', [AdminPromptController::class, 'destroy'])->name('prompts.destroy');

    // Aquí podrías añadir gestión de usuarios, categorías, etc.
});

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';