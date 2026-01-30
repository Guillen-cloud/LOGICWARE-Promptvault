<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PromptVault - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/welcome-dashboard.css') }}">

    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Fix Chatbot */
        #ai-chat-widget * {
            white-space: pre-wrap;
        }

        /* =========================
        HERO PRO
        ========================= */
        .hero--pro {
            position: relative;
            padding: 96px 16px 72px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: radial-gradient(1200px 600px at 50% -10%, rgba(99, 102, 241, .22), transparent 55%),
                radial-gradient(900px 500px at 85% 10%, rgba(168, 85, 247, .14), transparent 55%),
                #070b14;
        }

        .hero-content--pro {
            position: relative;
            max-width: 980px;
            margin: 0 auto;
            text-align: center;
        }

        .hero--pro h1 {
            margin: 18px 0 10px;
            font-size: clamp(34px, 5vw, 60px);
            line-height: 1.05;
            font-weight: 900;
            color: #fff;
        }

        .hero-accent {
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero-sub {
            margin: 0 auto;
            max-width: 720px;
            font-size: 18px;
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
            padding: 12px 18px;
            border-radius: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.2s;
        }

        .hero-button--light {
            background: #fff;
            color: #0b1220;
        }

        .hero-button--ghost {
            background: rgba(10, 15, 28, .45);
            color: white;
        }

        .hero-button--primary {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            color: white;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="/">PromptVault</a>
            </div>
            <div class="nav-links">
                @auth
                    <a href="{{ route('prompts.dashboard') }}" class="nav-link">Mis Prompts</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nav-link">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="nav-link nav-link-primary">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero hero--pro">
        <div class="hero-content hero-content--pro">

            <h1>
                Descubre los <span class="hero-accent">Mejores Prompts</span>
            </h1>

            <p class="hero-sub">
                Explora una biblioteca curada de prompts para potenciar tus IA.
            </p>

            <div class="hero-actions">
                <!-- ESTE BOTÓN YA FUNCIONA -->
                <a href="#prompts" class="hero-button hero-button--light">Explorar Prompts</a>

                @guest
                    <a href="{{ route('login') }}" class="hero-button hero-button--ghost">Comenzar</a>
                    <a href="{{ route('register') }}" class="hero-button hero-button--primary">Registrarse</a>
                @else
                    <a href="{{ route('prompts.dashboard') }}" class="hero-button hero-button--ghost">Mis Prompts</a>
                @endguest
            </div>
        </div>
    </section>

    <!-- SEARCH -->
    <section class="search-section">
        <div class="container">
            <form method="GET" action="/" class="search-form">
                <input type="text" name="q" placeholder="Buscar prompts..." class="search-input"
                    value="{{ request('q', '') }}">
                <button type="submit" class="search-button">Buscar</button>
            </form>
        </div>
    </section>

    <!-- PROMPTS DESTACADOS -->
    <!-- IMPORTANTE: ESTE ID HACE FUNCIONAR EL BOTÓN -->
    <section id="prompts" class="prompts-section">
        <div class="container">
            <h2>Prompts Destacados</h2>

            @if ($prompts && $prompts->count() > 0)
                <div class="prompts-grid">
                    @foreach ($prompts as $prompt)
                        <div class="prompt-card">
                            <h3>{{ $prompt->titulo }}</h3>
                            <p>{{ Str::limit($prompt->descripcion, 100) }}</p>
                            <a href="{{ route('prompts.show', $prompt) }}">Ver</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No hay prompts aún.</p>
            @endif
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2026 PromptVault</p>
    </footer>

</body>

</html>



<head>
    ...
    <link rel="stylesheet" href="{{ asset('css/welcome-dashboard.css') }}">

    <style>
        /* =========================
HERO PRO (portada premium)
========================= */
        .hero--pro {
            position: relative;
            padding: 96px 16px 72px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: radial-gradient(1200px 600px at 50% -10%, rgba(99, 102, 241, .22), transparent 55%),
                radial-gradient(900px 500px at 85% 10%, rgba(168, 85, 247, .14), transparent 55%),
                #070b14;
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
            background-image:
                linear-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
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