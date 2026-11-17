@extends('layouts.soporte')

@section('content')
<!-- Estilos Exclusivos Estandarizados DTL PREMIER - Módulo Soporte / Políticas SLA & Monitoreo -->
<style>
    :root {
        --dtl-navy: #0f172a;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
    }

    .btn-dtl-action {
        height: 38px;
        padding: 0 16px;
        font-size: 0.88rem;
        font-weight: 700;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
    }

    .btn-dtl-primary {
        background-color: var(--dtl-green) !important;
        border: 1px solid var(--dtl-green) !important;
        color: #ffffff !important;
    }
    .btn-dtl-primary:hover {
        background-color: var(--dtl-green-hover) !important;
        border-color: var(--dtl-green-hover) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    .btn-dtl-dark {
        background-color: var(--dtl-navy) !important;
        border: 1px solid var(--dtl-navy) !important;
        color: #ffffff !important;
    }
    .btn-dtl-dark:hover {
        background-color: var(--dtl-navy-hover) !important;
        border-color: var(--dtl-navy-hover) !important;
        color: #ffffff !important;
    }

    .btn-dtl-icon-only {
        width: 38px;
        height: 38px;
        padding: 0;
    }

    .dtl-search-input:focus, .dtl-input:focus, .form-control:focus, .form-select:focus {
        border-color: var(--dtl-green) !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* Cabecera unificada y exacta para la tabla y formularios */
    .dtl-table-hover thead th, .dtl-card-header-styled {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
        text-transform: uppercase;
    }

    .dtl-table-hover thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    /* Filas optimizadas y compactas */
    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
        vertical-align: middle;
    }

    /* REDUCCIÓN PROPORCIONAL Y COMPACTA PARA RESOLUCIÓN DE CELULAR */
    @media (max-width: 767.98px) {
        .dtl-table-hover thead th {
            font-size: 0.52rem !important;
            padding: 0.35rem 0.25rem !important;
            letter-spacing: 0.2px !important;
        }
        .dtl-table-hover td {
            font-size: 0.62rem !important;
            padding: 0.35rem 0.35rem !important;
        }
        .dtl-table-hover td span, .dtl-table-hover td div {
            font-size: 0.62rem !important;
        }
        .container-fluid {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
    }

    .extra-small {
        font-size: 0.72rem;
    }

    .status-pulse-green {
        width: 7px;
        height: 7px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pulse-yellow {
        width: 7px;
        height: 7px;
        background-color: #f59e0b;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pulse-red {
        width: 7px;
        height: 7px;
        background-color: #ef4444;
        border-radius: 50%;
        display: inline-block;
    }

    /* Chips KPI de Estado */
    .kpi-chip {
        background-color: #ffffff;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px;
        padding: 0.38rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.76rem;
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL ESTANDARIZADO (SIN LOGO) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-traffic-light me-1" style="color: #10b981;"></i> BACK-OFFICE &bull; HU-08
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Monitoreo Semafórico en Vivo
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Configuración de Políticas SLA y Monitor Semafórico de Obras
            </h3>
        </div>
    </div>

    <!-- ALERTAS DEL SISTEMA -->
    @if (session('success'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check me-2 fs-5 flex-shrink-0" style="color: #059669;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-triangle-exclamation me-2 fs-5 flex-shrink-0" style="color: #dc2626;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('error') }}</div>
        </div>
    @endif

    <!-- 2. BARRA DE ACCIÓN Y RESUMEN KPI (FUERA DEL ENCABEZADO SUPERIOR) -->
    @php
        $totalObrasActivas = $obras->count();
        $cntCriticas = $obrasCriticas->count();
        $cntDemoradas = $obrasDemoradas->count();
        $cntControl = $totalObrasActivas - ($cntCriticas + $cntDemoradas);
    @endphp

    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                
                <!-- Chips KPI en línea -->
                <div class="d-flex align-items-center flex-wrap gap-1.5">
                    <span class="text-uppercase fw-bold text-secondary me-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                        <i class="fas fa-gauge-high me-1 text-primary"></i> Estado General:
                    </span>

                    <div class="kpi-chip" style="border-left: 3px solid #059669 !important;">
                        <span class="status-pulse-green"></span>
                        <span class="fw-semibold text-dark">Control:</span>
                        <span class="fw-bold font-monospace text-success">{{ $cntControl }}</span>
                    </div>

                    <div class="kpi-chip" style="border-left: 3px solid #f59e0b !important;">
                        <span class="status-pulse-yellow"></span>
                        <span class="fw-semibold text-dark">Inspección Demorada:</span>
                        <span class="fw-bold font-monospace" style="color: #b45309;">{{ $cntDemoradas }}</span>
                    </div>

                    <div class="kpi-chip" style="border-left: 3px solid #dc2626 !important;">
                        <span class="status-pulse-red"></span>
                        <span class="fw-semibold text-dark">Cotización Crítica:</span>
                        <span class="fw-bold font-monospace text-danger">{{ $cntCriticas }}</span>
                    </div>
                </div>

                <!-- Botón de Políticas SLA ubicado fuera de la cabecera -->
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <button type="button" class="btn btn-dtl-action btn-dtl-primary shadow-sm" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA" aria-expanded="false" aria-controls="panelPoliticasSLA" title="Configurar Políticas y Umbrales de SLA">
                        <i class="fas fa-sliders-h"></i>
                        <span>Configurar Políticas SLA</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO HORIZONTAL DINÁMICO COLAPSABLE: POLÍTICAS OFICIALES SLA -->
    <div class="collapse mb-3" id="panelPoliticasSLA">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header dtl-card-header-styled px-3 py-2 d-flex align-items-center justify-content-between" style="border-bottom: 3px solid #059669;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-sliders-h text-success"></i>
                    <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                        Configuración de Parámetros y Umbrales Oficiales de SLA
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA" aria-label="Close"></button>
            </div>

            <form action="{{ route('soporte.sla.actualizar') }}" method="POST">
                @csrf
                <div class="card-body p-2.5 p-md-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5 align-items-center">
                        
                        <!-- Umbral Visita -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark d-flex align-items-center gap-1">
                                <span class="status-pulse-yellow"></span>
                                <span>Umbral Inspección / Visita <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="visita_horas" class="form-control font-monospace fw-bold" 
                                       value="{{ $politicaVisita->tiempo_limite_horas }}" min="1" style="border-color: #cbd5e1;" required>
                                <span class="input-group-text bg-white text-muted" style="border-color: #cbd5e1; font-size: 0.75rem;">Horas</span>
                            </div>
                        </div>

                        <!-- Umbral Cotización -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark d-flex align-items-center gap-1">
                                <span class="status-pulse-red"></span>
                                <span>Umbral Cotización / Propuesta <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="cotiz_horas" class="form-control font-monospace fw-bold text-danger" 
                                       value="{{ $politicaCotiz->tiempo_limite_horas }}" min="1" style="border-color: #cbd5e1;" required>
                                <span class="input-group-text bg-white text-muted" style="border-color: #cbd5e1; font-size: 0.75rem;">Horas</span>
                            </div>
                        </div>

                        <!-- Correo Notificaciones -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">
                                <i class="fas fa-envelope text-secondary me-1"></i> Correo de Notificaciones <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email_notif" class="form-control form-control-sm" 
                                   value="{{ $politicaCotiz->email_notificacion }}" placeholder="soporte@dtlpremier.pe" style="border-color: #cbd5e1; font-size: 0.80rem;" required>
                        </div>

                        <!-- Switch Notificaciones -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark d-block">Despacho Automático</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="notificacion_activa" value="1" id="swNotif" {{ $politicaCotiz->notificacion_activa ? 'checked' : '' }} style="cursor: pointer;">
                                <label class="form-check-label extra-small fw-semibold text-dark" for="swNotif" style="cursor: pointer;">
                                    Alertas por email activas
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white px-3 py-2 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">Actualizar Políticas SLA</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA PRINCIPAL RESALTADA: MONITOR SEMAFÓRICO EN TIEMPO REAL -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-header dtl-card-header-styled px-3 py-2.5 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-bottom: 3px solid #059669;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-traffic-light text-warning"></i>
                <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                    Monitor Semafórico de Obras y Alertas Activas
                </h6>
            </div>

            <div class="d-flex align-items-center gap-1.5">
                <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                    {{ $cntCriticas }} Críticas
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                    {{ $cntDemoradas }} Demoradas
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    {{ $cntControl }} En Regla
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover w-100" style="min-width: 820px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2 fw-bold text-center text-uppercase" style="width: 12%;">SEMÁFORO</th>
                            <th class="py-2 fw-bold text-uppercase" style="width: 26%;">OBRA / EXPEDIENTE</th>
                            <th class="py-2 fw-bold text-uppercase" style="width: 24%;">CLIENTE CORPORATIVO</th>
                            <th class="py-2 fw-bold text-uppercase" style="width: 16%;">ASESOR ASIGNADO</th>
                            <th class="pe-3 py-2 fw-bold text-uppercase" style="width: 22%;">DIAGNÓSTICO OBJETIVO SLA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obras as $obra)
                            @php
                                $color = strtoupper($obra->sla['color'] ?? 'VERDE');
                            @endphp
                            <tr style="border-top: 1px solid #cbd5e1;">

                                <!-- 1. Semáforo / Badge -->
                                <td class="ps-3 text-center">
                                    @if($color === 'ROJO')
                                        <span class="badge rounded-pill fw-bold px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.68rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            <span class="status-pulse-red"></span> CRÍTICO
                                        </span>
                                    @elseif($color === 'AMARILLO')
                                        <span class="badge rounded-pill fw-bold px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.68rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                            <span class="status-pulse-yellow"></span> DEMORADO
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-bold px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.68rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <span class="status-pulse-green"></span> CONTROL
                                        </span>
                                    @endif
                                </td>

                                <!-- 2. Obra / Código / Estado Real Derivado de Registros -->
                                <td>
                                    <div class="fw-bold text-dark text-break" style="font-size: 0.79rem;" title="{{ $obra->titulo }}">
                                        {{ $obra->titulo }}
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-0.5">
                                        <span class="badge px-1.5 py-0.5 rounded-1 font-monospace" style="background-color: var(--dtl-navy); color: #34d399; font-size: 0.62rem; letter-spacing: 0.3px;">
                                            {{ $obra->codigo }}
                                        </span>
                                        <span class="text-secondary extra-small fw-semibold">&bull; {{ $obra->estado_real }}</span>
                                    </div>
                                </td>

                                <!-- 3. Cliente y RUC -->
                                <td>
                                    <div class="fw-bold text-dark text-uppercase text-break" style="font-size: 0.77rem;" title="{{ $obra->cliente->razon_social ?? 'S/C' }}">
                                        {{ $obra->cliente->razon_social ?? 'S/C - CLIENTE PARTICULAR' }}
                                    </div>
                                    @if(isset($obra->cliente->ruc))
                                        <div class="text-muted font-monospace" style="font-size: 0.68rem;">RUC: {{ $obra->cliente->ruc }}</div>
                                    @endif
                                </td>

                                <!-- 4. Asesor a Cargo -->
                                <td>
                                    <div class="d-flex align-items-center gap-1.5 text-dark fw-semibold" style="font-size: 0.77rem;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light border text-secondary" style="width: 22px; height: 22px; font-size: 0.65rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="text-break">{{ $obra->user->name ?? 'Sin Asignar' }}</span>
                                    </div>
                                </td>

                                <!-- 5. Diagnóstico Objetivo SLA -->
                                <td class="pe-3">
                                    @if($color === 'ROJO')
                                        <div class="p-1 px-2 rounded-2" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                                            <span class="fw-bold text-danger d-flex align-items-center gap-1 text-break" style="font-size: 0.74rem;">
                                                <i class="fas fa-triangle-exclamation flex-shrink-0"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @elseif($color === 'AMARILLO')
                                        <div class="p-1 px-2 rounded-2" style="background-color: #fffbeb; border: 1px solid #fde68a;">
                                            <span class="fw-bold d-flex align-items-center gap-1 text-break" style="color: #b45309; font-size: 0.74rem;">
                                                <i class="fas fa-clock flex-shrink-0"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @else
                                        <div class="p-1 px-2 rounded-2" style="background-color: #ecfdf5; border: 1px solid #a7f3d0;">
                                            <span class="fw-semibold d-flex align-items-center gap-1 text-break" style="color: #047857; font-size: 0.74rem;">
                                                <i class="fas fa-circle-check flex-shrink-0 text-success"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small">
                                    <i class="fas fa-clipboard-check d-block fs-2 mb-2 text-secondary opacity-50"></i>
                                    No existen solicitudes u obras activas en el pipeline comercial.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection