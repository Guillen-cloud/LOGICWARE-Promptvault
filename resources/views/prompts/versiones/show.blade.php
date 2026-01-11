@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold">Detalle de Versión</h1>
                <p class="text-gray-600">
                    Prompt:
                    <a class="text-blue-700 hover:underline"
                        href="{{ route('prompts.show', $prompt) }}">{{ $prompt->titulo }}</a>
                    • Versión: <span class="font-medium">v{{ $version->numero_version }}</span>
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('prompts.versiones.index', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                    Volver al historial
                </a>
                <a href="{{ route('prompts.edit', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                    Editar prompt
                </a>
            </div>
        </div>

        <div class="rounded border p-4 space-y-3">
            <div>
                <div class="text-sm text-gray-600">Motivo del cambio</div>
                <div class="font-medium">{{ $version->motivo_cambio }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Fecha</div>
                <div class="font-medium">{{ optional($version->created_at)->format('Y-m-d H:i') }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Contenido anterior guardado</div>
                <pre class="mt-1 whitespace-pre-wrap rounded bg-gray-50 p-3 border">{{ $version->contenido_anterior }}</pre>
            </div>
        </div>
    </div>
@endsection