<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🔍 Diagnóstico - ChatBot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: #fff;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            color: #667eea;
        }

        h2 {
            color: #94a3b8;
            margin-top: 30px;
        }

        .check {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #ccc;
            font-size: 14px;
        }

        .check.ok {
            background: #1d3a1d;
            border-color: #10b981;
            color: #86efac;
        }

        .check.error {
            background: #3a1d1d;
            border-color: #ef4444;
            color: #fca5a5;
        }

        .check.warning {
            background: #3a3a1d;
            border-color: #f59e0b;
            color: #fde047;
        }

        .check.info {
            background: #1d2d3a;
            border-color: #3b82f6;
            color: #93c5fd;
        }

        code {
            background: #333;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }

        .solution {
            background: #2a2a2a;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 5px 10px 0;
        }

        button:hover {
            background: #764ba2;
        }
    </style>
</head>

<body>
    <h1>🔍 Diagnóstico Completo del ChatBot</h1>
    <p>Esta página verifica automáticamente si todo está configurado correctamente.</p>

    <div id="diagnostics"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const diagnostics = [];

            // 1. Verificar si está autenticado
            const isAuth = {{ auth()->check() ? 'true' : 'false' }};
            diagnostics.push({
                name: '1. ¿Usuario autenticado?',
                status: isAuth ? 'ok' : 'error',
                message: isAuth ? '✓ SÍ - Usuario autenticado' : '✗ NO - Debes iniciar sesión',
                details: isAuth ? '' : 'El widget solo aparece para usuarios autenticados. Ve a /login'
            });

            // 2. Verificar meta CSRF
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta?.content;
            diagnostics.push({
                name: '2. ¿Meta CSRF token?',
                status: csrfMeta && csrfToken ? 'ok' : 'error',
                message: csrfMeta && csrfToken ? `✓ Encontrado: ${csrfToken.substring(0, 20)}...` : '✗ NO encontrado',
                details: !csrfMeta ? 'Falta el meta tag en el <head>' : ''
            });

            // 3. Verificar widget HTML
            const widget = document.getElementById('ai-chat-widget');
            diagnostics.push({
                name: '3. ¿Widget HTML existe?',
                status: widget ? 'ok' : 'error',
                message: widget ? '✓ Elemento encontrado en DOM' : '✗ NO está en la página',
                details: !widget ? 'El widget no fue incluido en el layout' : ''
            });

            // 4. Verificar botón
            const button = document.getElementById('ai-chat-toggle');
            diagnostics.push({
                name: '4. ¿Botón del widget?',
                status: button ? 'ok' : 'error',
                message: button ? '✓ Botón encontrado' : '✗ Botón NO existe',
                details: !button ? 'El botón no se renderizó correctamente' : ''
            });

            // 5. Verificar visibilidad
            if (widget) {
                const computedStyle = window.getComputedStyle(widget);
                const isVisible = computedStyle.display !== 'none' && widget.offsetHeight > 0;
                const widgetDisplay = widget.style.display;

                diagnostics.push({
                    name: '5. ¿Widget visible?',
                    status: isVisible ? 'ok' : 'warning',
                    message: isVisible ? '✓ Widget visible' : `⚠ Widget oculto (display: ${widgetDisplay || 'auto'})`,
                    details: !isVisible ? 'El widget está oculto por CSS o display: none' : ''
                });
            }

            // 6. Verificar localStorage
            try {
                localStorage.setItem('test', 'ok');
                localStorage.removeItem('test');
                diagnostics.push({
                    name: '6. ¿LocalStorage?',
                    status: 'ok',
                    message: '✓ LocalStorage disponible',
                    details: ''
                });
            } catch (e) {
                diagnostics.push({
                    name: '6. ¿LocalStorage?',
                    status: 'error',
                    message: `✗ Error: ${e.message}`,
                    details: 'LocalStorage no está disponible (modo incógnito o políticas del navegador)'
                });
            }

            // 7. Verificar si el archivo está donde debe estar
            diagnostics.push({
                name: '7. ¿Archivo widget cargado?',
                status: widget ? 'ok' : 'warning',
                message: widget ? '✓ Componente ai-chat-widget-simple.blade.php está siendo incluido' : '⚠ Posible problema de inclusión',
                details: widget ? '' : 'Verifica que resources/views/components/ai-chat-widget-simple.blade.php existe'
            });

            // Renderizar diagnóstico
            renderDiagnostics(diagnostics);
        }, false);

        function renderDiagnostics(diagnostics) {
            const container = document.getElementById('diagnostics');
            let html = '';

            // Mostrar cada verificación
            diagnostics.forEach(d => {
                html += `
                    <div class="check ${d.status}">
                        <strong>${d.name}</strong><br>
                        ${d.message}
                        ${d.details ? '<br><small>📝 ' + d.details + '</small>' : ''}
                    </div>
                `;
            });

            // Resumen
            const errors = diagnostics.filter(d => d.status === 'error').length;
            const warnings = diagnostics.filter(d => d.status === 'warning').length;
            const okCount = diagnostics.filter(d => d.status === 'ok').length;

            html += '<h2>📋 Resumen General</h2>';
            html += `
                <div class="check info">
                    <strong>✓ Verificaciones correctas: ${okCount}</strong><br>
                    ${errors > 0 ? `<strong style="color: #fca5a5;">✗ Errores: ${errors}</strong><br>` : ''}
                    ${warnings > 0 ? `<strong style="color: #fde047;">⚠ Advertencias: ${warnings}</strong>` : ''}
                </div>
            `;

            if (errors === 0 && warnings === 0) {
                html += `
                    <div class="check ok">
                        <strong>✅ TODO ESTÁ BIEN</strong><br>
                        El widget debería funcionar correctamente. Si aún no lo ves:
                        <br><br>
                        <strong>1. Intenta esto:</strong><br>
                        • Presiona: <code>Ctrl+Shift+R</code> (limpia caché)<br>
                        • Si estás en otra página, ve a: <code>/dashboard</code> o <code>/prompts-dashboard</code><br>
                        • Mira la esquina INFERIOR DERECHA<br>
                        <br>
                        <strong>2. Si aún no ves el botón:</strong><br>
                        • Abre consola (F12 → Console)<br>
                        • Copia los errores que veas<br>
                        • Reinicia Laravel: <code>Ctrl+C</code> luego <code>php artisan serve</code>
                    </div>
                `;
            } else if (errors > 0) {
                html += `
                    <div class="check error">
                        <strong>❌ HAY ${errors} PROBLEMA(S) CRÍTICO(S)</strong><br>
                        Ver abajo las soluciones específicas
                    </div>
                `;

                // Mostrar soluciones para cada error
                if (!diagnostics[0].status === 'ok') {
                    html += `
                        <h2>🔧 Solución 1: Usuario no autenticado</h2>
                        <div class="solution">
                            <strong>Problema:</strong> No iniciaste sesión<br><br>
                            <strong>Solución:</strong><br>
                            1. Abre: <code>http://localhost:8000/login</code><br>
                            2. Inicia sesión con tu usuario<br>
                            3. Luego vuelve a esta página
                        </div>
                    `;
                }

                if (diagnostics[1].status === 'error') {
                    html += `
                        <h2>🔧 Solución 2: Meta CSRF token NO encontrado</h2>
                        <div class="solution">
                            <strong>Problema:</strong> El meta tag CSRF no está en el &lt;head&gt;<br><br>
                            <strong>Solución:</strong><br>
                            1. Abre: <code>resources/views/layouts/app.blade.php</code><br>
                            2. En la sección &lt;head&gt;, debe estar:<br>
                            <code>&lt;meta name="csrf-token" content="{{ csrf_token() }}"&gt;</code><br>
                            3. Si NO está, agrégala después de &lt;meta name="viewport"&gt;<br>
                            4. Reinicia Laravel: <code>Ctrl+C</code> luego <code>php artisan serve</code>
                        </div>
                    `;
                }

                if (diagnostics[2].status === 'error') {
                    html += `
                        <h2>🔧 Solución 3: Widget HTML NO existe</h2>
                        <div class="solution">
                            <strong>Problema:</strong> El widget no se incluye en la página<br><br>
                            <strong>Solución:</strong><br>
                            1. Abre: <code>resources/views/layouts/app.blade.php</code><br>
                            2. Antes de &lt;/body&gt; debe estar:<br>
                            <code>@include('components.ai-chat-widget-simple')</code><br>
                            3. Si NO está, agrégala<br>
                            4. Verifica que el archivo <code>resources/views/components/ai-chat-widget-simple.blade.php</code> existe<br>
                            5. Reinicia Laravel
                        </div>
                    `;
                }
            }

            html += `
                <h2>🔄 Acciones Rápidas</h2>
                <button onclick="location.reload()">🔄 Recargar esta página</button>
                <button onclick="location.href = '/dashboard'">📊 Ir a Dashboard</button>
                <button onclick="location.href = '/prompts-dashboard'">📝 Ir a Mis Prompts</button>
                <button onclick="clearCacheAndReload()">🗑️ Limpiar caché y recargar</button>
            `;

            container.innerHTML = html;
        }

        function clearCacheAndReload() {
            // Limpiar localStorage
            localStorage.clear();
            // Limpiar sessionStorage
            sessionStorage.clear();
            // Recargar sin caché
            window.location.href = '/diagnostico?t=' + Date.now();
        }
    </script>
</body>

</html>