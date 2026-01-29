<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Cargar .env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
$model = $_ENV['OPENAI_MODEL'] ?? 'gpt-4o-mini';

echo "🔑 API Key: " . substr($apiKey, 0, 20) . "...\n";
echo "📦 Model: $model\n";
echo "🚀 Testando OpenAI...\n\n";

try {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Responde en una sola línea.',
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Hola, ¿funciona?',
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 100,
            ]);

    echo "✅ Status: " . $response->status() . "\n";
    echo "📝 Respuesta:\n";

    $data = $response->json();

    if ($response->failed()) {
        echo "❌ Error:\n";
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if (isset($data['choices'][0]['message']['content'])) {
            echo "\n🤖 Mensaje: " . $data['choices'][0]['message']['content'] . "\n";
        }
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
