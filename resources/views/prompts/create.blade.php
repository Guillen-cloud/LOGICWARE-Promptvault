@extends('layouts.main')

@push('bodyClass')
    bg-slate-900 min-h-screen
@endpush

@section('hideNavigation', '1')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login-custom.css') }}">
@endpush

@section('content')
    <div class="login-backdrop">
        <div class="login-container">
            <div class="login-wrapper">
                <div class="login-logo">
                    <h1>Crear Prompt</h1>
                    <p>Crea y comparte tus mejores prompts</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <div class="alert-icon">⚠️</div>
                        <div class="alert-content">
                            <p class="font-semibold">Revisa los errores:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('prompts.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="titulo"><span class="label-text">Título *</span></label>
                        <input id="titulo" name="titulo" type="text" value="{{ old('titulo') }}" class="form-input"
                            maxlength="180" required>
                        @error('titulo') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="categoria_id"><span class="label-text">Categoría *</span></label>
                        <select id="categoria_id" name="categoria_id" class="form-input" required>
                            <option value="">-- Selecciona --</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" @selected(old('categoria_id') == $cat->id)>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ia_destino"><span class="label-text">IA destino *</span></label>
                        <input id="ia_destino" name="ia_destino" type="text" value="{{ old('ia_destino') }}"
                            class="form-input" maxlength="60" required>
                        @error('ia_destino') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripcion"><span class="label-text">Descripción</span></label>
                        <textarea id="descripcion" name="descripcion" class="form-input"
                            rows="3">{{ old('descripcion') }}</textarea>
                        @error('descripcion') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contenido"><span class="label-text">Contenido *</span></label>
                        <textarea id="contenido" name="contenido" class="form-input" rows="10"
                            required>{{ old('contenido') }}</textarea>
                        @error('contenido') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="etiquetas"><span class="label-text">Etiquetas</span></label>
                        <select id="etiquetas" name="etiquetas[]" class="form-input" multiple size="6">
                            @foreach($etiquetas as $tag)
                                <option value="{{ $tag->id }}" @selected(collect(old('etiquetas', []))->contains($tag->id))>
                                    {{ $tag->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-600 mt-1">Puedes seleccionar varias con Ctrl (Windows) / Cmd (Mac).</p>
                        @error('etiquetas') <p class="form-error">{{ $message }}</p> @enderror
                        @error('etiquetas.*') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="checkbox">
                            <input type="checkbox" class="checkbox-input" name="es_favorito" value="1"
                                @checked(old('es_favorito'))>
                            <span class="checkbox-label">Favorito</span>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="checkbox-input" name="es_publico" value="1"
                                @checked(old('es_publico'))>
                            <span class="checkbox-label">Público</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <span class="btn-text">Guardar</span>
                        </button>
                        <a href="{{ route('prompts.dashboard') }}" class="btn btn-ghost"
                            style="margin-top:8px;">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>
        </div>
    </div>
@endsection