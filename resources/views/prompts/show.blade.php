@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">{{ $prompt->titulo }}</h1>

            {{-- ✅ Acciones protegidas por Policies --}}
            <div class="flex gap-2 flex-wrap">
                @can('update', $prompt)
                    <a href="{{ route('prompts.edit', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                        Editar
                    </a>
                @endcan

                @can('share', $prompt)
                    <a href="{{ route('prompts.compartidos.create', $prompt) }}"
                        class="rounded bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-700">
                        Compartir
                    </a>

                    <a href="{{ route('prompts.compartidos.index', $prompt) }}"
                        class="rounded border px-3 py-2 hover:bg-gray-50">
                        Compartidos
                    </a>
                @endcan

                @can('viewVersions', $prompt)
                    <a href="{{ route('prompts.versiones.index', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                        Historial (versiones)
                    </a>
                @endcan

                @can('use', $prompt)
                    <form action="{{ route('prompts.usar', $prompt) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded bg-gray-900 px-3 py-2 text-white hover:bg-black">
                            Marcar como usado
                        </button>
                    </form>
                @endcan

                @can('delete', $prompt)
                    <form action="{{ route('prompts.destroy', $prompt) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este prompt?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded border border-red-300 px-3 py-2 text-red-700 hover:bg-red-50">
                            Eliminar
                        </button>
                    </form>
                @endcan

                <a href="{{ route('prompts.index') }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                    Volver
                </a>
            </div>
        </div>

        <div class="rounded border p-4 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <div class="text-sm text-gray-600">Categoría</div>
                    <div class="font-medium">{{ $prompt->categoria?->nombre }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">IA destino</div>
                    <div class="font-medium">{{ $prompt->ia_destino }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Favorito</div>
                    <div class="font-medium">{{ $prompt->es_favorito ? 'Sí' : 'No' }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Público</div>
                    <div class="font-medium">{{ $prompt->es_publico ? 'Sí' : 'No' }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Veces usado</div>
                    <div class="font-medium">{{ $prompt->veces_usado }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600">Versión actual</div>
                    <div class="font-medium">{{ $prompt->version_actual }}</div>
                </div>
            </div>

            @if($prompt->descripcion)
                <div>
                    <div class="text-sm text-gray-600">Descripción</div>
                    <div class="whitespace-pre-wrap">{{ $prompt->descripcion }}</div>
                </div>
            @endif

            <div>
                <div class="text-sm text-gray-600">Etiquetas</div>
                <div class="mt-1">
                    @forelse($prompt->etiquetas as $tag)
                        <span class="inline-block rounded bg-gray-100 px-2 py-0.5 mr-1 mb-1">
                            {{ $tag->nombre }}
                        </span>
                    @empty
                        <span class="text-gray-600">Sin etiquetas</span>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Contenido</div>
                <pre class="mt-1 whitespace-pre-wrap rounded bg-gray-50 p-3 border">{{ $prompt->contenido }}</pre>
            </div>
        </div>
    </div>
@endsection