@extends('layouts.soporte')

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

    /* SCROLL HORIZONTAL TÁCTIL GARANTIZADO */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* TABLA FIJA QUE NO SE DESARMA NI SE TRANSFORMA EN LISTA */
    .dtl-pure-table {
        min-width: 860px !important;
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th {
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

    /* Botón Circular VERDE (Página Activa) */
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
                    <i class="fas fa-layer-group me-1" style="color: #10b981;"></i> BACK-OFFICE &bull; HU-09
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
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

    <!-- 2. BÚSQUEDA Y ALTA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('soporte.partidas.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por código, descripción o categoría..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; height: 38px;">
                    
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

                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" 
                        data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro" 
                        aria-expanded="false" aria-controls="seccionFormularioRegistro" 
                        title="Incorporar Nueva Partida">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO REGISTRO (COLAPSADO POR DEFECTO) -->
    <div class="collapse mb-3" id="seccionFormularioRegistro">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header px-3 d-flex align-items-center justify-content-between" style="background-color: var(--dtl-navy); border-bottom: 3px solid #059669;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle text-success"></i>
                    <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                        Incorporar Nueva Partida al Catálogo Oficial
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#seccionFormularioRegistro"></button>
            </div>

            <form action="{{ route('soporte.partidas.store') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5">
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Código Oficial <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" class="form-control form-control-sm py-1 text-uppercase font-monospace fw-bold" placeholder="Ej: PAR-011" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>
                        <div class="col-12 col-md-9">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Descripción del Trabajo / Servicio <span class="text-danger">*</span></label>
                            <input type="text" name="descripcion" class="form-control form-control-sm py-1" placeholder="Ej: Inspección Estructural con Ultrasonido..." style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Especialidad / Categoría <span class="text-danger">*</span></label>
                            <input type="text" name="categoria" class="form-control form-control-sm py-1" value="Obras Civiles" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
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

    <!-- 4. TABLA CON SCROLL LATERAL (DERECHA / IZQUIERDA EN MÓVIL) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 14%;">CÓDIGO</th>
                            <th style="width: 36%;">DESCRIPCIÓN DEL TRABAJO</th>
                            <th style="width: 18%;">CATEGORÍA</th>
                            <th class="text-center" style="width: 10%;">UNIDAD</th>
                            <th class="text-end" style="width: 12%;">PRECIO BASE</th>
                            <th class="pe-3 text-center" style="width: 10%;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partidas as $partida)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold text-nowrap">
                                    <span class="badge px-2 py-1" style="background-color: var(--dtl-navy); color: #34d399; font-size: 0.72rem;">
                                        {{ $partida->codigo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 0.80rem;">{{ $partida->descripcion }}</span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.68rem; background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                                        {{ $partida->categoria }}
                                    </span>
                                </td>
                                <td class="text-center font-monospace fw-semibold text-secondary text-nowrap" style="font-size: 0.78rem;">
                                    {{ $partida->unidad_medida }}
                                </td>
                                <td class="text-end font-monospace fw-bold text-nowrap" style="color: var(--dtl-green); font-size: 0.84rem;">
                                    S/ {{ number_format($partida->precio_unitario, 2) }}
                                </td>
                                <td class="pe-3 text-center text-nowrap">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm p-1 rounded-3 border-0" 
                                                style="background-color: #eff6ff; color: #2563eb; width: 28px; height: 28px;" 
                                                title="Ajustar Tarifa"
                                                data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}" 
                                                aria-expanded="false">
                                            <i class="fas fa-edit" style="font-size: 0.75rem;"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm p-1 rounded-3 border-0" 
                                                style="background-color: #f1f5f9; color: #475569; width: 28px; height: 28px;" 
                                                title="Historial de Auditoría"
                                                data-bs-toggle="collapse" data-bs-target="#collapseHistorial{{ $partida->id }}" 
                                                aria-expanded="false">
                                            <i class="fas fa-clock-rotate-left" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- FORMULARIO EDITAR EN LÍNEA: ULTRA COMPACTO A LO ANCHO -->
                            <tr class="collapse" id="collapseEditarPartida{{ $partida->id }}">
                                <td colspan="6" class="p-0 border-0 bg-white">
                                    <div class="p-2.5 p-md-3 my-2 mx-2 bg-white rounded-3 shadow-sm" style="border: 1px solid #cbd5e1; border-left: 4px solid #2563eb !important;">
                                        
                                        <div class="d-flex align-items-center justify-content-between pb-1.5 mb-2 border-bottom">
                                            <span class="fw-bold text-dark text-uppercase extra-small">
                                                <i class="fas fa-pen-to-square text-primary me-1"></i> Modificar Tarifa: 
                                                <span class="text-primary font-monospace">{{ $partida->codigo }}</span>
                                            </span>
                                            <button type="button" class="btn-close btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}" style="font-size: 0.65rem;"></button>
                                        </div>

                                        <form action="{{ route('soporte.partidas.update', $partida->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row g-2 align-items-center">
                                                <div class="col-7 col-md-8">
                                                    <label class="form-label mb-0 fw-semibold text-dark" style="font-size: 0.68rem;">Descripción *</label>
                                                    <input type="text" name="descripcion" class="form-control form-control-sm py-1" value="{{ $partida->descripcion }}" style="font-size: 0.78rem;" required>
                                                </div>

                                                <div class="col-5 col-md-4">
                                                    <label class="form-label mb-0 fw-semibold text-dark" style="font-size: 0.68rem;">Categoría *</label>
                                                    <input type="text" name="categoria" class="form-control form-control-sm py-1" value="{{ $partida->categoria }}" style="font-size: 0.78rem;" required>
                                                </div>

                                                <div class="col-3 col-md-2">
                                                    <label class="form-label mb-0 fw-semibold text-dark" style="font-size: 0.68rem;">Unidad *</label>
                                                    <input type="text" name="unidad_medida" class="form-control form-control-sm py-1 text-center font-monospace" value="{{ $partida->unidad_medida }}" style="font-size: 0.78rem;" required>
                                                </div>

                                                <div class="col-4 col-md-3">
                                                    <label class="form-label mb-0 fw-semibold text-dark" style="font-size: 0.68rem;">Tarifa (S/) *</label>
                                                    <input type="number" step="0.01" name="precio_unitario" class="form-control form-control-sm py-1 font-monospace fw-bold text-success" value="{{ $partida->precio_unitario }}" style="font-size: 0.80rem;" required>
                                                </div>

                                                <div class="col-5 col-md-7">
                                                    <label class="form-label mb-0 fw-semibold text-dark" style="font-size: 0.68rem;">Motivo del Cambio *</label>
                                                    <input type="text" name="motivo_cambio" class="form-control form-control-sm py-1" placeholder="Ej: Actualización de costos..." style="font-size: 0.78rem;" required>
                                                </div>

                                                <div class="col-12 d-flex justify-content-end gap-2 mt-2 pt-1 border-top" style="border-color: #f1f5f9 !important;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#collapseEditarPartida{{ $partida->id }}" style="font-size: 0.74rem;">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-dtl-primary px-3 py-1 fw-bold rounded-2" style="font-size: 0.74rem;">
                                                        <i class="fas fa-check me-1"></i> Guardar Cambios
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- AUDITORÍA EN LÍNEA -->
                            <tr class="collapse" id="collapseHistorial{{ $partida->id }}">
                                <td colspan="6" class="p-0 border-0 bg-white">
                                    <div class="p-3 my-2 mx-2 bg-white rounded-3 shadow-sm" style="border: 1px solid #cbd5e1; border-left: 4px solid #059669 !important;">
                                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                            <span class="fw-bold text-dark text-uppercase extra-small">
                                                <i class="fas fa-clock-rotate-left text-success me-1"></i> Auditoría: <span class="text-success font-monospace">{{ $partida->codigo }}</span>
                                            </span>
                                            <button type="button" class="btn-close btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseHistorial{{ $partida->id }}"></button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0 extra-small">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>FECHA</th>
                                                        <th>USUARIO</th>
                                                        <th class="text-end">TARIFA ANT.</th>
                                                        <th class="text-end">TARIFA NUEVA</th>
                                                        <th>MOTIVO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($partida->historialPrecios as $hist)
                                                        <tr>
                                                            <td class="text-nowrap">{{ $hist->created_at->format('d/m/Y H:i') }}</td>
                                                            <td class="text-nowrap">{{ $hist->usuario->name ?? 'Sistema' }}</td>
                                                            <td class="text-end font-monospace text-nowrap">S/ {{ number_format($hist->precio_anterior, 2) }}</td>
                                                            <td class="text-end font-monospace fw-bold text-success text-nowrap">S/ {{ number_format($hist->precio_nuevo, 2) }}</td>
                                                            <td>{{ $hist->motivo_cambio ?: 'Sin observación' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="5" class="text-center py-2 text-muted">Sin movimientos registrados.</td></tr>
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
                                    No se encontraron partidas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. PAGINACIÓN IDÉNTICA A LA IMAGEN 1 (< 1 2 >) -->
    @if(isset($partidas) && $partidas->hasPages())
        <div class="dtl-pagination-wrapper">
            <ul class="pagination">
                {{-- Botón Anterior (<) --}}
                @if ($partidas->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $partidas->previousPageUrl() }}">&lsaquo;</a></li>
                @endif

                {{-- Números de Página (1, 2, 3...) --}}
                @foreach ($partidas->getUrlRange(1, $partidas->lastPage()) as $page => $url)
                    @if ($page == $partidas->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Botón Siguiente (>) --}}
                @if ($partidas->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $partidas->nextPageUrl() }}">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection