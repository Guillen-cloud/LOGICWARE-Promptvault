@extends('layouts.main')
@section('hideNavigation')
@endsection

@section('content')
    <style>
        :root {
            --bg1: #070b14;
            --bg2: #0a1222;
            --card: #0c1528;
            --card2: #0a1325;
            --border: rgba(255, 255, 255, .10);
            --muted: rgba(255, 255, 255, .65);
            --muted2: rgba(255, 255, 255, .45);
            --text: #ffffff;
            --accent1: #6366f1;
            /* indigo */
            --accent2: #a855f7;
            /* fuchsia */
            --good: #22c55e;
            --danger: #ef4444;
            --shadow: 0 22px 70px rgba(0, 0, 0, .55);
            --radius: 18px;
        }

        /* wrapper */
        .pv-wrap {
            min-height: calc(100vh - 80px);
            padding: 34px 16px 54px;
            background:
                radial-gradient(1200px 600px at 50% -10%, rgba(99, 102, 241, .22), transparent 55%),
                radial-gradient(900px 500px at 85% 10%, rgba(168, 85, 247, .15), transparent 55%),
                linear-gradient(180deg, var(--bg1), var(--bg2));
            color: var(--text);
        }

        .pv-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* top header */
        .pv-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .pv-title {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .pv-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(99, 102, 241, .22), rgba(168, 85, 247, .18));
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
            flex: 0 0 auto;
        }

        .pv-title h1 {
            margin: 0;
            font-size: 28px;
            line-height: 1.1;
            letter-spacing: -.5px;
            font-weight: 900;
        }

        .pv-title p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
            max-width: 640px;
        }

        .pv-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .pv-btn {
            appearance: none;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .85);
            padding: 10px 14px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: transform .15s ease, background .15s ease, border-color .15s ease, box-shadow .15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }

        .pv-btn:hover {
            background: rgba(255, 255, 255, .08);
            transform: translateY(-1px);
        }

        .pv-btn-primary {
            border-color: rgba(255, 255, 255, .12);
            background: linear-gradient(90deg, rgba(99, 102, 241, .95), rgba(168, 85, 247, .90));
            color: #fff;
            box-shadow: 0 16px 46px rgba(99, 102, 241, .18);
        }

        .pv-btn-primary:hover {
            opacity: .96;
        }

        /* errors */
        .pv-alert {
            border: 1px solid rgba(239, 68, 68, .35);
            background: rgba(239, 68, 68, .10);
            border-radius: var(--radius);
            padding: 14px 14px;
            margin: 14px 0 18px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .25);
        }

        .pv-alert strong {
            display: block;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .pv-alert ul {
            margin: 0;
            padding-left: 18px;
            color: rgba(255, 255, 255, .82);
        }

        .pv-alert li {
            margin: 3px 0;
            font-size: 13px;
        }

        /* layout grid */
        .pv-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 10px;
        }

        @media (min-width: 980px) {
            .pv-grid {
                grid-template-columns: 2fr 1fr;
                gap: 18px;
            }
        }

        /* cards */
        .pv-card {
            background: linear-gradient(180deg, rgba(12, 21, 40, .88), rgba(8, 14, 28, .72));
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .pv-card-inner {
            padding: 18px;
        }

        @media (min-width: 720px) {
            .pv-card-inner {
                padding: 22px;
            }
        }

        .pv-card-head {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .pv-card-head h2 {
            margin: 0;
            font-size: 14px;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .70);
            font-weight: 900;
        }

        .pv-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
            font-weight: 800;
        }

        .pv-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(99, 102, 241, .95);
            box-shadow: 0 0 0 6px rgba(99, 102, 241, .12);
        }

        /* form */
        .pv-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .pv-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 720px) {
            .pv-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        .pv-field label {
            display: block;
            margin-bottom: 7px;
            font-weight: 900;
            color: rgba(255, 255, 255, .82);
            font-size: 13px;
        }

        .pv-req {
            color: rgba(248, 113, 113, .95);
            font-weight: 900;
        }

        .pv-input,
        .pv-select,
        .pv-textarea {
            width: 100%;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(3, 7, 18, .38);
            color: rgba(255, 255, 255, .92);
            padding: 12px 12px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
            font-size: 14px;
        }

        .pv-textarea {
            min-height: 140px;
            resize: vertical;
        }

        .pv-input::placeholder,
        .pv-textarea::placeholder {
            color: rgba(255, 255, 255, .30);
        }

        .pv-input:focus,
        .pv-select:focus,
        .pv-textarea:focus {
            border-color: rgba(99, 102, 241, .45);
            box-shadow: 0 0 0 5px rgba(99, 102, 241, .14);
            background: rgba(3, 7, 18, .52);
        }

        .pv-help {
            margin-top: 7px;
            font-size: 12px;
            color: var(--muted2);
            line-height: 1.4;
        }

        .pv-error {
            margin-top: 7px;
            font-size: 12px;
            color: rgba(248, 113, 113, .95);
            font-weight: 800;
        }

        /* toggles */
        .pv-toggles {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 4px;
        }

        .pv-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            padding: 10px 12px;
            border-radius: 16px;
            font-weight: 900;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
            user-select: none;
        }

        .pv-toggle input {
            width: 18px;
            height: 18px;
            accent-color: var(--accent1);
        }

        /* bottom buttons */
        .pv-form-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 4px;
        }

        @media (min-width: 520px) {
            .pv-form-actions {
                flex-direction: row;
                justify-content: flex-end;
            }
        }

        /* side */
        .pv-side {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pv-list {
            margin: 10px 0 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            color: rgba(255, 255, 255, .68);
            font-size: 13px;
            line-height: 1.45;
        }

        .pv-li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .pv-bullet {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            margin-top: 6px;
            background: rgba(168, 85, 247, .85);
            box-shadow: 0 0 0 6px rgba(168, 85, 247, .12);
            flex: 0 0 auto;
        }

        .pv-states {
            margin-top: 12px;
            padding: 14px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .04);
        }

        .pv-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .pv-chip {
            padding: 7px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
            font-weight: 900;
        }

        /* small */
        @media (max-width: 520px) {
            .pv-title h1 {
                font-size: 24px;
            }
        }
    </style>

    <div class="pv-wrap">
        <div class="pv-container">

            {{-- TOP --}}
            <div class="pv-top">
                <div class="pv-title">
                    <div class="pv-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="currentColor" style="color: rgba(255,255,255,.9)">
                            <path
                                d="M14.06 9.02l.92.92L7.92 17H7v-.92l7.06-7.06zM17.66 3c-.26 0-.51.1-.71.29l-1.83 1.83 3.05 3.05 1.83-1.83c.39-.39.39-1.02 0-1.41l-1.34-1.34c-.2-.2-.45-.29-.7-.29zM14.06 6.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z" />
                        </svg>
                    </div>
                    <div>
                        <h1>Editar Prompt</h1>
                        <p>Actualiza tu prompt con un diseño limpio y profesional. Se recomienda escribir un motivo del
                            cambio para el historial de versiones.</p>
                    </div>
                </div>

                <div class="pv-actions">
                    <a class="pv-btn" href="{{ route('prompts.show', $prompt) }}">Volver</a>
                    <a class="pv-btn" href="{{ route('prompts.dashboard') }}">Mis Prompts</a>
                </div>
            </div>

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="pv-alert">
                    <strong>Revisa los errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="pv-grid">
                {{-- FORM CARD --}}
                <div class="pv-card">
                    <div class="pv-card-head">
                        <h2>Formulario de edición</h2>
                        <span class="pv-badge"><span class="pv-dot"></span> Modo edición</span>
                    </div>

                    <div class="pv-card-inner">
                        <form class="pv-form" action="{{ route('prompts.update', $prompt) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="pv-field">
                                <label for="titulo">Título <span class="pv-req">*</span></label>
                                <input class="pv-input" id="titulo" name="titulo" type="text"
                                    value="{{ old('titulo', $prompt->titulo) }}" maxlength="180" required
                                    placeholder="Ej: Análisis pro de diseño UI/UX">
                                @error('titulo') <div class="pv-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="pv-row">
                                <div class="pv-field">
                                    <label for="categoria_id">Categoría <span class="pv-req">*</span></label>
                                    <select class="pv-select" id="categoria_id" name="categoria_id" required>
                                        <option value="">-- Selecciona --</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}" @selected(old('categoria_id', $prompt->categoria_id) == $cat->id)>
                                                {{ $cat->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id') <div class="pv-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="pv-field">
                                    <label for="ia_destino">IA destino <span class="pv-req">*</span></label>
                                    <input class="pv-input" id="ia_destino" name="ia_destino" type="text"
                                        value="{{ old('ia_destino', $prompt->ia_destino) }}" maxlength="60" required
                                        placeholder="Ej: ChatGPT / Gemini / Claude">
                                    @error('ia_destino') <div class="pv-error">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="pv-field">
                                <label for="descripcion">Descripción</label>
                                <textarea class="pv-textarea" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Breve descripción del objetivo del prompt...">{{ old('descripcion', $prompt->descripcion) }}</textarea>
                                @error('descripcion') <div class="pv-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="pv-field">
                                <label for="contenido">Contenido <span class="pv-req">*</span></label>
                                <textarea class="pv-textarea" id="contenido" name="contenido" rows="10" required
                                    placeholder="Pega aquí tu prompt completo...">{{ old('contenido', $prompt->contenido) }}</textarea>
                                @error('contenido') <div class="pv-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Motivo del cambio --}}
                            <div class="pv-field">
                                <label for="motivo_cambio">Motivo del cambio <span class="pv-req">*</span></label>
                                <input class="pv-input" id="motivo_cambio" name="motivo_cambio" type="text"
                                    value="{{ old('motivo_cambio') }}" maxlength="255" required
                                    placeholder="Ej: Mejoré estructura, corregí error, agregué contexto...">
                                @error('motivo_cambio') <div class="pv-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Etiquetas --}}
                            <div class="pv-field">
                                <label for="etiquetas">Etiquetas</label>
                                @php
                                    $selected = collect(old('etiquetas', $etiquetasSeleccionadas ?? []))
                                        ->map(fn($v) => (int) $v)->all();
                                @endphp

                                <select class="pv-select" id="etiquetas" name="etiquetas[]" multiple size="6">
                                    @foreach($etiquetas as $tag)
                                        <option value="{{ $tag->id }}" @selected(in_array((int) $tag->id, $selected, true))>
                                            {{ $tag->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pv-help">Selecciona varias con <b>Ctrl</b> (Windows) / <b>Cmd</b> (Mac).</div>
                                @error('etiquetas') <div class="pv-error">{{ $message }}</div> @enderror
                                @error('etiquetas.*') <div class="pv-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- Toggles --}}
                            <div class="pv-toggles">
                                <label class="pv-toggle">
                                    <input type="checkbox" name="es_favorito" value="1" @checked(old('es_favorito', $prompt->es_favorito))>
                                    Favorito
                                </label>

                                <label class="pv-toggle">
                                    <input type="checkbox" name="es_publico" value="1" @checked(old('es_publico', $prompt->es_publico))>
                                    Público
                                </label>
                            </div>

                            {{-- Actions --}}
                            <div class="pv-form-actions">
                                <a class="pv-btn" href="{{ route('prompts.show', $prompt) }}">Cancelar</a>
                                <button class="pv-btn pv-btn-primary" type="submit">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SIDE --}}
                <div class="pv-side">
                    <div class="pv-card">
                        <div class="pv-card-head">
                            <h2>Consejos</h2>
                            <span class="pv-badge"><span class="pv-dot"
                                    style="background: rgba(168,85,247,.95); box-shadow:0 0 0 6px rgba(168,85,247,.12)"></span>
                                Recomendado</span>
                        </div>
                        <div class="pv-card-inner">
                            <ul class="pv-list">
                                <li class="pv-li"><span class="pv-bullet"></span> Mantén el título corto y específico.</li>
                                <li class="pv-li"><span class="pv-bullet"
                                        style="background: rgba(34,197,94,.9); box-shadow:0 0 0 6px rgba(34,197,94,.12)"></span>
                                    Usa pasos y bullets para claridad.</li>
                                <li class="pv-li"><span class="pv-bullet"
                                        style="background: rgba(99,102,241,.9); box-shadow:0 0 0 6px rgba(99,102,241,.12)"></span>
                                    El motivo del cambio ayuda al versionado.</li>
                            </ul>

                            <div class="pv-states">
                                <div
                                    style="font-weight: 900; color: rgba(255,255,255,.72); font-size: 12px; letter-spacing:.6px; text-transform:uppercase;">
                                    Estado actual
                                </div>

                                <div class="pv-chips">
                                    <span class="pv-chip">{{ $prompt->ia_destino }}</span>
                                    <span class="pv-chip">{{ $prompt->categoria->nombre ?? 'Sin categoría' }}</span>
                                    <span class="pv-chip">{{ $prompt->es_publico ? 'Público' : 'Privado' }}</span>
                                    <span class="pv-chip">{{ $prompt->es_favorito ? 'Favorito' : 'Normal' }}</span>
                                </div>

                                <div class="pv-help" style="margin-top:10px;">
                                    Tip: si quieres que el navbar y el fondo se vean idénticos a tu dashboard de la imagen,
                                    lo ideal es ajustar también el <b>layouts.main</b>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pv-card">
                        <div class="pv-card-head">
                            <h2>Atajos</h2>
                            <span class="pv-badge"><span class="pv-dot"
                                    style="background: rgba(34,197,94,.95); box-shadow:0 0 0 6px rgba(34,197,94,.12)"></span>
                                Útil</span>
                        </div>
                        <div class="pv-card-inner">
                            <div class="pv-help" style="margin-top:0">
                                • <b>Ctrl + A</b> dentro del contenido para seleccionar todo.<br>
                                • Usa “Motivo del cambio” para explicar la edición en una frase.<br>
                                • Publica solo cuando esté listo para la comunidad.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection