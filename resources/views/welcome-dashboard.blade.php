<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PromptVault - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/welcome-dashboard.css') }}">
    <style>
        /* Fix para mensajes del Chatbot */
        #ai-chat-widget * {
            white-space: pre-wrap;
            /* Vital para que no salga todo corrido */
        }

        #ai-chat-widget ul {
            padding-left: 1.5rem;
            list-style-type: disc;
            margin: 0.5rem 0;
        }

        #ai-chat-widget ol {
            padding-left: 1.5rem;
            list-style-type: decimal;
            margin: 0.5rem 0;
        }

        #ai-chat-widget strong {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="/">PromptVault</a>
            </div>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('prompts.dashboard') }}" class="nav-link">Mis Prompts</a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button class="nav-link" style="background: none; border: none; cursor: pointer;">Cerrar
                                sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link nav-link-primary">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Descubre los Mejores Prompts</h1>
            <p>Explora una biblioteca curada de prompts para potenciar tus IA</p>
            @if (!Auth::check())
                <a href="{{ route('login') }}" class="hero-button">Comenzar Ahora</a>
            @else
                <a href="{{ route('prompts.create') }}" class="hero-button">Crear Prompt</a>
            @endif
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="search-section">
        <div class="container">
            <form method="GET" action="/" class="search-form">
                <input type="text" name="q" placeholder="Buscar prompts..." class="search-input"
                    value="{{ request('q', '') }}">
                <button type="submit" class="search-button">Buscar</button>
            </form>
        </div>
    </section>

    <!-- Prompts Grid -->
    <section class="prompts-section">
        <div class="container">
            <h2>Prompts Destacados</h2>

            @if ($prompts && $prompts->count() > 0)
                <div class="prompts-grid">
                    @foreach ($prompts as $prompt)
                        <div class="prompt-card">
                            <div class="prompt-header">
                                <div class="prompt-category">{{ $prompt->categoria->nombre ?? 'Sin categoría' }}</div>
                                <div class="prompt-ia">{{ $prompt->ia_destino }}</div>
                            </div>

                            <h3 class="prompt-title">{{ $prompt->titulo }}</h3>

                            @if ($prompt->descripcion)
                                <p class="prompt-description">{{ Str::limit($prompt->descripcion, 100) }}</p>
                            @endif

                            <div class="prompt-content-preview">
                                {{ Str::limit($prompt->contenido, 150, '...') }}
                            </div>

                            @if ($prompt->etiquetas && $prompt->etiquetas->count() > 0)
                                <div class="prompt-tags">
                                    @foreach ($prompt->etiquetas->take(3) as $tag)
                                        <span class="tag">{{ $tag->nombre }}</span>
                                    @endforeach
                                    @if ($prompt->etiquetas->count() > 3)
                                        <span class="tag-more">+{{ $prompt->etiquetas->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif

                            <div class="prompt-footer">
                                <div class="prompt-author">Por: {{ $prompt->user->name ?? 'Anónimo' }}</div>
                                <a href="{{ route('prompts.show', $prompt) }}" class="view-button">Ver</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($prompts->hasPages())
                    <div class="pagination">
                        {{ $prompts->links('pagination::simple-bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <p>No hay prompts públicos disponibles aún.</p>
                    @if (Auth::check())
                        <a href="{{ route('prompts.create') }}" class="primary-button">Sé el primero en crear uno</a>
                    @else
                        <p>Regístrate para empezar a crear prompts.</p>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 PromptVault. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>