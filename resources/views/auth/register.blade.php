<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - PromptVault</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f4c75 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 480px;
        }

        .register-card {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 16px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-logo {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .register-header h1 {
            color: #e2e8f0;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-header p {
            color: #94a3b8;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1.5px solid rgba(100, 116, 139, 0.3);
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(102, 126, 234, 0.6);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
        }

        input::placeholder {
            color: #64748b;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        .register-button {
            width: 100%;
            padding: 13px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-top: 10px;
        }

        .register-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .register-button:active {
            transform: translateY(-1px);
        }

        .login-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid rgba(100, 116, 139, 0.2);
        }

        .login-section p {
            color: #94a3b8;
            font-size: 14px;
        }

        .login-section a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-section a:hover {
            color: #93c5fd;
            text-decoration: underline;
        }

        .error-box {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
        }

        .error-box ul {
            list-style: none;
        }

        .error-box li {
            color: #ff6b6b;
            font-size: 13px;
            margin: 4px 0;
        }

        @media (max-width: 600px) {
            .register-card {
                padding: 40px 25px;
            }

            .register-header h1 {
                font-size: 28px;
            }

            .register-logo {
                font-size: 40px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 12px 14px;
                font-size: 16px;
            }

            .register-button {
                padding: 12px 14px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="register-card">
            <div class="register-header">
                <span class="register-logo">🔐</span>
                <h1>Crear Cuenta</h1>
                <p>Únete a PromptVault hoy</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" id="name" name="name" placeholder="Tu nombre y apellido"
                        value="{{ old('name') }}" required autofocus autocomplete="name" />
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="tu@correo.com" value="{{ old('email') }}"
                        required autocomplete="username" />
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required
                        autocomplete="new-password" />
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Repite tu contraseña" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="register-button">Registrarse</button>
            </form>

            <div class="login-section">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</body>

</html>