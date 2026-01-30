@extends('layouts.admin')

@section('title', 'Editar Prompt')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.prompts.update', $prompt) }}" method="POST"
            class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-800">
                    <p class="font-semibold text-red-800 dark:text-red-200">Por favor, corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-red-700 dark:text-red-300 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título *</label>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $prompt->titulo) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenido
                    *</label>
                <textarea id="contenido" name="contenido" rows="12" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('contenido', $prompt->contenido) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría
                        *</label>
                    <select id="categoria_id" name="categoria_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected(old('categoria_id', $prompt->categoria_id) == $cat->id)>
                                {{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ia_destino" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IA Destino
                        *</label>
                    <input type="text" id="ia_destino" name="ia_destino"
                        value="{{ old('ia_destino', $prompt->ia_destino) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="descripcion"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion', $prompt->descripcion) }}</textarea>
            </div>

            <div>
                <label for="etiquetas" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Etiquetas</label>
                <select id="etiquetas" name="etiquetas[]" multiple
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @php
                        $selected = collect(old('etiquetas', $etiquetasSeleccionadas ?? []))->map(fn($v) => (int) $v)->all();
                    @endphp
                    @foreach($etiquetas as $tag)
                        <option value="{{ $tag->id }}" @selected(in_array((int) $tag->id, $selected, true))>{{ $tag->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-6">
                <label class="flex items-center"><input type="checkbox" name="es_publico" value="1"
                        @checked(old('es_publico', $prompt->es_publico))
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"> <span
                        class="ml-2">Público</span></label>
                <label class="flex items-center"><input type="checkbox" name="es_favorito" value="1"
                        @checked(old('es_favorito', $prompt->es_favorito))
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"> <span
                        class="ml-2">Favorito (para el autor)</span></label>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.prompts.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-500 rounded-md text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Guardar
                    Cambios</button>
            </div>
        </form>
    </div>
@endsection