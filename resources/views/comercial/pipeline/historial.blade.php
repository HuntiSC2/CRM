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

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
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

        /* 1. Ensanchamos a 1250px para evitar quiebres y que quepa todo */
        .dtl-pure-table {
            min-width: 1250px !important;
        }

        /* 2. Reducimos el alto vertical al mínimo posible */
        .dtl-pure-table thead th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.65rem !important;
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
        }

        /* Anchos generosos por columna */
        .col-mob-cod      { min-width: 120px !important; width: 120px !important; }
        .col-mob-proyecto { min-width: 380px !important; width: 380px !important; }
        .col-mob-cliente  { min-width: 300px !important; width: 300px !important; }
        .col-mob-monto    { min-width: 140px !important; width: 140px !important; }
        .col-mob-estado   { min-width: 140px !important; width: 140px !important; }
        .col-mob-fecha    { min-width: 160px !important; width: 160px !important; }
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

    <!-- 3. TABLA DE TODAS LAS OBRAS CERRADAS -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 col-mob-cod" style="width: 12%;">CÓDIGO</th>
                            <th class="col-mob-proyecto" style="width: 28%;">PROYECTO / OBRA</th>
                            <th class="col-mob-cliente" style="width: 24%;">CLIENTE</th>
                            <th class="col-mob-monto" style="width: 12%;">MONTO BASE</th>
                            <th class="text-center col-mob-estado" style="width: 12%;">ESTADO</th>
                            <th class="pe-3 col-mob-fecha" style="width: 12%;">FECHA REGISTRO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obrasHistorial as $obra)
                            @php 
                                $st = $obra->estado;
                                $stReal = $obra->estado_real;

                                // Verificación robusta de los 3 estados finales
                                $esGanada    = in_array($st, ['Aceptada', 'Ganada']) || in_array($stReal, ['Aceptada', 'Ganada']);
                                $esCancelada = ($st === 'Cancelada' || $stReal === 'Cancelada');
                                $esPerdida   = ($st === 'Perdida' || $stReal === 'Perdida');
                            @endphp
                            <tr>
                                <!-- CÓDIGO -->
                                <td class="ps-3 col-mob-cod text-nowrap">
                                    <span class="fw-bold font-monospace text-success" style="font-size: 0.76rem;">
                                        #{{ $obra->codigo }}
                                    </span>
                                </td>

                                <!-- PROYECTO (TÍTULO COMPLETO) -->
                                <td class="col-mob-proyecto">
                                    <span class="fw-bold text-dark text-uppercase d-block" style="font-size: 0.76rem; line-height: 1.3;">
                                        {{ $obra->titulo }}
                                    </span>
                                </td>

                                <!-- CLIENTE (RAZÓN SOCIAL COMPLETA) -->
                                <td class="col-mob-cliente">
                                    <span class="text-secondary d-block fw-semibold" style="font-size: 0.76rem; line-height: 1.3;">
                                        <i class="fas fa-building me-1 text-muted opacity-75"></i> {{ $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente' }}
                                    </span>
                                </td>

                                <!-- MONTO -->
                                <td class="font-monospace text-nowrap col-mob-monto">
                                    <span class="fw-bold text-dark" style="font-size: 0.76rem;">
                                        S/ {{ number_format($obra->monto, 2) }}
                                    </span>
                                </td>

                                <!-- ESTADOS BIEN DIFERENCIADOS: GANADA / CANCELADA / PERDIDA -->
                                <td class="text-center text-nowrap col-mob-estado">
                                    @if($esGanada)
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-trophy me-1 text-success"></i> Ganada
                                        </span>
                                    @elseif($esCancelada)
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3;">
                                            <i class="fas fa-ban me-1 text-danger"></i> Cancelada
                                        </span>
                                    @elseif($esPerdida)
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            <i class="fas fa-times-circle me-1 text-danger"></i> Perdida
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                            {{ $st }}
                                        </span>
                                    @endif
                                </td>

                                <!-- FECHA REGISTRO -->
                                <td class="pe-3 text-nowrap col-mob-fecha">
                                    <span class="text-secondary font-monospace" style="font-size: 0.72rem;">
                                        <i class="far fa-calendar-alt me-1 text-success"></i> {{ $obra->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-4">
                                    No se encontraron obras cerradas registradas en el historial.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. PAGINACIÓN CIRCULAR -->
    @if(isset($obrasHistorial) && $obrasHistorial->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                @if ($obrasHistorial->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $obrasHistorial->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                @foreach ($obrasHistorial->getUrlRange(1, $obrasHistorial->lastPage()) as $page => $url)
                    @if ($page == $obrasHistorial->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

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