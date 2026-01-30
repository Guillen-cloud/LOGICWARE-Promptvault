<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-width: 260px;
        }

        .content-area {
            margin-left: var(--sidebar-width);
        }

        @media (max-width: 768px) {
            .content-area {
                margin-left: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside
            class="sidebar fixed top-0 left-0 h-full w-[var(--sidebar-width)] bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 z-40 md:translate-x-0">
            <div class="p-4 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 h-16">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    PromptVault<span class="text-sm font-normal text-gray-500"> Admin</span>
                </a>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.prompts.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.prompts.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Prompts
                </a>
                {{-- Aquí puedes añadir más enlaces como Usuarios, Categorías, etc. --}}

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('prompts.dashboard') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a la App
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2.5 rounded-lg transition-colors hover:bg-red-50 dark:hover:bg-red-900/50 text-sm text-red-600 dark:text-red-400 mt-2">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 content-area">
            <header class="bg-white dark:bg-gray-800 shadow-sm h-16 flex items-center justify-between px-6">
                <button id="menu-toggle" class="md:hidden text-gray-500 dark:text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="hidden md:block">
                    <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                        alt="Avatar">
                </div>
            </header>

            <main class="p-6">
                @if (session('status'))
                    <div
                        class="mb-4 rounded-md bg-green-50 dark:bg-green-900/50 p-4 border border-green-200 dark:border-green-800">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>