<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'PromptVault') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg0: #070b14;
            --bg1: #0a1222;
            --panel: #0c1528;
            --panel2: #0a1325;
            --stroke: rgba(255, 255, 255, .10);
            --stroke2: rgba(255, 255, 255, .08);
            --text: #ffffff;
            --muted: rgba(255, 255, 255, .65);
            --muted2: rgba(255, 255, 255, .45);
            --shadow: 0 22px 70px rgba(0, 0, 0, .55);
            --shadow2: 0 14px 40px rgba(0, 0, 0, .35);
            --r: 18px;
            --r2: 22px;

            --ac1: #6366f1;
            /* indigo */
            --ac2: #a855f7;
            /* purple */
            --ac3: #22c55e;
            /* green */
            --ac4: #06b6d4;
            /* cyan */
            --danger: #ef4444;

            --sidebar: 280px;
            --topbar: 72px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
            color: var(--text);
            background:
                radial-gradient(1200px 600px at 35% -10%, rgba(168, 85, 247, .35), transparent 55%),
                radial-gradient(900px 520px at 90% 10%, rgba(99, 102, 241, .22), transparent 55%),
                linear-gradient(180deg, var(--bg0), var(--bg1));
        }

        /* Layout */
        .admin-shell {
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 18px 14px;
            background: rgba(7, 11, 20, .78);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-right: 1px solid var(--stroke2);
            z-index: 50;
        }

        .brand {
            height: 54px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            border: 1px solid var(--stroke2);
            background: rgba(255, 255, 255, .04);
            box-shadow: 0 12px 36px rgba(0, 0, 0, .30);
            text-decoration: none;
            color: var(--text);
        }

        .brand-badge {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(99, 102, 241, .22), rgba(168, 85, 247, .20));
            border: 1px solid var(--stroke);
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: -.2px;
            line-height: 1.05;
        }

        .brand-sub {
            display: block;
            margin-top: 2px;
            font-size: 12px;
            color: var(--muted);
            font-weight: 800;
            letter-spacing: .3px;
        }

        .nav {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            text-decoration: none;
            color: rgba(255, 255, 255, .82);
            font-weight: 900;
            font-size: 13px;
            border: 1px solid transparent;
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
            user-select: none;
        }

        .nav-link:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .06);
            border-color: rgba(255, 255, 255, .10);
        }

        .nav-link.active {
            background: rgba(99, 102, 241, .16);
            border-color: rgba(99, 102, 241, .30);
            color: rgba(255, 255, 255, .95);
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            opacity: .9;
        }

        .nav-muted {
            color: rgba(255, 255, 255, .60);
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .7px;
            padding: 8px 12px 2px;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(239, 68, 68, .25);
            background: rgba(239, 68, 68, .10);
            color: rgba(255, 255, 255, .92);
            font-weight: 900;
            cursor: pointer;
            transition: transform .15s ease, background .15s ease;
        }

        .logout-btn:hover {
            transform: translateY(-1px);
            background: rgba(239, 68, 68, .14);
        }

        /* Content */
        .content {
            margin-left: var(--sidebar);
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: var(--topbar);
            position: sticky;
            top: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
            background: rgba(7, 11, 20, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .9);
            border-radius: 14px;
            padding: 10px 12px;
            cursor: pointer;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, .08);
        }

        .page-title {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
            color: rgba(255, 255, 255, .92);
            letter-spacing: .2px;
        }

        .page-sub {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--muted);
            font-weight: 700;
        }

        .userbox {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .04);
        }

        .userbox .name {
            font-weight: 900;
            font-size: 13px;
        }

        .userbox .email {
            display: block;
            font-weight: 700;
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
            text-align: right;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .12);
            object-fit: cover;
        }

        .main {
            padding: 18px;
        }

        /* Cards / Panels */
        .panel {
            background: linear-gradient(180deg, rgba(12, 21, 40, .88), rgba(8, 14, 28, .72));
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 22px;
            box-shadow: var(--shadow);
        }

        .panel-pad {
            padding: 18px;
        }

        @media (min-width: 720px) {
            .panel-pad {
                padding: 22px;
            }
        }

        /* Responsive */
        @media (max-width: 980px) {
            .sidebar {
                transform: translateX(-102%);
                transition: transform .22s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .menu-toggle {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a class="brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-badge" aria-hidden="true">
                    <!-- mini icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"
                        style="color: rgba(255,255,255,.92)">
                        <path d="M12 2l9 4.9v10.2L12 22 3 17.1V6.9L12 2zm0 2.3L5 7v10l7 3.7 7-3.7V7l-7-2.7z" />
                    </svg>
                </span>
                <span>
                    <span class="brand-title">PromptVault</span>
                    <span class="brand-sub">Admin Panel</span>
                </span>
            </a>

            <div class="nav">
                <div class="nav-muted">Principal</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.prompts.index') }}"
                    class="nav-link {{ request()->routeIs('admin.prompts.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Prompts
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Usuarios
                </a>

                <div class="nav-section">
                    <div class="nav-muted">Acciones</div>

                    <a href="{{ route('prompts.dashboard') }}" class="nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a la App
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <header class="topbar">
                <div class="top-left">
                    <button class="menu-toggle" id="menu-toggle" type="button">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Menú
                    </button>

                    <div>
                        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                        <p class="page-sub">Administra PromptVault con un panel moderno.</p>
                    </div>
                </div>

                <div class="userbox">
                    <div style="text-align:right;">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <span class="email">{{ Auth::user()->email }}</span>
                    </div>
                    <img class="avatar"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=ffffff&background=4f46e5"
                        alt="Avatar">
                </div>
            </header>

            <main class="main">
                @if (session('status'))
                    <div class="panel panel-pad"
                        style="border-color: rgba(34,197,94,.25); background: rgba(34,197,94,.10); box-shadow: var(--shadow2); margin-bottom:14px;">
                        <div style="font-weight:900; color: rgba(255,255,255,.92);">Éxito</div>
                        <div style="margin-top:6px; color: rgba(255,255,255,.82); font-weight:700; font-size:13px;">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            if (!btn || !sidebar) return;
            btn.addEventListener('click', function () {
                sidebar.classList.toggle('open');
            });
        })();
    </script>
</body>

</html>