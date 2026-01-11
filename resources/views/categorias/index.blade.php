@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Categorías</h1>
            <a href="{{ route('categorias.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Nueva
            </a>
        </div>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Color</th>
                        <th class="p-3">Icono</th>
                        <th class="p-3">Descripción</th>
                        <th class="p-3 w-48">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $c)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $c->nombre }}</td>
                            <td class="p-3">{{ $c->color ?? '—' }}</td>
                            <td class="p-3">{{ $c->icono ?? '—' }}</td>
                            <td class="p-3">
                                <div class="max-w-md truncate" title="{{ $c->descripcion }}">
                                    {{ $c->descripcion ?? '—' }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('categorias.edit', $c) }}"
                                        class="rounded border px-3 py-1 hover:bg-gray-50">
                                        Editar
                                    </a>

                                    <form action="{{ route('categorias.destroy', $c) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar la categoría \" {{ $c->nombre }}\"?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded border border-red-300 px-3 py-1 text-red-700 hover:bg-red-50">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    * Si está usada por prompts, el sistema no permitirá eliminarla (FK RESTRICT).
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="5">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categorias->links() }}
        </div>
    </div>
@endsection