@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos DTL PREMIER -->
<style>
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
        background-color: #059669 !important;
        border: 1px solid #059669 !important;
        color: #ffffff !important;
    }
    .btn-dtl-primary:hover {
        background-color: #047857 !important;
        border-color: #047857 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    .btn-dtl-dark {
        background-color: #0f172a !important;
        border: 1px solid #0f172a !important;
        color: #ffffff !important;
    }

    .btn-dtl-icon-only {
        width: 38px;
        height: 38px;
        padding: 0;
    }

    .dtl-search-input:focus, .dtl-input:focus, .form-control:focus, .form-select:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .dtl-table-hover thead th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
    }

    .table-empty-space {
        height: 42px !important;
        padding: 0 !important;
    }

    @media (max-width: 767.98px) {
        .dtl-table-hover thead th {
            font-size: 0.52rem !important;
            padding: 0.35rem 0.25rem !important;
        }
        .dtl-table-hover td {
            font-size: 0.62rem !important;
            padding: 0.35rem 0.35rem !important;
        }
        .container-fluid {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
    }

    .dtl-pagination-wrapper nav > div:first-child,
    .dtl-pagination-wrapper p.small.text-muted,
    .dtl-pagination-wrapper .text-muted {
        display: none !important;
    }

    .dtl-pagination-wrapper {
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        width: 100% !important;
        margin-top: 15px !important;
        margin-bottom: 20px !important;
        padding-right: 4px !important;
    }

    .dtl-pagination-wrapper nav {
        display: flex !important;
        justify-content: flex-end !important;
        width: 100% !important;
    }

    .dtl-pagination-wrapper nav > div:last-child,
    .dtl-pagination-wrapper nav > div:nth-child(2) {
        display: flex !important;
        justify-content: flex-end !important;
        width: 100% !important;
    }

    .dtl-pagination-wrapper .pagination {
        margin-bottom: 0 !important;
        display: flex !important;
        flex-wrap: nowrap !important;
        justify-content: flex-end !important;
        align-items: center !important;
        gap: 4px !important;
        list-style: none !important;
        padding-left: 0 !important;
    }

    .dtl-pagination-wrapper .pagination .page-item .page-link {
        min-width: 32px !important;
        height: 32px !important;
        padding: 0 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 0.80rem !important;
        text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
    }

    .dtl-pagination-wrapper .pagination .page-item.active .page-link {
        background-color: #059669 !important;
        border-color: #059669 !important;
        color: #ffffff !important;
    }

    .dtl-pagination-wrapper .pagination .page-item.disabled .page-link {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important;
        border-radius: 8px !important;
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                <div class="col-auto">
                    <div class="p-1.5 p-md-2 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="min-width: 125px; height: 48px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 34px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <div class="col border-start-md ps-md-3" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-archive me-1" style="color: #10b981;"></i> ARCHIVO COMERCIAL
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                        Historial General de Expedientes
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN VOLVER -->
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

    <!-- 3. TABLA DE HISTORIAL CON TODOS LOS ESTADOS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th class="ps-3 fw-bold">CÓDIGO</th>
                            <th class="fw-bold">PROYECTO / OBRA</th>
                            <th class="fw-bold">CLIENTE</th>
                            <th class="fw-bold">MONTO TOTAL</th>
                            <th class="fw-bold text-center">ESTADO</th>
                            <th class="pe-3 fw-bold">FECHA DE REGISTRO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obrasHistorial as $obra)
                            <tr>
                                <td class="ps-3">
                                    <span class="fw-bold" style="color: #059669; font-size: 0.78rem;">
                                        #{{ $obra->codigo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem;">
                                        {{ $obra->titulo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary" style="font-size: 0.78rem;">
                                        <i class="fas fa-building me-1 text-muted"></i> {{ $obra->cliente ? $obra->cliente->razon_social : 'Sin Cliente' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 0.78rem;">
                                        S/ {{ number_format($obra->monto, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($obra->estado === 'Aceptada')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-trophy me-1 text-success"></i> Ganada
                                        </span>
                                    @elseif($obra->estado === 'Cancelada')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            <i class="fas fa-times-circle me-1 text-danger"></i> Perdida
                                        </span>
                                    @elseif($obra->estado === 'Prospecto')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                            <i class="fas fa-folder-open me-1 text-primary"></i> Prospecto
                                        </span>
                                    @elseif($obra->estado === 'Inspeccion')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fefce8; color: #a16207; border: 1px solid #fef08a;">
                                            <i class="fas fa-search me-1 text-warning"></i> Inspección
                                        </span>
                                    @elseif($obra->estado === 'Cotización')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;">
                                            <i class="fas fa-file-invoice-dollar me-1" style="color: #7c3aed;"></i> Cotización
                                        </span>
                                    @elseif($obra->estado === 'Cierre Comercial')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                            <i class="fas fa-handshake me-1 text-success"></i> Cierre Comercial
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                            {{ $obra->estado }}
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    <span class="text-secondary" style="font-size: 0.78rem;">
                                        <i class="far fa-calendar-alt me-1 text-success"></i> {{ $obra->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="table-empty-space text-center text-muted small py-3">
                                    No se encontraron obras registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. PAGINACIÓN NUMERADA -->
    <div class="dtl-pagination-wrapper">
        @if(isset($obrasHistorial) && method_exists($obrasHistorial, 'links'))
            {{ $obrasHistorial->withQueryString()->links('pagination::bootstrap-5') }}
        @endif
    </div>

</div>
@endsection