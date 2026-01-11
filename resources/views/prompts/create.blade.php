@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-3xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Crear Prompt</h1>
            <a href="{{ route('prompts.index') }}" class="rounded border px-3 py-2 hover:bg-gray-50">Volver</a>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-800">
                <p class="font-semibold mb-2">Revisa los errores:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('prompts.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium mb-1" for="titulo">Título *</label>
                <input id="titulo" name="titulo" type="text" value="{{ old('titulo') }}" class="w-full rounded border p-2"
                    maxlength="180" required>
                @error('titulo') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="categoria_id">Categoría *</label>
                <select id="categoria_id" name="categoria_id" class="w-full rounded border p-2" required>
                    <option value="">-- Selecciona --</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected(old('categoria_id') == $cat->id)>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="ia_destino">IA destino *</label>
                <input id="ia_destino" name="ia_destino" type="text" value="{{ old('ia_destino') }}"
                    class="w-full rounded border p-2" maxlength="60" required>
                @error('ia_destino') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="w-full rounded border p-2"
                    rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="contenido">Contenido *</label>
                <textarea id="contenido" name="contenido" class="w-full rounded border p-2" rows="10"
                    required>{{ old('contenido') }}</textarea>
                @error('contenido') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="etiquetas">Etiquetas</label>
                <select id="etiquetas" name="etiquetas[]" class="w-full rounded border p-2" multiple size="6">
                    @foreach($etiquetas as $tag)
                        <option value="{{ $tag->id }}" @selected(collect(old('etiquetas', []))->contains($tag->id))>
                            {{ $tag->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-600 mt-1">Puedes seleccionar varias con Ctrl (Windows) / Cmd (Mac).</p>
                @error('etiquetas') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
                @error('etiquetas.*') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="es_favorito" value="1" @checked(old('es_favorito'))>
                    <span>Favorito</span>
                </label>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="es_publico" value="1" @checked(old('es_publico'))>
                    <span>Público</span>
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Guardar
                </button>
                <a href="{{ route('prompts.index') }}" class="rounded border px-4 py-2 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection