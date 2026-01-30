<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PromptVault</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
        }

        main {
            min-height: 100vh;
        }
    </style>
</head>

<body class="@if(trim($__env->yieldPushContent('bodyClass')))@stack('bodyClass')@else bg-[#070b14] @endif">

    {{-- ✅ NAVBAR opcional: se oculta si la vista define @section('hideNavigation') --}}
    @unless(View::hasSection('hideNavigation'))
        @include('layouts.navigation')
    @endunless

    <main class="p-0">
        <div class="w-full px-0">
            @yield('content')
        </div>
    </main>

</body>

</html>