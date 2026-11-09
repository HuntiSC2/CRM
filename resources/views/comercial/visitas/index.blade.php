@extends('layouts.app')

@section('content')
<style>
    :root {
        --dtl-navy: #0c192c;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
        --dtl-amber: #f59e0b;
        --dtl-red: #dc2626;
    }

    .btn-dtl-green {
        height: 38px !important;
        padding: 0 16px !important;
        font-size: 0.80rem !important;
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
        text-decoration: none;
    }
    .btn-dtl-green:hover {
        background-color: var(--dtl-green-hover) !important;
        border-color: var(--dtl-green-hover) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.30);
    }

    .btn-dtl-reset {
        height: 38px;
        width: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        border-radius: 8px;
        color: #64748b;
        transition: all 0.15s ease;
    }
    .btn-dtl-reset:hover {
        background: #f1f5f9;
        color: var(--dtl-navy);
    }

    .filter-card-dtl {
        background: #ffffff;
        border: 1px solid #cbd5e1 !important;
        border-radius: 12px;
        padding: 0.85rem 1rem !important;
    }

    .input-dtl-control {
        height: 38px !important;
        font-size: 0.84rem !important;
        border-color: #cbd5e1 !important;
        border-radius: 8px !important;
    }
    .input-dtl-control:focus {
        border-color: var(--dtl-green) !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
    }

    .table-responsive-inspecciones {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0 0 12px 12px;
    }
    .table-responsive-inspecciones table {
        min-width: 900px;
    }

    .dtl-table thead th {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: none !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.5px;
        padding: 0.75rem 0.85rem !important;
        text-transform: uppercase;
    }
    .dtl-table tbody td {
        font-size: 0.78rem !important;
        padding: 0.65rem 0.85rem !important;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .dtl-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .dtl-pagination-wrapper nav > div:first-child,
    .dtl-pagination-wrapper p.small.text-muted {
        display: none !important;
    }
    .dtl-pagination-wrapper {
        display: flex !important;
        justify-content: flex-end !important;
        margin-top: 15px !important;
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO DTL PREMIER -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3.5px; background-color: var(--dtl-green);"></div>
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-1 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="width: 125px; height: 44px; border-color: #cbd5e1 !important;">
                    <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER" style="max-height: 28px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="border-start ps-3" style="border-color: #cbd5e1 !important;">
                    <div class="d-flex align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                            <i class="fas fa-clipboard-check me-1" style="color: #10b981;"></i> GESTIÓN TÉCNICA
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            Auditoría de Inspecciones & Campo
                        </span>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                        Control y Seguimiento de Inspecciones Técnicas
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERTAS -->
    @if (session('success'))
        <div class="alert border-0 rounded-3 shadow-sm mb-3 py-2 px-3 small d-flex align-items-center gap-2" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check fs-6 text-success"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 2. BARRA DE BÚSQUEDA -->
    <div class="card border-0 shadow-sm rounded-4 filter-card-dtl mb-3">
        <!-- CÓDIGO EXPANDIDO A TODO LO ANCHO: -->
        <form action="{{ route('comercial.visitas.index') }}" method="GET" class="d-flex align-items-center gap-2 w-100">
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-white border-end-0 text-muted px-2.5" style="border-color: #cbd5e1; height: 38px; border-radius: 8px 0 0 8px;">
                    <i class="fas fa-search" style="font-size: 0.75rem;"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control border-start-0 input-dtl-control" 
                       placeholder="Buscar por Obra, Ingeniero o Estado..."
                       style="border-radius: 0 8px 8px 0 !important;">
            </div>

            <button type="submit" class="btn-dtl-green">
                <i class="fas fa-filter"></i>
                <span>Buscar</span>
            </button>

            @if(request('search'))
                <a href="{{ route('comercial.visitas.index') }}" class="btn-dtl-reset" title="Limpiar filtro">
                    <i class="fas fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- 3. TABLA DE INSPECCIONES RESPONSIVA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="table-responsive-inspecciones">
            <table class="table dtl-table w-100 mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 12%;">ID</th>
                        <th style="width: 26%;">OBRA / PROYECTO</th>
                        <th style="width: 18%;">INGENIERO ASIGNADO</th>
                        <th class="text-center" style="width: 14%;">FECHA VISITA</th>
                        <th style="width: 16%;">RESULTADO / NOTAS</th>
                        <th class="text-center" style="width: 14%;">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inspecciones ?? [] as $inspeccion)
                        <tr>
                            <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-navy);">
                                #INS-{{ str_pad($inspeccion->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block text-truncate" style="max-width: 260px;">
                                    {{ $inspeccion->obra->titulo ?? 'Sin Obra' }}
                                </span>
                                <small class="text-muted d-block text-truncate" style="max-width: 260px; font-size: 0.70rem;">
                                    <i class="fas fa-building me-1"></i>{{ $inspeccion->obra->cliente->razon_social ?? 'Cliente General' }}
                                </small>
                            </td>
                            <td>
                                <span class="fw-semibold text-secondary d-block" style="font-size: 0.75rem;">
                                    <i class="fas fa-user-tie me-1 opacity-50"></i>{{ $inspeccion->ingeniero_asignado ?? 'No asignado' }}
                                </span>
                            </td>
                            <td class="text-center font-monospace" style="font-size: 0.74rem;">
                                <i class="far fa-calendar-alt me-1 text-success"></i>
                                {{ $inspeccion->fecha_inspeccion ? $inspeccion->fecha_inspeccion->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td>
                                <span class="text-secondary d-block text-truncate" style="max-width: 220px; font-size: 0.74rem;">
                                    {{ $inspeccion->resultado ?: 'Visita pendiente de informe' }}
                                </span>
                            </td>
                            <td class="text-center">
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
                            <td colspan="6" class="text-center py-5 text-muted small">
                                <i class="fas fa-clipboard-check text-muted fs-3 d-block mb-1 opacity-50"></i>
                                No se encontraron inspecciones técnicas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($inspecciones) && method_exists($inspecciones, 'hasPages') && $inspecciones->hasPages())
            <div class="d-flex justify-content-between align-items-center p-2.5 bg-light border-top">
                <small class="text-muted" style="font-size: 0.74rem;">Mostrando {{ $inspecciones->firstItem() }} a {{ $inspecciones->lastItem() }} de {{ $inspecciones->total() }} registros</small>
                <div class="dtl-pagination-wrapper">{{ $inspecciones->links('pagination::bootstrap-5') }}</div>
            </div>
        @endif
    </div>

</div>
@endsection