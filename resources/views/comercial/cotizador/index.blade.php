@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos Estandarizados DTL PREMIER -->
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

    /* TABLA INSTITUCIONAL ESTANDARIZADA */
    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .dtl-table-hover thead th {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
        position: sticky;
        top: 0;
        z-index: 2;
        text-transform: uppercase;
    }

    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
        vertical-align: middle;
    }

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

    /* PAGINACIÓN ESTANDARIZADA DTL PREMIER */
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

    .dtl-pagination-wrapper nav > div:first-child,
    .dtl-pagination-wrapper p.small.text-muted,
    .dtl-pagination-wrapper .text-muted {
        display: none !important;
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
        color: var(--dtl-navy) !important;
        font-weight: 700 !important;
        font-size: 0.80rem !important;
        text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
    }

    .dtl-pagination-wrapper .pagination .page-item.active .page-link {
        background-color: var(--dtl-green) !important;
        border-color: var(--dtl-green) !important;
        color: #ffffff !important;
    }

    .dtl-pagination-wrapper .pagination .page-item.disabled .page-link {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #cbd5e1 !important;
        border-radius: 8px !important;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL ESTANDARIZADO (SIN LOGO) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-file-invoice-dollar me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Auditoría de Presupuestos & Propuestas
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Módulo de Cotizaciones y Propuestas Económicas
            </h3>
        </div>
    </div>

    <!-- 2. MENSAJES DE ALERTA -->
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

    <!-- 3. BARRA DE BÚSQUEDA ANCHO COMPLETO ESTANDARIZADA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('comercial.cotizador.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por Código, Proyecto o Cliente..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('comercial.cotizador.index') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- 4. TABLA DE COTIZACIONES ESTANDARIZADA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover w-100" style="min-width: 860px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold" style="width: 12%;">CÓDIGO</th>
                            <th class="py-2.5 fw-bold" style="width: 25%;">PROYECTO / CLIENTE</th>
                            <th class="py-2.5 fw-bold text-end" style="width: 14%;">MONTO TOTAL</th>
                            <th class="py-2.5 fw-bold text-center" style="width: 15%;">FECHA PROG. / FIN</th>
                            <th class="py-2.5 fw-bold" style="width: 18%;">OBSERVACIONES</th>
                            <th class="py-2.5 fw-bold text-center" style="width: 10%;">ESTADO</th>
                            <th class="pe-3 py-2.5 fw-bold text-center" style="width: 6%;">PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones ?? [] as $cotizacion)
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-navy); font-size: 0.78rem;">
                                    {{ $cotizacion->codigo_cotizacion }}
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block text-break" style="font-size: 0.78rem;">
                                        {{ $cotizacion->obra->titulo ?? 'Sin Obra' }}
                                    </span>
                                    <small class="text-muted d-block text-break" style="font-size: 0.70rem;">
                                        <i class="fas fa-building me-1"></i>{{ $cotizacion->obra->cliente->razon_social ?? 'Cliente General' }}
                                    </small>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold font-monospace text-dark" style="font-size: 0.82rem;">
                                        @if($cotizacion->monto_total > 0)
                                            S/ {{ number_format($cotizacion->monto_total, 2) }}
                                        @else
                                            <span class="text-muted small fst-italic">Por cotizar</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center" style="font-size: 0.72rem;">
                                    <div class="fw-medium text-dark">
                                        <i class="far fa-calendar-check text-muted me-1"></i>{{ $cotizacion->fecha_emision ? \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-secondary" style="font-size: 0.68rem;">
                                        @if($cotizacion->fecha_vencimiento)
                                            <i class="far fa-calendar-times text-danger me-1"></i>{{ \Carbon\Carbon::parse($cotizacion->fecha_vencimiento)->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted fst-italic">Pendiente de envío</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary d-block text-break" style="font-size: 0.74rem; line-height: 1.45;" title="{{ $cotizacion->observaciones }}">
                                        {{ $cotizacion->observaciones ?: 'Sin observaciones' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php $est = strtoupper($cotizacion->estado_cotizacion ?? ''); @endphp
                                    @if($est === 'PROGRAMADA')
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 0.65rem;">Programada</span>
                                    @elseif($est === 'ENVIADA')
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 0.65rem;">Enviada</span>
                                    @elseif($est === 'ACEPTADA')
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem;">Aceptada</span>
                                    @elseif($est === 'RECHAZADA')
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.65rem;">Rechazada</span>
                                    @else
                                        <span class="badge rounded-pill px-2.5 py-1 bg-light text-dark border" style="font-size: 0.65rem;">{{ $est }}</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger p-0 d-inline-flex align-items-center justify-content-center" 
                                            style="width: 30px; height: 30px; border-radius: 8px;" 
                                            onclick="abrirVisorPdf('{{ route('comercial.cotizador.pdf', $cotizacion->id) }}', '{{ $cotizacion->codigo_cotizacion }}')"
                                            title="Ver Expediente PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted small">No se encontraron cotizaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN NUMERADA ESTANDARIZADA AL LADO DERECHO -->
    <div class="dtl-pagination-wrapper">
        @if(isset($cotizaciones) && method_exists($cotizaciones, 'links'))
            {{ $cotizaciones->withQueryString()->links('pagination::bootstrap-5') }}
        @endif
    </div>

</div>

<!-- MODAL FLOTANTE VISOR PDF -->
<div class="modal fade" id="modalVisorPdfCotizacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 88vw;">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            
            <div class="modal-header text-white py-2 px-3" style="background-color: var(--dtl-navy); border-bottom: 3.5px solid var(--dtl-green);">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger p-1"><i class="fas fa-file-pdf"></i></span>
                    <h6 class="modal-title fw-bold mb-0 text-white" style="font-size: 0.85rem; letter-spacing: 0.3px;">
                        EXPEDIENTE OFICIAL PDF: <span id="visorPdfCodigo" class="text-success font-monospace fw-bold"></span>
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0" style="height: 82vh; background-color: #525659;">
                <iframe id="visorPdfIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>

            <div class="modal-footer bg-white py-2 px-3 border-top d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-secondary fw-semibold px-4" data-bs-dismiss="modal" style="font-size: 0.80rem;">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    function abrirVisorPdf(urlPdf, codigoCotizacion) {
        document.getElementById('visorPdfCodigo').innerText = codigoCotizacion;
        document.getElementById('visorPdfIframe').src = urlPdf;
        
        const modal = new bootstrap.Modal(document.getElementById('modalVisorPdfCotizacion'));
        modal.show();
    }

    document.getElementById('modalVisorPdfCotizacion').addEventListener('hidden.bs.modal', function () {
        document.getElementById('visorPdfIframe').src = '';
    });
</script>
@endsection