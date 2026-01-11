@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">
                @if(request('publico') == 1)
                    Prompts Públicos
                @else
                    Mis Prompts
                @endif
            </h1>

            <a href="{{ route('prompts.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Nuevo
            </a>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('prompts.index') }}" class="mb-4 rounded border p-3 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1" for="q">Buscar (título / contenido)</label>
                    <input id="q" name="q" type="text" value="{{ request('q') }}" class="w-full rounded border p-2"
                        placeholder="Ej: marketing, resumen, rol...">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" class="w-full rounded border p-2">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected((string) request('categoria_id') === (string) $cat->id)>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="ia_destino">IA destino</label>
                    <select id="ia_destino" name="ia_destino" class="w-full rounded border p-2">
                        <option value="">Todas</option>
                        @foreach($iasDestino as $ia)
                            <option value="{{ $ia }}" @selected((string) request('ia_destino') === (string) $ia)>
                                {{ $ia }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="desde">Desde</label>
                    <input id="desde" name="desde" type="date" value="{{ request('desde') }}"
                        class="w-full rounded border p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="hasta">Hasta</label>
                    <input id="hasta" name="hasta" type="date" value="{{ request('hasta') }}"
                        class="w-full rounded border p-2">
                </div>
            </div>

            <div class="mt-3 flex flex-wrap items-center gap-4">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="favorito" value="1" @checked(request('favorito') == 1)>
                    <span>Solo favoritos</span>
                </label>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="publico" value="1" @checked(request('publico') == 1)>
                    <span>Ver públicos</span>
                </label>

                <div class="flex gap-2">
                    <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white hover:bg-black">
                        Filtrar
                    </button>

                    <a href="{{ route('prompts.index') }}" class="rounded border px-4 py-2 hover:bg-gray-50">
                        Limpiar
                    </a>
                </div>

                <div class="text-sm text-gray-600">
                    @if(request('publico') == 1)
                        Mostrando prompts públicos (incluye de terceros).
                    @else
                        Mostrando solo tus prompts.
                    @endif
                </div>
            </div>
        </form>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">Título</th>
                        <th class="p-3">Categoría</th>
                        <th class="p-3">IA destino</th>
                        <th class="p-3">Favorito</th>
                        <th class="p-3">Público</th>
                        @if(request('publico') == 1)
                            <th class="p-3">Autor</th>
                        @endif
                        <th class="p-3">Creado</th>
                        <th class="p-3 w-56">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prompts as $prompt)
                        @php
                            $esMio = ((int) $prompt->user_id === (int) $userId); // solo para badge
                        @endphp
                        <tr class="border-t">
                            <td class="p-3">
                                <a class="text-blue-700 hover:underline" href="{{ route('prompts.show', $prompt) }}">
                                    {{ $prompt->titulo }}
                                </a>

                                @if(!$esMio)
                                    <span
                                        class="ml-2 inline-block text-xs rounded bg-yellow-50 border border-yellow-200 px-2 py-0.5 text-yellow-800">
                                        De terceros
                                    </span>
                                @endif

                                @if($prompt->etiquetas->count())
                                    <div class="mt-1 text-sm text-gray-600">
                                        @foreach($prompt->etiquetas as $tag)
                                            <span class="inline-block rounded bg-gray-100 px-2 py-0.5 mr-1">
                                                {{ $tag->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            <td class="p-3">{{ $prompt->categoria?->nombre }}</td>
                            <td class="p-3">{{ $prompt->ia_destino }}</td>
                            <td class="p-3">{{ $prompt->es_favorito ? 'Sí' : 'No' }}</td>
                            <td class="p-3">{{ $prompt->es_publico ? 'Sí' : 'No' }}</td>

                            @if(request('publico') == 1)
                                <td class="p-3">
                                    {{ $prompt->user?->name ?? '—' }}
                                    @if($esMio)
                                        <span
                                            class="ml-2 inline-block text-xs rounded bg-green-50 border border-green-200 px-2 py-0.5 text-green-800">
                                            Tú
                                        </span>
                                    @endif
                                </td>
                            @endif

                            <td class="p-3">
                                {{ optional($prompt->created_at)->format('Y-m-d H:i') }}
                            </td>

                            {{-- ✅ Acciones con Policies --}}
                            <td class="p-3">
                                <div class="flex gap-2 flex-wrap">
                                    @can('update', $prompt)
                                        <a href="{{ route('prompts.edit', $prompt) }}"
                                            class="rounded border px-3 py-1 hover:bg-gray-50">
                                            Editar
                                        </a>
                                    @endcan

                                    @can('delete', $prompt)
                                        <form action="{{ route('prompts.destroy', $prompt) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar este prompt?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded border border-red-300 px-3 py-1 text-red-700 hover:bg-red-50">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endcan

                                    @cannot('update', $prompt)
                                    <span class="text-sm text-gray-500">Solo lectura</span>
                                    @endcannot
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="{{ request('publico') == 1 ? 8 : 7 }}">
                                No hay resultados con estos filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $prompts->links() }}
        </div>
    </div>
@endsection