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

<body> <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo"> <a href="/">PromptVault</a> </div>
            <div class="nav-links"> @if (Route::has('login')) @auth <a href="{{ route('prompts.dashboard') }}"
                        class="nav-link">Mis Prompts</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;"> @csrf <button
                            class="nav-link" style="background: none; border: none; cursor: pointer;">Cerrar sesión</button>
                </form> @else <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                        @if (Route::has('register')) <a href="{{ route('register') }}"
            class="nav-link nav-link-primary">Registrarse</a> @endif @endauth @endif
            </div>
        </div>
    </nav> <!-- Hero Section --> <!-- Hero Section (MEJORADO) -->
    <section class="hero hero--pro"> <!-- Decoración tipo “imagen” -->
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-spot hero-spot-1"></div>
            <div class="hero-spot hero-spot-2"></div>
            <div class="hero-spot hero-spot-3"></div>
            <div class="hero-grid"></div>
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content hero-content--pro"> <span class="hero-pill"> <span class="hero-dot"></span> Biblioteca
                pública • solo lectura </span>
            <h1> Descubre los <span class="hero-accent">Mejores Prompts</span> </h1>
            <p class="hero-sub"> Explora una biblioteca curada de prompts para potenciar tus IA. Inicia sesión para
                crear, versionar y compartir. </p> <!-- CTA dinámico -->
            <div class="hero-actions"> <a href="#prompts" class="hero-button hero-button--light">Explorar Prompts</a>
                @if (!Auth::check()) <a href="{{ route('login') }}" class="hero-button hero-button--ghost">Comenzar
                    Ahora</a> @if (Route::has('register')) <a href="{{ route('register') }}"
                class="hero-button hero-button--primary">Registrarse</a> @endif @else <a
                        href="{{ route('prompts.dashboard') }}" class="hero-button hero-button--ghost">Ir a Mis Prompts</a>
                    <a href="{{ route('prompts.create') }}" class="hero-button hero-button--primary">Crear Prompt</a> @endif
            </div> <!-- Chips rápidos (solo visual, puedes enlazar a filtros si quieres) -->
            <div class="hero-chips"> <span class="chip">ChatGPT</span> <span class="chip">Educación</span> <span
                    class="chip">Programación</span> <span class="chip">Creatividad</span> <span
                    class="chip">DevOps</span> </div>
            <!-- Mini stats (opcionales; si no tienes contadores reales, déjalos así) -->
            <div class="hero-stats">
                <div class="stat">
                    <div class="stat-num">{{ $prompts?->total() ?? 0 }}</div>
                    <div class="stat-label">Prompts públicos</div>
                </div>
                <div class="stat">
                    <div class="stat-num">Versionado</div>
                    <div class="stat-label">Historial de cambios</div>
                </div>
                <div class="stat">
                    <div class="stat-num">Compartir</div>
                    <div class="stat-label">Comunidad</div>
                </div>
            </div>
        </div>
    </section> <!-- Search & Filter Section -->
    <section class="search-section">
        <div class="container">
            <form method="GET" action="/" class="search-form"> <input type="text" name="q"
                    placeholder="Buscar prompts..." class="search-input" value="{{ request('q', '') }}"> <button
                    type="submit" class="search-button">Buscar</button> </form>
        </div>
    </section> <!-- Prompts Grid -->
    <section id="prompts" class="prompts-section">
        <div class="container">
            <h2>Prompts Destacados</h2> @if ($prompts && $prompts->count() > 0)
                <div class="prompts-grid"> @foreach ($prompts as $prompt) <div class="prompt-card">
                    <div class="prompt-header">
                        <div class="prompt-category">{{ $prompt->categoria->nombre ?? 'Sin categoría' }}</div>
                        <div class="prompt-ia">{{ $prompt->ia_destino }}</div>
                    </div>
                    <h3 class="prompt-title">{{ $prompt->titulo }}</h3> @if ($prompt->descripcion)
                    <p class="prompt-description">{{ Str::limit($prompt->descripcion, 100) }}</p> @endif <div
                        class="prompt-content-preview"> {{ Str::limit($prompt->contenido, 150, '...') }} </div>
                    @if ($prompt->etiquetas && $prompt->etiquetas->count() > 0)
                        <div class="prompt-tags"> @foreach ($prompt->etiquetas->take(3) as $tag) <span
                        class="tag">{{ $tag->nombre }}</span> @endforeach @if ($prompt->etiquetas->count() > 3)
                    <span class="tag-more">+{{ $prompt->etiquetas->count() - 3 }}</span> @endif </div> @endif <div
                        class="prompt-footer">
                        <div class="prompt-author">Por: {{ $prompt->user->name ?? 'Anónimo' }}</div> <a
                            href="{{ route('prompts.show', $prompt) }}" class="view-button">Ver</a>
                    </div>
                </div> @endforeach </div> <!-- Pagination --> @if ($prompts->hasPages())
            <div class="pagination"> {{ $prompts->links('pagination::simple-bootstrap-5') }} </div> @endif @else <div
                class="empty-state">
                <p>No hay prompts públicos disponibles aún.</p> @if (Auth::check()) <a
                href="{{ route('prompts.create') }}" class="primary-button">Sé el primero en crear uno</a> @else <p>
                    Regístrate para empezar a crear prompts.</p> @endif
            </div> @endif
        </div>
    </section> <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 PromptVault. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

<head> ...
    <link rel="stylesheet" href="{{ asset('css/welcome-dashboard.css') }}">
    <style>
        /* ========================= HERO PRO (portada premium) ========================= */
        .hero--pro {
            position: relative;
            padding: 96px 16px 72px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: radial-gradient(1200px 600px at 50% -10%, rgba(99, 102, 241, .22), transparent 55%), radial-gradient(900px 500px at 85% 10%, rgba(168, 85, 247, .14), transparent 55%), #070b14;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .hero-spot {
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            filter: blur(70px);
            opacity: .55;
        }

        .hero-spot-1 {
            left: 18%;
            top: -120px;
            background: rgba(99, 102, 241, .35);
        }

        .hero-spot-2 {
            right: 10%;
            top: -80px;
            background: rgba(168, 85, 247, .30);
        }

        .hero-spot-3 {
            left: -140px;
            bottom: -220px;
            background: rgba(236, 72, 153, .18);
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            opacity: .16;
            background-image: linear-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(ellipse at center, rgba(0, 0, 0, 1) 40%, rgba(0, 0, 0, 0) 75%);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(7, 11, 20, .15), rgba(7, 11, 20, .55));
        }

        .hero-content--pro {
            position: relative;
            max-width: 980px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(10, 15, 28, .55);
            border: 1px solid rgba(255, 255, 255, .10);
            color: rgba(255, 255, 255, .78);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: .2px;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: #34d399;
            box-shadow: 0 0 0 6px rgba(52, 211, 153, .12);
        }

        .hero--pro h1 {
            margin: 18px 0 10px;
            font-size: clamp(34px, 5vw, 60px);
            line-height: 1.05;
            letter-spacing: -1px;
            font-weight: 900;
            color: #fff;
        }

        .hero-accent {
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-sub {
            margin: 0 auto;
            max-width: 720px;
            font-size: 18px;
            line-height: 1.7;
            color: rgba(255, 255, 255, .72);
        }

        .hero-actions {
            margin-top: 26px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
            border: 1px solid rgba(255, 255, 255, .10);
        }

        .hero-button:hover {
            transform: translateY(-1px);
        }

        .hero-button--light {
            background: #fff;
            color: #0b1220;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
        }

        .hero-button--ghost {
            background: rgba(10, 15, 28, .45);
            color: rgba(255, 255, 255, .88);
            border-color: rgba(255, 255, 255, .14);
        }

        .hero-button--primary {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            color: #fff;
            box-shadow: 0 14px 36px rgba(99, 102, 241, .22);
            border-color: rgba(255, 255, 255, .12);
        }

        .hero-chips {
            margin-top: 18px;
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .chip {
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(10, 15, 28, .45);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .72);
            font-weight: 700;
            font-size: 12px;
        }

        .hero-stats {
            margin: 26px auto 0;
            max-width: 760px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .stat {
            padding: 14px 12px;
            border-radius: 18px;
            background: rgba(10, 15, 28, .45);
            border: 1px solid rgba(255, 255, 255, .10);
        }

        .stat-num {
            font-weight: 900;
            color: #fff;
            font-size: 18px;
        }

        .stat-label {
            margin-top: 4px;
            font-size: 12px;
            color: rgba(255, 255, 255, .60);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        @media (max-width: 720px) {
            .hero-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>