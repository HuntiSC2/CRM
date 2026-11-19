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
                    <i class="fas fa-archive me-1" style="color: #10b981;"></i> ARCHIVO COMERCIAL
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Expedientes Cerrados
                </span>
            </div>

            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Historial General de Expedientes
            </h3>
        </div>
    </div>

    <!-- 2. BÚSQUEDA Y BOTÓN VOLVER -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <form action="{{ route('comercial.pipeline.historial') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ $search ?? '' }}" placeholder="Buscar por código (ej. OBR-001), título del proyecto o cliente..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(!empty($search))
                        <a href="{{ route('comercial.pipeline.historial') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>

                <a href="{{ route('comercial.pipeline.index') }}" class="btn btn-dtl-action btn-dtl-primary flex-shrink-0" style="height: 38px;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </form>
        </div>
    </div>

    <!-- 3. TABLA CON SCROLL LATERAL (DERECHA / IZQUIERDA EN MÓVIL) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 14%;">CÓDIGO</th>
                            <th style="width: 26%;">PROYECTO / OBRA</th>
                            <th style="width: 22%;">CLIENTE</th>
                            <th style="width: 14%;">MONTO BASE</th>
                            <th class="text-center" style="width: 10%;">ESTADO</th>
                            <th class="pe-3" style="width: 14%;">FECHA REGISTRO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obrasHistorial as $obra)
                            @php $estadoReal = $obra->estado_real; @endphp
                            <tr>
                                <td class="ps-3 text-nowrap">
                                    <span class="fw-bold font-monospace text-success" style="font-size: 0.78rem;">
                                        #{{ $obra->codigo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase d-block" style="font-size: 0.78rem;">
                                        {{ $obra->titulo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary d-block" style="font-size: 0.78rem;">
                                        <i class="fas fa-building me-1 text-muted"></i> {{ $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente' }}
                                    </span>
                                </td>
                                <td class="font-monospace text-nowrap">
                                    <span class="fw-bold text-dark" style="font-size: 0.78rem;">
                                        S/ {{ number_format($obra->monto, 2) }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    @if($estadoReal === 'Aceptada')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-trophy me-1 text-success"></i> Ganada
                                        </span>
                                    @elseif($estadoReal === 'Cancelada' || $estadoReal === 'Perdida')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            <i class="fas fa-times-circle me-1 text-danger"></i> Perdida
                                        </span>
                                    @elseif($estadoReal === 'Prospecto')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                            <i class="fas fa-folder-open me-1 text-primary"></i> Prospecto
                                        </span>
                                    @elseif($estadoReal === 'Inspeccion')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fefce8; color: #a16207; border: 1px solid #fef08a;">
                                            <i class="fas fa-search me-1 text-warning"></i> Inspección
                                        </span>
                                    @elseif($estadoReal === 'Cotización')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;">
                                            <i class="fas fa-file-invoice-dollar me-1" style="color: #7c3aed;"></i> Cotización
                                        </span>
                                    @elseif($estadoReal === 'Cierre Comercial')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                            <i class="fas fa-handshake me-1 text-success"></i> Cierre Comercial
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                            {{ $estadoReal }}
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-3 text-nowrap">
                                    <span class="text-secondary" style="font-size: 0.78rem;">
                                        <i class="far fa-calendar-alt me-1 text-success"></i> {{ $obra->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-4">
                                    No se encontraron obras registradas en el historial.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. PAGINACIÓN IDÉNTICA A LA IMAGEN 1 (< 1 2 >) -->
    @if(isset($obrasHistorial) && $obrasHistorial->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                {{-- Botón Anterior (<) --}}
                @if ($obrasHistorial->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $obrasHistorial->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                {{-- Números de Página (1, 2, 3...) --}}
                @foreach ($obrasHistorial->getUrlRange(1, $obrasHistorial->lastPage()) as $page => $url)
                    @if ($page == $obrasHistorial->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Botón Siguiente (>) --}}
                @if ($obrasHistorial->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $obrasHistorial->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection