@extends('layouts.app')

@section('content')
<style>
    :root {
        --dtl-navy: #0f172a;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
    }

    /* SCROLL HORIZONTAL FORZADO (DERECHA E IZQUIERDA EN CELULAR) */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* TABLA FIJA QUE NO SE DESARMA NI SE TRANSFORMA EN LISTA */
    .dtl-pure-table {
        min-width: 900px !important; /* Fuerza deslizamiento lateral suave */
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th, .dtl-card-header-styled {
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
        white-space: nowrap !important;
    }

    .dtl-pure-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .extra-small {
        font-size: 0.73rem !important;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    .btn-floating-volver {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1050;
        background-color: var(--dtl-green);
        color: #ffffff !important;
        border: none;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4);
        font-weight: 700;
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-floating-volver:hover {
        background-color: var(--dtl-green-hover);
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    /* ==========================================================
       PAGINACIÓN: CÍRCULOS PERFECTOS EXACTOS A LA IMAGEN 1
    ========================================================== */
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

    /* Botón Circular Blanco (Inactivo y Flechas) */
    .dtl-pagination-wrapper .page-link {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important; /* Círculo perfecto */
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: var(--dtl-navy) !important; /* Número en azul oscuro */
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

    /* Botón Circular VERDE (Página Activa como el '2' de la foto) */
    .dtl-pagination-wrapper .page-item.active .page-link {
        background-color: var(--dtl-green) !important;
        border-color: var(--dtl-green) !important;
        color: #ffffff !important;
        box-shadow: 0 3px 8px rgba(5, 150, 105, 0.35) !important;
    }

    /* Flechas deshabilitadas */
    .dtl-pagination-wrapper .page-item.disabled .page-link {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-address-book me-1" style="color: #10b981;"></i> BITÁCORA CLIENTE 360°
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> RUC: {{ $cliente->ruc }}
                </span>
            </div>

            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                {{ $cliente->razon_social }}
            </h3>
        </div>
    </div>

    <!-- 2. DATOS GENERALES -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center" style="border-bottom: 3px solid #059669;">
            <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                Ficha General y Contacto Corporativo
            </h6>
        </div>
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Dirección Fiscal:</span>
                    <span class="text-dark fw-semibold" style="font-size: 0.82rem;">{{ $cliente->direccion ?: 'No registrada' }}</span>
                </div>
                <div class="col-12 col-md-3">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Contacto Principal:</span>
                    <span class="text-dark fw-semibold" style="font-size: 0.82rem;">{{ $cliente->nombre_contacto }} ({{ $cliente->telefono_contacto }})</span>
                </div>
                <div class="col-12 col-md-3">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Correo:</span>
                    <span class="text-dark fw-semibold" style="font-size: 0.82rem;">{{ $cliente->email_contacto }}</span>
                </div>
                <div class="col-12 col-md-2">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Asignado:</span>
                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.70rem;">{{ $cliente->user->name ?? 'Asesor CRM' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABLA CON SCROLL LATERAL PURO (DERECHA E IZQUIERDA EN MÓVIL) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 14%;">CÓDIGO OBRA</th>
                            <th style="width: 26%;">PROYECTO / OBRA</th>
                            <th class="text-center" style="width: 12%;">ESTADO OBRA</th>
                            <th style="width: 24%;">ACCIONES TÉCNICAS (INSPECCIONES)</th>
                            <th style="width: 24%;">PROPUESTAS ECONÓMICAS (COTIZACIONES)</th>
                            <th class="pe-3 text-center" style="width: 6%;">PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obras ?? $cliente->obras as $obra)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-green);">
                                    {{ $obra->codigo }}
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase d-block">{{ $obra->titulo }}</span>
                                    <span class="d-block text-success fw-bold extra-small mt-0.5">
                                        <i class="fas fa-coins me-1"></i>Total Cotizado: {{ $obra->monto_total_cotizado_formateado }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f1f5f9; color: var(--dtl-navy); border: 1px solid #cbd5e1;">
                                        {{ $obra->estado_real }}
                                    </span>
                                </td>
                                <td>
                                    @if($obra->inspecciones && $obra->inspecciones->count() > 0)
                                        <ul class="list-unstyled mb-0 extra-small">
                                            @foreach($obra->inspecciones as $insp)
                                                <li class="mb-1">
                                                    <i class="fas fa-clipboard-check text-success me-1"></i> 
                                                    <strong>{{ date('d/m/Y', strtotime($insp->fecha_inspeccion)) }}</strong> - Ing. {{ $insp->ingeniero_asignado }} 
                                                    <span class="badge bg-light text-dark border px-1" style="font-size: 0.55rem;">{{ $insp->estado_inspeccion }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted extra-small fst-italic">Sin inspecciones</span>
                                    @endif
                                </td>
                                <td>
                                    @if($obra->cotizaciones && $obra->cotizaciones->count() > 0)
                                        <ul class="list-unstyled mb-0 extra-small">
                                            @foreach($obra->cotizaciones as $cot)
                                                <li class="mb-1">
                                                    <i class="fas fa-file-invoice-dollar text-success me-1"></i> 
                                                    <strong>{{ $cot->codigo_cotizacion }}</strong> (S/ {{ number_format($cot->monto_total, 2) }}) 
                                                    <span class="badge bg-light text-dark border px-1" style="font-size: 0.55rem;">{{ $cot->estado_cotizacion }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted extra-small fst-italic">Sin cotizaciones</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-center">
                                    @if($obra->cotizaciones && $obra->cotizaciones->count() > 0)
                                        @php $ultimaCotizacion = $obra->cotizaciones->sortByDesc('id')->first(); @endphp
                                        <a href="{{ route('comercial.cotizador.pdf', $ultimaCotizacion->id) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-danger p-0 d-inline-flex align-items-center justify-content-center"
                                           style="width: 30px; height: 30px; border-radius: 8px;"
                                           title="Ver PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">&mdash;</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">Este cliente aún no registra proyectos u obras asociadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. PAGINACIÓN IDÉNTICA A LA IMAGEN 1 (< 1 2 >) -->
    @php
        $paginador = $obras ?? ($cliente->obras instanceof \Illuminate\Pagination\LengthAwarePaginator ? $cliente->obras : null);
    @endphp

    @if($paginador && $paginador->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                {{-- Botón Anterior (<) --}}
                @if ($paginador->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginador->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                {{-- Números de Página (1, 2, 3...) --}}
                @foreach ($paginador->getUrlRange(1, $paginador->lastPage()) as $page => $url)
                    @if ($page == $paginador->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Botón Siguiente (>) --}}
                @if ($paginador->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginador->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

    <!-- BOTÓN VOLVER -->
    <a href="{{ route('comercial.clientes.index') }}" class="btn-floating-volver" title="Volver al Directorio">
        <i class="fas fa-arrow-left"></i>
        <span>Volver</span>
    </a>

</div>
@endsection