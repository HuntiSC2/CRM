@extends('layouts.app')

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

    .dtl-search-input:focus, .form-control:focus, .form-select:focus {
        border-color: var(--dtl-green) !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-search-input::placeholder {
        color: #94a3b8 !important;
        font-size: 0.82rem;
    }

    /* SCROLL HORIZONTAL TÁCTIL (DERECHA E IZQUIERDA EN MÓVIL) */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* TABLA FIJA QUE NO SE DESARMA NI SE VUELVE LISTA */
    .dtl-pure-table {
        min-width: 900px !important;
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

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
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

    /* Botón Circular VERDE (Página Activa) */
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
                    <i class="fas fa-clipboard-check me-1" style="color: #10b981;"></i> GESTIÓN TÉCNICA
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Auditoría de Inspecciones & Campo
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Control y Seguimiento de Inspecciones Técnicas
            </h3>
        </div>
    </div>

    <!-- ALERTAS -->
    @if (session('success'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check me-2 fs-5 flex-shrink-0" style="color: var(--dtl-green);"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-triangle-exclamation me-2 fs-5 flex-shrink-0" style="color: #dc2626;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('error') }}</div>
        </div>
    @endif

    <!-- 2. BÚSQUEDA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('comercial.visitas.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por Obra, Ingeniero, Cliente..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('comercial.visitas.index') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- 3. TABLA CON SCROLL LATERAL (DERECHA / IZQUIERDA EN MÓVIL) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 12%;">ID</th>
                            <th style="width: 26%;">OBRA / PROYECTO</th>
                            <th style="width: 20%;">INGENIERO ASIGNADO</th>
                            <th class="text-center" style="width: 14%;">FECHA VISITA</th>
                            <th style="width: 18%;">RESULTADO / DICTAMEN</th>
                            <th class="pe-3 text-center" style="width: 10%;">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inspecciones ?? [] as $inspeccion)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold text-nowrap" style="color: var(--dtl-navy); font-size: 0.78rem;">
                                    #INS-{{ str_pad($inspeccion->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 0.78rem;">
                                        {{ $inspeccion->obra->titulo ?? 'Sin Obra' }}
                                    </span>
                                    <small class="text-muted d-block" style="font-size: 0.70rem;">
                                        <i class="fas fa-building me-1"></i>{{ $inspeccion->obra->cliente->razon_social ?? 'Cliente General' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-secondary d-block" style="font-size: 0.75rem;">
                                        <i class="fas fa-user-tie me-1 opacity-50"></i>{{ $inspeccion->ingeniero_asignado ?? 'No asignado' }}
                                    </span>
                                </td>
                                <td class="text-center font-monospace text-nowrap" style="font-size: 0.74rem;">
                                    <span class="text-dark d-inline-flex align-items-center">
                                        <i class="far fa-calendar-alt me-1 text-success"></i>
                                        {{ $inspeccion->fecha_inspeccion ? \Carbon\Carbon::parse($inspeccion->fecha_inspeccion)->format('d/m/Y H:i') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary d-block" style="font-size: 0.74rem; line-height: 1.45;" title="{{ $inspeccion->resultado }}">
                                        {{ $inspeccion->resultado ?: 'Visita pendiente de informe' }}
                                    </span>
                                </td>
                                <td class="pe-3 text-center text-nowrap">
                                    @php $est = ucfirst(strtolower($inspeccion->estado_inspeccion ?? '')); @endphp
                                    @if($est === 'Completada')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem;">
                                            <i class="fas fa-check-circle me-1"></i>Completada
                                        </span>
                                    @elseif($est === 'Pendiente')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 0.65rem;">
                                            <i class="fas fa-clock me-1"></i>Pendiente
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1 bg-light text-dark border" style="font-size: 0.65rem;">{{ $est }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">No se encontraron inspecciones técnicas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. PAGINACIÓN IDÉNTICA A LA IMAGEN 1 (< 1 2 >) -->
    @if(isset($inspecciones) && $inspecciones->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                {{-- Botón Anterior (<) --}}
                @if ($inspecciones->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $inspecciones->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                {{-- Números de Página (1, 2, 3...) --}}
                @foreach ($inspecciones->getUrlRange(1, $inspecciones->lastPage()) as $page => $url)
                    @if ($page == $inspecciones->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Botón Siguiente (>) --}}
                @if ($inspecciones->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $inspecciones->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection