@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Editar Categoría</h1>
            <a href="{{ route('categorias.index') }}" class="rounded border px-3 py-2 hover:bg-gray-50">Volver</a>
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

        <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1" for="nombre">Nombre *</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $categoria->nombre) }}"
                    class="w-full rounded border p-2" maxlength="120" required>
                @error('nombre') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1" for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full rounded border p-2">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                @error('descripcion') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium mb-1" for="color">Color (opcional)</label>
                    <input id="color" name="color" type="text" value="{{ old('color', $categoria->color) }}"
                        class="w-full rounded border p-2" maxlength="20">
                    @error('color') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1" for="icono">Icono (opcional)</label>
                    <input id="icono" name="icono" type="text" value="{{ old('icono', $categoria->icono) }}"
                        class="w-full rounded border p-2" maxlength="60">
                    @error('icono') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Guardar cambios
                </button>
                <a href="{{ route('categorias.index') }}" class="rounded border px-4 py-2 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection