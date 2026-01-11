@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Historial de Actividades</h1>
            <a href="{{ route('prompts.index') }}" class="rounded border px-3 py-2 hover:bg-gray-50">Ir a Prompts</a>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('actividades.index') }}" class="mb-4 rounded border p-3 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-sm font-medium mb-1" for="accion">Acción</label>
                    <select id="accion" name="accion" class="w-full rounded border p-2">
                        <option value="">Todas</option>
                        @foreach($acciones as $a)
                            <option value="{{ $a }}" @selected(request('accion') === $a)>{{ $a }}</option>
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

                <div class="flex items-end gap-2">
                    <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white hover:bg-black">
                        Filtrar
                    </button>
                    <a href="{{ route('actividades.index') }}" class="rounded border px-4 py-2 hover:bg-gray-50">
                        Limpiar
                    </a>
                </div>
            </div>

            <p class="text-sm text-gray-600 mt-2">
                Se muestran como máximo las <strong>últimas 100</strong> actividades (paginado).
            </p>
        </form>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Acción</th>
                        <th class="p-3">Prompt</th>
                        <th class="p-3">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actividades as $act)
                        <tr class="border-t">
                            <td class="p-3 whitespace-nowrap">
                                {{ optional($act->created_at)->format('Y-m-d H:i') }}
                            </td>
                            <td class="p-3">
                                <span class="inline-block rounded bg-gray-100 px-2 py-0.5">
                                    {{ $act->accion }}
                                </span>
                            </td>
                            <td class="p-3">
                                @if($act->prompt_id && $act->prompt)
                                    <a class="text-blue-700 hover:underline" href="{{ route('prompts.show', $act->prompt_id) }}">
                                        {{ $act->prompt->titulo }}
                                    </a>
                                @elseif($act->prompt_id && !$act->prompt)
                                    <span class="text-gray-500">Prompt eliminado</span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="whitespace-pre-wrap">{{ $act->descripcion }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="4">
                                No hay actividades registradas con esos filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $actividades->links() }}
        </div>
    </div>
@endsection