<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test - AI Chat Widget</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f4c75 100%);
            color: #e2e8f0;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 10px;
        }

        .header p {
            color: #94a3b8;
            font-size: 16px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 12px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .card h2 {
            font-size: 20px;
            color: #e2e8f0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(100, 116, 139, 0.3);
            border-radius: 8px;
            color: #e2e8f0;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: rgba(102, 126, 234, 0.6);
            background: rgba(15, 23, 42, 1);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        button {
            flex: 1;
            padding: 12px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .info-box {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 8px;
            padding: 15px;
            color: #93c5fd;
            font-size: 13px;
            line-height: 1.6;
        }

        .info-box strong {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🤖 Test - AI Chat Widget</h1>
            <p>Prueba la integración con OpenAI. El widget aparecerá en la esquina inferior derecha.</p>
        </div>

        <div class="content-grid">
            <!-- Panel Izquierdo -->
            <div class="card">
                <h2>📝 Formulario de Prueba</h2>

                <div class="form-group">
                    <label for="prompt-content">Prompt Actual (Contexto)</label>
                    <textarea id="prompt-content"
                        placeholder="Pega tu prompt aquí para que el widget lo use como contexto...">Actúa como un experto en marketing digital</textarea>
                </div>

                <div class="form-group">
                    <label for="prompt-goal">Objetivo</label>
                    <input type="text" id="prompt-goal" placeholder="Ej: Generar leads para mi tienda online">
                </div>

                <div class="form-group">
                    <label for="prompt-tone">Tono</label>
                    <input type="text" id="prompt-tone" placeholder="Ej: Profesional, amable, persuasivo">
                </div>

                <div class="button-group">
                    <button
                        onclick="alert('✓ Prueba el botón ⚡ Mejorar en el widget para enviar automáticamente el prompt')">Cargar
                        Ejemplo</button>
                </div>

                <div class="info-box" style="margin-top: 20px;">
                    <strong>💡 Instrucciones:</strong><br>
                    1. Rellena el campo "Prompt Actual" con tu prompt<br>
                    2. Abre el widget (burbuja azul abajo derecha)<br>
                    3. Usa el botón "⚡ Mejorar" para enviar automáticamente<br>
                    4. O escribe tu pregunta directamente en el chat
                </div>
            </div>

            <!-- Panel Derecho -->
            <div class="card">
                <h2>ℹ️ Información</h2>

                <div class="info-box">
                    <strong>🎯 Características del Widget:</strong><br><br>
                    ✓ Chat flotante en esquina inferior derecha<br>
                    ✓ Tema oscuro y responsivo<br>
                    ✓ Integración con OpenAI<br>
                    ✓ Contexto automático de prompts<br>
                    ✓ Rate limiter: 30 req/10min por usuario<br>
                    ✓ Historial en localStorage<br>
                    ✓ Botones de acción rápida
                </div>

                <div class="info-box" style="margin-top: 20px;">
                    <strong>🔐 Seguridad:</strong><br><br>
                    ✓ API key NUNCA se envía al frontend<br>
                    ✓ CSRF token en cada request<br>
                    ✓ Validación en backend<br>
                    ✓ Rate limiting protegido<br>
                    ✓ Auditoría en BD
                </div>

                <div class="info-box"
                    style="margin-top: 20px; background: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.3); color: #86efac;">
                    <strong style="color: #51cf66;">✅ Sistema Listo</strong><br><br>
                    Todo está configurado y funcionando.<br>
                    El widget está activo y listo para usar.
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el widget -->
    @include('components.ai-chat-widget')
</body>

</html>