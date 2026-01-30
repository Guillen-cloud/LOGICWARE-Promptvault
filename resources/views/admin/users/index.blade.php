@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')

    <style>
        /* ====== Layout grande ====== */
        .page-wrap {
            width: 100%;
            max-width: 1400px;
            /* más ancho */
            margin: 0 auto;
        }

        /* ====== Card / Panel ====== */
        .card {
            border-radius: 18px;
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .10);
            box-shadow: 0 24px 70px rgba(0, 0, 0, .45);
            overflow: hidden;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: linear-gradient(90deg, rgba(99, 102, 241, .14), rgba(168, 85, 247, .10));
        }

        .card-title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .card-title h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: rgba(255, 255, 255, .95);
            letter-spacing: -.2px;
        }

        .card-title p {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, .65);
            font-weight: 700;
        }

        /* ====== Search ====== */
        .searchbar {
            display: flex;
            gap: 10px;
            align-items: center;
            min-width: 360px;
            width: min(520px, 100%);
        }

        .searchbar input {
            width: 100%;
            padding: 11px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(8, 12, 22, .75);
            color: rgba(255, 255, 255, .92);
            outline: none;
            font-weight: 700;
        }

        .searchbar input::placeholder {
            color: rgba(255, 255, 255, .45);
        }

        .searchbar input:focus {
            border-color: rgba(99, 102, 241, .35);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
        }

        .btn {
            padding: 11px 14px;
            border-radius: 14px;
            font-weight: 900;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .90);
            cursor: pointer;
            transition: transform .12s ease, background .12s ease, border-color .12s ease;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .08);
        }

        .btn-primary {
            background: linear-gradient(90deg, rgba(99, 102, 241, .95), rgba(168, 85, 247, .92));
            border-color: rgba(255, 255, 255, .16);
            box-shadow: 0 16px 44px rgba(99, 102, 241, .18);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 1), rgba(168, 85, 247, 1));
        }

        /* ====== Table ====== */
        .table-wrap {
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 980px;
            /* hace que se vea grande y consistente */
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            text-align: left;
            font-size: 11px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .65);
            font-weight: 900;
            padding: 12px 16px;
            background: rgba(8, 12, 22, .65);
            border-bottom: 1px solid rgba(255, 255, 255, .10);
            backdrop-filter: blur(6px);
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .86);
            font-weight: 700;
            vertical-align: middle;
            font-size: 13px;
        }

        tbody tr:hover td {
            background: rgba(255, 255, 255, .03);
        }

        .muted {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            color: rgba(255, 255, 255, .55);
            font-weight: 700;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .04);
            color: rgba(255, 255, 255, .78);
            font-weight: 900;
            font-size: 12px;
            white-space: nowrap;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .link-btn {
            padding: 8px 10px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .04);
            color: rgba(255, 255, 255, .86);
            text-decoration: none;
            font-weight: 900;
            font-size: 12px;
            transition: transform .12s ease, background .12s ease, border-color .12s ease;
        }

        .link-btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .06);
        }

        .link-btn--edit {
            border-color: rgba(59, 130, 246, .22);
        }

        .link-btn--delete {
            border-color: rgba(248, 113, 113, .22);
            color: rgba(248, 113, 113, .95);
        }

        /* ====== Footer ====== */
        .card-foot {
            padding: 14px 18px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            justify-content: flex-end;
        }

        /* ====== Empty ====== */
        .empty {
            padding: 22px;
            text-align: center;
            color: rgba(255, 255, 255, .70);
            font-weight: 800;
        }

        @media (max-width: 780px) {
            .card-head {
                flex-direction: column;
                align-items: stretch;
            }

            .searchbar {
                min-width: 0;
                width: 100%;
            }
        }
    </style>

    <div class="page-wrap">
        <div class="card">
            <div class="card-head">
                <div class="card-title">
                    <h2>Usuarios</h2>
                    <p>Administra usuarios: búsqueda, edición y eliminación.</p>
                </div>

                <form method="GET" action="{{ route('admin.users.index') }}" class="searchbar">
                    <input type="search" name="q" value="{{ $q ?? request('q') }}" placeholder="Buscar por nombre o email…">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Registro</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                    <span class="muted">ID: {{ $user->id }}</span>
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <span class="chip">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </span>
                                    <span class="muted">{{ $user->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="link-btn link-btn--edit" href="{{ route('admin.users.edit', $user) }}">
                                            Editar
                                        </a>

                                        <button type="button" class="link-btn link-btn--delete" data-delete-id="{{ $user->id }}"
                                            data-delete-name="{{ $user->name }}" onclick="openUserDeleteModal(this)">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty">
                                    No se encontraron usuarios con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="card-foot">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('admin.users.delete-modal')

@endsection