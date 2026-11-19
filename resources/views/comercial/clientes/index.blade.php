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

    /* SCROLL HORIZONTAL TÁCTIL (PERMITE MOVERSE DERECHA E IZQUIERDA EN MÓVIL) */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* TABLA FIJA QUE NO SE DESARMA NI SE VUELVE LISTA VERTICAL */
    .dtl-pure-table {
        min-width: 900px !important;
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
        border-radius: 50% !important; /* Círculo idéntico a la imagen */
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: var(--dtl-navy) !important; /* Número en azul oscuro */
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

    /* Botón Circular VERDE (Página Activa como el '2' de la foto) */
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
                    <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Expedientes Activos
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

    <!-- 2. BÚSQUEDA Y ACCIÓN -->
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

    <!-- 3. FORMULARIO DINÁMICO (CERRADO POR DEFECTO) -->
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

    <!-- 4. TABLA CON SCROLL LATERAL PURO (DERECHA / IZQUIERDA EN MÓVIL) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 12%;">RUC</th>
                            <th style="width: 24%;">RAZÓN SOCIAL</th>
                            <th style="width: 20%;">DIRECCIÓN</th>
                            <th style="width: 20%;">CONTACTO</th>
                            <th class="text-center" style="width: 10%;">ESTADO</th>
                            <th class="text-center" style="width: 8%;">ASIGNADO (CRM)</th>
                            <th class="pe-3 text-center" style="width: 6%;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-green); font-size: 0.78rem;">
                                    {{ $cliente->ruc }}
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase d-block" style="font-size: 0.78rem;">
                                        {{ $cliente->razon_social }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary d-block" style="font-size: 0.78rem;">{{ $cliente->direccion ?? '---' }}</span>
                                </td>
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
                                <td class="text-center">
                                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">{{ $cliente->user->name ?? 'Asesor Comercial' }}</span>
                                </td>
                                <td class="pe-3 text-center">
                                    <a href="{{ route('comercial.clientes.show', $cliente->id) }}" class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center text-decoration-none" style="background-color: #ecfdf5; color: var(--dtl-green); width: 28px; height: 28px;" title="Ver Bitácora e Historial 360°">
                                        <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                                    </a>
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

    <!-- 5. PAGINACIÓN IDÉNTICA A LA IMAGEN 1 (< 1 2 >) -->
    @if(isset($clientes) && $clientes->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                {{-- Botón Anterior (<) --}}
                @if ($clientes->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $clientes->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                {{-- Números de Página (1, 2, 3...) --}}
                @foreach ($clientes->getUrlRange(1, $clientes->lastPage()) as $page => $url)
                    @if ($page == $clientes->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Botón Siguiente (>) --}}
                @if ($clientes->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $clientes->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection