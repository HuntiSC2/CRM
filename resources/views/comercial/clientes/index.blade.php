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

    /* Cabecera unificada y exacta para la tabla y el formulario */
    .dtl-table-hover thead th, .dtl-card-header-styled {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
    }

    .dtl-table-hover thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
    }

    /* REDUCCIÓN PROPORCIONAL Y COMPACTA PARA RESOLUCIÓN DE CELULAR */
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

    /* Ocultar texto de la paginación de Laravel */
    .dtl-pagination-wrapper nav > div:first-child,
    .dtl-pagination-wrapper p.small.text-muted,
    .dtl-pagination-wrapper .text-muted {
        display: none !important;
    }

    /* Paginación Numerada en círculos alineada a la derecha */
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

    .extra-small {
        font-size: 0.73rem;
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
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                        </span>

                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Expedientes Activos
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                        Directorio de Clientes
                    </h3>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check me-2 fs-5 flex-shrink-0" style="color: #059669;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-triangle-exclamation me-2 fs-5 flex-shrink-0" style="color: #dc2626;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('error') }}</div>
        </div>
    @endif

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN DE ACCIÓN (+) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('comercial.clientes.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por RUC, Razón Social..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('comercial.clientes.index') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>

                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" aria-expanded="false" aria-controls="seccionFormularioRegistro" title="Registrar Cliente">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO DINÁMICO COMPACTO Y OPTIMIZADO -->
    <div class="collapse mb-3" id="seccionFormularioRegistro">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center justify-content-between" style="border-bottom: 3px solid #059669;">
                <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">Registro de Nueva Ficha de Cliente</h6>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" aria-label="Close"></button>
            </div>

            <form action="{{ route('comercial.clientes.store') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5">
                        
                        <!-- FILA 1: RUC y Razón Social -->
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">RUC (11 Dígitos) <span class="text-danger">*</span></label>
                            <input type="text" name="ruc" class="form-control form-control-sm py-1" maxlength="11" placeholder="Ej: 20100017491" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <div class="col-12 col-md-9">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" name="razon_social" class="form-control form-control-sm py-1" placeholder="Ej: DTL PREMIER S.A.C." style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <!-- FILA 2: Nombre de Contacto, Teléfono y Correo Electrónico -->
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Nombre de Contacto <span class="text-danger">*</span></label>
                            <input type="text" name="nombre_contacto" class="form-control form-control-sm py-1" placeholder="Ej: Ing. Carlos Mendoza" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Teléfono / Celular <span class="text-danger">*</span></label>
                            <input type="text" name="telefono_contacto" class="form-control form-control-sm py-1" placeholder="Ej: +51 987654321" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email_contacto" class="form-control form-control-sm py-1" placeholder="Ej: contacto@dtlpremier.com" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <!-- FILA 3: Dirección Fiscal y Observaciones alineadas en paralelo (2 líneas) -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Dirección Fiscal / Oficina</label>
                            <input type="text" name="direccion" class="form-control form-control-sm py-1" placeholder="Ej: Av. Javier Prado Este 4200, Surco" style="font-size: 0.82rem; border-color: #cbd5e1;">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Observaciones / Notas</label>
                            <textarea name="observaciones" class="form-control form-control-sm py-1" rows="2" placeholder="Detalles o notas importantes sobre el cliente..." style="font-size: 0.82rem; border-color: #cbd5e1;"></textarea>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white px-3 py-2 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA RESPONSIVA Y COMPACTA DE CLIENTES -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="min-width: 650px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold">RUC</th>
                            <th class="py-2.5 fw-bold">RAZÓN SOCIAL</th>
                            <th class="py-2.5 fw-bold">DIRECCIÓN</th>
                            <th class="py-2.5 fw-bold">CONTACTO</th>
                            <th class="py-2.5 fw-bold text-center">ESTADO</th>
                            <th class="py-2.5 fw-bold text-center">ASIGNADO (CRM)</th>
                            <th class="pe-3 py-2.5 fw-bold text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3">
                                    <span class="fw-bold" style="color: #059669; font-size: 0.78rem;">
                                        {{ $cliente->ruc }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem;">
                                        {{ $cliente->razon_social }}
                                    </span>
                                </td>
                                <td><span class="text-secondary" style="font-size: 0.78rem;">{{ $cliente->direccion ?? '---' }}</span></td>
                                <td>
                                    <div style="font-size: 0.78rem;" class="fw-semibold text-dark">{{ $cliente->nombre_contacto }}</div>
                                    <div style="font-size: 0.70rem;" class="text-muted">{{ $cliente->telefono_contacto }} | {{ $cliente->email_contacto }}</div>
                                </td>
                                <td class="text-center">
                                    @php $est = strtoupper($cliente->estado ?? 'ACTIVO'); @endphp
                                    @if($est == 'ACTIVO')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">Activo</span>
                                    @elseif($est == 'EN_EVALUACION')
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">En Evaluación</span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center"><span class="text-muted fw-semibold" style="font-size: 0.78rem;">{{ $cliente->user->name ?? 'Asesor Comercial' }}</span></td>
                                <td class="pe-3 text-center">
                                    <button class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center" style="background-color: #ecfdf5; color: #059669; width: 28px; height: 28px;" title="Ver Detalle">
                                        <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted small">No se encontraron clientes registrados en el directorio.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN NUMERADA -->
    <div class="dtl-pagination-wrapper">
        @if(isset($clientes) && method_exists($clientes, 'links'))
            {{ $clientes->withQueryString()->links('pagination::bootstrap-5') }}
        @endif
    </div>

</div>
@endsection