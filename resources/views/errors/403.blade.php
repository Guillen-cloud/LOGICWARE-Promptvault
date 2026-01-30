<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado - PromptVault</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .error-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 16px;
            padding: 60px 40px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .error-icon {
            font-size: 80px;
            margin-bottom: 30px;
            display: block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .error-code {
            font-size: 14px;
            font-weight: 700;
            color: #ef4444;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .error-title {
            font-size: 32px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .error-description {
            font-size: 16px;
            color: #cbd5e1;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-details {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 40px;
            text-align: left;
        }

        .details-title {
            font-size: 13px;
            font-weight: 600;
            color: #ff6b6b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .details-text {
            font-size: 14px;
            color: #fca5a5;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-direction: column;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: rgba(100, 116, 139, 0.15);
            border: 1.5px solid rgba(100, 116, 139, 0.4);
            color: #e0e7ff;
        }

        .btn-secondary:hover {
            border-color: rgba(100, 116, 139, 0.6);
            background: rgba(100, 116, 139, 0.25);
            color: #f1f5f9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(100, 116, 139, 0.2);
        }

        .footer-text {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(100, 116, 139, 0.2);
            font-size: 13px;
            color: #94a3b8;
        }

        .footer-text a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-text a:hover {
            color: #93c5fd;
        }

        @media (max-width: 600px) {
            .error-card {
                padding: 40px 25px;
            }

            .error-icon {
                font-size: 60px;
                margin-bottom: 20px;
            }

            .error-title {
                font-size: 26px;
            }

            .error-description {
                font-size: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                padding: 12px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-card">
            <span class="error-icon">🔒</span>

            <div class="error-code">Error 403</div>
            <h1 class="error-title">Acceso Denegado</h1>
            <p class="error-description">
                No tienes permiso para acceder a este recurso. Esta acción está restringida solo para el propietario.
            </p>

            <div class="error-details">
                <div class="details-title">ℹ️ Información</div>
                <div class="details-text">
                    ✓ Solo el propietario del prompt puede ver el historial de versiones y los compartidos.
                    <br><br>
                    ✓ Si crees que esto es un error, contacta con el administrador.
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('prompts.dashboard') }}" class="btn btn-primary">← Volver al Dashboard</a>
                <a href="/" class="btn btn-secondary">🏠 Ir al Inicio</a>
            </div>

            <div class="footer-text">
                ¿Necesitas ayuda? <a href="/">Contacta con soporte</a>
            </div>
        </div>
    </div>
</body>

</html>