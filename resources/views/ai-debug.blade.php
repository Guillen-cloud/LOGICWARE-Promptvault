<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Debug - Sistema de IA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #0f172a;
            color: #e2e8f0;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .section {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.3);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1,
        h2 {
            color: #f1f5f9;
            margin-bottom: 15px;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin: 0 5px 0 0;
        }

        .status.ok {
            background: #10b981;
            color: white;
        }

        .status.error {
            background: #ef4444;
            color: white;
        }

        .status.warning {
            background: #f59e0b;
            color: white;
        }

        .log {
            background: #1e293b;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
            overflow-x: auto;
        }

        .log pre {
            font-size: 12px;
        }

        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            font-family: inherit;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .test-result {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .test-result.pass {
            background: rgba(16, 185, 129, 0.1);
            border-left: 3px solid #10b981;
        }

        .test-result.fail {
            background: rgba(239, 68, 68, 0.1);
            border-left: 3px solid #ef4444;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🔧 Debug - Sistema de IA Chat</h1>

        <div class="section">
            <h2>📋 Checklist de Configuración</h2>
            <div id="checklist"></div>
        </div>

        <div class="section">
            <h2>🧪 Pruebas de Conectividad</h2>
            <button onclick="testConnectivity()">Ejecutar Pruebas</button>
            <div id="test-results"></div>
        </div>

        <div class="section">
            <h2>📊 Estado de la Aplicación</h2>
            <div id="app-status"></div>
        </div>

        <div class="section">
            <h2>🛠️ Acciones</h2>
            <button onclick="clearLocalStorage()">Limpiar LocalStorage</button>
            <button onclick="testOpenAI()">Test OpenAI API</button>
            <button onclick="loadDashboard()">Ir a Dashboard</button>
        </div>
    </div>

    <script>
        // Generar checklist
        function generateChecklist() {
            const checks = [
                { name: 'Base de datos (ai_interactions table)', check: 'Verifica en phpMyAdmin' },
                { name: 'OPENAI_API_KEY en .env', check: 'Debe estar configurada' },
                { name: 'OPENAI_MODEL en .env', check: 'Debe ser gpt-4o-mini o superior' },
                { name: 'Widget en layouts/app.blade.php', check: 'Debe estar incluido' },
                { name: 'Rutas POST /ai/chat configuradas', check: 'Ver routes/web.php' },
                { name: 'Rate limiter en RouteServiceProvider', check: '30 req/10 min' },
                { name: 'AiChatController creado', check: 'Debe validar y enviar' },
                { name: 'AiChatService creado', check: 'Debe conectar con OpenAI' },
            ];

            const html = checks.map(c => `
                <div style="margin-bottom: 10px; padding: 10px; background: rgba(51, 65, 85, 0.3); border-radius: 4px;">
                    <strong>✓ ${c.name}</strong><br>
                    <small style="color: #94a3b8;">${c.check}</small>
                </div>
            `).join('');

            document.getElementById('checklist').innerHTML = html;
        }

        // Pruebas de conectividad
        async function testConnectivity() {
            const resultsDiv = document.getElementById('test-results');
            resultsDiv.innerHTML = '<p>Ejecutando pruebas...</p>';

            const tests = [];

            // Test 1: CSRF Token
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            tests.push({
                name: 'CSRF Token presente',
                pass: !!csrfMeta,
                msg: csrfMeta ? 'Token detectado' : 'Token NO DETECTADO'
            });

            // Test 2: Rutas accesibles
            try {
                const response = await fetch('{{ route("ai.chat.send") }}', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });
                tests.push({
                    name: 'Ruta /ai/chat accesible',
                    pass: response.status !== 404,
                    msg: `Status: ${response.status}`
                });
            } catch (e) {
                tests.push({
                    name: 'Ruta /ai/chat accesible',
                    pass: false,
                    msg: e.message
                });
            }

            // Test 3: LocalStorage
            try {
                localStorage.setItem('test', 'ok');
                const val = localStorage.getItem('test');
                localStorage.removeItem('test');
                tests.push({
                    name: 'LocalStorage funcionando',
                    pass: val === 'ok',
                    msg: 'LocalStorage OK'
                });
            } catch (e) {
                tests.push({
                    name: 'LocalStorage funcionando',
                    pass: false,
                    msg: e.message
                });
            }

            // Mostrar resultados
            resultsDiv.innerHTML = tests.map(t => `
                <div class="test-result ${t.pass ? 'pass' : 'fail'}">
                    <strong>${t.pass ? '✓' : '✗'} ${t.name}</strong><br>
                    <small>${t.msg}</small>
                </div>
            `).join('');
        }

        // Test OpenAI
        async function testOpenAI() {
            const resultsDiv = document.getElementById('test-results');
            resultsDiv.innerHTML = '<p>Conectando con OpenAI...</p>';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await fetch('{{ route("ai.chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: 'Hola, ¿funcionas correctamente?',
                        context: null
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    resultsDiv.innerHTML = `
                        <div class="test-result pass">
                            <strong>✓ OpenAI Conectado</strong><br>
                            <div class="log"><pre>${JSON.stringify(data, null, 2)}</pre></div>
                        </div>
                    `;
                } else {
                    resultsDiv.innerHTML = `
                        <div class="test-result fail">
                            <strong>✗ Error: ${data.error || 'Error desconocido'}</strong><br>
                            <div class="log"><pre>${JSON.stringify(data, null, 2)}</pre></div>
                        </div>
                    `;
                }
            } catch (e) {
                resultsDiv.innerHTML = `
                    <div class="test-result fail">
                        <strong>✗ Error de conexión</strong><br>
                        <div class="log"><pre>${e.message}</pre></div>
                    </div>
                `;
            }
        }

        // Limpiar LocalStorage
        function clearLocalStorage() {
            localStorage.clear();
            alert('✓ LocalStorage limpiado');
        }

        // Ir a dashboard
        function loadDashboard() {
            window.location.href = '{{ route("prompts.dashboard") }}';
        }

        // Inicializar
        generateChecklist();
    </script>
</body>

</html>