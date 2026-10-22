@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos para el Directorio de Clientes DTL PREMIER -->
<style>
    /* Botones de Acción Superior */
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

    /* Campos de Formulario */
    .dtl-search-input:focus, .dtl-input:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-search-input::placeholder, .dtl-input::placeholder {
        color: #94a3b8 !important;
        font-size: 0.82rem;
    }

    /* Tabla Escritorio Base */
    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .dtl-table-hover thead th {
        background-color: #f8fafc !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        font-size: 0.65rem !important;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .dtl-table-hover td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.6rem 0.75rem !important;
    }

    /* Tarjetas Móviles */
    .dtl-mobile-card {
        border: 1px solid #e2e8f0 !important;
        border-left: 5px solid #059669 !important;
        margin-bottom: 8px !important;
        border-radius: 12px !important;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .dtl-mobile-card-header {
        padding: 10px 14px !important;
    }

    /* PAGINACIÓN ENUMERADA EN MÓVIL Y ESCRITORIO AL LADO DERECHO (< 1 2 >) */
    .dtl-pagination-wrapper {
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        width: 100% !important;
        margin-top: 12px !important;
        margin-bottom: 16px !important;
        padding-right: 4px !important;
    }

    .dtl-pagination-wrapper nav {
        display: flex !important;
        justify-content: flex-end !important;
        width: 100% !important;
    }

    .dtl-pagination-wrapper nav > div:first-child {
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
        gap: 5px !important;
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
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
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
    }

    .dtl-pagination-wrapper p.small.text-muted {
        display: none !important;
    }

    .dtl-icon-addon {
        display: flex !important;
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

    /* ========================================================================== */
    /* REDUCCIÓN DE TEXTO DE 2 PUNTOS / TAMAÑOS PARA MODOS TABLET Y ESCRITORIO  */
    /* ========================================================================== */
    @media (min-width: 768px) {
        .dtl-icon-addon {
            display: none !important;
        }
        .dtl-input-responsive {
            border-top-left-radius: 0.375rem !important;
            border-bottom-left-radius: 0.375rem !important;
            border-left: 1px solid #cbd5e1 !important;
        }

        /* Reducción en la Tabla Principal */
        .dtl-table-hover thead th {
            font-size: 0.58rem !important;
        }
        .dtl-table-hover td, 
        .dtl-table-hover td span, 
        .dtl-table-hover td a {
            font-size: 0.70rem !important;
        }
        .dtl-table-hover .badge {
            font-size: 0.58rem !important;
        }

        /* Reducción en la Ventana Modal */
        #modalRegistrarCliente .modal-title {
            font-size: 0.92rem !important;
        }
        #modalRegistrarCliente .card-header h6 {
            font-size: 0.68rem !important;
        }
        #modalRegistrarCliente label {
            font-size: 0.68rem !important;
        }
        #modalRegistrarCliente .form-control {
            font-size: 0.75rem !important;
        }
        #modalRegistrarCliente .form-text,
        #modalRegistrarCliente .extra-small,
        #modalRegistrarCliente .invalid-feedback,
        #modalRegistrarCliente [id$="-error-msg"] {
            font-size: 0.65rem !important;
        }
        #validation-summary-alert .extra-small span {
            font-size: 0.68rem !important;
        }
    }

    @media (max-width: 991.98px) {
        .container-fluid {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
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

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN DE REGISTRO (+) -->
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
                        <a href="{{ route('comercial.clientes.index') }}" class="btn btn-dtl-action dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>

                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalRegistrarCliente" title="Registrar Ficha">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. TABLA Y LISTADO MÓVIL DE CLIENTES -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            
            <!-- VISTA TABLA -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="min-width: 800px;">
                    <thead class="text-uppercase" style="letter-spacing: 0.8px;">
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold">RUC</th>
                            <th class="py-2.5 fw-bold">RAZÓN SOCIAL</th>
                            <th class="py-2.5 fw-bold">CONTACTO</th>
                            <th class="py-2.5 fw-bold">TELÉFONO</th>
                            <th class="py-2.5 fw-bold">EMAIL</th>
                            <th class="py-2.5 fw-bold text-center">ESTADO</th>
                            <th class="py-2.5 fw-bold text-center">REGISTRADO POR</th>
                            <th class="pe-3 py-2.5 fw-bold text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3">
                                    <a href="#" class="fw-bold text-decoration-none" style="color: #059669; font-size: 0.78rem;">
                                        {{ $cliente->ruc }}
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem;">
                                        {{ $cliente->razon_social }}
                                    </span>
                                </td>
                                <td><span class="text-secondary" style="font-size: 0.78rem;">{{ $cliente->contacto ?? $cliente->nombre_contacto ?? '---' }}</span></td>
                                <td><span class="text-secondary" style="font-size: 0.78rem;">{{ $cliente->telefono ?? $cliente->telefono_contacto ?? '---' }}</span></td>
                                <td><span class="text-secondary" style="font-size: 0.78rem;">{{ $cliente->email ?? $cliente->email_contacto ?? '---' }}</span></td>
                                <td class="text-center">
                                    @php $est = strtoupper($cliente->estado ?? ''); @endphp
                                    @if(in_array($est, ['ACTIVO', 'ACTIVE']))
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">Activo</span>
                                    @elseif(in_array($est, ['EN_EVALUACION', 'EN EVALUACIÓN', 'EVALUANDO', 'EVALUACION']))
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Evaluando</span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center"><span class="text-muted" style="font-size: 0.78rem;">{{ $cliente->user->name ?? $cliente->registrado_por ?? 'Asesor Comercial' }}</span></td>
                                <td class="pe-3 text-center">
                                    <button class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center" style="background-color: #ecfdf5; color: #059669; width: 28px; height: 28px;">
                                        <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted small">No se encontraron clientes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- VISTA TARJETAS MÓVILES -->
            <div class="d-block d-lg-none p-2">
                @forelse($clientes ?? [] as $index =>$cliente)
                    <div class="dtl-mobile-card">
                        <div class="dtl-mobile-card-header d-flex align-items-center justify-content-between gap-2">
                            <div class="flex-grow-1 ps-1" style="min-width: 0;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="fw-bold" style="color: #059669; font-size: 0.82rem;">{{ $cliente->ruc }}</span>
                                    @php $est = strtoupper($cliente->estado ?? ''); @endphp
                                    @if(in_array($est, ['ACTIVO', 'ACTIVE']))
                                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">Activo</span>
                                    @elseif(in_array($est, ['EN_EVALUACION', 'EN EVALUACIÓN', 'EVALUANDO', 'EVALUACION']))
                                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Evaluando</span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">Inactivo</span>
                                    @endif
                                </div>
                                <h6 class="fw-bold text-dark text-uppercase text-truncate mb-0" style="font-size: 0.80rem; line-height: 1.3;">{{ $cliente->razon_social }}</h6>
                            </div>

                            <button class="btn btn-sm btn-light border p-1 rounded-2 text-muted flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileClienteCollapse{{ $index }}" aria-expanded="false" style="border-color: #cbd5e1 !important; width: 32px; height: 32px;">
                                <i class="fas fa-chevron-down" style="font-size: 0.72rem;"></i>
                            </button>
                        </div>

                        <div class="collapse border-top" id="mobileClienteCollapse{{ $index }}" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                            <div class="p-3 d-flex flex-column gap-1.5" style="font-size: 0.72rem;">
                                <div class="d-flex justify-content-between border-bottom pb-1">
                                    <span class="text-muted fw-semibold"><i class="fas fa-user me-1 text-success"></i> Contacto:</span>
                                    <span class="fw-medium text-dark text-end">{{ $cliente->contacto ?? $cliente->nombre_contacto ?: 'No registrado' }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-1">
                                    <span class="text-muted fw-semibold"><i class="fas fa-phone me-1 text-success"></i> Teléfono:</span>
                                    <span class="fw-medium text-dark text-end">{{ $cliente->telefono ?? $cliente->telefono_contacto ?: 'No registrado' }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-1">
                                    <span class="text-muted fw-semibold"><i class="fas fa-envelope me-1 text-success"></i> Email:</span>
                                    <span class="fw-medium text-dark text-end text-break" style="max-width: 60%;">{{ $cliente->email ?? $cliente->email_contacto ?: 'No registrado' }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-1">
                                    <span class="text-muted fw-semibold"><i class="fas fa-id-badge me-1 text-success"></i> Registrado Por:</span>
                                    <span class="fw-medium text-dark text-end">{{ $cliente->user->name ?? $cliente->registrado_por ?? 'Asesor Comercial' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No se encontraron clientes registrados.</div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- 4. BOTONES DE PAGINACIÓN ENUMERADA AL LADO DERECHO -->
    <div class="dtl-pagination-wrapper">
        @if(isset($clientes) && method_exists($clientes, 'links'))
            {{ $clientes->withQueryString()->links('pagination::bootstrap-5') }}
        @else
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Anterior">&lt;</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Siguiente">&gt;</a>
                </li>
            </ul>
        @endif
    </div>

</div>

<!-- ================================================================= -->
<!-- VENTANA MODAL CON CONTROL STRICTO Y ALERTA DE ERRORES CORREGIDA   -->
<!-- ================================================================= -->
<div class="modal fade" id="modalRegistrarCliente" tabindex="-1" aria-labelledby="modalRegistrarClienteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg px-2 px-md-0">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            
            <!-- ENCABEZADO SUPERIOR -->
            <div class="modal-header text-white px-3 px-md-4 py-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%); border-bottom: 3px solid #059669; position: relative;">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-2.5 me-4 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.35); color: #10b981; min-width: 46px; height: 46px;">
                        <i class="fas fa-building-circle-check fs-5"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-0.5">
                            <h5 class="modal-title fw-bold mb-0" id="modalRegistrarClienteLabel" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                                Ficha de Registro de Cliente
                            </h5>
                            <span class="badge rounded-pill fw-bold text-uppercase" style="font-size: 0.58rem; background-color: #059669; color: #ffffff;"></span>
                        </div>
                        <p class="mb-0 extra-small opacity-75" style="color: #cbd5e1 !important;">
                            sistema DTL PREMIER S.A.C.
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- ALERTA DE RESUMEN DE ERRORES (TEXTO SIMPLIFICADO) -->
            <div id="validation-summary-alert" class="alert border-0 m-3 mb-0 p-3 d-flex align-items-center rounded-3 d-none" role="alert" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
                <i class="fas fa-circle-exclamation me-3 fs-5" style="color: #ef4444;"></i>
                <div class="extra-small">
                    <span class="fw-bold d-block">Formulario Incompleto o no Válido:</span>
                    <span id="validation-summary-msg">Atención: Debe corregir o completar todos los campos requeridos.</span>
                </div>
            </div>

            <!-- FORMULARIO -->
            <form id="formRegistrarCliente" action="{{ route('comercial.clientes.store') }}" method="POST" novalidate>
                @csrf

                <div class="modal-body p-3 p-md-4 bg-light pb-1" style="background-color: #f8fafc !important;">
                    <div class="row g-3">
                        
                        <!-- SECCIÓN 1: DATOS TRIBUTARIOS -->
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 bg-white h-100" style="border: 1px solid #e2e8f0 !important;">
                                <div class="card-header bg-white border-bottom p-2.5 px-3 d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
                                    <div class="d-flex align-items-center">
                                        <span class="badge text-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 0.70rem; background-color: #0f172a;">1</span>
                                        <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; color: #0f172a;">Información Tributaria</h6>
                                    </div>
                                    <i class="fas fa-landmark opacity-50" style="color: #059669; font-size: 0.85rem;"></i>
                                </div>

                                <div class="card-body p-3">
                                    <!-- RUC SUNAT -->
                                    <div class="mb-2.5">
                                        <label for="ruc" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Número de RUC (11 Dígitos) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="ruc" name="ruc" value="{{ old('ruc') }}" placeholder="Ej. 20601234567" maxlength="11" style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;" required>
                                        </div>
                                        <span class="form-text extra-small" style="color: #64748b; font-size: 0.70rem;">Debe tener 11 dígitos y comenzar con 10, 15, 17 o 20.</span>
                                        <div id="ruc-error-msg" class="text-danger extra-small d-none mt-1 fw-medium"></div>
                                    </div>

                                    <!-- Razón Social -->
                                    <div class="mb-2.5">
                                        <label for="razon_social" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Razón Social / Legal <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="razon_social" name="razon_social" value="{{ old('razon_social') }}" placeholder="Ej. Constructora del Sur S.A.C." style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;" required>
                                        </div>
                                        <div id="razon_social-error-msg" class="text-danger extra-small d-none mt-1 fw-medium">La Razón Social es requerida.</div>
                                    </div>

                                    <!-- Dirección Fiscal -->
                                    <div class="mb-0">
                                        <label for="direccion" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Dirección Fiscal
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-map-location-dot"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Ej. Av. Larco 123, Miraflores" style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: CONTACTO COMERCIAL DIRECTO -->
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 bg-white h-100" style="border: 1px solid #e2e8f0 !important;">
                                <div class="card-header bg-white border-bottom p-2.5 px-3 d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
                                    <div class="d-flex align-items-center">
                                        <span class="badge text-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 0.70rem; background-color: #0f172a;">2</span>
                                        <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; color: #0f172a;">Contacto Directo</h6>
                                    </div>
                                    <i class="fas fa-address-book opacity-50" style="color: #059669; font-size: 0.85rem;"></i>
                                </div>

                                <div class="card-body p-3">
                                    <!-- Persona de Contacto -->
                                    <div class="mb-2.5">
                                        <label for="nombre_contacto" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Persona de Contacto <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-user-tie"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto') }}" placeholder="Ej. Ing. Carlos Mendoza" style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;" required>
                                        </div>
                                        <div id="nombre_contacto-error-msg" class="text-danger extra-small d-none mt-1 fw-medium">El nombre de contacto es requerido.</div>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-2.5">
                                        <label for="email_contacto" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Correo Electrónico <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="email_contacto" name="email_contacto" value="{{ old('email_contacto') }}" placeholder="Ej. contacto@empresa.com" style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;" required>
                                        </div>
                                        <div id="email_contacto-error-msg" class="text-danger extra-small d-none mt-1 fw-medium">Ingrese un correo electrónico válido.</div>
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="mb-0">
                                        <label for="telefono_contacto" class="form-label fw-semibold extra-small mb-1" style="color: #0f172a;">
                                            Teléfono / Celular <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text border-end-0 ps-2.5 dtl-icon-addon" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                                <i class="fas fa-phone-flip"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 py-1.5 dtl-input dtl-input-responsive" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}" placeholder="Ej. 987654321" style="border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a;" required>
                                        </div>
                                        <div id="telefono_contacto-error-msg" class="text-danger extra-small d-none mt-1 fw-medium">El teléfono o celular es requerido.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FOOTER CON BOTÓN COMPACTO "+" -->
                <div class="modal-footer bg-light border-top-0 pt-0 pb-2.5 px-3 px-md-4 d-flex align-items-center justify-content-between mt-n2" style="background-color: #f8fafc !important;">
                    <div class="d-flex align-items-center text-success extra-small">
                        <i class="fas fa-circle-check me-1.5" style="color: #059669; font-size: 0.80rem;"></i>
                        <span class="fw-medium text-secondary" style="font-size: 0.75rem;">Campos obligatorios (*)</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 justify-content-end ms-auto">
                        <button type="button" class="btn btn-sm btn-light border px-3 py-1.5 fw-semibold" data-bs-dismiss="modal" style="font-size: 0.82rem; border-color: #cbd5e1 !important; color: #334155;">
                            Cancelar
                        </button>
                        <button type="submit" id="btn-registrar-ajax" class="btn btn-sm btn-dtl-primary px-3.5 py-1.5 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center" style="font-size: 0.85rem; min-width: 40px; height: 34px;" title="Registrar Ficha">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- JAVASCRIPT DE CONTROL STRICTO DE ENVÍO Y VALIDACIÓN SUNAT -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('modalRegistrarCliente');
        const form = document.getElementById('formRegistrarCliente');
        const btnRegistrar = document.getElementById('btn-registrar-ajax');
        const alertSummary = document.getElementById('validation-summary-alert');
        const alertMsgText = document.getElementById('validation-summary-msg');

        // Referencias a los campos
        const rucInput = document.getElementById('ruc');
        const rucErrorMsg = document.getElementById('ruc-error-msg');
        
        const razonSocialInput = document.getElementById('razon_social');
        const razonSocialErrorMsg = document.getElementById('razon_social-error-msg');

        const nombreContactoInput = document.getElementById('nombre_contacto');
        const nombreContactoErrorMsg = document.getElementById('nombre_contacto-error-msg');

        const emailContactoInput = document.getElementById('email_contacto');
        const emailContactoErrorMsg = document.getElementById('email_contacto-error-msg');

        const telefonoContactoInput = document.getElementById('telefono_contacto');
        const telefonoContactoErrorMsg = document.getElementById('telefono_contacto-error-msg');

        let rucExisteEnBD = false;

        // Solo permitir números en el campo RUC
        if (rucInput) {
            rucInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validarRucFormato();
            });

            rucInput.addEventListener('blur', function() {
                const val = this.value.trim();
                if (val.length === 11 && (val.startsWith('10') || val.startsWith('15') || val.startsWith('17') || val.startsWith('20'))) {
                    fetch(`{{ route('comercial.clientes.checkRuc') }}?ruc=${val}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.exists) {
                                rucExisteEnBD = true;
                                marcarCampoInvalido(rucInput, rucErrorMsg, 'Este RUC ya se encuentra registrado en el sistema.');
                            } else {
                                rucExisteEnBD = false;
                                marcarCampoValido(rucInput, rucErrorMsg);
                            }
                        })
                        .catch(err => console.error('Error al consultar RUC:', err));
                }
            });
        }

        // Validación estricta de la estructura del RUC
        function validarRucFormato() {
            const val = rucInput.value.trim();
            if (!val) {
                marcarCampoInvalido(rucInput, rucErrorMsg, 'El número de RUC es obligatorio.');
                return false;
            }
            if (val.length !== 11) {
                marcarCampoInvalido(rucInput, rucErrorMsg, 'El RUC debe tener exactamente 11 dígitos.');
                return false;
            }
            if (!val.startsWith('10') && !val.startsWith('15') && !val.startsWith('17') && !val.startsWith('20')) {
                marcarCampoInvalido(rucInput, rucErrorMsg, 'El RUC debe comenzar obligatoriamente con 10, 15, 17 o 20.');
                return false;
            }
            if (rucExisteEnBD) {
                marcarCampoInvalido(rucInput, rucErrorMsg, 'Este RUC ya se encuentra registrado en el sistema.');
                return false;
            }

            marcarCampoValido(rucInput, rucErrorMsg);
            return true;
        }

        function marcarCampoInvalido(input, errorElement, mensaje) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (errorElement) {
                errorElement.textContent = mensaje;
                errorElement.classList.remove('d-none');
            }
        }

        function marcarCampoValido(input, errorElement) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (errorElement) {
                errorElement.classList.add('d-none');
            }
        }

        // INTERCEPCIÓN DEL FORM.ONSUBMIT
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let esFormularioValido = true;

                // 1. RUC SUNAT
                if (!validarRucFormato()) {
                    esFormularioValido = false;
                }

                // 2. Razón Social
                if (!razonSocialInput.value.trim()) {
                    marcarCampoInvalido(razonSocialInput, razonSocialErrorMsg, 'La Razón Social es requerida.');
                    esFormularioValido = false;
                } else {
                    marcarCampoValido(razonSocialInput, razonSocialErrorMsg);
                }

                // 3. Contacto
                if (!nombreContactoInput.value.trim()) {
                    marcarCampoInvalido(nombreContactoInput, nombreContactoErrorMsg, 'El nombre de contacto es requerido.');
                    esFormularioValido = false;
                } else {
                    marcarCampoValido(nombreContactoInput, nombreContactoErrorMsg);
                }

                // 4. Email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailContactoInput.value.trim() || !emailRegex.test(emailContactoInput.value.trim())) {
                    marcarCampoInvalido(emailContactoInput, emailContactoErrorMsg, 'Ingrese un correo electrónico válido.');
                    esFormularioValido = false;
                } else {
                    marcarCampoValido(emailContactoInput, emailContactoErrorMsg);
                }

                // 5. Teléfono
                if (!telefonoContactoInput.value.trim()) {
                    marcarCampoInvalido(telefonoContactoInput, telefonoContactoErrorMsg, 'El teléfono o celular es requerido.');
                    esFormularioValido = false;
                } else {
                    marcarCampoValido(telefonoContactoInput, telefonoContactoErrorMsg);
                }

                // SI EL FORMULARIO TIENE ERRORES: MANTIENE EL MODAL ABIERTO
                if (!esFormularioValido) {
                    if (alertSummary) {
                        alertMsgText.textContent = "Atención: Debe corregir o completar todos los campos requeridos.";
                        alertSummary.classList.remove('d-none');
                    }
                    return false;
                }

                // SI TODO ES VÁLIDO: REALIZAR REGISTRO AJAX EN BD
                if (alertSummary) alertSummary.classList.add('d-none');

                btnRegistrar.disabled = true;
                const htmlOriginal = btnRegistrar.innerHTML;
                btnRegistrar.innerHTML = '<span class="spinner-border spinner-border-sm text-white" role="status"></span>';

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(async response => {
                    if (response.ok) {
                        const bsModal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                        bsModal.hide();
                        window.location.reload(); 
                    } else if (response.status === 422) {
                        const data = await response.json();
                        btnRegistrar.disabled = false;
                        btnRegistrar.innerHTML = htmlOriginal;

                        if (data.errors) {
                            if (data.errors.ruc) marcarCampoInvalido(rucInput, rucErrorMsg, data.errors.ruc[0]);
                            if (data.errors.razon_social) marcarCampoInvalido(razonSocialInput, razonSocialErrorMsg, data.errors.razon_social[0]);
                            if (data.errors.nombre_contacto) marcarCampoInvalido(nombreContactoInput, nombreContactoErrorMsg, data.errors.nombre_contacto[0]);
                            if (data.errors.email_contacto) marcarCampoInvalido(emailContactoInput, emailContactoErrorMsg, data.errors.email_contacto[0]);
                            if (data.errors.telefono_contacto) marcarCampoInvalido(telefonoContactoInput, telefonoContactoErrorMsg, data.errors.telefono_contacto[0]);
                        }
                        
                        if (alertSummary) {
                            alertMsgText.textContent = "Atención: Debe corregir o completar todos los campos requeridos.";
                            alertSummary.classList.remove('d-none');
                        }
                    } else {
                        throw new Error('Error de servidor al guardar la ficha.');
                    }
                })
                .catch(err => {
                    console.error('Error AJAX:', err);
                    btnRegistrar.disabled = false;
                    btnRegistrar.innerHTML = htmlOriginal;
                    if (alertSummary) {
                        alertMsgText.textContent = "Atención: Debe corregir o completar todos los campos requeridos.";
                        alertSummary.classList.remove('d-none');
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
