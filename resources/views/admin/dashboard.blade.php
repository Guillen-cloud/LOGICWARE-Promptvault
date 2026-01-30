@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dash-wrap {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .dash-hero {
            padding: 18px;
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .10);
            background:
                radial-gradient(900px 300px at 15% 0%, rgba(168, 85, 247, .18), transparent 60%),
                radial-gradient(700px 260px at 60% 10%, rgba(99, 102, 241, .16), transparent 60%),
                linear-gradient(180deg, rgba(12, 21, 40, .88), rgba(8, 14, 28, .72));
            box-shadow: 0 22px 70px rgba(0, 0, 0, .55);
        }

        .dash-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .dash-hero h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -.4px;
        }

        .dash-hero p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, .65);
            font-weight: 700;
            font-size: 13px;
            line-height: 1.5;
            max-width: 720px;
        }

        .dash-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            appearance: none;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .88);
            padding: 10px 12px;
            border-radius: 14px;
            font-weight: 900;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: transform .15s ease, background .15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .09);
        }

        .btn-primary {
            background: linear-gradient(90deg, rgba(99, 102, 241, .95), rgba(168, 85, 247, .92));
            border-color: rgba(255, 255, 255, .12);
            box-shadow: 0 16px 46px rgba(99, 102, 241, .18);
        }

        .btn-primary:hover {
            opacity: .97;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 720px) {
            .kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1100px) {
            .kpi-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .kpi {
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .04);
            padding: 14px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, .30);
        }

        .kpi-ico {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            flex: 0 0 auto;
        }

        .kpi-label {
            font-size: 12px;
            font-weight: 900;
            color: rgba(255, 255, 255, .62);
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .kpi-value {
            margin-top: 4px;
            font-size: 22px;
            font-weight: 900;
            color: rgba(255, 255, 255, .95);
        }

        .dash-panels {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width: 980px) {
            .dash-panels {
                grid-template-columns: 2fr 1fr;
                align-items: start;
            }
        }

        .panel {
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: linear-gradient(180deg, rgba(12, 21, 40, .88), rgba(8, 14, 28, .72));
            box-shadow: 0 22px 70px rgba(0, 0, 0, .55);
            overflow: hidden;
        }

        .panel-head {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .panel-head h3 {
            margin: 0;
            font-size: 13px;
            font-weight: 900;
            color: rgba(255, 255, 255, .70);
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .panel-body {
            padding: 16px;
        }

        .muted {
            color: rgba(255, 255, 255, .65);
            font-weight: 700;
            font-size: 13px;
            line-height: 1.6;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
            font-weight: 900;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(34, 197, 94, .95);
            box-shadow: 0 0 0 6px rgba(34, 197, 94, .12);
        }

        .quick-list {
            margin: 0;
            padding-left: 16px;
            color: rgba(255, 255, 255, .75);
            font-weight: 700;
            font-size: 13px;
            line-height: 1.7;
        }
    </style>

    <div class="dash-wrap">

        <section class="dash-hero">
            <div class="dash-hero-top">
                <div>
                    <h2>Bienvenido, {{ Auth::user()->name }}</h2>
                    <p>Administra usuarios, prompts y categorías con un panel premium oscuro. Este dashboard muestra
                        métricas clave y accesos rápidos.</p>
                </div>

                <!--<div class="dash-actions">
                        <a class="btn" href="{{ route('admin.prompts.index') }}">Export data</a>
                        <a class="btn btn-primary" href="{{ route('admin.prompts.index') }}">Create report</a>
                    </div>-->
            </div>

            <div style="margin-top: 14px;" class="kpi-grid">
                <div class="kpi">
                    <div class="kpi-ico" style="box-shadow: 0 0 0 6px rgba(99,102,241,.10);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            style="color: rgba(255,255,255,.9)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 8v6M23 11h-6" />
                        </svg>
                    </div>
                    <div>
                        <div class="kpi-label">Total de usuarios</div>
                        <div class="kpi-value">{{ number_format($stats['total_users']) }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-ico" style="box-shadow: 0 0 0 6px rgba(34,197,94,.10);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            style="color: rgba(255,255,255,.9)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="kpi-label">Total de prompts</div>
                        <div class="kpi-value">{{ number_format($stats['total_prompts']) }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-ico" style="box-shadow: 0 0 0 6px rgba(168,85,247,.10);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            style="color: rgba(255,255,255,.9)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <div class="kpi-label">Categorías</div>
                        <div class="kpi-value">{{ number_format($stats['total_categories']) }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-ico" style="box-shadow: 0 0 0 6px rgba(6,182,212,.10);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            style="color: rgba(255,255,255,.9)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0 3.866-3.582 7-8 7a9.77 9.77 0 01-2-.2L4 16m8-5c0-3.866 3.582-7 8-7a9.77 9.77 0 012 .2L20 6m-8 5v10m0 0l3-3m-3 3l-3-3" />
                        </svg>
                    </div>
                    <div>
                        <div class="kpi-label">Prompts públicos</div>
                        <div class="kpi-value">{{ number_format($stats['public_prompts']) }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="dash-panels">
            <div class="panel">
                <div class="panel-head">
                    <h3>Resumen del panel</h3>
                    <span class="badge"><span class="dot"></span> Sistema activo</span>
                </div>
                <div class="panel-body">
                    <p class="muted">
                        Desde aquí puedes gestionar todos los aspectos de PromptVault. Usa el menú lateral para navegar por
                        las secciones
                        principales. Este panel está diseñado con estética dark premium.
                    </p>

                    <div style="margin-top:12px; display:grid; grid-template-columns: 1fr; gap:10px;">
                        <div class="panel" style="box-shadow:none; background: rgba(255,255,255,.04); border-radius:18px;">
                            <div class="panel-body">
                                <div style="font-weight:900; color: rgba(255,255,255,.88);">Sugerencia</div>
                                <div class="muted" style="margin-top:6px;">
                                    Agrega módulos adicionales: Usuarios, Categorías, Etiquetas, Auditoría y Reportes.
                                </div>
                            </div>
                        </div>

                        <div class="panel" style="box-shadow:none; background: rgba(255,255,255,.04); border-radius:18px;">
                            <div class="panel-body">
                                <div style="font-weight:900; color: rgba(255,255,255,.88);">Acción rápida</div>
                                <div class="muted" style="margin-top:6px;">
                                    Revisa la lista de prompts para moderar públicos o ajustar categorías.
                                </div>
                                <div style="margin-top:10px;">
                                    <a class="btn btn-primary" href="{{ route('admin.prompts.index') }}">Ir a Prompts</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h3>Atajos</h3>
                    <span class="badge" style="border-color: rgba(168,85,247,.22); background: rgba(168,85,247,.10);">
                        <span class="dot"
                            style="background: rgba(168,85,247,.95); box-shadow: 0 0 0 6px rgba(168,85,247,.12);"></span>
                        Recomendado
                    </span>
                </div>
                <div class="panel-body">
                    <ul class="quick-list">
                        <li>Gestiona prompts públicos y privados.</li>
                        <li>Revisa usuarios y controla accesos.</li>
                        <li>Organiza categorías para mantener orden.</li>
                    </ul>
                </div>
            </div>
        </section>

    </div>
@endsection