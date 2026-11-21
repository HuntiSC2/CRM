@extends('layouts.soporte')

@section('content')
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

    .extra-small {
        font-size: 0.72rem;
    }

    .status-pulse-green, .status-pulse-yellow, .status-pulse-red {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .status-pulse-green { background-color: #10b981; }
    .status-pulse-yellow { background-color: #f59e0b; }
    .status-pulse-red { background-color: #ef4444; }

    /* CHIPS KPI CON ESPACIADO PROPORCIONAL */
    .sla-kpi-chip {
        background-color: #ffffff;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.76rem;
        white-space: nowrap !important;
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

    /* ==========================================================
       OPTIMIZACIÓN EXCLUSIVA PARA RESOLUCIÓN DE CELULAR
    ========================================================== */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .sla-kpi-container {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 0.4rem !important;
            width: 100% !important;
        }
        .sla-kpi-chip {
            justify-content: space-between !important;
            width: 100% !important;
            padding: 0.4rem 0.65rem !important;
        }
        .sla-toolbar-actions {
            width: 100% !important;
            margin-top: 0.4rem !important;
        }
        .sla-toolbar-actions .btn {
            width: 100% !important;
        }

        /* 1. Ancho total de 1350px para dar espacio completo al diagnóstico */
        .dtl-pure-table {
            min-width: 1350px !important;
        }

        /* 2. Reducción vertical drástica de altura de celdas */
        .dtl-pure-table thead th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.65rem !important;
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
        }

        /* 3. Anchos generosos por columna */
        .col-mob-semaforo { min-width: 135px !important; width: 135px !important; }
        .col-mob-obra     { min-width: 380px !important; width: 380px !important; }
        .col-mob-cliente  { min-width: 280px !important; width: 280px !important; }
        .col-mob-asesor   { min-width: 180px !important; width: 180px !important; }
        .col-mob-diag     { min-width: 380px !important; width: 380px !important; }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-traffic-light me-1" style="color: #10b981;"></i> BACK-OFFICE &bull; HU-08
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    Monitoreo Semafórico en Vivo
                </span>
            </div>
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Configuración de Políticas SLA y Monitor Semafórico de Obras
            </h3>
        </div>
    </div>

    <!-- ALERTAS -->
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

    <!-- 2. BARRA DE ESTADO / KPI -->
    @php
        $totalObrasActivas = $obras->count();
        $cntCriticas = $obrasCriticas->count();
        $cntDemoradas = $obrasDemoradas->count();
        $cntControl = $totalObrasActivas - ($cntCriticas + $cntDemoradas);
    @endphp

    <div class="card border-0 shadow-sm rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                
                <div class="sla-kpi-container d-flex align-items-center flex-wrap gap-2">
                    <span class="text-uppercase fw-bold text-secondary me-1 d-none d-lg-inline" style="font-size: 0.70rem;">
                        <i class="fas fa-gauge-high me-1 text-primary"></i> Estado General:
                    </span>

                    <div class="sla-kpi-chip" style="border-left: 3px solid #059669 !important;">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="status-pulse-green"></span>
                            <span class="fw-semibold text-dark">Control:</span>
                        </div>
                        <span class="fw-bold font-monospace text-success ms-2">{{ $cntControl }}</span>
                    </div>

                    <div class="sla-kpi-chip" style="border-left: 3px solid #f59e0b !important;">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="status-pulse-yellow"></span>
                            <span class="fw-semibold text-dark">Inspección Demorada:</span>
                        </div>
                        <span class="fw-bold font-monospace ms-2" style="color: #b45309 !important;">{{ $cntDemoradas }}</span>
                    </div>

                    <div class="sla-kpi-chip" style="border-left: 3px solid #dc2626 !important;">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="status-pulse-red"></span>
                            <span class="fw-semibold text-dark">Cotización Crítica:</span>
                        </div>
                        <span class="fw-bold font-monospace text-danger ms-2">{{ $cntCriticas }}</span>
                    </div>
                </div>

                <div class="sla-toolbar-actions ms-auto">
                    <button type="button" class="btn btn-dtl-action btn-dtl-primary shadow-sm" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA" aria-expanded="false">
                        <i class="fas fa-sliders-h"></i>
                        <span>Configurar Políticas SLA</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. CONFIGURADOR DE POLÍTICAS -->
    <div class="collapse mb-3" id="panelPoliticasSLA">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header px-3 py-2 d-flex align-items-center justify-content-between" style="background-color: var(--dtl-navy); border-bottom: 3px solid #059669;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-sliders-h text-success"></i>
                    <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                        Configuración de Parámetros y Umbrales Oficiales de SLA
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA"></button>
            </div>

            <form action="{{ route('soporte.sla.actualizar') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Umbral Inspección (Horas) *</label>
                            <input type="number" name="visita_horas" class="form-control form-control-sm font-monospace fw-bold" 
                                   value="{{ $politicaVisita->tiempo_limite_horas }}" min="1" required>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Umbral Cotización (Horas) *</label>
                            <input type="number" name="cotiz_horas" class="form-control form-control-sm font-monospace fw-bold text-danger" 
                                   value="{{ $politicaCotiz->tiempo_limite_horas }}" min="1" required>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Correo Notificaciones *</label>
                            <input type="email" name="email_notif" class="form-control form-control-sm" 
                                   value="{{ $politicaCotiz->email_notificacion }}" required>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark d-block">Despacho Automático</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="notificacion_activa" value="1" id="swNotif" {{ $politicaCotiz->notificacion_activa ? 'checked' : '' }}>
                                <label class="form-check-label extra-small fw-semibold text-dark" for="swNotif">Alertas activas</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white px-3 py-2 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#panelPoliticasSLA">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">Actualizar Políticas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA CON SCROLL LATERAL Y ALTO MÍNIMO -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-header px-3 py-2.5 d-flex align-items-center justify-content-between" style="background-color: var(--dtl-navy); border-bottom: 3px solid #059669;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-traffic-light text-warning"></i>
                <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                    Monitor Semafórico de Obras y Alertas Activas
                </h6>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 text-center col-mob-semaforo" style="width: 12%;">SEMÁFORO</th>
                            <th class="col-mob-obra" style="width: 28%;">OBRA / EXPEDIENTE</th>
                            <th class="col-mob-cliente" style="width: 24%;">CLIENTE CORPORATIVO</th>
                            <th class="col-mob-asesor" style="width: 16%;">ASESOR ASIGNADO</th>
                            <th class="pe-3 col-mob-diag" style="width: 20%;">DIAGNÓSTICO OBJETIVO SLA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obras as $obra)
                            @php
                                $color = strtoupper($obra->sla['color'] ?? 'VERDE');
                            @endphp
                            <tr>
                                <!-- SEMÁFORO -->
                                <td class="ps-3 text-center text-nowrap col-mob-semaforo">
                                    @if($color === 'ROJO')
                                        <span class="badge rounded-pill fw-bold px-2 py-0.5 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.62rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            <span class="status-pulse-red"></span> CRÍTICO
                                        </span>
                                    @elseif($color === 'AMARILLO')
                                        <span class="badge rounded-pill fw-bold px-2 py-0.5 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.62rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                            <span class="status-pulse-yellow"></span> DEMORADO
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-bold px-2 py-0.5 d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.62rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <span class="status-pulse-green"></span> CONTROL
                                        </span>
                                    @endif
                                </td>

                                <!-- OBRA / EXPEDIENTE (COMPLETO) -->
                                <td class="col-mob-obra">
                                    <div class="fw-bold text-dark" style="font-size: 0.76rem; line-height: 1.25;">
                                        {{ $obra->titulo }}
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-0.5 font-monospace">
                                        <span class="badge px-1.5 py-0.2 rounded-1" style="background-color: var(--dtl-navy); color: #34d399; font-size: 0.60rem;">
                                            {{ $obra->codigo }}
                                        </span>
                                        <span class="text-secondary extra-small fw-semibold" style="font-size: 0.65rem;">&bull; {{ $obra->estado_real }}</span>
                                    </div>
                                </td>

                                <!-- CLIENTE -->
                                <td class="col-mob-cliente">
                                    <div class="fw-bold text-dark text-uppercase" style="font-size: 0.76rem; line-height: 1.25;">
                                        {{ $obra->cliente->razon_social ?? 'S/C - CLIENTE PARTICULAR' }}
                                    </div>
                                    @if(isset($obra->cliente->ruc))
                                        <div class="text-muted font-monospace" style="font-size: 0.66rem; line-height: 1.2;">RUC: {{ $obra->cliente->ruc }}</div>
                                    @endif
                                </td>

                                <!-- ASESOR -->
                                <td class="text-nowrap col-mob-asesor">
                                    <div class="d-flex align-items-center gap-1 text-dark fw-semibold" style="font-size: 0.74rem;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light border text-secondary" style="width: 20px; height: 20px; font-size: 0.60rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span>{{ $obra->user->name ?? 'Sin Asignar' }}</span>
                                    </div>
                                </td>

                                <!-- DIAGNÓSTICO OBJETIVO SLA (COMPLETO A LO ANCHO) -->
                                <td class="pe-3 col-mob-diag">
                                    @if($color === 'ROJO')
                                        <div class="py-0.5 px-2 rounded-2" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                                            <span class="fw-bold text-danger d-flex align-items-center gap-1" style="font-size: 0.70rem; line-height: 1.3;">
                                                <i class="fas fa-triangle-exclamation flex-shrink-0"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @elseif($color === 'AMARILLO')
                                        <div class="py-0.5 px-2 rounded-2" style="background-color: #fffbeb; border: 1px solid #fde68a;">
                                            <span class="fw-bold d-flex align-items-center gap-1" style="color: #b45309; font-size: 0.70rem; line-height: 1.3;">
                                                <i class="fas fa-clock flex-shrink-0"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @else
                                        <div class="py-0.5 px-2 rounded-2" style="background-color: #ecfdf5; border: 1px solid #a7f3d0;">
                                            <span class="fw-semibold d-flex align-items-center gap-1" style="color: #047857; font-size: 0.70rem; line-height: 1.3;">
                                                <i class="fas fa-circle-check flex-shrink-0 text-success"></i>
                                                <span>{{ $obra->sla['mensaje'] }}</span>
                                            </span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    No existen solicitudes u obras activas en el pipeline comercial.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN CIRCULAR -->
    @if(isset($obras) && method_exists($obras, 'links') && $obras->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                @if ($obras->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $obras->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                @foreach ($obras->getUrlRange(1, $obras->lastPage()) as $page => $url)
                    @if ($page == $obras->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($obras->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $obras->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection