<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PromptVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="@if(trim($__env->yieldPushContent('bodyClass')))@stack('bodyClass')@else bg-gray-100 @endif">
    @hasSection('hideNavigation')
    @else
        @include('layouts.navigation')
    @endif

    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>

</html>