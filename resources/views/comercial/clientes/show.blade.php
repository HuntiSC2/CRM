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
    .btn-dtl-dark {
        background-color: #0f172a !important;
        border: 1px solid #0f172a !important;
        color: #ffffff !important;
    }
    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    .dtl-table-hover thead th, .dtl-card-header-styled {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
    }
    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
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
        background-color: #059669;
        color: #ffffff !important;
        border: none;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4), 0 2px 6px rgba(0, 0, 0, 0.15);
        font-weight: 700;
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }
    .btn-floating-volver:hover {
        background-color: #047857;
        color: #ffffff !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.45), 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    .btn-floating-volver:active {
        transform: translateY(0) scale(0.98);
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
                            <i class="fas fa-address-book me-1" style="color: #10b981;"></i> BITÁCORA CLIENTE 360°
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> RUC: {{ $cliente->ruc }}
                        </span>
                    </div>

                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                        {{ $cliente->razon_social }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TARJETA DE DATOS GENERALES -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center">
            <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                Historial de Obras, Acciones Técnicas y Propuestas Económicas
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
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Correo Electrónico:</span>
                    <span class="text-dark fw-semibold" style="font-size: 0.82rem;">{{ $cliente->email_contacto }}</span>
                </div>
                <div class="col-12 col-md-2">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Asignado CRM:</span>
                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.70rem;">{{ $cliente->user->name ?? 'Asesor Comercial' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABLA HISTÓRICA DE ACCIONES Y PROYECTOS (1 A MUCHOS) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="min-width: 850px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold">CÓDIGO OBRA</th>
                            <th class="py-2.5 fw-bold">PROYECTO / OBRA</th>
                            <th class="py-2.5 fw-bold text-center">ESTADO OBRA</th>
                            <th class="py-2.5 fw-bold">ACCIONES TÉCNICAS (INSPECCIONES)</th>
                            <th class="py-2.5 fw-bold">PROPUESTAS ECONÓMICAS (COTIZACIONES)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cliente->obras as $obra)
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3">
                                    <span class="fw-bold text-success" style="font-size: 0.78rem;">{{ $obra->codigo }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem;">{{ $obra->titulo }}</span>
                                    <span class="d-block text-muted extra-small">Monto Base: S/ {{ number_format($obra->monto ?? 0, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;">
                                        {{ $obra->estado }}
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
                                        <span class="text-muted extra-small fst-italic">Sin inspecciones registradas</span>
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
                                        <span class="text-muted extra-small fst-italic">Sin cotizaciones emitidas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Este cliente aún no registra proyectos u obras asociadas en el sistema.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BOTÓN FLOTANTE VOLVER -->
    <a href="{{ route('comercial.clientes.index') }}" class="btn-floating-volver" title="Volver al Directorio">
        <i class="fas fa-arrow-left"></i>
        <span>Volver</span>
    </a>

</div>
@endsection