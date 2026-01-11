@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Crear Etiqueta</h1>
            <a href="{{ route('etiquetas.index') }}" class="rounded border px-3 py-2 hover:bg-gray-50">Volver</a>
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

        <form method="POST" action="{{ route('etiquetas.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium mb-1" for="nombre">Nombre *</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" class="w-full rounded border p-2"
                    maxlength="80" required>
                @error('nombre') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Guardar
                </button>
                <a href="{{ route('etiquetas.index') }}" class="rounded border px-4 py-2 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection