@extends('layouts.admin')

@section('title', 'Gestionar Prompts')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" action="{{ route('admin.prompts.index') }}">
                <div class="flex items-center">
                    <input type="search" name="q" placeholder="Buscar por título, contenido, autor..."
                           value="{{ request('q') }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-gray-50 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">Buscar</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Título</th>
                        <th scope="col" class="px-6 py-3">Autor</th>
                        <th scope="col" class="px-6 py-3">Categoría</th>
                        <th scope="col" class="px-6 py-3">Visibilidad</th>
                        <th scope="col" class="px-6 py-3">Fecha Creación</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prompts as $prompt)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ Str::limit($prompt->titulo, 50) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $prompt->user->name }}
                                <span class="block text-xs text-gray-400">{{ $prompt->user->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $prompt->categoria->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($prompt->es_publico)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Público</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Privado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $prompt->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.prompts.edit', $prompt) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Editar</a>
                                    <form action="{{ route('admin.prompts.destroy', $prompt) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este prompt? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">
                                No se encontraron prompts con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($prompts->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $prompts->links() }}
            </div>
        @endif
    </div>
@endsection