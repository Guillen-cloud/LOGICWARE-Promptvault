@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Etiquetas</h1>
            <a href="{{ route('etiquetas.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Nueva
            </a>
        </div>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3 w-48">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etiquetas as $e)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $e->nombre }}</td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('etiquetas.edit', $e) }}"
                                        class="rounded border px-3 py-1 hover:bg-gray-50">
                                        Editar
                                    </a>

                                    <form action="{{ route('etiquetas.destroy', $e) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar la etiqueta \" {{ $e->nombre }}\"?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded border border-red-300 px-3 py-1 text-red-700 hover:bg-red-50">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    * Si la etiqueta está vinculada a prompts, se desvinculará automáticamente (FK CASCADE).
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="2">No hay etiquetas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $etiquetas->links() }}
        </div>
    </div>
@endsection