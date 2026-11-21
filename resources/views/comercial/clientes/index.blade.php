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

    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    .dtl-pure-table {
        min-width: 950px !important;
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th, .dtl-card-header-styled {
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
        white-space: nowrap !important;
    }

    .dtl-pure-table tbody tr:hover {
        background-color: #f8fafc !important;
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

        /* 1. Ensanchamos la tabla para que las columnas respiren */
        .dtl-pure-table {
            min-width: 1080px !important;
        }

        /* 2. Reducimos el padding vertical a menos de la mitad para no ocupar espacio abajo */
        .dtl-pure-table thead th {
            padding: 0.40rem 0.60rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.60rem !important;
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
        }

        /* Ancho fijo y controlado por columna en celular */
        .col-mob-ruc      { min-width: 110px !important; }
        .col-mob-razon    { min-width: 250px !important; max-width: 280px !important; }
        .col-mob-dir      { min-width: 200px !important; max-width: 240px !important; }
        .col-mob-contacto { min-width: 220px !important; }
        .col-mob-estado   { min-width: 115px !important; }
        .col-mob-crm      { min-width: 125px !important; }
        .col-mob-acciones { min-width: 85px !important; }

        .texto-celda-compacto {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Directorio & Ecosistema de Clientes
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Directorio de Clientes
            </h3>
        </div>
    </div>

    <!-- ALERTAS -->
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

    <!-- 2. BÚSQUEDA Y ACCIONES -->
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

                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" aria-expanded="false" title="Registrar Cliente">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO REGISTRO -->
    <div class="collapse mb-3" id="seccionFormularioRegistro">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center justify-content-between" style="border-bottom: 3px solid #059669;">
                <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">Registro de Nueva Ficha de Cliente</h6>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro"></button>
            </div>

            <form action="{{ route('comercial.clientes.store') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5">
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">RUC (11 Dígitos) <span class="text-danger">*</span></label>
                            <input type="text" name="ruc" class="form-control form-control-sm py-1 font-monospace" maxlength="11" placeholder="Ej: 20100017491" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>
                        <div class="col-12 col-md-9">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" name="razon_social" class="form-control form-control-sm py-1" placeholder="Ej: DTL PREMIER S.A.C." style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>
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
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Dirección Fiscal / Oficina</label>
                            <input type="text" name="direccion" class="form-control form-control-sm py-1" placeholder="Ej: Av. Javier Prado Este 4200, Surco" style="font-size: 0.82rem; border-color: #cbd5e1;">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Observaciones / Notas</label>
                            <textarea name="observaciones" class="form-control form-control-sm py-1" rows="2" placeholder="Detalles o notas importantes..." style="font-size: 0.82rem; border-color: #cbd5e1;"></textarea>
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

    <!-- 4. TABLA DE CLIENTES CON SCROLL SUAVE Y ALTO ULTRA COMPACTO -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 col-mob-ruc" style="width: 12%;">RUC</th>
                            <th class="col-mob-razon" style="width: 24%;">RAZÓN SOCIAL</th>
                            <th class="col-mob-dir" style="width: 20%;">DIRECCIÓN</th>
                            <th class="col-mob-contacto" style="width: 20%;">CONTACTO</th>
                            <th class="text-center col-mob-estado" style="width: 10%;">ESTADO</th>
                            <th class="text-center col-mob-crm" style="width: 8%;">ASIGNADO (CRM)</th>
                            <th class="pe-3 text-center col-mob-acciones" style="width: 6%;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                            @php 
                                $est = $cliente->estado_dinamico; 
                                $clienteObrasDesc = $cliente->obras ? $cliente->obras->pluck('estado')->implode(', ') : '';
                            @endphp
                            <tr>
                                <td class="ps-3 font-monospace fw-bold col-mob-ruc" style="color: var(--dtl-green); font-size: 0.76rem;">
                                    {{ $cliente->ruc }}
                                </td>
                                <td class="col-mob-razon">
                                    <span class="fw-bold text-dark text-uppercase texto-celda-compacto d-block" title="{{ $cliente->razon_social }}" style="font-size: 0.76rem;">
                                        {{ $cliente->razon_social }}
                                    </span>
                                </td>
                                <td class="col-mob-dir">
                                    <span class="text-secondary texto-celda-compacto d-block" title="{{ $cliente->direccion }}" style="font-size: 0.74rem;">{{ $cliente->direccion ?? '---' }}</span>
                                </td>
                                <td class="col-mob-contacto">
                                    <div style="font-size: 0.74rem; line-height: 1.2;" class="fw-semibold text-dark texto-celda-compacto">{{ $cliente->nombre_contacto }}</div>
                                    <div style="font-size: 0.68rem; line-height: 1.2;" class="text-muted texto-celda-compacto">{{ $cliente->telefono_contacto }} | {{ $cliente->email_contacto }}</div>
                                </td>
                                
                                <td class="text-center col-mob-estado position-relative">
                                    <button type="button" 
                                            class="badge rounded-pill fw-semibold px-2 py-0.5 border-0 text-nowrap" 
                                            style="cursor: pointer; font-size: 0.62rem; background-color: {{ $est === 'ACTIVO' ? '#ecfdf5' : ($est === 'EN_PROCESO' ? '#fef3c7' : '#fef2f2') }}; color: {{ $est === 'ACTIVO' ? '#047857' : ($est === 'EN_PROCESO' ? '#b45309' : '#b91c1c') }}; border: 1px solid {{ $est === 'ACTIVO' ? '#a7f3d0' : ($est === 'EN_PROCESO' ? '#fde68a' : '#fecaca') }} !important;" 
                                            onclick="solicitarAccionCliente(event, this, {{ $cliente->id }}, '{{ addslashes($cliente->razon_social) }}', '{{ $est }}', '{{ addslashes($clienteObrasDesc) }}', 'estado')"
                                            title="Clic para ver detalle de estado">
                                        <i class="fas {{ $est === 'ACTIVO' ? 'fa-circle-check' : ($est === 'EN_PROCESO' ? 'fa-spinner' : 'fa-circle-xmark') }} me-0.5"></i>
                                        {{ $est === 'ACTIVO' ? 'Activo' : ($est === 'EN_PROCESO' ? 'En Proceso' : 'Inactivo') }}
                                    </button>
                                </td>

                                <td class="text-center col-mob-crm">
                                    <span class="text-muted fw-semibold text-nowrap" style="font-size: 0.74rem;">{{ $cliente->user->name ?? 'Asesor CRM' }}</span>
                                </td>
                                
                                <td class="pe-3 text-center col-mob-acciones position-relative">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('comercial.clientes.show', $cliente->id) }}" class="btn btn-sm p-0 rounded-2 border-0 d-inline-flex align-items-center justify-content-center text-decoration-none" style="background-color: #ecfdf5; color: var(--dtl-green); width: 24px; height: 24px;" title="Ver Bitácora 360°">
                                            <i class="fas fa-eye" style="font-size: 0.70rem;"></i>
                                        </a>

                                        <button type="button" 
                                                class="btn btn-sm p-0 rounded-2 border-0 d-inline-flex align-items-center justify-content-center" 
                                                style="width: 24px; height: 24px; background-color: {{ $est === 'INACTIVO' ? '#f1f5f9' : ($est === 'EN_PROCESO' ? '#fef3c7' : '#fef2f2') }}; color: {{ $est === 'INACTIVO' ? '#64748b' : ($est === 'EN_PROCESO' ? '#b45309' : '#dc2626') }};"
                                                onclick="solicitarAccionCliente(event, this, {{ $cliente->id }}, '{{ addslashes($cliente->razon_social) }}', '{{ $est }}', '{{ addslashes($clienteObrasDesc) }}', 'accion')"
                                                title="Estado">
                                            <i class="fas {{ $est === 'INACTIVO' ? 'fa-circle-info' : 'fa-user-slash' }}" style="font-size: 0.70rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3 text-muted small">No se encontraron clientes registrados en el directorio.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN -->
    @if(isset($clientes) && $clientes->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                @if ($clientes->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $clientes->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                @foreach ($clientes->getUrlRange(1, $clientes->lastPage()) as $page => $url)
                    @if ($page == $clientes->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($clientes->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $clientes->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>

<!-- POPOVER MODAL COMPACTO -->
<div id="cardValidacionClienteOverlay" class="d-none" onclick="cerrarTarjetaValidacionCliente()" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.28); backdrop-filter: blur(1.5px); z-index: 1080;"></div>

<div id="cardValidacionCliente" class="d-none flyout-cliente-card" style="position: fixed; width: 320px; z-index: 1090;">
    <div class="card-note-dtl shadow-lg" id="cardDtlInner" style="cursor: default; padding: 0.85rem 0.90rem !important; border-radius: 12px !important; box-shadow: 0 16px 35px -6px rgba(12, 25, 44, 0.35) !important;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center flex-wrap gap-1">
                <span class="badge px-1.5 py-0.5 text-uppercase font-monospace" style="background-color: rgba(0, 0, 0, 0.28); color: #ffffff; font-size: 0.60rem; font-weight: 700; border-radius: 4px;">
                    <i class="fas fa-building me-1 opacity-75"></i>CRM CLIENTE
                </span>
                <span id="badgeEstadoCardCompact" class="btn-pill-base" style="font-size: 0.58rem !important; padding: 0.12rem 0.45rem !important; cursor: default;">-</span>
            </div>
            <button type="button" class="btn btn-sm p-0 text-white opacity-75 border-0 bg-transparent" onclick="cerrarTarjetaValidacionCliente()" style="font-size: 0.82rem; line-height: 1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-task-title mb-1" id="clienteNombreCardCompact" style="font-size: 0.86rem; font-weight: 800; color: #ffffff; letter-spacing: -0.2px;">-</div>

        <div class="card-task-client mb-2" id="tituloCardCompact" style="font-size: 0.72rem; color: #e6fffa; font-weight: 600; display: flex; align-items: center; gap: 4px;">
            <i class="fas fa-info-circle opacity-75"></i> <span>Validación de Estado</span>
        </div>

        <div class="p-2 rounded-3 mb-2" id="boxMensajeBlanco" style="background: #ffffff; color: #1e293b; border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);">
            <div id="alertBoxCardCompact" class="d-flex align-items-start gap-1.5" style="font-size: 0.74rem; line-height: 1.45;">
                <i id="alertIconCardCompact" class="fas fa-circle-exclamation mt-0.5 flex-shrink-0" style="font-size: 0.85rem;"></i>
                <div id="mensajeTextoCardCompact" class="fw-medium"></div>
            </div>
            <div id="notaInstCardCompact" class="text-muted extra-small fst-italic text-center mt-1.5 pt-1 border-top" style="font-size: 0.65rem; border-color: #f1f5f9 !important;"></div>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-1" style="border-top: 1px dashed rgba(255, 255, 255, 0.35);">
            <span class="text-white opacity-75 font-monospace" style="font-size: 0.65rem;">
                <i class="fas fa-shield-alt me-1"></i>DTL PREMIER
            </span>
            <div class="d-flex align-items-center gap-1.5">
                <button type="button" class="btn btn-sm btn-light py-0.5 px-2.5 rounded-2 fw-bold text-dark border-0" onclick="cerrarTarjetaValidacionCliente()" style="font-size: 0.70rem;">Cerrar</button>
                <form id="formConfirmarBajaCard" action="" method="POST" class="d-inline m-0">
                    @csrf
                    @method('PATCH')
                    <button type="submit" id="btnAccionBajaCard" class="btn btn-sm py-0.5 px-2.5 rounded-2 fw-bold text-white border-0" style="background-color: #dc2626; font-size: 0.70rem;">
                        <i class="fas fa-user-slash me-1"></i>Dar de Baja
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .flyout-cliente-card {
        animation: popUpCardPipeline 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        transition: transform 0.2s ease, opacity 0.2s ease, box-shadow 0.2s ease;
    }
    @keyframes popUpCardPipeline {
        from { opacity: 0; transform: translateY(12px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .card-note-dtl-green { background-color: var(--dtl-green) !important; }
    .card-note-dtl-navy  { background-color: var(--dtl-navy) !important; }
    .card-note-dtl-amber { background-color: #b45309 !important; }
    .card-note-dtl-slate { background-color: #475569 !important; }
</style>

<script>
    function cerrarTarjetaValidacionCliente() {
        document.getElementById('cardValidacionClienteOverlay').classList.add('d-none');
        document.getElementById('cardValidacionCliente').classList.add('d-none');
    }

    function solicitarAccionCliente(ev, btnTrigger, clienteId, razonSocial, estadoActual, obrasResumen, tipoOrigen = 'accion') {
        if (ev) ev.stopPropagation();

        const card = document.getElementById('cardValidacionCliente');
        const cardInner = document.getElementById('cardDtlInner');
        const overlay = document.getElementById('cardValidacionClienteOverlay');
        const form = document.getElementById('formConfirmarBajaCard');
        form.action = "{{ url('comercial/clientes') }}/" + clienteId + "/toggle-estado";

        const nombreEl = document.getElementById('clienteNombreCardCompact');
        const badgeEl = document.getElementById('badgeEstadoCardCompact');
        const tituloEl = document.getElementById('tituloCardCompact');
        const alertIcon = document.getElementById('alertIconCardCompact');
        const mensajeTexto = document.getElementById('mensajeTextoCardCompact');
        const notaInst = document.getElementById('notaInstCardCompact');
        const btnBaja = document.getElementById('btnAccionBajaCard');

        nombreEl.innerText = razonSocial;
        cardInner.classList.remove('card-note-dtl-green', 'card-note-dtl-navy', 'card-note-dtl-amber', 'card-note-dtl-slate');

        if (estadoActual === 'EN_PROCESO') {
            cardInner.classList.add('card-note-dtl-amber');
            tituloEl.innerHTML = '<i class="fas fa-spinner fa-spin me-1 text-warning"></i> En Evaluación Comercial';
            badgeEl.className = 'btn-pill-base pill-amarillo';
            badgeEl.innerHTML = '<i class="fas fa-clock"></i> En Proceso';
            alertIcon.className = 'fas fa-circle-exclamation text-warning mt-0.5 flex-shrink-0';
            mensajeTexto.innerHTML = `Cliente en proceso comercial: <span class="d-block mt-0.5 fw-bold font-monospace">${obrasResumen || 'En Evaluación'}</span>`;
            notaInst.innerText = 'DTL PREMIER • No se puede dar de baja con trámites activos.';
            btnBaja.style.display = 'none';
        } else if (estadoActual === 'ACTIVO') {
            cardInner.classList.add('card-note-dtl-green');
            tituloEl.innerHTML = '<i class="fas fa-shield-halved me-1 text-light"></i> Obra Culminada / Activo';
            badgeEl.className = 'btn-pill-base pill-verde-ok';
            badgeEl.innerHTML = '<i class="fas fa-check-circle"></i> Activo';
            alertIcon.className = 'fas fa-triangle-exclamation text-danger mt-0.5 flex-shrink-0';
            mensajeTexto.innerHTML = `¿Está seguro de <strong>dar de baja</strong> a este cliente?`;
            notaInst.innerText = 'Pasará automáticamente a estado "Inactivo".';
            btnBaja.style.display = 'inline-block';
        } else {
            cardInner.classList.add('card-note-dtl-slate');
            tituloEl.innerHTML = '<i class="fas fa-archive me-1 text-light"></i> Sin Obras Activas';
            badgeEl.className = 'btn-pill-base pill-rojo-rechazada';
            badgeEl.innerHTML = '<i class="fas fa-circle-xmark"></i> Inactivo';
            alertIcon.className = 'fas fa-circle-info text-secondary mt-0.5 flex-shrink-0';
            mensajeTexto.innerHTML = `Cliente inactivo. Se reactiva al asociarle una nueva obra en <strong>Prospecto</strong>.`;
            notaInst.innerText = 'Reactivación automática.';
            btnBaja.style.display = 'none';
        }

        overlay.classList.remove('d-none');
        card.classList.remove('d-none');

        if (window.innerWidth < 768) {
            card.style.top = '50%';
            card.style.left = '50%';
            card.style.transform = 'translate(-50%, -50%)';
        } else if (btnTrigger) {
            const rect = btnTrigger.getBoundingClientRect();
            card.style.top = (rect.bottom + 8) + 'px';
            card.style.left = Math.max(15, rect.right - 345) + 'px';
            card.style.transform = 'none';
        }
    }
</script>
@endsection