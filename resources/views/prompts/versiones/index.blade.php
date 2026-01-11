@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold">Historial de Versiones</h1>
                <p class="text-gray-600">
                    Prompt: <a class="text-blue-700 hover:underline"
                        href="{{ route('prompts.show', $prompt) }}">{{ $prompt->titulo }}</a>
                </p>
            </div>

            <a href="{{ route('prompts.edit', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                Volver a editar
            </a>
        </div>

        <div class="overflow-x-auto rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">N° versión</th>
                        <th class="p-3">Motivo</th>
                        <th class="p-3">Fecha</th>
                        <th class="p-3 w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($versiones as $v)
                        <tr class="border-t">
                            <td class="p-3 font-medium">v{{ $v->numero_version }}</td>
                            <td class="p-3">{{ $v->motivo_cambio }}</td>
                            <td class="p-3">{{ optional($v->created_at)->format('Y-m-d H:i') }}</td>
                            <td class="p-3">
                                <a class="rounded border px-3 py-1 hover:bg-gray-50"
                                    href="{{ route('prompts.versiones.show', [$prompt, $v]) }}">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="p-3 text-gray-600" colspan="4">
                                Aún no hay versiones guardadas para este prompt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $versiones->links() }}
        </div>
    </div>
@endsection