@extends('layouts.gerencia')

@section('content')
<style>
    .bg-dtl-navy { background-color: #0c192c !important; }
    .text-dtl-navy { color: #0c192c !important; }
    .border-dtl-green { border-top: 3.5px solid #059669 !important; }

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
    .kpi-emerald::before { background: #059669; }
    .kpi-navy::before    { background: #0c192c; }

    .executive-kpi-card:hover { transform: translateY(-3px); }
    .kpi-amber:hover   { box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.20) !important; border-color: #fde68a; }
    .kpi-emerald:hover { box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.20) !important; border-color: #a7f3d0; }
    .kpi-navy:hover    { box-shadow: 0 10px 20px -5px rgba(12, 25, 44, 0.18) !important; border-color: #bfdbfe; }

    .kpi-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .filter-toolbar-card {
        background: #ffffff;
        border: 1px solid #cbd5e1 !important;
        border-radius: 12px;
        padding: 0.75rem 1rem !important;
        box-shadow: 0 2px 8px rgba(12, 25, 44, 0.04);
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
    .segmented-btn:hover { color: #0c192c; background-color: #e2e8f0; }
    .segmented-btn.active {
        background-color: #0c192c !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(12, 25, 44, 0.25);
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
        background-color: #059669 !important;
        color: #ffffff !important;
        border: 1px solid #059669 !important;
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
        background-color: #047857 !important;
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

    .dtl-table thead th {
        background-color: #0c192c !important;
        color: #ffffff !important;
        font-size: 0.68rem !important;
        padding: 0.70rem 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-color: #1e293b !important;
        white-space: nowrap;
    }
    .dtl-table tbody td {
        font-size: 0.78rem !important;
        padding: 0.65rem 0.75rem !important;
        vertical-align: middle;
        border-color: #e2e8f0 !important;
    }

    /* BOTONES DE ACCIÓN PROFESIONALES */
    .btn-action-pro {
        height: 30px;
        padding: 0 10px;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease-in-out;
        border: 1px solid transparent;
        white-space: nowrap;
        text-decoration: none;
    }
    .btn-action-aceptar {
        background-color: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
    .btn-action-aceptar:hover {
        background-color: #059669;
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
        color: #0c192c;
        border-color: #cbd5e1;
        cursor: pointer;
    }
    .btn-action-pdf:hover {
        background-color: #0c192c;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(12, 25, 44, 0.20);
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 border-dtl-green" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-1 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="width: 130px; height: 46px; border-color: #cbd5e1 !important;">
                    <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER" style="max-height: 32px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="border-start ps-3" style="border-color: #e2e8f0 !important;">
                    <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase mb-1" style="background-color: #0c192c; color: #ffffff; font-size: 0.60rem;">
                        💼 GESTIÓN GERENCIAL
                    </span>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem; letter-spacing: -0.3px;">
                        Solicitudes de Aprobación de Cotizaciones
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TARJETAS KPI -->
    <div class="row g-3 mb-3">
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
        <div class="alert alert-success border-0 rounded-3 shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-circle-check text-success fs-6"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-triangle-exclamation text-danger fs-6"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- 3. BARRA DE CONTROL Y PESTAÑAS (TODAS, ENVIADA, ACEPTADA, RECHAZADA) -->
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
                        <div class="input-group search-responsive-box">
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
                        <div class="date-responsive-box">
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                                   class="form-control input-dtl-control" title="Fecha Desde">
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-xl-auto">
                        <div class="date-responsive-box">
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                                   class="form-control input-dtl-control" title="Fecha Hasta">
                        </div>
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
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
        <div class="overflow-x-auto">
            <table class="table table-bordered align-middle dtl-table w-100 mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 14%;">CÓDIGO</th>
                        <th style="width: 24%;">CLIENTE / PROYECTO</th>
                        <th class="text-end" style="width: 14%;">MONTO OFERTADO</th>
                        <th class="text-center" style="width: 10%;">DESCUENTO</th>
                        <th style="width: 14%;">SOLICITADO POR</th>
                        <th class="text-center" style="width: 10%;">ESTADO</th>
                        <th class="text-center pe-3" style="width: 14%;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotizaciones as $cot)
                        @php
                            $desc = $cot->porcentaje_descuento ?? 0;
                            $montoBaseObra = $cot->obra->monto ?? 0;
                            $esDescAlto = ($desc > 5.00);
                            $esEnviada = ($cot->estado_cotizacion === 'Enviada');
                        @endphp
                        <tr>
                            <td class="ps-3 font-monospace fw-bold text-dtl-navy">
                                {{ $cot->codigo_cotizacion }}
                                <small class="text-muted d-block font-sans-serif" style="font-size: 0.68rem; font-family: sans-serif;">
                                    {{ $cot->fecha_emision ? \Carbon\Carbon::parse($cot->fecha_emision)->format('d/m/Y') : '-' }}
                                </small>
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.80rem;">{{ $cot->obra->cliente->razon_social ?? 'Cliente General' }}</span>
                                <small class="text-muted d-block text-truncate" style="max-width: 280px; font-size: 0.70rem;">
                                    <i class="fas fa-building me-1"></i>{{ $cot->obra->titulo ?? 'Sin Obra' }}
                                </small>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold font-monospace text-dark" style="font-size: 0.86rem;">S/ {{ number_format($cot->monto_total, 2) }}</span>
                                @if($montoBaseObra > 0)
                                    <small class="text-muted d-block font-monospace" style="font-size: 0.65rem;">Base: S/ {{ number_format($montoBaseObra, 2) }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($esDescAlto)
                                    <span class="badge rounded-pill fw-bold px-2 py-0.5" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">-{{ number_format($desc, 1) }}%</span>
                                @else
                                    <span class="badge rounded-pill fw-semibold px-2 py-0.5 bg-light text-dark border">{{ number_format($desc, 1) }}%</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5">
                                    <i class="fas fa-user-circle text-muted"></i>
                                    <span class="fw-semibold text-secondary" style="font-size: 0.74rem;">{{ $cot->comercial->name ?? 'Asesor Comercial' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($cot->estado_cotizacion === 'Enviada')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                        <i class="fas fa-paper-plane me-0.5"></i> Enviada
                                    </span>
                                @elseif($cot->estado_cotizacion === 'Aceptada')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                        <i class="fas fa-check-circle me-0.5"></i> Aceptada
                                    </span>
                                @elseif($cot->estado_cotizacion === 'Rechazada')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                        <i class="fas fa-times-circle me-0.5"></i> Rechazada
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-2.5 py-1 bg-light text-dark border">{{ $cot->estado_cotizacion }}</span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    
                                    {{-- DETECCIÓN AUTOMÁTICA: SI ESTÁ 'ENVIADA', SE ACTIVAN ACEPTAR Y RECHAZAR --}}
                                    @if($esEnviada)
                                        <!-- Botón Aceptar y Firmar Digitalmente -->
                                        <form action="{{ route('gerencia.aprobaciones.aceptar', $cot->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Confirmar la aceptación y firma digital de la cotización {{ $cot->codigo_cotizacion }}? Esta acción quedará registrada en auditoría.');" 
                                                    class="btn btn-action-pro btn-action-aceptar" 
                                                    title="Firmar digitalmente y aceptar propuesta">
                                                <i class="fas fa-file-signature"></i> Aceptada
                                            </button>
                                        </form>

                                        <!-- Botón Rechazar con Modal de Motivo -->
                                        <button type="button" 
                                                class="btn btn-action-pro btn-action-rechazar btn-abrir-rechazo" 
                                                data-id="{{ $cot->id }}" 
                                                data-codigo="{{ $cot->codigo_cotizacion }}" 
                                                title="Rechazar Propuesta">
                                            <i class="fas fa-times"></i> Rechazada
                                        </button>
                                    @endif

                                    <!-- VISOR EMBEBIDO DE PDF -->
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
                            <td colspan="7" class="text-center py-5 text-muted small">
                                <i class="fas fa-clipboard-check text-muted fs-4 d-block mb-1"></i>
                                No se encontraron registros de cotización en esta sección.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cotizaciones->hasPages())
            <div class="d-flex justify-content-between align-items-center p-2.5 bg-light border-top">
                <small class="text-muted" style="font-size: 0.74rem;">Mostrando {{ $cotizaciones->firstItem() }} a {{ $cotizaciones->lastItem() }} de {{ $cotizaciones->total() }} registros</small>
                <div>{{ $cotizaciones->links('pagination::bootstrap-5') }}</div>
            </div>
        @endif
    </div>

</div>

<!-- MODAL VISOR DE PDF EN LA MISMA PANTALLA -->
<div class="modal fade" id="modalVisorPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="height: 90vh;">
        <div class="modal-content h-100 rounded-4 border-0 shadow">
            <div class="modal-header text-white py-2 px-3" style="background-color: #0c192c; border-bottom: 3.5px solid #059669;">
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

<!-- MODAL DE RECHAZO CON MOTIVO OBLIGATORIO PARA AUDITORÍA -->
<div class="modal fade" id="modalRechazo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white py-2 px-3" style="border-bottom: 3.5px solid #dc2626;">
                <h6 class="modal-title small fw-bold">Rechazar Cotización: <span id="codigoModal" class="font-monospace text-warning"></span></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRechazo" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-3" style="background-color: #f8fafc;">
                    <label class="form-label small fw-semibold text-dark mb-1">Motivo del rechazo gerencial <span class="text-danger">*</span></label>
                    <textarea name="motivo_rechazo" rows="3" class="form-control form-control-sm" required placeholder="Especifique el sustento del rechazo para auditoría..."></textarea>
                </div>
                <div class="modal-footer py-1.5 px-3 bg-white border-top">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-danger fw-bold">Confirmar Rechazo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function lanzarModalRechazo(id, codigo) {
        document.getElementById('codigoModal').innerText = codigo;
        document.getElementById('formRechazo').action = "{{ url('gerencia/aprobaciones') }}/" + id + "/rechazar";
        new bootstrap.Modal(document.getElementById('modalRechazo')).show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Asignación de evento para rechazar
        document.querySelectorAll('.btn-abrir-rechazo').forEach(function (btn) {
            btn.addEventListener('click', function () {
                lanzarModalRechazo(this.dataset.id, this.dataset.codigo);
            });
        });

        // Visor de PDF embebido
        var modalVisor = new bootstrap.Modal(document.getElementById('modalVisorPDF'));
        var iframePDF = document.getElementById('iframePDF');
        var pdfModalCodigo = document.getElementById('pdfModalCodigo');

        document.querySelectorAll('.btn-ver-pdf').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var url = this.dataset.url;
                var codigo = this.dataset.codigo;
                
                pdfModalCodigo.innerText = codigo;
                iframePDF.src = url;
                modalVisor.show();
            });
        });

        document.getElementById('modalVisorPDF').addEventListener('hidden.bs.modal', function () {
            iframePDF.src = '';
        });
    });
</script>
@endsection