@extends('layouts.gerencia')

@section('content')
<style>
    :root {
        --dtl-navy: #0f172a;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
    }

    .bg-dtl-navy { background-color: var(--dtl-navy) !important; }
    .text-dtl-navy { color: var(--dtl-navy) !important; }
    .border-dtl-green { border-top: 3.5px solid var(--dtl-green) !important; }

    /* TARJETAS KPI EJECUTIVAS */
    .executive-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.35rem;
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease-in-out;
    }
    .executive-kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3.5px;
    }
    .kpi-amber::before   { background: #f59e0b; }
    .kpi-emerald::before { background: var(--dtl-green); }
    .kpi-navy::before    { background: var(--dtl-navy); }

    .executive-kpi-card:hover { transform: translateY(-3px); }
    .kpi-amber:hover   { box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.20) !important; border-color: #fde68a; }
    .kpi-emerald:hover { box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.20) !important; border-color: #a7f3d0; }
    .kpi-navy:hover    { box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.18) !important; border-color: #cbd5e1; }

    .kpi-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .filter-toolbar-card {
        background: #ffffff;
        border: 1px solid #cbd5e1 !important;
        border-radius: 12px;
        padding: 0.75rem 1rem !important;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .segmented-control-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .segmented-control-wrapper::-webkit-scrollbar { display: none; }
    .segmented-control-group {
        background-color: #f1f5f9;
        padding: 3px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        gap: 2px;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .segmented-btn {
        height: 33px;
        padding: 0 13px;
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        border-radius: 7px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .segmented-btn:hover { color: var(--dtl-navy); background-color: #e2e8f0; }
    .segmented-btn.active {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.25);
    }

    .input-dtl-control {
        height: 36px !important;
        font-size: 0.82rem !important;
        border-color: #cbd5e1 !important;
        border-radius: 8px !important;
    }

    .btn-dtl-green {
        height: 36px !important;
        padding: 0 16px !important;
        font-size: 0.78rem !important;
        font-weight: 700 !important;
        background-color: var(--dtl-green) !important;
        color: #ffffff !important;
        border: 1px solid var(--dtl-green) !important;
        border-radius: 8px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.20);
        white-space: nowrap;
    }
    .btn-dtl-green:hover {
        background-color: var(--dtl-green-hover) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.30);
    }

    .btn-dtl-reset {
        height: 36px;
        width: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        border-radius: 8px;
        color: #64748b;
    }

    /* SCROLL HORIZONTAL TÁCTIL */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* TABLA FIJA EN ESCRITORIO */
    .dtl-pure-table {
        min-width: 950px !important;
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding: 0.65rem 0.75rem !important;
        text-transform: uppercase;
        white-space: nowrap !important;
    }

    .dtl-pure-table td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.65rem 0.75rem !important;
        vertical-align: middle !important;
    }

    .dtl-pure-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .btn-action-pro {
        height: 29px;
        padding: 0 9px;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease-in-out;
        border: 1px solid transparent;
        white-space: nowrap;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-action-aceptar {
        background-color: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
    .btn-action-aceptar:hover {
        background-color: var(--dtl-green);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(5, 150, 105, 0.25);
    }

    .btn-action-rechazar {
        background-color: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }
    .btn-action-rechazar:hover {
        background-color: #dc2626;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.25);
    }

    .btn-action-pdf {
        background-color: #f8fafc;
        color: var(--dtl-navy);
        border-color: #cbd5e1;
        cursor: pointer;
    }
    .btn-action-pdf:hover {
        background-color: var(--dtl-navy);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(15, 23, 42, 0.20);
    }

    /* PAGINACIÓN CIRCULAR */
    .dtl-pagination-wrapper {
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        width: 100% !important;
        margin-top: 15px !important;
        margin-bottom: 25px !important;
        padding-right: 6px !important;
    }

    .dtl-pagination-wrapper ul.pagination {
        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 8px !important;
        list-style: none !important;
        padding-left: 0 !important;
        margin: 0 !important;
    }

    .dtl-pagination-wrapper .page-item {
        display: inline-block !important;
        margin: 0 !important;
    }

    .dtl-pagination-wrapper .page-link {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: var(--dtl-navy) !important;
        font-weight: 700 !important;
        font-size: 0.88rem !important;
        text-decoration: none !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08) !important;
        transition: all 0.2s ease-in-out;
    }

    .dtl-pagination-wrapper .page-link:hover {
        background-color: #f1f5f9 !important;
        border-color: #94a3b8 !important;
        color: var(--dtl-navy) !important;
    }

    .dtl-pagination-wrapper .page-item.active .page-link {
        background-color: var(--dtl-green) !important;
        border-color: var(--dtl-green) !important;
        color: #ffffff !important;
        box-shadow: 0 3px 8px rgba(5, 150, 105, 0.35) !important;
    }

    .dtl-pagination-wrapper .page-item.disabled .page-link {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    /* ==========================================================
       TARJETA COMPACTA FLOTANTE CONTEXTUAL (SIN BLOQUEO PANTALLA)
    ========================================================== */
    .card-decision-popover {
        position: fixed;
        z-index: 1095;
        width: 325px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 18px 38px -6px rgba(15, 23, 42, 0.25), 0 4px 12px rgba(15, 23, 42, 0.08);
        border: 1px solid #cbd5e1;
        animation: popDecisionCard 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(8px);
        overflow: hidden;
    }
    @keyframes popDecisionCard {
        from { opacity: 0; transform: translateY(-8px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .input-error-dtl {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }
    .msg-error-dtl {
        font-size: 0.65rem;
        font-weight: 700;
        color: #dc2626;
        margin-top: 3px;
    }

    /* ==========================================================
       OPTIMIZACIÓN EXCLUSIVA PARA RESOLUCIÓN DE CELULAR
    ========================================================== */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .executive-kpi-card { padding: 0.85rem 1rem !important; }
        .executive-kpi-card h3 { font-size: 1.45rem !important; }
        .kpi-icon-box { width: 40px !important; height: 40px !important; font-size: 1.1rem !important; }

        .dtl-pure-table {
            min-width: 1280px !important;
        }

        .dtl-pure-table thead th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.65rem !important;
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
        }

        .col-mob-cod         { min-width: 135px !important; width: 135px !important; }
        .col-mob-cliente     { min-width: 380px !important; width: 380px !important; }
        .col-mob-monto       { min-width: 145px !important; width: 145px !important; }
        .col-mob-solicitado  { min-width: 165px !important; width: 165px !important; }
        .col-mob-estado      { min-width: 130px !important; width: 130px !important; }
        .col-mob-acciones    { min-width: 245px !important; width: 245px !important; }

        .btn-action-pro {
            height: 26px !important;
            font-size: 0.68rem !important;
            padding: 0 7px !important;
        }

        .card-decision-popover {
            width: 90% !important;
            left: 5% !important;
            right: 5% !important;
        }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    💼 GESTIÓN GERENCIAL
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Solicitudes y Dictámenes en Espera
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Solicitudes de Aprobación de Cotizaciones
            </h3>
        </div>
    </div>

    <!-- 2. TARJETAS KPI -->
    <div class="row g-2.5 mb-3">
        <div class="col-12 col-sm-4">
            <div class="executive-kpi-card kpi-amber shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.65rem;">Pendientes de Revisión</span>
                    <h3 class="fw-black text-dark mb-0 mt-1" style="font-size: 1.75rem;">{{ $metricas['pendientes_count'] ?? 0 }}</h3>
                    <small class="text-warning fw-bold d-block mt-0.5" style="font-size: 0.68rem;"><i class="fas fa-clock me-1"></i>Enviadas por comercial</small>
                </div>
                <div class="kpi-icon-box" style="background: #fffbeb; color: #f59e0b; border: 1px solid #fde68a;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="executive-kpi-card kpi-emerald shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.65rem;">Aceptadas y Firmadas</span>
                    <h3 class="fw-black text-dark mb-0 mt-1" style="font-size: 1.75rem; color: #047857;">{{ $metricas['aprobadas_count'] ?? 0 }}</h3>
                    <small class="text-success fw-bold d-block mt-0.5" style="font-size: 0.68rem;"><i class="fas fa-check-double me-1"></i>Listas para ejecución</small>
                </div>
                <div class="kpi-icon-box" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="executive-kpi-card kpi-navy shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 0.65rem;">Monto Total en Espera</span>
                    <h3 class="fw-black text-dark mb-0 mt-1 font-monospace" style="font-size: 1.65rem; color: #0c192c;">
                        S/ {{ number_format($metricas['pendientes_monto'] ?? 0, 2) }}
                    </h3>
                    <small class="text-primary fw-bold d-block mt-0.5" style="font-size: 0.68rem;"><i class="fas fa-shield-alt me-1"></i>Volumen presupuestado</small>
                </div>
                <div class="kpi-icon-box" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERTAS -->
    @if (session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check text-success fs-6"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-triangle-exclamation text-danger fs-6"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- 3. BARRA DE FILTROS -->
    <div class="card border-0 filter-toolbar-card mb-3">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.5px;">ESTADO:</span>
                <div class="segmented-control-wrapper">
                    <div class="segmented-control-group">
                        <a href="{{ route('gerencia.aprobaciones.index', array_merge(request()->query(), ['tab' => 'todas', 'page' => 1])) }}"
                           class="segmented-btn {{ ($tab ?? '') === 'todas' ? 'active' : '' }}">Todas</a>
                        
                        <a href="{{ route('gerencia.aprobaciones.index', array_merge(request()->query(), ['tab' => 'enviadas', 'page' => 1])) }}"
                           class="segmented-btn {{ ($tab ?? 'enviadas') === 'enviadas' ? 'active' : '' }}">
                            <i class="fas fa-paper-plane me-1 text-primary"></i> Enviada
                        </a>

                        <a href="{{ route('gerencia.aprobaciones.index', array_merge(request()->query(), ['tab' => 'aceptadas', 'page' => 1])) }}"
                           class="segmented-btn {{ ($tab ?? '') === 'aceptadas' ? 'active' : '' }}">
                            <i class="fas fa-check-circle me-1 text-success"></i> Aceptada
                        </a>

                        <a href="{{ route('gerencia.aprobaciones.index', array_merge(request()->query(), ['tab' => 'rechazadas', 'page' => 1])) }}"
                           class="segmented-btn {{ ($tab ?? '') === 'rechazadas' ? 'active' : '' }}">
                            <i class="fas fa-times-circle me-1 text-danger"></i> Rechazada
                        </a>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('gerencia.aprobaciones.index') }}" class="w-100 w-xl-auto">
                <input type="hidden" name="tab" value="{{ $tab ?? 'enviadas' }}">
                <div class="row g-2 align-items-center justify-content-xl-end">
                    <div class="col-12 col-md-6 col-xl-auto">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted px-2.5" style="border-color: #cbd5e1; height: 36px; border-radius: 8px 0 0 8px;">
                                <i class="fas fa-search" style="font-size: 0.75rem;"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" 
                                   class="form-control border-start-0 input-dtl-control" 
                                   placeholder="Quote ID, Cliente o RUC..." 
                                   style="border-radius: 0 8px 8px 0 !important;">
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-xl-auto">
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                               class="form-control input-dtl-control" title="Fecha Desde">
                    </div>

                    <div class="col-6 col-md-3 col-xl-auto">
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                               class="form-control input-dtl-control" title="Fecha Hasta">
                    </div>

                    <div class="col-12 col-md-auto col-xl-auto d-flex align-items-center justify-content-end gap-2">
                        <button type="submit" class="btn-dtl-green flex-grow-1 flex-xl-grow-0">
                            <i class="fas fa-filter"></i>
                            <span>Buscar</span>
                        </button>
                        @if(request()->filled('search') || request()->filled('fecha_desde') || request()->filled('fecha_hasta'))
                            <a href="{{ route('gerencia.aprobaciones.index', ['tab' => $tab ?? 'enviadas']) }}" 
                               class="btn-dtl-reset" title="Limpiar">
                                <i class="fas fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA DE COTIZACIONES -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 col-mob-cod" style="width: 14%;">CÓDIGO</th>
                            <th class="col-mob-cliente" style="width: 28%;">CLIENTE / PROYECTO</th>
                            <th class="text-end col-mob-monto" style="width: 15%;">MONTO OFERTADO</th>
                            <th class="col-mob-solicitado" style="width: 15%;">SOLICITADO POR</th>
                            <th class="text-center col-mob-estado" style="width: 11%;">ESTADO</th>
                            <th class="text-center pe-3 col-mob-acciones" style="width: 17%;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cot)
                            @php
                                $esEnviada = ($cot->estado_cotizacion === 'Enviada');
                                $clienteNombre = $cot->obra->cliente->razon_social ?? 'Cliente General';
                                $montoFormateado = number_format($cot->monto_total, 2);
                            @endphp
                            <tr>
                                <!-- CÓDIGO -->
                                <td class="ps-3 font-monospace fw-bold text-dtl-navy text-nowrap col-mob-cod">
                                    {{ $cot->codigo_cotizacion }}
                                    <small class="text-muted d-block font-monospace" style="font-size: 0.68rem;">
                                        {{ $cot->fecha_emision ? \Carbon\Carbon::parse($cot->fecha_emision)->format('d/m/Y') : '-' }}
                                    </small>
                                </td>

                                <!-- CLIENTE Y PROYECTO -->
                                <td class="col-mob-cliente">
                                    <span class="fw-bold text-dark d-block text-uppercase" style="font-size: 0.76rem; line-height: 1.25;">
                                        {{ $clienteNombre }}
                                    </span>
                                    <small class="text-muted d-block font-monospace" style="font-size: 0.68rem; line-height: 1.2;">
                                        <i class="fas fa-building me-1 opacity-75"></i>{{ $cot->obra->titulo ?? 'Sin Obra' }}
                                    </small>
                                </td>

                                <!-- MONTO -->
                                <td class="text-end font-monospace text-nowrap col-mob-monto">
                                    <span class="fw-bold text-dark" style="font-size: 0.78rem;">
                                        S/ {{ $montoFormateado }}
                                    </span>
                                </td>

                                <!-- ASESOR -->
                                <td class="text-nowrap col-mob-solicitado">
                                    <div class="d-flex align-items-center gap-1.5">
                                        <i class="fas fa-user-circle text-muted"></i>
                                        <span class="fw-semibold text-secondary" style="font-size: 0.74rem;">{{ $cot->comercial->name ?? 'Asesor Comercial' }}</span>
                                    </div>
                                </td>

                                <!-- ESTADO -->
                                <td class="text-center text-nowrap col-mob-estado">
                                    @if($cot->estado_cotizacion === 'Enviada')
                                        <span class="badge rounded-pill px-2 py-0.5 fw-semibold" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.62rem;">
                                            <i class="fas fa-paper-plane me-0.5"></i> Enviada
                                        </span>
                                    @elseif($cot->estado_cotizacion === 'Aceptada')
                                        <span class="badge rounded-pill px-2 py-0.5 fw-semibold" style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 0.62rem;">
                                            <i class="fas fa-check-circle me-0.5"></i> Aceptada
                                        </span>
                                    @elseif($cot->estado_cotizacion === 'Rechazada')
                                        <span class="badge rounded-pill px-2 py-0.5 fw-semibold" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.62rem;">
                                            <i class="fas fa-times-circle me-0.5"></i> Rechazada
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-2 py-0.5 bg-light text-dark border" style="font-size: 0.62rem;">{{ $cot->estado_cotizacion }}</span>
                                    @endif
                                </td>

                                <!-- ACCIONES -->
                                <td class="text-center pe-3 text-nowrap col-mob-acciones position-relative">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        @if($esEnviada)
                                            <!-- BOTÓN ACEPTADA (ABRE TARJETA COMPACTA DE FIRMA) -->
                                            <button type="button" 
                                                    class="btn btn-action-pro btn-action-aceptar" 
                                                    onclick="abrirTarjetaAceptacion(event, this, '{{ $cot->id }}', '{{ $cot->codigo_cotizacion }}', '{{ addslashes($clienteNombre) }}', '{{ $montoFormateado }}')"
                                                    title="Aceptar y firmar digitalmente">
                                                <i class="fas fa-file-signature"></i> Aceptada
                                            </button>

                                            <!-- BOTÓN RECHAZADA (ABRE TARJETA COMPACTA DE RECHAZO) -->
                                            <button type="button" 
                                                    class="btn btn-action-pro btn-action-rechazar" 
                                                    onclick="abrirTarjetaRechazo(event, this, '{{ $cot->id }}', '{{ $cot->codigo_cotizacion }}', '{{ addslashes($clienteNombre) }}')"
                                                    title="Rechazar con sustento técnico">
                                                <i class="fas fa-times"></i> Rechazada
                                            </button>
                                        @endif

                                        <button type="button" 
                                                class="btn btn-action-pro btn-action-pdf btn-ver-pdf"
                                                data-url="{{ route('comercial.cotizador.pdf', $cot->id) }}"
                                                data-codigo="{{ $cot->codigo_cotizacion }}"
                                                title="Visualizar Cotización PDF">
                                            <i class="fas fa-file-pdf text-danger"></i> Detalle
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">
                                    <i class="fas fa-clipboard-check text-muted fs-4 d-block mb-1"></i>
                                    No se encontraron registros de cotización en esta sección.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN CIRCULAR -->
    @if(isset($cotizaciones) && $cotizaciones->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                @if ($cotizaciones->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $cotizaciones->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                @foreach ($cotizaciones->getUrlRange(1, $cotizaciones->lastPage()) as $page => $url)
                    @if ($page == $cotizaciones->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($cotizaciones->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $cotizaciones->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>

<!-- =========================================================================
     TARJETA COMPACTA FLOTANTE 1: CONFIRMACIÓN Y FIRMA DIGITAL (ACEPTADA)
========================================================================= -->
<div id="popoverAceptacion" class="card-decision-popover d-none" onclick="event.stopPropagation();">
    <div class="py-2 px-2.5 text-white d-flex align-items-center justify-content-between" style="background-color: var(--dtl-green); border-bottom: 2px solid #047857;">
        <span class="fw-bold d-flex align-items-center gap-1.5" style="font-size: 0.72rem; letter-spacing: 0.3px;">
            <i class="fas fa-file-signature"></i> Firma Digital de Cotización
        </span>
        <button type="button" class="btn-close btn-close-white p-0" style="font-size: 0.50rem;" onclick="cerrarPopoversDecision()"></button>
    </div>

    <div class="p-2.5 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
            <span class="badge font-monospace text-white" id="popAceptarCodigo" style="background-color: var(--dtl-navy); font-size: 0.65rem;">-</span>
            <span class="font-monospace fw-bold text-success" id="popAceptarMonto" style="font-size: 0.76rem;">S/ 0.00</span>
        </div>

        <div class="text-dark fw-bold mb-1.5 text-truncate" id="popAceptarCliente" style="font-size: 0.72rem;">-</div>

        <p class="text-secondary mb-2" style="font-size: 0.68rem; line-height: 1.35;">
            ¿Desea formalizar la <strong class="text-success">aceptación gerencial</strong> y estampar su firma digital en esta cotización?
        </p>

        <form id="formAprobarCotizacionMaster" method="POST" action="" class="d-flex gap-1.5">
            @csrf
            @method('PATCH')
            <button type="button" class="btn btn-sm btn-light border w-50 py-1 fw-bold" style="font-size: 0.70rem;" onclick="cerrarPopoversDecision()">
                Cancelar
            </button>
            <button type="submit" id="btnSubmitAceptarPop" class="btn btn-sm btn-success w-50 py-1 fw-bold d-inline-flex align-items-center justify-content-center gap-1 shadow-sm" style="font-size: 0.70rem;">
                <i class="fas fa-check"></i> Firmar
            </button>
        </form>
    </div>
</div>

<!-- =========================================================================
     TARJETA COMPACTA FLOTANTE 2: SUSTENTO Y RECHAZO GERENCIAL (RECHAZADA)
========================================================================= -->
<div id="popoverRechazo" class="card-decision-popover d-none" onclick="event.stopPropagation();">
    <div class="py-2 px-2.5 text-white d-flex align-items-center justify-content-between" style="background-color: #dc2626; border-bottom: 2px solid #b91c1c;">
        <span class="fw-bold d-flex align-items-center gap-1.5" style="font-size: 0.72rem; letter-spacing: 0.3px;">
            <i class="fas fa-times-circle"></i> Dictamen de Rechazo
        </span>
        <button type="button" class="btn-close btn-close-white p-0" style="font-size: 0.50rem;" onclick="cerrarPopoversDecision()"></button>
    </div>

    <form id="formRechazarCotizacionMaster" method="POST" action="" onsubmit="return validarEnvioRechazo(event)">
        @csrf
        @method('PATCH')
        <div class="p-2.5 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                <span class="badge font-monospace text-white" id="popRechazoCodigo" style="background-color: var(--dtl-navy); font-size: 0.65rem;">-</span>
                <span class="text-danger fw-bold font-monospace" style="font-size: 0.65rem;">Estado: Rechazada</span>
            </div>

            <div class="text-dark fw-bold mb-1 text-truncate" id="popRechazoCliente" style="font-size: 0.72rem;">-</div>

            <label class="form-label text-muted fw-bold mb-0.5" style="font-size: 0.64rem;">Motivo / Sustento de Auditoría <span class="text-danger">*</span></label>
            <textarea name="motivo_rechazo" id="txtMotivoRechazoPop" rows="2" class="form-control form-control-sm" style="font-size: 0.70rem;" placeholder="Especifique la causa del rechazo..." oninput="limpiarErrorRechazo(this)"></textarea>
            <div id="msgErrorRechazoPop" class="msg-error-dtl d-none">
                <i class="fas fa-circle-exclamation me-0.5"></i> Ingrese al menos 5 caracteres de sustento.
            </div>

            <div class="d-flex gap-1.5 mt-2 pt-1 border-top">
                <button type="button" class="btn btn-sm btn-light border w-50 py-1 fw-bold" style="font-size: 0.70rem;" onclick="cerrarPopoversDecision()">
                    Cancelar
                </button>
                <button type="submit" id="btnSubmitRechazarPop" class="btn btn-sm btn-danger w-50 py-1 fw-bold d-inline-flex align-items-center justify-content-center gap-1 shadow-sm" style="font-size: 0.70rem;">
                    <i class="fas fa-ban"></i> Rechazar
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MODAL VISOR DE PDF OFICIAL -->
<div class="modal fade" id="modalVisorPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="height: 90vh;">
        <div class="modal-content h-100 rounded-4 border-0 shadow">
            <div class="modal-header text-white py-2 px-3" style="background-color: var(--dtl-navy); border-bottom: 3.5px solid var(--dtl-green);">
                <h6 class="modal-title fw-bold text-uppercase mb-0" style="font-size: 0.85rem;">
                    <i class="fas fa-file-pdf text-danger me-1"></i> Expediente Oficial PDF: <span id="pdfModalCodigo" class="text-success font-monospace"></span>
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="background-color: #525659;">
                <iframe id="iframePDF" src="" class="w-100 h-100 border-0" style="min-height: 550px;"></iframe>
            </div>
            <div class="modal-footer py-1.5 px-3 bg-white border-top d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Cierra cualquier tarjeta flotante activa
    function cerrarPopoversDecision() {
        const popAceptar = document.getElementById('popoverAceptacion');
        const popRechazo = document.getElementById('popoverRechazo');
        if (popAceptar) popAceptar.classList.add('d-none');
        if (popRechazo) popRechazo.classList.add('d-none');
    }

    // Posicionamiento inteligente flotante junto al botón que disparó la acción
    function posicionarTarjetaContextual(card, btnTrigger) {
        card.classList.remove('d-none');

        if (window.innerWidth < 768) {
            card.style.top = '50%';
            card.style.left = '50%';
            card.style.transform = 'translate(-50%, -50%)';
            return;
        }

        const rect = btnTrigger.getBoundingClientRect();
        const cardWidth = 325;
        const cardHeight = card.offsetHeight || 190;

        let top = rect.bottom + 6;
        let left = rect.right - cardWidth;

        // Ajuste si se sale de la pantalla
        if (top + cardHeight > window.innerHeight) {
            top = Math.max(10, rect.top - cardHeight - 6);
        }
        if (left < 15) {
            left = 15;
        }

        card.style.top = top + 'px';
        card.style.left = left + 'px';
        card.style.transform = 'none';
    }

    // 1. ABRIR TARJETA DE ACEPTACIÓN / FIRMA DIGITAL
    function abrirTarjetaAceptacion(ev, btn, id, codigo, cliente, monto) {
        ev.stopPropagation();
        cerrarPopoversDecision();

        document.getElementById('popAceptarCodigo').innerText = codigo;
        document.getElementById('popAceptarCliente').innerText = cliente;
        document.getElementById('popAceptarMonto').innerText = 'S/ ' + monto;

        const form = document.getElementById('formAprobarCotizacionMaster');
        form.action = "{{ url('gerencia/aprobaciones') }}/" + id + "/aceptar";

        const card = document.getElementById('popoverAceptacion');
        posicionarTarjetaContextual(card, btn);
    }

    // 2. ABRIR TARJETA DE RECHAZO GERENCIAL
    function abrirTarjetaRechazo(ev, btn, id, codigo, cliente) {
        ev.stopPropagation();
        cerrarPopoversDecision();

        document.getElementById('popRechazoCodigo').innerText = codigo;
        document.getElementById('popRechazoCliente').innerText = cliente;
        
        const txtMotivo = document.getElementById('txtMotivoRechazoPop');
        txtMotivo.value = '';
        limpiarErrorRechazo(txtMotivo);

        const form = document.getElementById('formRechazarCotizacionMaster');
        form.action = "{{ url('gerencia/aprobaciones') }}/" + id + "/rechazar";

        const card = document.getElementById('popoverRechazo');
        posicionarTarjetaContextual(card, btn);

        setTimeout(() => txtMotivo.focus(), 80);
    }

    // Validación inline al enviar el rechazo
    function validarEnvioRechazo(e) {
        const txt = document.getElementById('txtMotivoRechazoPop');
        const msg = document.getElementById('msgErrorRechazoPop');
        
        if (txt.value.trim().length < 5) {
            e.preventDefault();
            txt.classList.add('input-error-dtl');
            msg.classList.remove('d-none');
            txt.focus();
            return false;
        }

        const btn = document.getElementById('btnSubmitRechazarPop');
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Procesando...`;
        return true;
    }

    function limpiarErrorRechazo(el) {
        el.classList.remove('input-error-dtl');
        const msg = document.getElementById('msgErrorRechazoPop');
        if (msg) msg.classList.add('d-none');
    }

    // Cierra las tarjetas si se hace clic en cualquier parte fuera de ellas
    document.addEventListener('click', function () {
        cerrarPopoversDecision();
    });

    // Visor de PDF
    document.addEventListener('DOMContentLoaded', function () {
        var modalVisor = new bootstrap.Modal(document.getElementById('modalVisorPDF'));
        var iframePDF = document.getElementById('iframePDF');
        var pdfModalCodigo = document.getElementById('pdfModalCodigo');

        document.querySelectorAll('.btn-ver-pdf').forEach(function (btn) {
            btn.addEventListener('click', function () {
                pdfModalCodigo.innerText = this.dataset.codigo;
                iframePDF.src = this.dataset.url;
                modalVisor.show();
            });
        });

        document.getElementById('modalVisorPDF').addEventListener('hidden.bs.modal', function () {
            iframePDF.src = '';
        });
    });
</script>
@endsection