<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PromptVault - Gestión Inteligente de Prompts</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-gray-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <!-- 1) NAVBAR SUPERIOR (Sticky + Blur) -->
    <nav
        class="sticky top-0 z-50 w-full backdrop-blur-lg bg-gray-900/80 border-b border-gray-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-white">PromptVault</span>
                </div>

                <!-- Links Centrales (Desktop) -->
                <div class="hidden md:flex space-x-8">
                    <a href="#prompts"
                        class="text-gray-300 hover:text-white transition-colors text-sm font-medium hover:underline decoration-indigo-500 decoration-2 underline-offset-4">Explorar</a>
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Categorías</a>
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Etiquetas</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-medium text-indigo-400 hover:text-indigo-300">Ir al Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Ingresar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- 2) HERO DE BIENVENIDA -->
    <div class="relative overflow-hidden border-b border-gray-800">
        <!-- Background Gradients -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl mix-blend-screen opacity-30 animate-pulse">
            </div>
            <div
                class="absolute top-20 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl mix-blend-screen opacity-30">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                Bienvenido a <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">PromptVault</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400 leading-relaxed">
                Explora, organiza y reutiliza prompts de inteligencia artificial de forma eficiente.
                Tu biblioteca personal para potenciar tu creatividad.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="#prompts"
                    class="px-8 py-3 rounded-lg bg-white text-gray-900 font-bold hover:bg-gray-100 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-transform">
                    Explorar Prompts
                </a>
                <a href="{{ route('login') }}"
                    class="px-8 py-3 rounded-lg bg-gray-800 text-white font-bold border border-gray-700 hover:bg-gray-700 transition-colors">
                    Crear mis Prompts
                </a>
            </div>

            <!-- Estadísticas Simuladas -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-3xl mx-auto border-t border-gray-800 pt-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">+120</div>
                    <div class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Prompts</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">15</div>
                    <div class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Categorías</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">80</div>
                    <div class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Usuarios</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4) SECCIÓN EXPLICATIVA (Features) -->
    <div class="bg-gray-900 py-20 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="p-8 rounded-2xl bg-gray-800/30 border border-gray-700/50 hover:bg-gray-800/80 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-indigo-900/50 rounded-lg flex items-center justify-center mb-6 text-indigo-400 ring-1 ring-indigo-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Guarda tus Prompts</h3>
                    <p class="text-gray-400 leading-relaxed">Almacena tus mejores comandos para ChatGPT, Midjourney y
                        más en un solo lugar seguro y accesible.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="p-8 rounded-2xl bg-gray-800/30 border border-gray-700/50 hover:bg-gray-800/80 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-purple-900/50 rounded-lg flex items-center justify-center mb-6 text-purple-400 ring-1 ring-purple-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Versiona tus Ideas</h3>
                    <p class="text-gray-400 leading-relaxed">Mantén un historial de cambios y mejoras en tus prompts
                        para no perder nunca una buena iteración.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="p-8 rounded-2xl bg-gray-800/30 border border-gray-700/50 hover:bg-gray-800/80 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-pink-900/50 rounded-lg flex items-center justify-center mb-6 text-pink-400 ring-1 ring-pink-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Comparte con Otros</h3>
                    <p class="text-gray-400 leading-relaxed">Haz públicos tus prompts favoritos y contribuye a la
                        comunidad de creadores.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3) SECCIÓN DE PROMPTS DESTACADOS -->
    <div id="prompts" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-white">Prompts Destacados</h2>
                <p class="text-gray-400 mt-2 text-lg">Descubre lo que la comunidad está creando.</p>
            </div>
            <a href="#"
                class="hidden sm:flex items-center text-indigo-400 hover:text-indigo-300 font-medium transition-colors group">
                Ver todos
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>

        <!-- Grid de Prompts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($prompts) && count($prompts) > 0)
                @foreach($prompts as $prompt)
                    @include('partials.prompt-card', ['prompt' => $prompt, 'mode' => 'guest'])
                @endforeach
            @else
                <div
                    class="col-span-full text-center py-16 bg-gray-900/30 rounded-2xl border border-gray-800 border-dashed">
                    <p class="text-gray-500 text-lg">No hay prompts públicos disponibles en este momento.</p>
                </div>
            @endif
        </div>

        <!-- Paginación -->
        @if(isset($prompts) && method_exists($prompts, 'links'))
            <div class="mt-12">
                {{ $prompts->links() }}
            </div>
        @endif
    </div>

    <!-- 5) FOOTER -->
    <footer class="bg-gray-950 border-t border-gray-900 py-12">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-gray-800 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-gray-400 font-medium text-lg">PromptVault</span>
            </div>
            <p class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} PromptVault — Gestión inteligente de prompts IA.
            </p>
        </div>
    </footer>

</body>

</html>