<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $prompt->titulo }} - PromptVault</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f4c75 100%);
            color: #e2e8f0;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px;
            margin-bottom: 40px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 8px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-button:hover {
            border-color: rgba(100, 116, 139, 0.4);
            color: #cbd5e1;
        }

        .title-section {
            flex: 1;
            margin-top: 50px;
        }

        .prompt-title {
            font-size: 36px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .prompt-meta-info {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 14px;
            color: #94a3b8;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Action Buttons */
        .actions-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: rgba(30, 41, 59, 0.8);
            border: 1.5px solid rgba(100, 116, 139, 0.3);
            color: #cbd5e1;
        }

        .btn-secondary:hover {
            border-color: rgba(100, 116, 139, 0.6);
            background: rgba(30, 41, 59, 1);
            color: #e2e8f0;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1.5px solid rgba(239, 68, 68, 0.3);
            color: #ff6b6b;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ff6b6b;
        }

        .btn-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1.5px solid rgba(34, 197, 94, 0.3);
            color: #51cf66;
        }

        .btn-success:hover {
            background: rgba(34, 197, 94, 0.2);
            border-color: #51cf66;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Alert Message */
        .alert {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 8px;
            padding: 14px 16px;
            color: #86efac;
            margin-bottom: 30px;
            font-size: 14px;
        }

        /* Main Content Card */
        .content-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
        }

        .content-card:hover {
            border-color: rgba(100, 116, 139, 0.3);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #e2e8f0;
        }

        .info-badge {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            width: fit-content;
        }

        .info-badge.public {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .info-badge.private {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .info-badge.favorite {
            background: rgba(251, 146, 60, 0.15);
            color: #fdba74;
            border: 1px solid rgba(251, 146, 60, 0.3);
        }

        /* Section Title */
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.2);
        }

        /* Description */
        .description-text {
            color: #cbd5e1;
            line-height: 1.6;
            white-space: pre-wrap;
            font-size: 15px;
        }

        /* Tags */
        .tags-container {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .tag {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(102, 126, 234, 0.15);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 20px;
            color: #93c5fd;
            font-size: 13px;
            font-weight: 500;
        }

        .empty-tags {
            color: #94a3b8;
            font-style: italic;
            font-size: 14px;
        }

        /* Code/Content Block */
        .content-block {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 8px;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            color: #cbd5e1;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
            }

            .title-section {
                margin-top: 0;
            }

            .prompt-title {
                font-size: 26px;
            }

            .actions-section {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .actions-section .btn {
                flex: 1;
                min-width: 120px;
            }

            .content-card {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                width: 100%;
            }

            .back-button {
                position: static;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('prompts.dashboard') }}" class="back-button">← Volver</a>

        @if (session('status'))
            <div class="alert">
                ✓ {{ session('status') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="header">
            <div class="title-section">
                <h1 class="prompt-title">{{ $prompt->titulo }}</h1>
                <div class="prompt-meta-info">
                    <div class="meta-item">👤 {{ $prompt->user->name ?? 'Anónimo' }}</div>
                    <div class="meta-item">📅 {{ $prompt->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <div class="actions-section">
                @can('update', $prompt)
                    <a href="{{ route('prompts.edit', $prompt) }}" class="btn btn-primary">✏️ Editar</a>
                @endcan

                @can('share', $prompt)
                    <a href="{{ route('prompts.compartidos.create', $prompt) }}" class="btn btn-primary">🔗 Compartir</a>
                @endcan

                @can('use', $prompt)
                    <form action="{{ route('prompts.usar', $prompt) }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%;">✓ Usar</button>
                    </form>
                @endcan

                @can('delete', $prompt)
                    <form action="{{ route('prompts.destroy', $prompt) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este prompt? Esta acción no se puede deshacer.');"
                        style="width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%;">🗑️ Eliminar</button>
                    </form>
                @endcan
            </div>
        </div>

        <!-- Info Grid -->
        <div class="content-card">
            <div class="info-grid">
                @if($prompt->categoria)
                    <div class="info-item">
                        <div class="info-label">📁 Categoría</div>
                        <div class="info-value">{{ $prompt->categoria->nombre }}</div>
                    </div>
                @endif

                <div class="info-item">
                    <div class="info-label">🤖 IA Destino</div>
                    <div class="info-value">{{ $prompt->ia_destino }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">👁️ Visibilidad</div>
                    <div>
                        @if($prompt->es_publico)
                            <span class="info-badge public">🔓 Público</span>
                        @else
                            <span class="info-badge private">🔒 Privado</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">⭐ Favorito</div>
                    <div>
                        @if($prompt->es_favorito)
                            <span class="info-badge favorite">⭐ Sí</span>
                        @else
                            <span class="info-value">No</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">📊 Veces Usado</div>
                    <div class="info-value">{{ $prompt->veces_usado }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">📌 Versión</div>
                    <div class="info-value">v{{ $prompt->version_actual }}</div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($prompt->descripcion)
            <div class="content-card">
                <div class="section-title">📝 Descripción</div>
                <div class="description-text">{{ $prompt->descripcion }}</div>
            </div>
        @endif

        <!-- Tags -->
        @if($prompt->etiquetas && $prompt->etiquetas->count() > 0)
            <div class="content-card">
                <div class="section-title">🏷️ Etiquetas</div>
                <div class="tags-container">
                    @foreach($prompt->etiquetas as $tag)
                        <span class="tag">{{ $tag->nombre }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Content -->
        <div class="content-card">
            <div class="section-title">💬 Contenido del Prompt</div>
            <div class="content-block">{{ $prompt->contenido }}</div>
        </div>

        <!-- Action Buttons -->
        <div class="content-card">
            <div class="btn-group">
                @can('viewVersions', $prompt)
                    <a href="{{ route('prompts.versiones.index', $prompt) }}" class="btn btn-secondary">📜 Historial de
                        Versiones</a>
                @endcan

                @can('share', $prompt)
                    <a href="{{ route('prompts.compartidos.index', $prompt) }}" class="btn btn-secondary">👥 Ver
                        Compartidos</a>
                @endcan

                <a href="{{ route('prompts.dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>