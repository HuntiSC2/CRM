@extends('layouts.soporte')

@section('content')
<!-- Estilos Exclusivos Estandarizados DTL PREMIER - Módulo Soporte / Tarifarios -->
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

    .dtl-search-input:focus, .dtl-input:focus, .form-control:focus, .form-select:focus {
        border-color: var(--dtl-green) !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* Cabecera unificada y exacta para la tabla y formularios dinámicos */
    .dtl-table-hover thead th, .dtl-card-header-styled {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
        text-transform: uppercase;
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
        vertical-align: middle;
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

    /* Ocultar texto informativo excesivo de la paginación de Laravel */
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

    <!-- 1. ENCABEZADO INSTITUCIONAL ESTANDARIZADO (SIN LOGO) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-layer-group me-1" style="color: #10b981;"></i> BACK-OFFICE &bull; HU-09
                </span>

                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> Tarifario Oficial Vigente
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Catálogo Maestro de Partidas y Tarifarios Oficiales
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

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN DINÁMICO (+) AL COSTADO DERECHO DE BUSCAR -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('soporte.partidas.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por código de partida, descripción o categoría..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('soporte.partidas.index') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>

                <!-- Botón Dinámico (+) para desplegar el Formulario Colapsable (idéntico a Clientes) -->
                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" 
                        data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" 
                        aria-expanded="false" aria-controls="seccionFormularioRegistro" 
                        title="Incorporar Nueva Partida al Catálogo">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO DINÁMICO COLAPSABLE DE ALTA DE PARTIDA -->
    <div class="collapse mb-3" id="seccionFormularioRegistro">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center justify-content-between" style="border-bottom: 3px solid #059669;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle text-success"></i>
                    <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                        Incorporar Nueva Partida al Catálogo Oficial
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" aria-label="Close"></button>
            </div>

            <form action="{{ route('soporte.partidas.store') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5">
                        
                        <!-- FILA 1: Código Oficial y Descripción -->
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Código Oficial <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" class="form-control form-control-sm py-1 text-uppercase font-monospace fw-bold" placeholder="Ej: PAR-011" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <div class="col-12 col-md-9">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Descripción del Trabajo / Servicio <span class="text-danger">*</span></label>
                            <input type="text" name="descripcion" class="form-control form-control-sm py-1" placeholder="Ej: Inspección Estructural con Ultrasonido y Esclerometría" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <!-- FILA 2: Especialidad/Categoría, Unidad de Medida y Precio Unitario -->
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Especialidad / Categoría <span class="text-danger">*</span></label>
                            <input type="text" name="categoria" class="form-control form-control-sm py-1" value="Obras Civiles" placeholder="Ej: Movimiento de Tierras, Estructuras..." style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Unidad de Medida <span class="text-danger">*</span></label>
                            <select name="unidad_medida" class="form-select form-select-sm py-1" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                <option value="global">global (Servicio integral)</option>
                                <option value="jor">jor (Jornada técnica)</option>
                                <option value="m2">m2 (Metro cuadrado)</option>
                                <option value="m3">m3 (Metro cúbico)</option>
                                <option value="ml">ml (Metro lineal)</option>
                                <option value="kg">kg (Kilogramo)</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Precio Unitario Base (S/) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="precio_unitario" class="form-control form-control-sm py-1 font-monospace fw-bold text-success" placeholder="0.00" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white px-3 py-2 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">Dar de Alta Partida</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA RESPONSIVA Y COMPACTA DE PARTIDAS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover w-100" style="min-width: 760px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold text-uppercase" style="width: 14%;">CÓDIGO</th>
                            <th class="py-2.5 fw-bold text-uppercase" style="width: 38%;">DESCRIPCIÓN DEL TRABAJO</th>
                            <th class="py-2.5 fw-bold text-uppercase" style="width: 18%;">CATEGORÍA</th>
                            <th class="py-2.5 fw-bold text-center text-uppercase" style="width: 10%;">UNIDAD</th>
                            <th class="py-2.5 fw-bold text-end text-uppercase" style="width: 12%;">PRECIO BASE</th>
                            <th class="pe-3 py-2.5 fw-bold text-center text-uppercase" style="width: 8%;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partidas as $partida)
                            <!-- FILA DE DATOS DE LA PARTIDA -->
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3 font-monospace fw-bold" style="color: var(--dtl-navy); font-size: 0.78rem;">
                                    <span class="badge px-2 py-1" style="background-color: var(--dtl-navy); color: #34d399; font-size: 0.72rem; letter-spacing: 0.5px;">
                                        {{ $partida->codigo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block text-break" style="font-size: 0.80rem; line-height: 1.45;">{{ $partida->descripcion }}</span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill fw-semibold px-2 py-0.5 text-break" style="font-size: 0.68rem; background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                                        {{ $partida->categoria }}
                                    </span>
                                </td>
                                <td class="text-center font-monospace fw-semibold text-secondary" style="font-size: 0.78rem;">
                                    {{ $partida->unidad_medida }}
                                </td>
                                <td class="text-end font-monospace fw-bold" style="color: var(--dtl-green); font-size: 0.84rem;">
                                    S/ {{ number_format($partida->precio_unitario, 2) }}
                                </td>
                                <td class="pe-3 text-center">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Botón desplegable para editar en línea -->
                                        <button type="button" class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center text-decoration-none" 
                                                style="background-color: #eff6ff; color: #2563eb; width: 28px; height: 28px;" 
                                                title="Ajustar Tarifa y Detalles"
                                                data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}" 
                                                aria-expanded="false" aria-controls="collapseEditarPartida{{ $partida->id }}">
                                            <i class="fas fa-edit" style="font-size: 0.75rem;"></i>
                                        </button>

                                        <!-- Botón desplegable para ver pista de auditoría en línea -->
                                        <button type="button" class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center text-decoration-none" 
                                                style="background-color: #f1f5f9; color: #475569; width: 28px; height: 28px;" 
                                                title="Historial de Auditoría"
                                                data-bs-toggle="collapse" data-bs-target="#collapseHistorial{{ $partida->id }}" 
                                                aria-expanded="false" aria-controls="collapseHistorial{{ $partida->id }}">
                                            <i class="fas fa-clock-rotate-left" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- SECCIÓN DINÁMICA COLAPSABLE: EDICIÓN EN LÍNEA (SIN MODAL) -->
                            <tr class="collapse p-0" id="collapseEditarPartida{{ $partida->id }}">
                                <td colspan="6" class="p-0 border-0">
                                    <div class="p-3 my-2 mx-2 bg-white rounded-3 shadow-sm" style="border: 1px solid #cbd5e1 !important; border-left: 4px solid #2563eb !important;">
                                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom" style="border-color: #e2e8f0 !important;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-pen-to-square text-primary"></i>
                                                <span class="fw-bold text-dark text-uppercase" style="font-size: 0.74rem; letter-spacing: 0.5px;">
                                                    Ajuste de Tarifa y Modificación: <span class="text-primary font-monospace">{{ $partida->codigo }}</span>
                                                </span>
                                            </div>
                                            <button type="button" class="btn-close btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}"></button>
                                        </div>

                                        <form action="{{ route('soporte.partidas.update', $partida->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-2.5">
                                                <div class="col-12 col-md-5">
                                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Descripción <span class="text-danger">*</span></label>
                                                    <input type="text" name="descripcion" class="form-control form-control-sm py-1" value="{{ $partida->descripcion }}" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                                </div>

                                                <div class="col-12 col-md-2">
                                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Categoría <span class="text-danger">*</span></label>
                                                    <input type="text" name="categoria" class="form-control form-control-sm py-1" value="{{ $partida->categoria }}" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                                </div>

                                                <div class="col-12 col-md-2">
                                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Unidad <span class="text-danger">*</span></label>
                                                    <input type="text" name="unidad_medida" class="form-control form-control-sm py-1" value="{{ $partida->unidad_medida }}" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                                </div>

                                                <div class="col-12 col-md-3">
                                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Tarifa Oficial (S/) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" name="precio_unitario" class="form-control form-control-sm py-1 font-monospace fw-bold text-success" value="{{ $partida->precio_unitario }}" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                                                </div>

                                                <div class="col-12 col-md-9">
                                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Motivo del Ajuste (Pista de Auditoría Obligatoria) <span class="text-danger">*</span></label>
                                                    <input type="text" name="motivo_cambio" class="form-control form-control-sm py-1" placeholder="Ej: Actualización de costos de mano de obra y combustible..." style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                                </div>

                                                <div class="col-12 col-md-3 d-flex align-items-end justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}">Cancelar</button>
                                                    <button type="submit" class="btn btn-sm btn-dtl-primary px-3 fw-bold rounded-2">Guardar Ajuste</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- SECCIÓN DINÁMICA COLAPSABLE: PISTA DE AUDITORÍA EN LÍNEA (SIN MODAL) -->
                            <tr class="collapse p-0" id="collapseHistorial{{ $partida->id }}">
                                <td colspan="6" class="p-0 border-0">
                                    <div class="p-3 my-2 mx-2 bg-white rounded-3 shadow-sm" style="border: 1px solid #cbd5e1 !important; border-left: 4px solid #059669 !important;">
                                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom" style="border-color: #e2e8f0 !important;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-clock-rotate-left text-success"></i>
                                                <span class="fw-bold text-dark text-uppercase" style="font-size: 0.74rem; letter-spacing: 0.5px;">
                                                    Pista de Auditoría de Tarifas: <span class="text-success font-monospace">{{ $partida->codigo }}</span> - {{ $partida->descripcion }}
                                                </span>
                                            </div>
                                            <button type="button" class="btn-close btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseHistorial{{ $partida->id }}"></button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="font-size: 0.78rem;">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-3 py-2 fw-bold" style="width: 150px;">FECHA REGISTRO</th>
                                                        <th class="py-2 fw-bold" style="width: 220px;">AUDITOR / USUARIO</th>
                                                        <th class="py-2 text-end fw-bold" style="width: 130px;">TARIFA ANT.</th>
                                                        <th class="py-2 text-end fw-bold" style="width: 130px;">TARIFA NUEVA</th>
                                                        <th class="pe-3 py-2 fw-bold">MOTIVO DEL AJUSTE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($partida->historialPrecios as $hist)
                                                        <tr style="border-top: 1px solid #cbd5e1;">
                                                            <td class="ps-3 font-monospace text-muted" style="font-size: 0.74rem;">
                                                                {{ $hist->created_at->format('d/m/Y H:i') }}
                                                            </td>
                                                            <td>
                                                                <span class="fw-semibold text-dark">
                                                                    <i class="fas fa-user-check text-success me-1"></i>{{ $hist->usuario->name ?? 'Sistema' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end font-monospace text-muted" style="font-size: 0.78rem;">
                                                                S/ {{ number_format($hist->precio_anterior, 2) }}
                                                            </td>
                                                            <td class="text-end font-monospace fw-bold text-success" style="font-size: 0.82rem;">
                                                                S/ {{ number_format($hist->precio_nuevo, 2) }}
                                                            </td>
                                                            <td class="pe-3 text-secondary" style="font-size: 0.76rem;">
                                                                {{ $hist->motivo_cambio ?: 'Sin observación' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-3 text-muted small">Sin movimientos ni ajustes registrados en la pista de auditoría.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted small">
                                    <i class="fas fa-box-open d-block fs-2 mb-2 text-secondary opacity-50"></i>
                                    No se encontraron partidas registradas en el catálogo maestro.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN NUMERADA ESTANDARIZADA AL LADO DERECHO -->
    <div class="dtl-pagination-wrapper">
        @if(isset($partidas) && method_exists($partidas, 'links'))
            {{ $partidas->withQueryString()->links('pagination::bootstrap-5') }}
        @endif
    </div>

</div>
@endsection
