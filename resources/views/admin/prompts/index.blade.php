@extends('layouts.admin')

@section('title', 'Gestionar Prompts')

@section('content')
    <style>
        /* =========================================================
               ADMIN PROMPTS (Dark Premium) - sin Tailwind en esta vista
               ========================================================= */

        .ap-card {
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: linear-gradient(180deg, rgba(12, 21, 40, .88), rgba(8, 14, 28, .72));
            box-shadow: 0 22px 70px rgba(0, 0, 0, .55);
            overflow: hidden;
        }

        .ap-head {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .03);
        }

        .ap-search {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .ap-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .04);
            color: rgba(255, 255, 255, .88);
            border-right: 0;
            border-radius: 16px 0 0 16px;
            outline: none;
            font-weight: 800;
            font-size: 13px;
        }

        .ap-input::placeholder {
            color: rgba(255, 255, 255, .45);
            font-weight: 700;
        }

        .ap-input:focus {
            border-color: rgba(99, 102, 241, .35);
            box-shadow: 0 0 0 6px rgba(99, 102, 241, .10);
        }

        .ap-btn {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .90);
            padding: 12px 14px;
            border-radius: 0 16px 16px 0;
            cursor: pointer;
            font-weight: 900;
            font-size: 13px;
            transition: transform .15s ease, background .15s ease;
            user-select: none;
        }

        .ap-btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .10);
        }

        .ap-table-wrap {
            overflow-x: auto;
        }

        .ap-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 860px;
        }

        .ap-table thead th {
            text-align: left;
            font-size: 12px;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .70);
            padding: 14px 16px;
            background: rgba(255, 255, 255, .04);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            white-space: nowrap;
        }

        .ap-table tbody td {
            padding: 14px 16px;
            color: rgba(255, 255, 255, .82);
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            background: rgba(255, 255, 255, .02);
            vertical-align: top;
        }

        .ap-table tbody tr:hover td {
            background: rgba(255, 255, 255, .04);
        }

        .ap-title {
            color: rgba(255, 255, 255, .95);
            font-weight: 1000;
        }

        .ap-muted {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, .55);
            font-weight: 700;
            font-size: 12px;
        }

        .ap-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .ap-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .ap-dot.green {
            background: rgba(34, 197, 94, .95);
            box-shadow: 0 0 0 6px rgba(34, 197, 94, .12);
        }

        .ap-dot.red {
            background: rgba(239, 68, 68, .95);
            box-shadow: 0 0 0 6px rgba(239, 68, 68, .12);
        }

        .ap-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ap-link {
            font-weight: 1000;
            text-decoration: none;
            border: 1px solid transparent;
            padding: 7px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .04);
            color: rgba(255, 255, 255, .85);
            cursor: pointer;
            transition: transform .15s ease, background .15s ease;
        }

        .ap-link:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .08);
        }

        .ap-link.danger {
            background: rgba(239, 68, 68, .10);
            border-color: rgba(239, 68, 68, .20);
        }

        .ap-link.danger:hover {
            background: rgba(239, 68, 68, .14);
        }

        .ap-empty {
            padding: 22px 16px;
            text-align: center;
            color: rgba(255, 255, 255, .72);
            font-weight: 800;
        }

        .ap-pager {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .02);
        }

        /* =======================
               Modal Dark Premium
               ======================= */
        .pv-modal {
            position: fixed;
            inset: 0;
            display: none;
            z-index: 9999;
        }

        .pv-modal.is-open {
            display: block;
        }

        .pv-modal__backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .pv-modal__dialog {
            position: relative;
            width: min(520px, calc(100% - 28px));
            margin: 10vh auto 0;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: linear-gradient(180deg, rgba(12, 21, 40, .95), rgba(8, 14, 28, .92));
            box-shadow: 0 30px 90px rgba(0, 0, 0, .65);
            overflow: hidden;
        }

        .pv-modal__head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 16px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .03);
        }

        .pv-modal__icon {
            width: 34px;
            height: 34px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 1000;
            color: rgba(255, 255, 255, .95);
            background: rgba(239, 68, 68, .14);
            border: 1px solid rgba(239, 68, 68, .24);
            flex: 0 0 auto;
        }

        .pv-modal__title {
            font-weight: 1000;
            color: rgba(255, 255, 255, .95);
            letter-spacing: -.2px;
        }

        .pv-modal__sub {
            margin-top: 4px;
            color: rgba(255, 255, 255, .65);
            font-weight: 700;
            font-size: 12px;
        }

        .pv-modal__x {
            margin-left: auto;
            border: none;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .10);
            color: rgba(255, 255, 255, .85);
            width: 34px;
            height: 34px;
            border-radius: 14px;
            cursor: pointer;
        }

        .pv-modal__x:hover {
            background: rgba(255, 255, 255, .10);
        }

        .pv-modal__body {
            padding: 14px 16px 8px;
        }

        .pv-modal__text {
            margin: 0;
            color: rgba(255, 255, 255, .80);
            font-weight: 700;
            line-height: 1.6;
        }

        .pv-modal__name {
            color: rgba(255, 255, 255, .95);
            font-weight: 1000;
        }

        .pv-modal__actions {
            padding: 12px 16px 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .pv-btn {
            border-radius: 14px;
            padding: 10px 12px;
            font-weight: 1000;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .90);
        }

        .pv-btn:hover {
            background: rgba(255, 255, 255, .10);
        }

        .pv-btn-ghost {
            background: rgba(255, 255, 255, .04);
        }

        .pv-btn-danger {
            border-color: rgba(239, 68, 68, .28);
            background: rgba(239, 68, 68, .14);
        }

        .pv-btn-danger:hover {
            background: rgba(239, 68, 68, .18);
        }
    </style>

    <div class="ap-card">
        <div class="ap-head">
            <form method="GET" action="{{ route('admin.prompts.index') }}">
                <div class="ap-search">
                    <input type="search" name="q" placeholder="Buscar por título, contenido, autor..."
                        value="{{ request('q') }}" class="ap-input">
                    <button type="submit" class="ap-btn">Buscar</button>
                </div>
            </form>
        </div>

        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoría</th>
                        <th>Visibilidad</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prompts as $prompt)
                        <tr>
                            <td>
                                <div class="ap-title">{{ Str::limit($prompt->titulo, 50) }}</div>
                            </td>

                            <td>
                                <div style="font-weight: 1000; color: rgba(255,255,255,.92);">
                                    {{ $prompt->user->name }}
                                </div>
                                <span class="ap-muted">{{ $prompt->user->email }}</span>
                            </td>

                            <td>
                                <span style="font-weight: 900;">
                                    {{ $prompt->categoria->nombre ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                @if($prompt->es_publico)
                                    <span class="ap-badge">
                                        <span class="ap-dot green"></span> Público
                                    </span>
                                @else
                                    <span class="ap-badge">
                                        <span class="ap-dot red"></span> Privado
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="ap-muted" style="margin:0;">
                                    {{ $prompt->created_at->format('d/m/Y H:i') }}
                                </span>
                            </td>

                            <td>
                                <div class="ap-actions">
                                    <a href="{{ route('admin.prompts.edit', $prompt) }}" class="ap-link">Editar</a>

                                    <form action="{{ route('admin.prompts.destroy', $prompt) }}" method="POST"
                                        class="js-delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="ap-link danger js-open-delete"
                                            data-title="{{ $prompt->titulo }}">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="ap-empty">
                                No se encontraron prompts con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($prompts->hasPages())
            <div class="ap-pager">
                {{ $prompts->links() }}
            </div>
        @endif
    </div>

    {{-- =========================
    MODAL ELIMINAR (Dark Premium)
    ========================= --}}
    <div class="pv-modal" id="deleteModal" aria-hidden="true">
        <div class="pv-modal__backdrop" data-close></div>

        <div class="pv-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="pvModalTitle">
            <div class="pv-modal__head">
                <div class="pv-modal__icon">!</div>
                <div>
                    <div class="pv-modal__title" id="pvModalTitle">Confirmar eliminación</div>
                    <div class="pv-modal__sub">Esta acción es irreversible.</div>
                </div>
                <button class="pv-modal__x" type="button" data-close aria-label="Cerrar">✕</button>
            </div>

            <div class="pv-modal__body">
                <p class="pv-modal__text">
                    ¿Seguro que quieres eliminar el prompt:
                    <span class="pv-modal__name" id="pvPromptName">—</span>?
                </p>
            </div>

            <div class="pv-modal__actions">
                <button type="button" class="pv-btn pv-btn-ghost" data-close>Cancelar</button>
                <button type="button" class="pv-btn pv-btn-danger" id="pvConfirmDelete">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('deleteModal');
            if (!modal) return;

            const nameEl = document.getElementById('pvPromptName');
            const btnConfirm = document.getElementById('pvConfirmDelete');

            let activeForm = null;

            function openModal(promptTitle, formEl) {
                activeForm = formEl;
                nameEl.textContent = promptTitle || 'este prompt';
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeModal() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                activeForm = null;
            }

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.js-open-delete');
                if (!btn) return;

                const form = btn.closest('form');
                const title = btn.getAttribute('data-title') || '';
                openModal(title, form);
            });

            modal.addEventListener('click', function (e) {
                if (e.target.hasAttribute('data-close')) closeModal();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            });

            btnConfirm.addEventListener('click', function () {
                if (activeForm) activeForm.submit();
            });
        })();
    </script>
@endsection