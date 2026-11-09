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

    .table-responsive-cotizador {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0 0 12px 12px;
    }
    .table-responsive-cotizador table {
        min-width: 860px;
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

    <!-- ENCABEZADO -->
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
                            💼 GESTIÓN COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            Auditoría de Presupuestos & Propuestas
                        </span>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                        Módulo de Cotizaciones y Propuestas Económicas
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

    <!-- BUSCADOR ANCHO COMPLETO -->
    <div class="card border-0 shadow-sm rounded-4 filter-card-dtl mb-3">
        <form action="{{ route('comercial.cotizador.index') }}" method="GET" class="d-flex align-items-center gap-2 w-100">
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-white border-end-0 text-muted px-2.5" style="border-color: #cbd5e1; height: 38px; border-radius: 8px 0 0 8px;">
                    <i class="fas fa-search" style="font-size: 0.75rem;"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control border-start-0 input-dtl-control" 
                       placeholder="Buscar por Código, Obra o Cliente..."
                       style="border-radius: 0 8px 8px 0 !important;">
            </div>

            <button type="submit" class="btn-dtl-green">
                <i class="fas fa-filter"></i>
                <span>Buscar</span>
            </button>

            @if(request('search'))
                <a href="{{ route('comercial.cotizador.index') }}" class="btn-dtl-reset" title="Limpiar filtro">
                    <i class="fas fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- TABLA DE COTIZACIONES -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="table-responsive-cotizador">
            <table class="table dtl-table w-100 mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 14%;">CÓDIGO</th>
                        <th style="width: 26%;">PROYECTO / CLIENTE</th>
                        <th class="text-end" style="width: 14%;">MONTO TOTAL</th>
                        <th class="text-center" style="width: 14%;">FECHA PROG. / FIN</th>
                        <th style="width: 16%;">OBSERVACIONES</th>
                        <th class="text-center" style="width: 10%;">ESTADO</th>
                        <th class="pe-3 text-center" style="width: 6%;">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotizaciones ?? [] as $cotizacion)
                        <tr>
                            <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-navy);">
                                {{ $cotizacion->codigo_cotizacion }}
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block text-truncate" style="max-width: 280px;">
                                    {{ $cotizacion->obra->titulo ?? 'Sin Obra' }}
                                </span>
                                <small class="text-muted d-block text-truncate" style="max-width: 280px; font-size: 0.70rem;">
                                    <i class="fas fa-building me-1"></i>{{ $cotizacion->obra->cliente->razon_social ?? 'Cliente General' }}
                                </small>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold font-monospace text-dark" style="font-size: 0.86rem;">
                                    @if($cotizacion->monto_total > 0)
                                        S/ {{ number_format($cotizacion->monto_total, 2) }}
                                    @else
                                        <span class="text-muted small fst-italic">Por cotizar</span>
                                    @endif
                                </span>
                            </td>
                            <td class="text-center" style="font-size: 0.72rem;">
                                <div><i class="far fa-calendar-check text-muted me-1"></i>{{ $cotizacion->fecha_emision ? $cotizacion->fecha_emision->format('d/m/Y') : '-' }}</div>
                                <div class="text-secondary">
                                    @if($cotizacion->fecha_vencimiento)
                                        <i class="far fa-calendar-times text-danger me-1"></i>{{ $cotizacion->fecha_vencimiento->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted fst-italic">Pendiente de envío</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary d-block text-truncate" style="max-width: 220px; font-size: 0.74rem;">
                                    {{ $cotizacion->observaciones ?: 'Sin observaciones' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php $est = strtoupper($cotizacion->estado_cotizacion ?? ''); @endphp
                                @if($est === 'PROGRAMADA')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 0.65rem;">Programada</span>
                                @elseif($est === 'APROBADA')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.65rem;">Aprobada</span>
                                @elseif($est === 'ENVIADA')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem;">Enviada</span>
                                @elseif($est === 'ACEPTADA')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 0.65rem;">Aceptada</span>
                                @elseif($est === 'RECHAZADA')
                                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.65rem;">Rechazada</span>
                                @else
                                    <span class="badge rounded-pill px-2.5 py-1 bg-light text-dark border" style="font-size: 0.65rem;">{{ $est }}</span>
                                @endif
                            </td>
                            <!-- BOTÓN QUE ABRE EL VISOR MODAL (IDÉNTICO A LA IMAGEN 1) -->
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
                            <td colspan="7" class="text-center py-5 text-muted small">
                                No se encontraron cotizaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($cotizaciones) && method_exists($cotizaciones, 'hasPages') && $cotizaciones->hasPages())
            <div class="d-flex justify-content-between align-items-center p-2.5 bg-light border-top">
                <small class="text-muted" style="font-size: 0.74rem;">Mostrando {{ $cotizaciones->firstItem() }} a {{ $cotizaciones->lastItem() }} de {{ $cotizaciones->total() }} registros</small>
                <div class="dtl-pagination-wrapper">{{ $cotizaciones->links('pagination::bootstrap-5') }}</div>
            </div>
        @endif
    </div>

</div>

<!-- VENTANA MODAL FLOTANTE (VISOR IDÉNTICO A IMAGEN 1) -->
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