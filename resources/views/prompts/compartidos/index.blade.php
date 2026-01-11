@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold">Compartidos</h1>
                <p class="text-gray-600">
                    Prompt: <a class="text-blue-700 hover:underline"
                        href="{{ route('prompts.show', $prompt) }}">{{ $prompt->titulo }}</a>
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('prompts.compartidos.create', $prompt) }}"
                    class="rounded bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-700">
                    + Compartir
                </a>
                <a href="{{ route('prompts.show', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                    Volver
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">Destinatario</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Fecha compartido</th>
                        <th class="p-3">Notas</th>
                        <th class="p-3 w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compartidos as $c)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $c->nombre_destinatario }}</td>
                            <td class="p-3">{{ $c->email_destinatario }}</td>
                            <td class="p-3">{{ optional($c->fecha_compartido)->format('Y-m-d H:i') }}</td>
                            <td class="p-3">
                                <div class="max-w-xs truncate" title="{{ $c->notas }}">
                                    {{ $c->notas ?? '—' }}
                                </div>
                            </td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('prompts.compartidos.destroy', [$prompt, $c]) }}"
                                    onsubmit="return confirm('¿Eliminar este registro de compartido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded border border-red-300 px-3 py-1 text-red-700 hover:bg-red-50">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="5">
                                No hay compartidos registrados para este prompt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $compartidos->links() }}
        </div>
    </div>
@endsection