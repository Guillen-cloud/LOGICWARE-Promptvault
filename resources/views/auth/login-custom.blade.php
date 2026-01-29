<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PromptVault</title>
    <link rel="stylesheet" href="{{ asset('css/login-custom.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Logo -->
            <div class="login-logo">
                <h1>PromptVault</h1>
                <p>Tu gestor de prompts personalizado</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                @csrf

                <!-- Session Status -->
                @if ($errors->any())
                    <div class="alert alert-error">
                        <span class="alert-icon">⚠</span>
                        <div class="alert-content">
                            <p><strong>Error de validación</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        <span class="alert-icon">✓</span>
                        <div class="alert-content">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <span class="label-text">Correo Electrónico</span>
                        <span class="label-icon">✉</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-input @error('email') error @enderror"
                        value="{{ old('email') }}" required autofocus placeholder="tu@email.com"
                        autocomplete="username">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <span class="label-text">Contraseña</span>
                        <span class="label-icon">🔒</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                            class="form-input @error('password') error @enderror" required placeholder="••••••••"
                            autocomplete="current-password">
                        <button type="button" class="password-toggle" id="togglePassword"
                            aria-label="Mostrar/ocultar contraseña">
                            👁
                        </button>
                    </div>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group checkbox">
                    <input type="checkbox" id="remember_me" name="remember" class="checkbox-input">
                    <label for="remember_me" class="checkbox-label">
                        Recuérdame en este dispositivo
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <span class="btn-text">Iniciar Sesión</span>
                    <span class="btn-icon">→</span>
                </button>

                <!-- Links -->
                <div class="form-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-forgot">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="link-register">
                            ¿No tienes cuenta? <strong>Regístrate aquí</strong>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>&copy; {{ date('Y') }} PromptVault. Todos los derechos reservados.</p>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="decoration decoration-1"></div>
        <div class="decoration decoration-2"></div>
        <div class="decoration decoration-3"></div>
    </div>

    <script src="{{ asset('js/login-custom.js') }}"></script>
</body>

</html>