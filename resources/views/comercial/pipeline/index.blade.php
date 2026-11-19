@extends('layouts.app')

@section('content')
<style>
    :root {
        --dtl-navy: #0c192c;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
        --bg-gray-soft: #f1f5f9;
        --card-white: #ffffff;
    }

    .dtl-pipeline-wrapper {
        background-color: var(--bg-gray-soft);
        min-height: 94vh;
        border-radius: 16px;
        padding: 1rem 0.75rem;
    }

    /* KANBAN HORIZONTAL */
    .kanban-board-container { 
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        gap: 1rem !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        padding-bottom: 2.5rem;
        width: 100% !important;
    }

    /* Columnas en escritorio: fluidas y proporcionales */
    .kanban-col-dtl { 
        flex: 1 1 0px !important;
        min-width: 320px !important;
        min-height: 640px; 
        background-color: var(--card-white) !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 14px !important;
        padding: 0.85rem !important;
        box-shadow: 0 4px 6px -1px rgba(12, 25, 44, 0.05), 0 2px 4px -2px rgba(12, 25, 44, 0.05);
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    .kanban-col-dtl.drag-over {
        border-color: var(--dtl-green) !important;
        background-color: #ecfdf5 !important;
    }

    .col-header-centered {
        text-align: center !important;
        padding-bottom: 0.65rem;
        margin-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .col-header-title {
        font-size: 0.88rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: var(--dtl-navy);
        text-transform: uppercase;
        margin-bottom: 0.20rem;
    }
    .col-header-subtitle {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748b;
        font-family: monospace;
        letter-spacing: 0.2px;
    }

    /* TARJETA PRINCIPAL VERDE INSTITUCIONAL */
    .card-note-dtl {
        background-color: var(--dtl-green) !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.75rem 0.85rem !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.25);
        cursor: grab;
        position: relative;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        width: 100% !important;
    }
    .card-note-dtl:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(5, 150, 105, 0.35) !important;
    }
    .card-note-dtl:active { cursor: grabbing; }

    .card-note-dtl:has(.dropdown-menu.show),
    .card-note-dtl:has(.flyout-card-panel:not(.d-none)),
    .card-note-dtl:focus-within,
    .card-note-dtl.has-menu-open {
        z-index: 2000 !important;
    }

    .card-header-pills {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
        flex-grow: 1;
        min-width: 0;
    }

    .card-task-title {
        font-size: 0.85rem;
        font-weight: 700;
        line-height: 1.35;
        color: #ffffff;
        margin-bottom: 0.35rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
    }

    .card-task-client {
        font-size: 0.74rem;
        font-weight: 500;
        color: #e6fffa;
        margin-bottom: 0.50rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-note-lines {
        border-top: 1px dashed rgba(255, 255, 255, 0.35);
        padding-top: 0.45rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.72rem;
        font-weight: 700;
        color: #ffffff;
    }

    .card-amount-pill {
        background: rgba(0, 0, 0, 0.22);
        padding: 0.18rem 0.55rem;
        border-radius: 6px;
        font-family: monospace;
        letter-spacing: 0.3px;
    }

    /* PASTILLAS */
    .btn-pill-base {
        font-size: 0.55rem !important;
        font-weight: 800 !important;
        padding: 0.12rem 0.40rem !important;
        border-radius: 50rem !important;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        transition: all 0.15s ease-in-out;
        line-height: 1.25;
        white-space: nowrap;
        border: 1px solid transparent !important;
        cursor: pointer;
    }
    .btn-pill-base:hover {
        transform: translateY(-1px);
    }

    .pill-amarillo {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border-color: #fde68a !important;
    }
    .pill-amarillo:hover { background-color: #fde68a !important; }

    .pill-azul-enviada {
        background-color: #e0f2fe !important;
        color: #0369a1 !important;
        border-color: #bae6fd !important;
    }
    .pill-azul-enviada:hover { background-color: #bae6fd !important; }

    .pill-verde-ok {
        background-color: #ffffff !important;
        color: #047857 !important;
        border-color: #a7f3d0 !important;
    }

    .pill-rojo-rechazada {
        background-color: #ffffff !important;
        color: #dc2626 !important;
        border-color: #fecaca !important;
    }

    .dropdown-menu-dtl {
        z-index: 2050 !important;
        box-shadow: 0 14px 28px rgba(12, 25, 44, 0.20), 0 10px 10px rgba(12, 25, 44, 0.08) !important;
        border: 1px solid #cbd5e1 !important;
    }

    /* FLYOUTS BASE */
    .flyout-card-panel {
        position: absolute;
        top: 2px;
        left: calc(100% + 8px);
        z-index: 2040;
        width: 290px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.75rem 0.85rem;
        box-shadow: 0 14px 30px rgba(12, 25, 44, 0.22);
        color: #1e293b;
        animation: flyoutSlide 0.12s ease-out;
    }
    @keyframes flyoutSlide {
        from { opacity: 0; transform: translateX(-6px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .flyout-card-panel::before {
        content: '';
        position: absolute;
        top: 11px;
        left: -6px;
        width: 11px;
        height: 11px;
        background: #ffffff;
        border-left: 1px solid #cbd5e1;
        border-bottom: 1px solid #cbd5e1;
        transform: rotate(45deg);
    }

    .flyout-insp-left {
        left: auto !important;
        right: calc(100% + 10px) !important;
        width: 295px !important;
        z-index: 2040 !important;
        animation: flyoutSlideLeft 0.12s ease-out !important;
    }
    @keyframes flyoutSlideLeft {
        from { opacity: 0; transform: translateX(6px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .flyout-insp-left::before {
        left: auto !important;
        right: -6px !important;
        border-left: none !important;
        border-bottom: none !important;
        border-right: 1px solid #cbd5e1 !important;
        border-top: 1px solid #cbd5e1 !important;
    }

    .kanban-col-dtl:first-child .flyout-insp-left {
        left: calc(100% + 10px) !important;
        right: auto !important;
    }
    .kanban-col-dtl:first-child .flyout-insp-left::before {
        left: -6px !important;
        right: auto !important;
        border-right: none !important;
        border-top: none !important;
        border-left: 1px solid #cbd5e1 !important;
        border-bottom: 1px solid #cbd5e1 !important;
    }

    .kanban-col-dtl:last-child .flyout-card-panel:not(.flyout-insp-left) {
        left: auto;
        right: calc(100% + 8px);
    }
    .kanban-col-dtl:last-child .flyout-card-panel:not(.flyout-insp-left)::before {
        left: auto;
        right: -6px;
        border-left: none;
        border-bottom: none;
        border-right: 1px solid #cbd5e1;
        border-top: 1px solid #cbd5e1;
    }

    .nav-partes-mini {
        display: flex;
        gap: 3px;
        overflow-x: auto;
        padding-bottom: 2px;
        margin-bottom: 6px;
    }
    .btn-tab-parte {
        font-size: 0.62rem;
        font-weight: 700;
        padding: 0.15rem 0.40rem;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.12s;
    }
    .btn-tab-parte:hover { background: #e2e8f0; color: #0f172a; }
    .btn-tab-parte.active {
        background: var(--dtl-green) !important;
        color: #ffffff !important;
        border-color: var(--dtl-green) !important;
    }

    .btn-mini-action {
        width: 100%;
        padding: 0.38rem 0.50rem;
        border-radius: 6px;
        font-size: 0.70rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid transparent;
        transition: all 0.12s ease;
        cursor: pointer;
    }
    .btn-mini-ganada {
        background-color: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
    .btn-mini-ganada:hover {
        background-color: #059669;
        color: #ffffff;
    }
    .btn-mini-cancelada {
        background-color: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .btn-mini-cancelada:hover {
        background-color: #dc2626;
        color: #ffffff;
    }

    .input-error-dtl {
        border: 1.5px solid #ef4444 !important;
        background-color: #fef2f2 !important;
    }
    .msg-error-dtl {
        font-size: 0.64rem;
        font-weight: 700;
        color: #b91c1c;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .floating-new-obra-card {
        position: fixed;
        bottom: 85px;
        right: 25px;
        width: 320px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 1rem;
        box-shadow: 0 16px 35px -6px rgba(12, 25, 44, 0.25);
        z-index: 1085;
        animation: popUpCard 0.15s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes popUpCard {
        from { opacity: 0; transform: translateY(12px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .floating-new-obra-card::after {
        content: '';
        position: absolute;
        bottom: -7px;
        right: 22px;
        width: 14px;
        height: 14px;
        background: #ffffff;
        border-right: 1px solid #cbd5e1;
        border-bottom: 1px solid #cbd5e1;
        transform: rotate(45deg);
    }

    /* ==========================================================
       OPTIMIZACIÓN CLAVE PARA CELULAR (TARJETAS ANCHAS)
       - Columnas anchas a 86vw (ocupan casi toda la pantalla móvil)
       - Desplazamiento carrusel táctil suave (scroll-snap)
    ========================================================== */
    @media (max-width: 767.98px) {
        .container-fluid { padding-left: 6px !important; padding-right: 6px !important; }
        .dtl-pipeline-wrapper { padding: 0.5rem 0.25rem !important; }
        
        .kanban-board-container {
            scroll-snap-type: x mandatory !important;
            gap: 0.75rem !important;
            padding-left: 4px;
            padding-right: 4px;
        }

        /* Cada columna mide el 86% del ancho del celular */
        .kanban-col-dtl { 
            width: 86vw !important; 
            min-width: 86vw !important;
            max-width: 86vw !important;
            scroll-snap-align: center !important; /* Centra la columna al deslizar */
            padding: 0.75rem !important;
        }

        /* La tarjeta verde ocupa todo el ancho de la columna espaciosa */
        .card-note-dtl {
            padding: 0.70rem 0.75rem !important;
            width: 100% !important;
        }

        /* Pastillas compactas y proporcionadas en celular */
        .btn-pill-base {
            font-size: 0.50rem !important;
            padding: 0.10rem 0.35rem !important;
            gap: 2.5px !important;
        }
        .btn-pill-base i {
            font-size: 0.52rem !important;
        }

        .badge-codigo-obra {
            font-size: 0.54rem !important;
            padding: 0.10rem 0.32rem !important;
        }

        .card-task-title {
            font-size: 0.82rem !important;
            line-height: 1.3 !important;
            margin-bottom: 0.30rem !important;
        }

        .card-task-client {
            font-size: 0.70rem !important;
            margin-bottom: 0.40rem !important;
        }

        .card-note-lines {
            font-size: 0.68rem !important;
            padding-top: 0.40rem !important;
        }

        .card-amount-pill {
            font-size: 0.68rem !important;
            padding: 0.14rem 0.45rem !important;
        }

        .flyout-card-panel, .flyout-insp-left {
            left: 5% !important;
            right: 5% !important;
            width: 90% !important;
            top: 35px !important;
        }
        .flyout-card-panel::before, .flyout-insp-left::before { display: none !important; }

        .floating-new-obra-card { right: 10px; left: 10px; width: auto; bottom: 75px; }
    }
</style>

<div class="container-fluid px-2 px-md-3 py-3">
    <div class="dtl-pipeline-wrapper position-relative">

        @if(session('success'))
            <div class="alert border-0 rounded-3 shadow-sm mb-3 p-2.5 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; font-size: 0.82rem; border: 1px solid #a7f3d0 !important;">
                <i class="fas fa-circle-check me-2 fs-6" style="color: var(--dtl-green);"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <!-- ENCABEZADO -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
            <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
            <div class="card-body p-2.5 p-md-3">
                <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                    <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                        <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> PIPELINE COMERCIAL
                    </span>
                    <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                        <span class="status-pulse-green"></span> Flujo Dinámico Activo
                    </span>
                </div>

                <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                    Pipeline de Obras y Proyectos
                </h3>
            </div>
        </div>

        <!-- TABLERO KANBAN HORIZONTAL Y ANCHO -->
        <div class="d-flex kanban-board-container align-items-start" id="kanban-main-board">
            @foreach($statuses as $status)
                @php $totalSuma = $totalesPorColumna[$status] ?? 0; @endphp

                <div class="kanban-col-dtl d-flex flex-column flex-shrink-0" 
                     id="col-{{ Str::slug($status) }}" data-col-status="{{ $status }}"
                     ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropCard(event)">
                    
                    <div class="col-header-centered">
                        <div class="col-header-title">{{ $status }}</div>
                        <div class="col-header-subtitle">{{ count($obras[$status] ?? []) }} EXPEDIENTES &bull; S/ {{ number_format($totalSuma, 2) }}</div>
                    </div>

                    <div class="kanban-cards-container d-flex flex-column gap-2.5 flex-grow-1" data-status="{{ $status }}">
                        @if(isset($obras[$status]) && count($obras[$status]) > 0)
                            @foreach($obras[$status] as $obra)
                                @php
                                    $esProspectoColumna = ($status === 'Prospecto');
                                    $esCierreColumna    = ($status === 'Cierre Comercial');

                                    $puedeVerSiguienteParte = !$esCierreColumna && $obra['puede_agendar_inspeccion'];

                                    $mostrarAgendarInspeccionMenu = false;
                                    if (!$esCierreColumna && ($obra['puede_agendar_inspeccion'] ?? false)) {
                                        $mostrarAgendarInspeccionMenu = true;
                                    }

                                    $enumInsp = '(' . $obra['insp_completadas_count'] . '/' . $obra['total_inspecciones'] . ')';
                                    $enumCot  = '(' . $obra['cotizaciones_ok_count'] . '/' . $obra['total_cotizaciones'] . ')';
                                @endphp

                                <div class="card-note-dtl" draggable="true" ondragstart="dragStart(event)" 
                                     id="obra-card-{{ $obra['id'] }}" data-id="{{ $obra['id'] }}" data-monto="{{ $obra['monto_raw'] }}">
                                    
                                    <!-- FILA DE PASTILLAS -->
                                    <div class="d-flex align-items-center justify-content-between mb-1.5 position-relative">
                                        <div class="card-header-pills">
                                            
                                            <!-- CÓDIGO OBRA -->
                                            <span class="badge px-1 py-0.5 text-uppercase font-monospace flex-shrink-0 badge-codigo-obra" style="background-color: rgba(0, 0, 0, 0.22); color: #ffffff; font-size: 0.58rem; font-weight: 700;">
                                                #{{ $obra['codigo'] }}
                                            </span>

                                            <!-- PASTILLA 1: INSPECCIÓN -->
                                            @if($obra['tiene_inspeccion_pendiente'])
                                                <button type="button" 
                                                        class="btn-pill-base pill-amarillo flex-shrink-0" 
                                                        onclick="toggleFlyoutInspLeft(event, 'flyout-compact-insp-{{ $obra['id'] }}')"
                                                        title="Visita programada: {{ $obra['inspeccion_fecha'] }}">
                                                    <i class="fas fa-clock"></i>
                                                    Insp. Pend. {{ $enumInsp }}
                                                </button>

                                            @elseif($obra['inspeccion_es_completada'])
                                                <button type="button" class="btn-pill-base pill-verde-ok flex-shrink-0" 
                                                        onclick="toggleFlyoutInspLeft(event, 'flyout-compact-insp-{{ $obra['id'] }}')"
                                                        title="Ver historial de inspecciones">
                                                    <i class="fas fa-check-circle"></i> Insp. OK {{ $enumInsp }}
                                                </button>
                                            @endif

                                            <!-- TARJETITA COMPACTA FLOTANTE (INSPECCIÓN) -->
                                            <div id="flyout-compact-insp-{{ $obra['id'] }}" class="flyout-card-panel flyout-insp-left d-none" onclick="event.stopPropagation();">
                                                <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1 border-bottom">
                                                    <span class="text-dark fw-bold" style="font-size: 0.74rem;">
                                                        <i class="fas fa-clipboard-check text-success me-1"></i> Inspecciones Técnicas
                                                    </span>
                                                    <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-compact-insp-{{ $obra['id'] }}')"></button>
                                                </div>

                                                @if($obra['total_inspecciones'] > 0)
                                                    <div class="nav-partes-mini">
                                                        @foreach($obra['historial_inspecciones'] as $k => $h)
                                                            <button type="button" class="btn-tab-parte {{ $loop->last ? 'active' : '' }}" 
                                                                    onclick="cambiarTabParte('{{ $obra['id'] }}', '{{ $k }}', this)">
                                                                Parte #{{ $h['numero'] }}
                                                            </button>
                                                        @endforeach
                                                        
                                                        @if($puedeVerSiguienteParte)
                                                            <button type="button" class="btn-tab-parte text-success border-success" 
                                                                    onclick="mostrarNuevaParteMini('{{ $obra['id'] }}')" title="Agendar siguiente etapa">
                                                                <i class="fas fa-plus"></i> Siguiente Parte
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif

                                                @foreach($obra['historial_inspecciones'] as $k => $h)
                                                    <div class="tab-parte-content-{{ $obra['id'] }} {{ $loop->last ? '' : 'd-none' }}" id="tab-box-{{ $obra['id'] }}-{{ $k }}">
                                                        @if($h['estado'] === 'Pendiente')
                                                            <div class="p-1.5 rounded border bg-light mb-1.5">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 0.66rem;">Visita Pendiente en Curso</span>
                                                                    <span class="badge bg-warning text-dark font-monospace" style="font-size: 0.58rem;">Pendiente</span>
                                                                </div>

                                                                <div class="mb-1">
                                                                    <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Ingeniero Asignado:</label>
                                                                    <input type="text" id="ing-act-{{ $obra['id'] }}-{{ $h['id'] }}" value="{{ $h['ingeniero'] }}" class="form-control form-control-sm py-0.5" style="font-size: 0.70rem; height: 26px;" oninput="limpiarErrorValidacion(this, 'msg-error-ing-{{ $obra['id'] }}-{{ $h['id'] }}')">
                                                                    <div id="msg-error-ing-{{ $obra['id'] }}-{{ $h['id'] }}" class="msg-error-dtl d-none">
                                                                        <i class="fas fa-circle-exclamation"></i> Ingrese el ingeniero asignado.
                                                                    </div>
                                                                </div>

                                                                <div class="mb-1">
                                                                    <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Fecha Programada:</label>
                                                                    <input type="datetime-local" id="fecha-act-{{ $obra['id'] }}-{{ $h['id'] }}" value="{{ $obra['inspeccion_fecha_raw'] }}" class="form-control form-control-sm py-0.5" style="font-size: 0.70rem; height: 26px;" oninput="limpiarErrorValidacion(this, 'msg-error-fecha-{{ $obra['id'] }}-{{ $h['id'] }}')">
                                                                    <div id="msg-error-fecha-{{ $obra['id'] }}-{{ $h['id'] }}" class="msg-error-dtl d-none">
                                                                        <i class="fas fa-circle-exclamation"></i> Seleccione una fecha válida.
                                                                    </div>
                                                                </div>

                                                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 py-0.5 mb-1.5 fw-bold" 
                                                                        style="font-size: 0.64rem;" onclick="reprogramarFechaMini(this, '{{ $h['id'] }}', '{{ $obra['id'] }}')">
                                                                    <i class="fas fa-clock-rotate-left me-1"></i> Actualizar Fecha por Retraso
                                                                </button>

                                                                <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.66rem;">Dictamen / Metrado de Campo *</label>
                                                                <textarea id="dictamen-act-{{ $obra['id'] }}-{{ $h['id'] }}" rows="2" class="form-control form-control-sm mb-0.5" style="font-size: 0.70rem;" placeholder="Metrados y factibilidad técnica de esta etapa..." oninput="limpiarErrorValidacion(this, 'msg-error-dictamen-{{ $obra['id'] }}-{{ $h['id'] }}')"></textarea>
                                                                
                                                                <div id="msg-error-dictamen-{{ $obra['id'] }}-{{ $h['id'] }}" class="msg-error-dtl d-none mb-1">
                                                                    <i class="fas fa-circle-exclamation"></i> Ingrese el dictamen o metrado de campo.
                                                                </div>

                                                                <button type="button" class="btn btn-sm w-100 fw-bold text-white py-1 mt-1" 
                                                                        style="background-color: var(--dtl-green); font-size: 0.68rem;"
                                                                        onclick="finalizarInspMini(this, '{{ $h['id'] }}', '{{ $obra['id'] }}')">
                                                                    <i class="fas fa-check-circle me-1"></i> Completar Dictamen de Inspección
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="p-1.5 rounded border bg-light mb-1.5" style="font-size: 0.68rem;">
                                                                <div class="d-flex justify-content-between mb-0.5">
                                                                    <span class="fw-bold text-dark">{{ $h['ingeniero'] }}</span>
                                                                    <span class="badge bg-success" style="font-size: 0.58rem;">Completada</span>
                                                                </div>
                                                                <div class="text-muted mb-1" style="font-size: 0.63rem;"><i class="fas fa-calendar-day me-1"></i>{{ $h['fecha'] }}</div>
                                                                <div class="text-secondary p-1 rounded bg-white border" style="font-size: 0.65rem;">
                                                                    {{ $h['resultado'] ?? 'Sin dictamen registrado.' }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                @if($puedeVerSiguienteParte)
                                                    <div id="box-nueva-parte-{{ $obra['id'] }}" class="d-none p-1.5 rounded border bg-light">
                                                        <div class="fw-bold text-dark mb-1" style="font-size: 0.68rem;">
                                                            <i class="fas fa-calendar-plus text-success me-1"></i> Agendar Inspección / Nueva Etapa
                                                        </div>
                                                        <div class="mb-1">
                                                            <input type="text" id="nueva-ing-{{ $obra['id'] }}" class="form-control form-control-sm py-0.5" style="font-size: 0.70rem; height: 26px;" placeholder="Ingeniero Asignado *" oninput="limpiarErrorValidacion(this, 'msg-error-nueva-ing-{{ $obra['id'] }}')">
                                                            <div id="msg-error-nueva-ing-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                <i class="fas fa-circle-exclamation"></i> Ingrese el ingeniero responsable.
                                                            </div>
                                                        </div>
                                                        <div class="mb-1.5">
                                                            <input type="datetime-local" id="nueva-fecha-{{ $obra['id'] }}" value="{{ date('Y-m-d\T09:00') }}" class="form-control form-control-sm py-0.5" style="font-size: 0.70rem; height: 26px;">
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-success w-100 fw-bold py-1" style="font-size: 0.68rem;" onclick="guardarNuevaParteMini(this, '{{ $obra['id'] }}')">
                                                            <i class="fas fa-save me-1"></i> Guardar Visita
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- PASTILLA 2: COTIZACIÓN -->
                                            @if($obra['tiene_cotizaciones'])
                                                @if($obra['estado_cotizacion'] === 'Programada')
                                                    <button type="button" class="btn-pill-base pill-amarillo flex-shrink-0" 
                                                            onclick="toggleFlyout(event, 'flyout-cot-{{ $obra['id'] }}')"
                                                            title="Cotización programada. Clic para gestionar.">
                                                        <i class="fas fa-clock"></i> Cotiz. Pend. {{ $enumCot }}
                                                    </button>

                                                    <div id="flyout-cot-{{ $obra['id'] }}" class="flyout-card-panel d-none" style="width: 290px;" onclick="event.stopPropagation();">
                                                        <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1 border-bottom">
                                                            <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                                <i class="fas fa-paper-plane text-primary me-1"></i> Gestión de Cotización
                                                            </span>
                                                            <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-cot-{{ $obra['id'] }}')"></button>
                                                        </div>

                                                        <div class="p-1.5 rounded border bg-light mb-2">
                                                            <label class="form-label text-muted mb-0.5" style="font-size: 0.63rem;">Fecha de Emisión Programada:</label>
                                                            <input type="date" id="reprog-cot-fecha-{{ $obra['id'] }}" value="{{ $obra['cotizacion_fecha_emision'] }}" class="form-control form-control-sm py-0.5 mb-1" style="font-size: 0.70rem; height: 26px;">
                                                            
                                                            <button type="button" class="btn btn-sm btn-outline-secondary w-100 py-0.5 fw-bold" 
                                                                    style="font-size: 0.64rem;" onclick="reprogramarCotizacionFecha(this, '{{ $obra['cotizacion_id'] }}', '{{ $obra['id'] }}')">
                                                                <i class="fas fa-clock-rotate-left me-1"></i> Actualizar Fecha por Retraso
                                                            </button>
                                                        </div>

                                                        <div class="mb-1.5">
                                                            <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Monto Cotizado (S/) *</label>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text bg-light fw-bold" style="font-size: 0.68rem;">S/</span>
                                                                <input type="number" step="0.01" min="1" id="cot-monto-{{ $obra['id'] }}" class="form-control form-control-sm font-monospace fw-bold" placeholder="0.00" oninput="limpiarErrorValidacion(this, 'msg-error-cotmonto-{{ $obra['id'] }}')">
                                                            </div>
                                                            <div id="msg-error-cotmonto-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                <i class="fas fa-circle-exclamation"></i> Ingrese un monto válido mayor a 0.
                                                            </div>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Condiciones / Observaciones</label>
                                                            <textarea id="cot-obs-{{ $obra['id'] }}" rows="2" class="form-control form-control-sm" style="font-size: 0.72rem;" placeholder="Validez de oferta, condiciones de pago..."></textarea>
                                                        </div>

                                                        <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                                style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                                onclick="enviarCotDirecto(this, '{{ $obra['id'] }}', '{{ $obra['cotizacion_id'] }}')">
                                                            <i class="fas fa-paper-plane"></i> Emitir Cotización
                                                        </button>
                                                    </div>

                                                @elseif($obra['estado_cotizacion'] === 'Enviada')
                                                    <button type="button" class="btn-pill-base pill-azul-enviada flex-shrink-0" 
                                                            onclick="toggleFlyout(event, 'flyout-responder-cot-{{ $obra['id'] }}')"
                                                            title="Cotización enviada. Clic para registrar respuesta.">
                                                        <i class="fas fa-paper-plane"></i> Cotiz. Enviada {{ $enumCot }}
                                                    </button>

                                                    <div id="flyout-responder-cot-{{ $obra['id'] }}" class="flyout-card-panel d-none" style="width: 235px;" onclick="event.stopPropagation();">
                                                        <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1 border-bottom">
                                                            <span class="text-dark fw-bold" style="font-size: 0.70rem;">
                                                                <i class="fas fa-reply text-primary me-1"></i> Respuesta del Cliente
                                                            </span>
                                                            <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-responder-cot-{{ $obra['id'] }}')"></button>
                                                        </div>
                                                        <p class="text-muted mb-2" style="font-size: 0.65rem; line-height: 1.25;">
                                                            ¿Cuál fue la resolución del cliente respecto a la cotización emitida?
                                                        </p>
                                                        <div class="d-flex flex-column gap-1.5">
                                                            <button type="button" class="btn-mini-action btn-mini-ganada" 
                                                                    onclick="ejecutarRespuestaCotizacion(this, '{{ $obra['cotizacion_id'] }}', 'Aceptada')">
                                                                <span><i class="fas fa-check-double me-1 text-success"></i> Cotización Aceptada</span>
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn-mini-action btn-mini-cancelada" 
                                                                    onclick="ejecutarRespuestaCotizacion(this, '{{ $obra['cotizacion_id'] }}', 'Rechazada')">
                                                                <span><i class="fas fa-times-circle me-1 text-danger"></i> Cotización Rechazada</span>
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                @elseif($obra['estado_cotizacion'] === 'Aceptada')
                                                    <button type="button" class="btn-pill-base pill-verde-ok flex-shrink-0" 
                                                            onclick="toggleFlyout(event, 'flyout-view-cot-{{ $obra['id'] }}')"
                                                            title="Clic para ver detalle de cotización">
                                                        <i class="fas fa-check-circle"></i> Cotiz. OK {{ $enumCot }}
                                                    </button>

                                                @elseif($obra['estado_cotizacion'] === 'Rechazada')
                                                    <button type="button" class="btn-pill-base pill-rojo-rechazada flex-shrink-0" 
                                                            onclick="toggleFlyout(event, 'flyout-view-cot-{{ $obra['id'] }}')"
                                                            title="Clic para ver detalle de cotización">
                                                        <i class="fas fa-times-circle"></i> Cotiz. Rech. {{ $enumCot }}
                                                    </button>
                                                @endif

                                                @if($obra['cotizacion_finalizada'])
                                                    <div id="flyout-view-cot-{{ $obra['id'] }}" class="flyout-card-panel d-none" style="width: 295px;" onclick="event.stopPropagation();">
                                                        <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1 border-bottom">
                                                            <span class="text-dark fw-bold" style="font-size: 0.74rem;">
                                                                <i class="fas fa-file-invoice text-success me-1"></i> Cotizaciones Emitidas
                                                            </span>
                                                            <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-view-cot-{{ $obra['id'] }}')"></button>
                                                        </div>

                                                        @if(count($obra['historial_cotizaciones']) > 0)
                                                            <div class="nav-partes-mini">
                                                                @foreach($obra['historial_cotizaciones'] as $ck => $cotItem)
                                                                    <button type="button" class="btn-tab-parte {{ $loop->last ? 'active' : '' }}" 
                                                                            onclick="cambiarTabCotizacion('{{ $obra['id'] }}', '{{ $ck }}', this)">
                                                                        Fase #{{ $cotItem['numero'] }}
                                                                    </button>
                                                                @endforeach
                                                            </div>

                                                            @foreach($obra['historial_cotizaciones'] as $ck => $cotItem)
                                                                <div class="tab-cot-content-{{ $obra['id'] }} {{ $loop->last ? '' : 'd-none' }}" id="tab-box-cot-{{ $obra['id'] }}-{{ $ck }}">
                                                                    <div class="p-1.5 rounded border bg-light mb-1" style="font-size: 0.68rem;">
                                                                        <div class="d-flex justify-content-between text-muted mb-1">
                                                                            <span><strong>Cód:</strong> {{ $cotItem['codigo'] }}</span>
                                                                            <span class="badge {{ $cotItem['estado'] === 'Aceptada' ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.58rem;">{{ $cotItem['estado'] }}</span>
                                                                        </div>
                                                                        <div class="mb-1 text-dark"><strong>Monto:</strong> <span class="font-monospace fw-bold">{{ $cotItem['monto'] }}</span></div>
                                                                        <div class="mb-1 text-muted"><strong>Fecha:</strong> {{ $cotItem['fecha'] }}</div>
                                                                        
                                                                        <div class="p-1 rounded bg-white border mt-1" style="font-size: 0.64rem;">
                                                                            <div class="text-success fw-bold mb-0.5">
                                                                                <i class="fas fa-link me-1"></i> Vinculada a Inspección #{{ $cotItem['insp_numero'] }} ({{ $cotItem['insp_ingeniero'] }})
                                                                            </div>
                                                                            <div class="text-secondary text-truncate" title="{{ $cotItem['insp_dictamen'] }}">
                                                                                {{ $cotItem['insp_dictamen'] }}
                                                                            </div>
                                                                        </div>

                                                                        @if($cotItem['estado'] === 'Rechazada' && !$esCierreColumna)
                                                                            <div class="mt-2 pt-1 border-top d-flex flex-column gap-1.5">
                                                                                <button type="button" class="btn btn-sm btn-outline-warning w-100 fw-bold py-1 text-dark d-flex align-items-center justify-content-center gap-1"
                                                                                        style="font-size: 0.66rem; background-color: #fef3c7;"
                                                                                        onclick="abrirFormAjustarPrecio('{{ $obra['id'] }}', '{{ $cotItem['id'] }}')">
                                                                                    <i class="fas fa-calculator text-warning"></i> Actualizar precio
                                                                                </button>

                                                                                <button type="button" class="btn btn-sm btn-outline-danger w-100 fw-bold py-1 d-flex align-items-center justify-content-center gap-1"
                                                                                        style="font-size: 0.66rem; background-color: #fef2f2; color: #dc2626; border-color: #fecaca;"
                                                                                        onclick="abrirFormCerrarObra('{{ $obra['id'] }}', '{{ $cotItem['id'] }}')">
                                                                                    <i class="fas fa-ban text-danger"></i> Cerrar Obra
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        <!-- FORMULARIO AJUSTE PRECIO -->
                                                        <div id="box-ajustar-precio-{{ $obra['id'] }}" class="d-none p-2 rounded border bg-white mt-1">
                                                            <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom">
                                                                <span class="fw-bold text-dark" style="font-size: 0.68rem;"><i class="fas fa-edit text-warning me-1"></i> Reajuste Económico</span>
                                                                <button type="button" class="btn-close p-0" style="font-size: 0.45rem;" onclick="cerrarFormAjustarPrecio('{{ $obra['id'] }}')"></button>
                                                            </div>
                                                            <input type="hidden" id="ajuste-cot-id-{{ $obra['id'] }}">
                                                            
                                                            <div class="mb-1">
                                                                <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Nuevo Monto (S/) *</label>
                                                                <input type="number" step="0.01" min="1" id="ajuste-monto-{{ $obra['id'] }}" class="form-control form-control-sm font-monospace fw-bold py-0.5" style="font-size: 0.70rem; height: 26px;" placeholder="0.00" oninput="limpiarErrorValidacion(this, 'msg-error-ajustemonto-{{ $obra['id'] }}')">
                                                                <div id="msg-error-ajustemonto-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                    <i class="fas fa-circle-exclamation"></i> Ingrese el nuevo monto.
                                                                </div>
                                                            </div>

                                                            <div class="mb-1.5">
                                                                <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Motivo del Reajuste *</label>
                                                                <textarea id="ajuste-motivo-{{ $obra['id'] }}" rows="2" class="form-control form-control-sm" style="font-size: 0.68rem;" placeholder="Ej. Cambio de especificaciones técnicas..." oninput="limpiarErrorValidacion(this, 'msg-error-ajustemotivo-{{ $obra['id'] }}')"></textarea>
                                                                <div id="msg-error-ajustemotivo-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                    <i class="fas fa-circle-exclamation"></i> Indique el motivo del reajuste.
                                                                </div>
                                                            </div>

                                                            <button type="button" class="btn btn-sm btn-success w-100 fw-bold py-1" style="font-size: 0.68rem;" onclick="guardarAjustePrecioAjax(this, '{{ $obra['id'] }}')">
                                                                <i class="fas fa-check me-1"></i> Guardar y Reemitir
                                                            </button>
                                                        </div>

                                                        <!-- FORMULARIO CERRAR OBRA -->
                                                        <div id="box-cerrar-obra-{{ $obra['id'] }}" class="d-none p-2 rounded border bg-white mt-1" style="border-color: #fecaca !important;">
                                                            <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom">
                                                                <span class="fw-bold text-danger" style="font-size: 0.68rem;"><i class="fas fa-ban text-danger me-1"></i> Cerrar Obra (Perdida)</span>
                                                                <button type="button" class="btn-close p-0" style="font-size: 0.45rem;" onclick="cerrarFormCerrarObra('{{ $obra['id'] }}')"></button>
                                                            </div>
                                                            <input type="hidden" id="cerrar-cot-id-{{ $obra['id'] }}">

                                                            <div class="mb-1">
                                                                <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Tipo de Contacto <span class="text-danger">*</span></label>
                                                                <select id="cerrar-tipo-contacto-{{ $obra['id'] }}" class="form-select form-select-sm py-0.5" style="font-size: 0.70rem; height: 26px;">
                                                                    <option value="Llamada Telefónica" selected>Llamada Telefónica</option>
                                                                    <option value="Reunión Presencial">Reunión Presencial</option>
                                                                    <option value="Correo Electrónico">Correo Electrónico / WhatsApp</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-1.5">
                                                                <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Motivo del Cierre <span class="text-danger">*</span></label>
                                                                <textarea id="cerrar-motivo-{{ $obra['id'] }}" rows="2" class="form-control form-control-sm" style="font-size: 0.68rem;" placeholder="Ej. Cliente desestimó la propuesta..." oninput="limpiarErrorValidacion(this, 'msg-error-cerrarmotivo-{{ $obra['id'] }}')"></textarea>
                                                                <div id="msg-error-cerrarmotivo-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                    <i class="fas fa-circle-exclamation"></i> Ingrese el motivo de cierre.
                                                                </div>
                                                            </div>

                                                            <button type="button" class="btn btn-sm btn-danger w-100 fw-bold py-1" style="font-size: 0.68rem;" onclick="guardarCerrarObraAjax(this, '{{ $obra['id'] }}')">
                                                                <i class="fas fa-times-circle me-1"></i> Confirmar Cierre como Perdida
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            <!-- PASTILLA 3: CIERRE COMERCIAL -->
                                            @if($esCierreColumna)
                                                <button type="button" class="btn-pill-base pill-amarillo flex-shrink-0" 
                                                        onclick="toggleFlyout(event, 'flyout-cierre-{{ $obra['id'] }}')"
                                                        title="Definir resolución final de la obra">
                                                    <i class="fas fa-flag-checkered text-warning"></i> Cierre
                                                </button>

                                                <div id="flyout-cierre-{{ $obra['id'] }}" class="flyout-card-panel d-none" style="width: 260px;" onclick="event.stopPropagation();">
                                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                        <span class="text-dark fw-bold" style="font-size: 0.68rem;">
                                                            <i class="fas fa-handshake text-warning me-1"></i> RESOLUCIÓN
                                                        </span>
                                                        <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-cierre-{{ $obra['id'] }}')"></button>
                                                    </div>
                                                    
                                                    <div class="d-flex flex-column gap-1.5" id="cierre-opciones-{{ $obra['id'] }}">
                                                        <button type="button" class="btn-mini-action btn-mini-ganada" 
                                                                onclick="ejecutarCierreDirecto(this, '{{ $obra['id'] }}', 'Aceptada')">
                                                            <span><i class="fas fa-trophy me-1 text-success"></i> Obra Ganada</span>
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn-mini-action btn-mini-cancelada" 
                                                                onclick="mostrarFormCancelarCierre('{{ $obra['id'] }}')">
                                                            <span><i class="fas fa-ban me-1 text-danger"></i> Cancelar Obra</span>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>

                                                    <div id="cierre-form-cancelar-{{ $obra['id'] }}" class="d-none p-1.5 rounded border bg-light mt-1" style="border-color: #fecaca !important;">
                                                        <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom">
                                                            <span class="fw-bold text-danger" style="font-size: 0.68rem;"><i class="fas fa-ban text-danger me-1"></i> Cancelar Obra</span>
                                                            <button type="button" class="btn-close p-0" style="font-size: 0.45rem;" onclick="ocultarFormCancelarCierre('{{ $obra['id'] }}')"></button>
                                                        </div>

                                                        <div class="mb-1">
                                                            <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Tipo de Contacto <span class="text-danger">*</span></label>
                                                            <select id="cancelar-tipo-contacto-{{ $obra['id'] }}" class="form-select form-select-sm py-0.5" style="font-size: 0.70rem; height: 26px;">
                                                                <option value="Llamada Telefónica" selected>Llamada Telefónica</option>
                                                                <option value="Reunión Presencial">Reunión Presencial</option>
                                                                <option value="Correo Electrónico">Correo Electrónico / WhatsApp</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-1.5">
                                                            <label class="form-label text-muted mb-0" style="font-size: 0.63rem;">Motivo de Cancelación <span class="text-danger">*</span></label>
                                                            <textarea id="cancelar-motivo-{{ $obra['id'] }}" rows="2" class="form-control form-control-sm" style="font-size: 0.68rem;" placeholder="Escriba el motivo..." oninput="limpiarErrorValidacion(this, 'msg-error-cancelarmotivo-{{ $obra['id'] }}')"></textarea>
                                                            <div id="msg-error-cancelarmotivo-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                                <i class="fas fa-circle-exclamation"></i> Ingrese el motivo de cancelación.
                                                            </div>
                                                        </div>

                                                        <button type="button" class="btn btn-sm btn-danger w-100 fw-bold py-1" style="font-size: 0.68rem;" onclick="confirmarCancelarObraCierre(this, '{{ $obra['id'] }}')">
                                                            <i class="fas fa-times-circle me-1"></i> Confirmar Cancelación
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                        <!-- MENÚ DE TRES PUNTOS -->
                                        <div class="dropdown flex-shrink-0 ms-1">
                                            <button class="btn btn-sm p-0 border-0 d-flex align-items-center justify-content-center text-white opacity-75" 
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false" 
                                                    style="width: 20px; height: 20px;">
                                                <i class="fas fa-ellipsis-h" style="font-size: 0.82rem;"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 dropdown-menu-dtl" style="font-size: 0.76rem; min-width: 215px;">
                                                <li><h6 class="dropdown-header text-uppercase fw-bold px-2 py-0.5 text-muted" style="font-size: 0.62rem;">Hitos Técnicos</h6></li>
                                                
                                                @if(!$esCierreColumna)
                                                    @if($mostrarAgendarInspeccionMenu)
                                                        <li>
                                                            <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyoutInspLeft(event, 'flyout-compact-insp-{{ $obra['id'] }}', true)">
                                                                <i class="fas fa-calendar-plus text-success me-1.5"></i> Agendar Inspección
                                                            </button>
                                                        </li>
                                                    @elseif($obra['tiene_inspeccion_pendiente'])
                                                        <li>
                                                            <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium text-warning" onclick="toggleFlyoutInspLeft(event, 'flyout-compact-insp-{{ $obra['id'] }}')">
                                                                <i class="fas fa-clock-rotate-left me-1.5"></i> Ver / Reprogramar Visita
                                                            </button>
                                                        </li>
                                                    @endif

                                                    @if(!$esProspectoColumna && $obra['puede_programar_cotizacion'])
                                                        <li>
                                                            <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyout(event, 'flyout-programar-cot-{{ $obra['id'] }}')">
                                                                <i class="fas fa-file-invoice-dollar text-primary me-1.5"></i> Programar Cotización
                                                            </button>
                                                        </li>
                                                    @endif

                                                    @if($obra['puede_ir_a_cierre'] && !$obra['es_rechazada'])
                                                        <li>
                                                            <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-bold text-success" onclick="trasladarACierreDirecto(this, '{{ $obra['id'] }}')">
                                                                <i class="fas fa-magnet text-success me-1.5"></i> Ir a Cierre Comercial
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endif

                                                <li>
                                                    <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyout(event, 'flyout-bitacora-{{ $obra['id'] }}')">
                                                        <i class="fas fa-pen-nib text-warning me-1.5"></i> Nota de Bitácora
                                                    </button>
                                                </li>

                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li><h6 class="dropdown-header text-uppercase fw-bold px-2 py-0.5 text-muted" style="font-size: 0.62rem;">Libertad Manual</h6></li>
                                                @foreach($statuses as $targetStatus)
                                                    @if($obra['es_rechazada'] && $targetStatus === 'Cierre Comercial')
                                                        @continue
                                                    @endif
                                                    <li>
                                                        <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="moverTarjetaPorMenu('{{ $obra['id'] }}', '{{ $targetStatus }}')">
                                                            <i class="fas fa-arrow-right text-muted me-1.5"></i> A {{ $targetStatus }}
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <!-- POPOVER: PROGRAMAR COTIZACIÓN -->
                                        @if(!$esProspectoColumna && !$esCierreColumna)
                                            <div id="flyout-programar-cot-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                    <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                        <i class="fas fa-file-invoice-dollar text-primary me-1"></i> Programar Cotización
                                                    </span>
                                                    <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-programar-cot-{{ $obra['id'] }}')"></button>
                                                </div>

                                                <div class="mb-2">
                                                    <small class="text-muted d-block" style="font-size: 0.68rem;">Proyecto: <strong>{{ $obra['titulo'] }}</strong></small>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Fecha de Emisión *</label>
                                                    <input type="date" id="prog-fecha-emision-{{ $obra['id'] }}" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" style="font-size: 0.72rem;" required oninput="limpiarErrorValidacion(this, 'msg-error-progfecha-{{ $obra['id'] }}')">
                                                    <div id="msg-error-progfecha-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                        <i class="fas fa-circle-exclamation"></i> Seleccione una fecha válida.
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                        style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                        onclick="enviarProgramarCotizacionDirecto(this, '{{ $obra['id'] }}')">
                                                    <i class="fas fa-check me-1"></i> Programar y Ubicar en Cotización
                                                </button>
                                            </div>
                                        @endif

                                        <!-- POPOVER: NOTA DE BITÁCORA -->
                                        <div id="flyout-bitacora-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                    <i class="fas fa-clipboard-list text-warning me-1"></i> Bitácora Técnica
                                                </span>
                                                <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-bitacora-{{ $obra['id'] }}')"></button>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Nota / Suceso de Seguimiento *</label>
                                                <textarea id="bitacora-desc-{{ $obra['id'] }}" rows="3" class="form-control form-control-sm" style="font-size: 0.74rem;" placeholder="Acuerdos con cliente, especificaciones..." oninput="limpiarErrorValidacion(this, 'msg-error-bitacora-{{ $obra['id'] }}')"></textarea>
                                                <div id="msg-error-bitacora-{{ $obra['id'] }}" class="msg-error-dtl d-none">
                                                    <i class="fas fa-circle-exclamation"></i> Ingrese la nota de seguimiento.
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                    style="background-color: #f59e0b; font-size: 0.72rem;"
                                                    onclick="enviarBitacoraDirecto(this, '{{ $obra['id'] }}')">
                                                <i class="fas fa-save me-1"></i> Guardar en Bitácora
                                            </button>
                                        </div>

                                    </div>

                                    <!-- CUERPO DE LA TARJETA VERDE: TÍTULO HASTA EN 2 LÍNEAS COMPLETAS -->
                                    <div class="card-task-title" title="{{ $obra['titulo'] }}">
                                        {{ $obra['titulo'] }}
                                    </div>

                                    <div class="card-task-client" title="{{ $obra['cliente'] }}">
                                        <i class="fas fa-building me-1 opacity-75"></i>{{ $obra['cliente'] }}
                                    </div>

                                    <div class="card-note-lines">
                                        <span>
                                            <i class="fas fa-calendar-alt me-1 opacity-75"></i>{{ $obra['fecha'] }}
                                        </span>
                                        <span class="card-amount-pill">
                                            {{ $obra['monto'] }}
                                        </span>
                                    </div>

                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 my-auto empty-col-placeholder" style="opacity: 0.4;">
                                <i class="fas fa-clipboard-check fs-3 mb-1 text-muted"></i>
                                <p class="mb-0 small fw-bold text-uppercase text-muted" style="font-size: 0.65rem;">Sin proyectos</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- BOTONES FLOTANTES INFERIORES -->
        <div class="position-fixed bottom-0 end-0 p-3 p-md-4 d-flex align-items-center gap-2" style="z-index: 1040;">
            <a href="{{ route('comercial.pipeline.historial') }}" 
               class="btn shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center text-white" 
               style="width: 48px; height: 48px; background-color: var(--dtl-navy); border: 2px solid #ffffff;" 
               title="Ver Historial General">
                <i class="fas fa-archive fs-5"></i>
            </a>

            <button class="btn shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center text-white" 
                    id="btnTriggerNuevaObra"
                    onclick="toggleTarjetaNuevaObra(event)" 
                    style="width: 48px; height: 48px; background-color: var(--dtl-green); border: none;" 
                    title="Registrar Nueva Obra">
                <i class="fas fa-plus fs-4"></i>
            </button>
        </div>

        <!-- POPOVER FLOTANTE: REGISTRAR NUEVA OBRA -->
        <div id="cardNuevaObraFlotante" class="floating-new-obra-card d-none" onclick="event.stopPropagation();">
            <div class="d-flex align-items-center justify-content-between mb-2 pb-1.5 border-bottom">
                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.80rem;">
                    <i class="fas fa-plus-circle text-success me-1"></i> Nueva Obra (Prospecto)
                </h6>
                <button type="button" class="btn-close p-0" style="font-size: 0.60rem;" onclick="cerrarTarjetaNuevaObra()"></button>
            </div>

            <form id="formNuevaObraAjax" onsubmit="enviarNuevaObraAjax(event)" class="d-flex flex-column gap-2">
                @csrf
                <div>
                    <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Cliente Empresarial *</label>
                    <select name="cliente_id" id="new-cliente-id" class="form-select form-select-sm" style="font-size: 0.74rem;" required>
                        <option value="" selected disabled>-- Seleccione un Cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->razon_social }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Título del Proyecto *</label>
                    <input type="text" name="titulo" id="new-titulo" class="form-control form-control-sm" style="font-size: 0.74rem;" placeholder="Ej. Instalación de Líneas de Tubería..." minlength="5" required>
                </div>

                <div class="row g-1.5">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Monto Estimado *</label>
                        <input type="number" step="0.01" min="1" name="monto" id="new-monto" class="form-control form-control-sm font-monospace fw-bold" style="font-size: 0.74rem;" placeholder="0.00" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Fecha</label>
                        <input type="date" name="fecha" id="new-fecha" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" style="font-size: 0.72rem;">
                    </div>
                </div>

                <div class="pt-2 border-top d-flex justify-content-end gap-1.5 mt-1">
                    <button type="button" class="btn btn-sm btn-light border py-1 px-2.5" style="font-size: 0.72rem;" onclick="cerrarTarjetaNuevaObra()">Cancelar</button>
                    <button type="submit" id="btnSubmitNuevaObra" class="btn btn-sm fw-bold text-white py-1 px-3" style="background-color: var(--dtl-green); font-size: 0.72rem;">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener('show.bs.dropdown', function (event) {
        const card = event.target.closest('.card-note-dtl');
        if (card) card.classList.add('has-menu-open');
    });

    document.addEventListener('hide.bs.dropdown', function (event) {
        const card = event.target.closest('.card-note-dtl');
        if (card) card.classList.remove('has-menu-open');
    });

    if (window.jQuery) {
        $(document).on('show.bs.dropdown', '.dropdown', function () {
            $(this).closest('.card-note-dtl').addClass('has-menu-open');
        });
        $(document).on('hide.bs.dropdown', '.dropdown', function () {
            $(this).closest('.card-note-dtl').removeClass('has-menu-open');
        });
    }

    function limpiarErrorValidacion(input, errorId) {
        input.classList.remove('input-error-dtl');
        const msg = document.getElementById(errorId);
        if (msg) msg.classList.add('d-none');
    }

    function toggleFlyoutInspLeft(ev, flyoutId, forzarNueva = false) {
        ev.stopPropagation();
        cerrarTarjetaNuevaObra();

        document.querySelectorAll('.flyout-card-panel').forEach(el => {
            if (el.id !== flyoutId) el.classList.add('d-none');
        });

        document.querySelectorAll('.card-note-dtl').forEach(c => c.classList.remove('has-menu-open'));

        const panel = document.getElementById(flyoutId);
        if (panel) {
            const card = panel.closest('.card-note-dtl');
            if (card) card.classList.toggle('has-menu-open');

            panel.classList.toggle('d-none');
            if (forzarNueva) {
                const obraId = flyoutId.replace('flyout-compact-insp-', '');
                mostrarNuevaParteMini(obraId);
            }
        }
    }

    function cambiarTabParte(obraId, index, btn) {
        document.querySelectorAll(`.tab-parte-content-${obraId}`).forEach(el => el.classList.add('d-none'));
        const boxNueva = document.getElementById(`box-nueva-parte-${obraId}`);
        if (boxNueva) boxNueva.classList.add('d-none');

        const tabBox = document.getElementById(`tab-box-${obraId}-${index}`);
        if (tabBox) tabBox.classList.remove('d-none');

        const parentNav = btn.closest('.nav-partes-mini');
        if (parentNav) {
            parentNav.querySelectorAll('.btn-tab-parte').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    }

    function cambiarTabCotizacion(obraId, index, btn) {
        document.querySelectorAll(`.tab-cot-content-${obraId}`).forEach(el => el.classList.add('d-none'));
        const boxAjuste = document.getElementById(`box-ajustar-precio-${obraId}`);
        if (boxAjuste) boxAjuste.classList.add('d-none');

        const tabBox = document.getElementById(`tab-box-cot-${obraId}-${index}`);
        if (tabBox) tabBox.classList.remove('d-none');

        const parentNav = btn.closest('.nav-partes-mini');
        if (parentNav) {
            parentNav.querySelectorAll('.btn-tab-parte').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    }

    function mostrarNuevaParteMini(obraId) {
        document.querySelectorAll(`.tab-parte-content-${obraId}`).forEach(el => el.classList.add('d-none'));
        const boxNueva = document.getElementById(`box-nueva-parte-${obraId}`);
        if (boxNueva) boxNueva.classList.remove('d-none');

        const card = document.getElementById(`flyout-compact-insp-${obraId}`);
        if (card) {
            card.querySelectorAll('.btn-tab-parte').forEach(b => b.classList.remove('active'));
        }
    }

    function abrirFormAjustarPrecio(obraId, cotId) {
        cerrarFormCerrarObra(obraId);
        document.getElementById(`ajuste-cot-id-${obraId}`).value = cotId;
        const box = document.getElementById(`box-ajustar-precio-${obraId}`);
        if (box) box.classList.remove('d-none');
    }

    function cerrarFormAjustarPrecio(obraId) {
        const box = document.getElementById(`box-ajustar-precio-${obraId}`);
        if (box) box.classList.add('d-none');
    }

    function abrirFormCerrarObra(obraId, cotId) {
        cerrarFormAjustarPrecio(obraId);
        document.getElementById(`cerrar-cot-id-${obraId}`).value = cotId;
        const box = document.getElementById(`box-cerrar-obra-${obraId}`);
        if (box) box.classList.remove('d-none');
    }

    function cerrarFormCerrarObra(obraId) {
        const box = document.getElementById(`box-cerrar-obra-${obraId}`);
        if (box) box.classList.add('d-none');
    }

    function guardarCerrarObraAjax(btn, obraId) {
        const cotId = document.getElementById(`cerrar-cot-id-${obraId}`).value;
        const motivoInput = document.getElementById(`cerrar-motivo-${obraId}`);
        const tipoContactoSelect = document.getElementById(`cerrar-tipo-contacto-${obraId}`);
        const tipoContacto = tipoContactoSelect ? tipoContactoSelect.value : 'Llamada Telefónica';

        if (!motivoInput.value.trim()) {
            motivoInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-cerrarmotivo-${obraId}`).classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Cerrando...`;

        fetch("{{ route('comercial.pipeline.cerrarObraPerdida') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                cotizacion_id: cotId,
                tipo_contacto: tipoContacto,
                motivo: motivoInput.value.trim()
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al cerrar la obra.');
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-times-circle me-1"></i> Confirmar Cierre como Perdida`;
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = `<i class="fas fa-times-circle me-1"></i> Confirmar Cierre como Perdida`;
        });
    }

    function guardarAjustePrecioAjax(btn, obraId) {
        const cotId = document.getElementById(`ajuste-cot-id-${obraId}`).value;
        const montoInput = document.getElementById(`ajuste-monto-${obraId}`);
        const motivoInput = document.getElementById(`ajuste-motivo-${obraId}`);

        let hayError = false;
        if (!montoInput.value || parseFloat(montoInput.value) <= 0) {
            montoInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-ajustemonto-${obraId}`).classList.remove('d-none');
            hayError = true;
        }

        if (!motivoInput.value.trim()) {
            motivoInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-ajustemotivo-${obraId}`).classList.remove('d-none');
            hayError = true;
        }

        if (hayError) return;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Reajustando...`;

        fetch("{{ route('comercial.pipeline.ajustarPrecio') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cotizacion_id: cotId,
                nuevo_monto: montoInput.value,
                motivo_reajuste: motivoInput.value.trim()
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-check me-1"></i> Guardar y Reemitir`;
            }
        });
    }

    function reprogramarFechaMini(btn, inspId, obraId) {
        const nuevaFecha = document.getElementById(`fecha-act-${obraId}-${inspId}`).value;
        const ing = document.getElementById(`ing-act-${obraId}-${inspId}`).value.trim();

        if (!nuevaFecha || !ing) return;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.reprogramarInspeccion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                inspeccion_id: inspId,
                nueva_fecha: nuevaFecha,
                ingeniero_asignado: ing
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-clock-rotate-left me-1"></i> Actualizar Fecha por Retraso`;
            }
        });
    }

    function finalizarInspMini(btn, inspId, obraId) {
        const textarea = document.getElementById(`dictamen-act-${obraId}-${inspId}`);
        const dictamen = textarea.value.trim();
        const msgError = document.getElementById(`msg-error-dictamen-${obraId}-${inspId}`);

        if (!dictamen) {
            textarea.classList.add('input-error-dtl');
            if (msgError) msgError.classList.remove('d-none');
            textarea.focus();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.completarInspeccion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                inspeccion_id: inspId,
                resultado: dictamen
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-check-circle me-1"></i> Completar Dictamen de Inspección`;
            }
        });
    }

    function guardarNuevaParteMini(btn, obraId) {
        const ingInput = document.getElementById(`nueva-ing-${obraId}`);
        const fechaInput = document.getElementById(`nueva-fecha-${obraId}`);

        let hayError = false;
        if (!ingInput.value.trim()) {
            ingInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-nueva-ing-${obraId}`).classList.remove('d-none');
            hayError = true;
        }

        if (!fechaInput.value) {
            hayError = true;
        }

        if (hayError) return;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Agendando...`;

        fetch("{{ route('comercial.pipeline.agendarInspeccion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                ingeniero_asignado: ingInput.value.trim(),
                fecha_inspeccion: fechaInput.value
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-save me-1"></i> Guardar Visita`;
            }
        });
    }

    function enviarProgramarCotizacionDirecto(btn, obraId) {
        const fechaInput = document.getElementById('prog-fecha-emision-' + obraId);
        if (!fechaInput.value) {
            fechaInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-progfecha-${obraId}`).classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Reubicando...`;

        fetch("{{ route('comercial.pipeline.programarCotizacion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                fecha_emision: fechaInput.value
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
            }
        });
    }

    function reprogramarCotizacionFecha(btn, cotId, obraId) {
        const nuevaFecha = document.getElementById('reprog-cot-fecha-' + obraId).value;
        if (!nuevaFecha) return;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.reprogramarCotizacion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cotizacion_id: cotId,
                nueva_fecha_emision: nuevaFecha
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-clock-rotate-left me-1"></i> Actualizar Fecha por Retraso`;
            }
        });
    }

    function enviarCotDirecto(btn, obraId, cotId) {
        const montoInput = document.getElementById('cot-monto-' + obraId);
        const obs = document.getElementById('cot-obs-' + obraId).value;

        if (!montoInput.value || parseFloat(montoInput.value) <= 0) {
            montoInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-cotmonto-${obraId}`).classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.enviarCotizacion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cotizacion_id: cotId,
                monto_total: montoInput.value,
                observaciones: obs
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
            }
        });
    }

    function ejecutarRespuestaCotizacion(btn, cotId, estadoCotizacion) {
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.responderCotizacion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cotizacion_id: cotId,
                estado_cotizacion: estadoCotizacion
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
            }
        });
    }

    function trasladarACierreDirecto(btn, obraId) {
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Trasladando...`;

        fetch("{{ route('comercial.pipeline.trasladarCierre') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ obra_id: obraId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'No se pudo trasladar la obra a Cierre Comercial.');
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-magnet text-success me-1.5"></i> Ir a Cierre Comercial`;
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = `<i class="fas fa-magnet text-success me-1.5"></i> Ir a Cierre Comercial`;
        });
    }

    function mostrarFormCancelarCierre(obraId) {
        const opciones = document.getElementById(`cierre-opciones-${obraId}`);
        const formCancelar = document.getElementById(`cierre-form-cancelar-${obraId}`);
        if (opciones) opciones.classList.add('d-none');
        if (formCancelar) formCancelar.classList.remove('d-none');
    }

    function ocultarFormCancelarCierre(obraId) {
        const opciones = document.getElementById(`cierre-opciones-${obraId}`);
        const formCancelar = document.getElementById(`cierre-form-cancelar-${obraId}`);
        if (formCancelar) formCancelar.classList.add('d-none');
        if (opciones) opciones.classList.remove('d-none');
    }

    function confirmarCancelarObraCierre(btn, obraId) {
        const motivoInput = document.getElementById(`cancelar-motivo-${obraId}`);
        const tipoContactoSelect = document.getElementById(`cancelar-tipo-contacto-${obraId}`);
        const tipoContacto = tipoContactoSelect ? tipoContactoSelect.value : 'Llamada Telefónica';

        if (!motivoInput.value.trim()) {
            motivoInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-cancelarmotivo-${obraId}`).classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Cancelando...`;

        fetch("{{ route('comercial.pipeline.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                obra_id: obraId, 
                nuevo_estado: 'Cancelada',
                motivo: motivoInput.value.trim(),
                tipo_contacto: tipoContacto
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al cancelar la obra.');
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-times-circle me-1"></i> Confirmar Cancelación`;
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = `<i class="fas fa-times-circle me-1"></i> Confirmar Cancelación`;
        });
    }

    function ejecutarCierreDirecto(btn, obraId, nuevoEstado) {
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Archivando...`;

        fetch("{{ route('comercial.pipeline.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                obra_id: obraId, 
                nuevo_estado: nuevoEstado 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
            }
        });
    }

    function toggleTarjetaNuevaObra(ev) {
        ev.stopPropagation();
        document.querySelectorAll('.flyout-card-panel').forEach(el => el.classList.add('d-none'));
        const card = document.getElementById('cardNuevaObraFlotante');
        card.classList.toggle('d-none');
    }

    function cerrarTarjetaNuevaObra() {
        document.getElementById('cardNuevaObraFlotante').classList.add('d-none');
    }

    function enviarNuevaObraAjax(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitNuevaObra');
        const clienteId = document.getElementById('new-cliente-id').value;
        const titulo = document.getElementById('new-titulo').value.trim();
        const monto = document.getElementById('new-monto').value;
        const fecha = document.getElementById('new-fecha').value;

        if (!clienteId || !titulo || !monto || parseFloat(monto) <= 0) return;

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cliente_id: clienteId,
                titulo: titulo,
                monto: monto,
                fecha: fecha
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-save me-1"></i> Guardar`;
            }
        })
        .catch(() => { location.reload(); });
    }

    function toggleFlyout(ev, flyoutId) {
        ev.stopPropagation();
        cerrarTarjetaNuevaObra();

        document.querySelectorAll('.flyout-card-panel').forEach(el => {
            if (el.id !== flyoutId) el.classList.add('d-none');
        });

        document.querySelectorAll('.card-note-dtl').forEach(c => c.classList.remove('has-menu-open'));

        const panel = document.getElementById(flyoutId);
        if (panel) {
            const card = panel.closest('.card-note-dtl');
            if (card) card.classList.toggle('has-menu-open');
            panel.classList.toggle('d-none');
        }
    }

    function cerrarFlyout(flyoutId) {
        const panel = document.getElementById(flyoutId);
        if (panel) {
            panel.classList.add('d-none');
            const card = panel.closest('.card-note-dtl');
            if (card) card.classList.remove('has-menu-open');
        }
    }

    document.addEventListener('click', function () {
        cerrarTarjetaNuevaObra();
        document.querySelectorAll('.flyout-card-panel').forEach(el => el.classList.add('d-none'));
        document.querySelectorAll('.card-note-dtl').forEach(c => c.classList.remove('has-menu-open'));
    });

    function enviarBitacoraDirecto(btn, obraId) {
        const descInput = document.getElementById('bitacora-desc-' + obraId);
        if (!descInput.value.trim()) {
            descInput.classList.add('input-error-dtl');
            document.getElementById(`msg-error-bitacora-${obraId}`).classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Guardando...`;

        fetch("{{ route('comercial.pipeline.agregarBitacora') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                descripcion: descInput.value.trim()
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                cerrarFlyout('flyout-bitacora-' + obraId);
                btn.disabled = false;
                descInput.value = '';
            } else {
                btn.disabled = false;
            }
        });
    }

    let draggedCardId = null;

    function allowDrop(ev) { 
        ev.preventDefault(); 
        const col = ev.target.closest('.kanban-col-dtl');
        if (col) col.classList.add('drag-over');
    }

    function dragLeave(ev) {
        const col = ev.target.closest('.kanban-col-dtl');
        if (col) col.classList.remove('drag-over');
    }

    function dragStart(ev) {
        const card = ev.target.closest('.card-note-dtl');
        if (card) { 
            draggedCardId = card.dataset.id; 
            ev.dataTransfer.setData('text/plain', card.dataset.id);
        }
    }

    function dropCard(ev) {
        ev.preventDefault();
        const col = ev.target.closest('.kanban-col-dtl');
        if (col) {
            col.classList.remove('drag-over');
            const cardId = draggedCardId || ev.dataTransfer.getData('text/plain');
            if (cardId) moverTarjetaSoloVisual(cardId, col);
        }
        draggedCardId = null;
    }

    function moverTarjetaPorMenu(obraId, targetStatus) {
        const col = document.querySelector(`.kanban-col-dtl[data-col-status="${targetStatus}"]`);
        if (col) moverTarjetaSoloVisual(obraId, col);
    }

    function moverTarjetaSoloVisual(obraId, targetCol) {
        const card = document.getElementById('obra-card-' + obraId);
        if (!card) return;

        const sourceCol = card.closest('.kanban-col-dtl');
        if (!sourceCol || sourceCol === targetCol) return;

        const sourceContainer = sourceCol.querySelector('.kanban-cards-container');
        const targetContainer = targetCol.querySelector('.kanban-cards-container');

        const emptyPlaceholder = targetContainer.querySelector('.empty-col-placeholder');
        if (emptyPlaceholder) emptyPlaceholder.remove();

        targetContainer.appendChild(card);

        if (sourceContainer.querySelectorAll('.card-note-dtl').length === 0) {
            sourceContainer.innerHTML = `
                <div class="text-center py-5 my-auto empty-col-placeholder" style="opacity: 0.4;">
                    <i class="fas fa-clipboard-check fs-3 mb-1 text-muted"></i>
                    <p class="mb-0 small fw-bold text-uppercase text-muted" style="font-size: 0.65rem;">Sin proyectos</p>
                </div>`;
        }

        recalcularSubtituloColumna(sourceCol);
        recalcularSubtituloColumna(targetCol);
    }

    function recalcularSubtituloColumna(col) {
        const cards = col.querySelectorAll('.card-note-dtl');
        let total = 0;
        cards.forEach(c => { total += parseFloat(c.dataset.monto || 0); });
        const formato = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const subtitle = col.querySelector('.col-header-subtitle');
        if (subtitle) {
            subtitle.innerHTML = `${cards.length} EXPEDIENTES &bull; S/ ${formato}`;
        }
    }
</script>
@endsection