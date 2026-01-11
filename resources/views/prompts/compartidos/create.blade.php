@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold">Compartir Prompt</h1>
                <p class="text-gray-600">
                    Prompt: <a class="text-blue-700 hover:underline"
                        href="{{ route('prompts.show', $prompt) }}">{{ $prompt->titulo }}</a>
                </p>
            </div>
            <a href="{{ route('prompts.show', $prompt) }}" class="rounded border px-3 py-2 hover:bg-gray-50">
                Volver
            </a>
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

        <form method="POST" action="{{ route('prompts.compartidos.store', $prompt) }}" class="space-y-4">
            @csrf

            <div>
                <label for="nombre_destinatario" class="block font-medium mb-1">Nombre del destinatario *</label>
                <input id="nombre_destinatario" name="nombre_destinatario" type="text"
                    value="{{ old('nombre_destinatario') }}" class="w-full rounded border p-2" maxlength="140" required>
                @error('nombre_destinatario') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email_destinatario" class="block font-medium mb-1">Email del destinatario *</label>
                <input id="email_destinatario" name="email_destinatario" type="email"
                    value="{{ old('email_destinatario') }}" class="w-full rounded border p-2" maxlength="160" required>
                @error('email_destinatario') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="notas" class="block font-medium mb-1">Notas (opcional)</label>
                <textarea id="notas" name="notas" rows="4" class="w-full rounded border p-2">{{ old('notas') }}</textarea>
                @error('notas') <p class="text-red-700 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                    Registrar compartido
                </button>
                <a href="{{ route('prompts.compartidos.index', $prompt) }}"
                    class="rounded border px-4 py-2 hover:bg-gray-50">
                    Ver compartidos
                </a>
            </div>

            <p class="text-sm text-gray-600">
                Se registrará <strong>fecha_compartido</strong> automáticamente con la fecha/hora actual.
            </p>
        </form>
    </div>
@endsection