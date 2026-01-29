<?php

/**
 * SCRIPT DE DIAGNOSIS - OpenAI Integration
 * 
 * Ejecuta este script en la terminal para diagnosticar problemas:
 * php artisan tinker < storage/diagnostics.php
 */

echo "\n=== DIAGNOSTICO DE OPENAI INTEGRATION ===\n\n";

// 1. Verificar Configuración
echo "1️⃣  CONFIGURACIÓN\n";
echo "   - OPENAI_API_KEY: " . (config('services.openai.key') ? '✓ Configurada' : '✗ FALTA') . "\n";
echo "   - OPENAI_MODEL: " . (config('services.openai.model') ?? 'gpt-4o-mini') . "\n";
echo "   - DB Connection: " . config('database.default') . "\n\n";

// 2. Verificar Archivos
echo "2️⃣  ARCHIVOS REQUERIDOS\n";
$files = [
    'app/Services/AiChatService.php',
    'app/Http/Controllers/AiChatController.php',
    'app/Models/AiInteraction.php',
    'resources/views/components/ai-chat-widget.blade.php',
];

foreach ($files as $file) {
    $exists = file_exists(base_path($file));
    echo "   - $file: " . ($exists ? '✓' : '✗ FALTA') . "\n";
}
echo "\n";

// 3. Verificar Base de Datos
echo "3️⃣  BASE DE DATOS\n";
try {
    $tableExists = \Illuminate\Support\Facades\Schema::hasTable('ai_interactions');
    echo "   - Tabla ai_interactions: " . ($tableExists ? '✓ Existe' : '✗ NO EXISTE') . "\n";

    if ($tableExists) {
        $count = DB::table('ai_interactions')->count();
        echo "   - Registros: $count\n";
    }
} catch (Exception $e) {
    echo "   - Error al conectar: " . $e->getMessage() . "\n";
}
echo "\n";

// 4. Verificar Modelo
echo "4️⃣  MODELO\n";
try {
    $model = new \App\Models\AiInteraction();
    echo "   - AiInteraction::class: ✓ Cargado\n";
    echo "   - Tabla: " . $model->getTable() . "\n";
    echo "   - Fillable: " . implode(', ', $model->getFillable()) . "\n";
} catch (Exception $e) {
    echo "   - Error: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Verificar Rutas
echo "5️⃣  RUTAS\n";
try {
    $routes = [
        'ai.chat.send' => 'POST /ai/chat',
        'ai.test' => 'GET /ai/test',
        'ai.debug' => 'GET /ai/debug',
    ];

    foreach ($routes as $name => $display) {
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName($name);
        echo "   - $display: " . ($route ? '✓' : '✗ FALTA') . "\n";
    }
} catch (Exception $e) {
    echo "   - Error: " . $e->getMessage() . "\n";
}
echo "\n";

// 6. Test de OpenAI Connection
echo "6️⃣  CONEXIÓN OPENAI\n";
try {
    $service = new \App\Services\AiChatService();
    echo "   - AiChatService: ✓ Instanciado\n";
    echo "   - API Key: " . (strlen(config('services.openai.key')) > 10 ? '✓ Válida' : '✗ Inválida') . "\n";
    echo "   - Model: " . config('services.openai.model') . "\n";
} catch (Exception $e) {
    echo "   - Error: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== FIN DIAGNOSTICO ===\n\n";

// Instrucciones
echo "PROXIMOS PASOS:\n";
echo "1. Si falta ai_interactions table:\n";
echo "   → Ejecuta el SQL en PhpMyAdmin desde: database/migrations/ai_interactions.sql\n";
echo "2. Si falta OPENAI_API_KEY:\n";
echo "   → Agrega en .env: OPENAI_API_KEY=sk-...\n";
echo "3. Si ves ✗ en rutas:\n";
echo "   → Verifica que routes/web.php tenga las rutas\n";
echo "4. Para probar el sistema:\n";
echo "   → Ve a: http://localhost:8000/ai/debug\n";
echo "\n";
?>