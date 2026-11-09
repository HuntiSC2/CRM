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
        padding: 1rem 0.5rem;
    }

    .kanban-board-container { 
        gap: 1.25rem !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 3.5rem;
    }

    .kanban-col-dtl { 
        width: 360px !important; 
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
    }
    .card-note-dtl:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(5, 150, 105, 0.35) !important;
    }
    .card-note-dtl:active { cursor: grabbing; }

    .card-task-title {
        font-size: 0.85rem;
        font-weight: 700;
        line-height: 1.3;
        color: #ffffff;
        margin-bottom: 0.30rem;
    }

    .card-task-client {
        font-size: 0.74rem;
        font-weight: 500;
        color: #e6fffa;
        margin-bottom: 0.50rem;
    }

    .card-note-lines {
        border-top: 1px dashed rgba(255, 255, 255, 0.35);
        padding-top: 0.45rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.70rem;
        font-weight: 700;
        color: #ffffff;
    }

    .card-amount-pill {
        background: rgba(0, 0, 0, 0.22);
        padding: 0.18rem 0.50rem;
        border-radius: 6px;
        font-family: monospace;
        letter-spacing: 0.3px;
    }

    /* PASTILLAS EN UNA SOLA LÍNEA */
    .btn-pill-alerta-warning {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a !important;
        font-size: 0.60rem !important;
        font-weight: 800 !important;
        padding: 0.15rem 0.42rem !important;
        border-radius: 50rem !important;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        line-height: 1.25;
        white-space: nowrap;
    }
    .btn-pill-alerta-warning:hover {
        background-color: #fde68a !important;
        transform: translateY(-1px);
    }

    .pill-badge-ok-dtl {
        background-color: #ffffff !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
        font-size: 0.60rem !important;
        font-weight: 800 !important;
        padding: 0.15rem 0.45rem !important;
        border-radius: 50rem !important;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        line-height: 1.25;
        white-space: nowrap;
    }

    .pill-badge-cancel-dtl {
        background-color: #ffffff !important;
        color: #dc2626 !important;
        border: 1px solid #fecaca !important;
        font-size: 0.60rem !important;
        font-weight: 800 !important;
        padding: 0.15rem 0.45rem !important;
        border-radius: 50rem !important;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        line-height: 1.25;
        white-space: nowrap;
    }

    /* FLYOUTS Y POPOVERS */
    .flyout-card-panel {
        position: absolute;
        top: 2px;
        left: calc(100% + 8px);
        z-index: 1080;
        width: 285px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.75rem 0.85rem;
        box-shadow: 0 12px 28px -4px rgba(12, 25, 44, 0.22);
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
    .kanban-col-dtl:last-child .flyout-card-panel {
        left: auto;
        right: calc(100% + 8px);
    }
    .kanban-col-dtl:last-child .flyout-card-panel::before {
        left: auto;
        right: -6px;
        border-left: none;
        border-bottom: none;
        border-right: 1px solid #cbd5e1;
        border-top: 1px solid #cbd5e1;
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

    .btn-mini-action {
        width: 100%;
        padding: 0.35rem 0.50rem;
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

    @media (max-width: 767.98px) {
        .kanban-col-dtl { width: 100% !important; min-height: auto; }
        .flyout-card-panel { left: 5% !important; right: 5% !important; top: 40px !important; width: 90% !important; }
        .flyout-card-panel::before { display: none; }
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
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="position-absolute top-0 start-0 w-100" style="height: 3.5px; background-color: var(--dtl-green);"></div>
            <div class="card-body p-2.5 p-md-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-1 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="width: 125px; height: 44px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER" style="max-height: 28px; max-width: 100%; object-fit: contain;">
                    </div>
                    <div class="border-start ps-3" style="border-color: #cbd5e1 !important;">
                        <div class="d-flex align-items-center gap-1.5 mb-0.5">
                            <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                                💼 PIPELINE COMERCIAL
                            </span>
                            <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                Flujo Dinámico Activo
                            </span>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem; letter-spacing: -0.2px;">Pipeline de Obras y Proyectos</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLERO KANBAN LIBRE Y FLUIDO -->
        <div class="d-flex kanban-board-container align-items-start justify-content-start justify-content-xl-center" id="kanban-main-board">
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
                                    $estadoActualObra  = $obra['estado'] ?? $status;
                                    $esObraAceptada    = ($estadoActualObra === 'Aceptada');
                                    $esObraCancelada   = ($estadoActualObra === 'Cancelada');
                                    $tieneCotEmitida   = !empty($obra['cotizacion_es_completada']); // Hito técnico indispensable

                                    // REGLA ESTRICTA: Solo puede haber Cierre si la cotización ya fue emitida y aprobada técnicamente
                                    $requiereCierre    = !$esObraAceptada && !$esObraCancelada && $tieneCotEmitida;
                                @endphp

                                <div class="card-note-dtl" draggable="true" ondragstart="dragStart(event)" 
                                     id="obra-card-{{ $obra['id'] }}" data-id="{{ $obra['id'] }}">
                                    
                                    <!-- FILA DE ESTADOS / PASTILLAS -->
                                    <div class="d-flex align-items-center justify-content-between mb-1.5 position-relative">
                                        <div class="d-flex align-items-center gap-1 flex-nowrap" style="overflow-x: hidden;">
                                            
                                            <!-- CÓDIGO OBRA -->
                                            <span class="badge px-1.5 py-0.5 text-uppercase font-monospace flex-shrink-0" style="background-color: rgba(0, 0, 0, 0.22); color: #ffffff; font-size: 0.65rem; font-weight: 700;">
                                                #{{ $obra['codigo'] }}
                                            </span>

                                            <!-- PASTILLA 1: INSPECCIÓN -->
                                            @if($obra['tiene_inspeccion_pendiente'])
                                                <button type="button" class="btn-pill-alerta-warning flex-shrink-0" 
                                                        onclick="toggleFlyout(event, 'flyout-insp-{{ $obra['id'] }}')"
                                                        title="Completar dictamen técnico">
                                                    <i class="fas fa-clock"></i> Insp. Pendiente
                                                </button>

                                                <!-- POPOVER: COMPLETAR INSPECCIÓN (EL IMÁN MUEVE A COTIZACIÓN) -->
                                                <div id="flyout-insp-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                        <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                            <i class="fas fa-clipboard-check text-success me-1"></i> Dictamen Técnico
                                                        </span>
                                                        <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-insp-{{ $obra['id'] }}')"></button>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Informe de Campo / Dictamen *</label>
                                                        <textarea id="insp-res-{{ $obra['id'] }}" rows="3" class="form-control form-control-sm" style="font-size: 0.74rem;" placeholder="Metrados, factibilidad y dictamen técnico..."></textarea>
                                                    </div>

                                                    <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                            style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                            onclick="enviarInspDirecto(this, '{{ $obra['id'] }}', '{{ $obra['inspeccion_pendiente_id'] }}')">
                                                        <i class="fas fa-check"></i> Completar y Reubicar en Cotización
                                                    </button>
                                                </div>

                                            @elseif($obra['inspeccion_es_completada'])
                                                <span class="pill-badge-ok-dtl flex-shrink-0" title="Inspección completada con éxito">
                                                    <i class="fas fa-check-circle"></i> Insp. OK
                                                </span>
                                            @endif

                                            <!-- PASTILLA 2: COTIZACIÓN -->
                                            @if(!empty($obra['tiene_cotizacion_pendiente']))
                                                <button type="button" class="btn-pill-alerta-warning flex-shrink-0" 
                                                        onclick="toggleFlyout(event, 'flyout-cot-{{ $obra['id'] }}')"
                                                        title="Completar y emitir presupuesto">
                                                    <i class="fas fa-clock"></i> Cotiz. Pendiente
                                                </button>

                                                <!-- POPOVER: EMITIR COTIZACIÓN (EL IMÁN MUEVE A CIERRE COMERCIAL) -->
                                                <div id="flyout-cot-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                        <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                            <i class="fas fa-paper-plane text-primary me-1"></i> Emitir Presupuesto Final
                                                        </span>
                                                        <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-cot-{{ $obra['id'] }}')"></button>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Monto Cotizado (S/) *</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text bg-light fw-bold" style="font-size: 0.68rem;">S/</span>
                                                            <input type="number" step="0.01" min="1" id="cot-monto-{{ $obra['id'] }}" class="form-control form-control-sm font-monospace fw-bold" placeholder="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Condiciones / Observaciones</label>
                                                        <textarea id="cot-obs-{{ $obra['id'] }}" rows="2" class="form-control form-control-sm" style="font-size: 0.72rem;" placeholder="Validez de oferta, condiciones de pago..."></textarea>
                                                    </div>

                                                    <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                            style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                            onclick="enviarCotDirecto(this, '{{ $obra['id'] }}', '{{ $obra['cotizacion_pendiente_id'] }}')">
                                                        <i class="fas fa-paper-plane"></i> Emitir y Reubicar en Cierre
                                                    </button>
                                                </div>

                                            @elseif(!empty($obra['cotizacion_es_rechazada']))
                                                <span class="pill-badge-cancel-dtl flex-shrink-0" title="Cotización rechazada">
                                                    <i class="fas fa-times-circle"></i> Cotiz. Rechazada
                                                </span>
                                            @elseif(!empty($obra['cotizacion_es_completada']))
                                                <span class="pill-badge-ok-dtl flex-shrink-0" title="Cotización emitida exitosamente">
                                                    <i class="fas fa-check-circle"></i> Cotiz. OK
                                                </span>
                                            @endif

                                          <!-- PASTILLA 3: CIERRE COMERCIAL -->
                                           
                                          <!-- PASTILLA 3: CIERRE COMERCIAL -->
                                                @if($esObraAceptada)
                                                    <span class="pill-badge-ok-dtl flex-shrink-0" title="Obra Ganada">
                                                        <i class="fas fa-trophy"></i> Ganada
                                                    </span>
                                                @elseif($esObraCancelada)
                                                    <span class="pill-badge-cancel-dtl flex-shrink-0" title="Obra Cancelada">
                                                        <i class="fas fa-times-circle"></i> Cancelada
                                                    </span>
                                                @elseif($requiereCierre)
                                                    <button type="button" class="btn-pill-alerta-warning flex-shrink-0" 
                                                            onclick="toggleFlyout(event, 'flyout-cierre-{{ $obra['id'] }}')"
                                                            title="Definir resolución comercial">
                                                        <i class="fas fa-flag-checkered text-warning"></i> Cierre
                                                    </button>
                                                ...

                                                <!-- POPOVER: CIERRE DEFINITIVO -->
                                                <div id="flyout-cierre-{{ $obra['id'] }}" class="flyout-card-panel d-none" style="width: 210px;" onclick="event.stopPropagation();">
                                                    <div class="d-flex align-items-center justify-content-between mb-1.5 pb-1 border-bottom">
                                                        <span class="text-dark fw-bold text-uppercase" style="font-size: 0.65rem;">
                                                            <i class="fas fa-handshake text-warning me-1"></i> Resolución
                                                        </span>
                                                        <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-cierre-{{ $obra['id'] }}')"></button>
                                                    </div>
                                                    
                                                    <div class="d-flex flex-column gap-1.5">
                                                        <button type="button" class="btn-mini-action btn-mini-ganada" 
                                                                onclick="ejecutarCierreDirecto(this, '{{ $obra['id'] }}', 'Aceptada')">
                                                            <span><i class="fas fa-trophy me-1"></i> Obra Ganada</span>
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn-mini-action btn-mini-cancelada" 
                                                                onclick="ejecutarCierreDirecto(this, '{{ $obra['id'] }}', 'Cancelada')">
                                                            <span><i class="fas fa-ban me-1"></i> Cancelar Obra</span>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                        <!-- MENÚ DE TRES PUNTOS CONTEXTUAL -->
                                        <div class="dropdown flex-shrink-0 ms-1">
                                            <button class="btn btn-sm p-0 border-0 d-flex align-items-center justify-content-center text-white opacity-75" 
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false" 
                                                    style="width: 20px; height: 20px;">
                                                <i class="fas fa-ellipsis-h" style="font-size: 0.82rem;"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="font-size: 0.76rem; min-width: 205px; z-index: 1060;">
                                                <li><h6 class="dropdown-header text-uppercase fw-bold px-2 py-0.5 text-muted" style="font-size: 0.62rem;">Hitos Técnicos</h6></li>
                                                
                                                <li>
                                                    <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyout(event, 'flyout-agendar-insp-{{ $obra['id'] }}')">
                                                        <i class="fas fa-calendar-plus text-success me-1.5"></i> Agendar Inspección
                                                    </button>
                                                </li>

                                                <li>
                                                    <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyout(event, 'flyout-programar-cot-{{ $obra['id'] }}')">
                                                        <i class="fas fa-file-invoice-dollar text-primary me-1.5"></i> Programar Cotización
                                                    </button>
                                                </li>

                                                <li>
                                                    <button type="button" class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="toggleFlyout(event, 'flyout-bitacora-{{ $obra['id'] }}')">
                                                        <i class="fas fa-pen-nib text-warning me-1.5"></i> Nota de Bitácora
                                                    </button>
                                                </li>

                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li><h6 class="dropdown-header text-uppercase fw-bold px-2 py-0.5 text-muted" style="font-size: 0.62rem;">Libertad Manual (Mover)</h6></li>
                                                @foreach($statuses as $targetStatus)
                                                    @if($targetStatus !== $status)
                                                        <li>
                                                            <button class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="updateStatusBackend('{{ $obra['id'] }}', '{{ $targetStatus }}')">
                                                                <i class="fas fa-arrow-right text-muted me-1.5"></i> A {{ $targetStatus }}
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <!-- POPOVER 1: AGENDAR INSPECCIÓN (EL IMÁN MUEVE A INSPECCION) -->
                                        <div id="flyout-agendar-insp-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                    <i class="fas fa-calendar-check text-success me-1"></i> Agendar Inspección
                                                </span>
                                                <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-agendar-insp-{{ $obra['id'] }}')"></button>
                                            </div>

                                            <div class="mb-1.5">
                                                <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Ingeniero Responsable *</label>
                                                <input type="text" id="agendar-ing-{{ $obra['id'] }}" class="form-control form-control-sm" style="font-size: 0.72rem;" placeholder="Ej. Ing. Carlos Pérez" required>
                                            </div>

                                            <div class="mb-1.5">
                                                <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Fecha y Hora Programada *</label>
                                                <input type="datetime-local" id="agendar-fecha-{{ $obra['id'] }}" value="{{ date('Y-m-d\T09:00') }}" class="form-control form-control-sm" style="font-size: 0.72rem;" required>
                                            </div>

                                            <div class="row g-1 mb-2">
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.65rem;">Contacto</label>
                                                    <input type="text" id="agendar-contacto-{{ $obra['id'] }}" class="form-control form-control-sm" style="font-size: 0.70rem;" placeholder="Nombre">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.65rem;">Teléfono</label>
                                                    <input type="text" id="agendar-tel-{{ $obra['id'] }}" class="form-control form-control-sm" style="font-size: 0.70rem;" placeholder="999-999-999">
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                    style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                    onclick="enviarAgendarInspeccionDirecto(this, '{{ $obra['id'] }}')">
                                                <i class="fas fa-save me-1"></i> Agendar y Reubicar en Inspección
                                            </button>
                                        </div>

                                        <!-- POPOVER 2: PROGRAMAR COTIZACIÓN (EL IMÁN MUEVE A COTIZACIÓN) -->
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
                                                <input type="date" id="prog-fecha-emision-{{ $obra['id'] }}" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" style="font-size: 0.72rem;" required>
                                            </div>

                                            <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                    style="background-color: var(--dtl-green); font-size: 0.72rem;"
                                                    onclick="enviarProgramarCotizacionDirecto(this, '{{ $obra['id'] }}')">
                                                <i class="fas fa-check me-1"></i> Programar y Reubicar en Cotización
                                            </button>
                                        </div>

                                        <!-- POPOVER 3: NOTA DE BITÁCORA -->
                                        <div id="flyout-bitacora-{{ $obra['id'] }}" class="flyout-card-panel d-none" onclick="event.stopPropagation();">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="text-dark fw-bold" style="font-size: 0.72rem;">
                                                    <i class="fas fa-clipboard-list text-warning me-1"></i> Bitácora Técnica
                                                </span>
                                                <button type="button" class="btn-close p-0" style="font-size: 0.50rem;" onclick="cerrarFlyout('flyout-bitacora-{{ $obra['id'] }}')"></button>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label fw-bold text-dark mb-0.5" style="font-size: 0.68rem;">Nota / Suceso de Seguimiento *</label>
                                                <textarea id="bitacora-desc-{{ $obra['id'] }}" rows="3" class="form-control form-control-sm" style="font-size: 0.74rem;" placeholder="Acuerdos con cliente, especificaciones..." required></textarea>
                                            </div>

                                            <button type="button" class="btn btn-sm w-100 fw-bold text-white d-flex align-items-center justify-content-center gap-1"
                                                    style="background-color: #f59e0b; font-size: 0.72rem;"
                                                    onclick="enviarBitacoraDirecto(this, '{{ $obra['id'] }}')">
                                                <i class="fas fa-save me-1"></i> Guardar en Bitácora
                                            </button>
                                        </div>

                                    </div>

                                    <!-- CUERPO DE LA TARJETA VERDE -->
                                    <div class="card-task-title text-truncate" title="{{ $obra['titulo'] }}">
                                        {{ $obra['titulo'] }}
                                    </div>

                                    <div class="card-task-client text-truncate" title="{{ $obra['cliente'] }}">
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
                            <div class="text-center py-5 my-auto" style="opacity: 0.4;">
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

        if (!clienteId || !titulo || !monto || parseFloat(monto) <= 0) {
            alert('Por favor complete todos los campos obligatorios correctamente.');
            return;
        }

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
                alert(data.message || 'Error al guardar la obra.');
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

        const panel = document.getElementById(flyoutId);
        if (panel) {
            panel.classList.toggle('d-none');
        }
    }

    function cerrarFlyout(flyoutId) {
        const panel = document.getElementById(flyoutId);
        if (panel) panel.classList.add('d-none');
    }

    document.addEventListener('click', function () {
        cerrarTarjetaNuevaObra();
        document.querySelectorAll('.flyout-card-panel').forEach(el => el.classList.add('d-none'));
    });

    // 1. EL IMÁN: AGENDAR INSPECCIÓN -> REUBICA EN 'INSPECCION'
    function enviarAgendarInspeccionDirecto(btn, obraId) {
        const ing = document.getElementById('agendar-ing-' + obraId).value.trim();
        const fecha = document.getElementById('agendar-fecha-' + obraId).value;
        const contacto = document.getElementById('agendar-contacto-' + obraId).value.trim();
        const tel = document.getElementById('agendar-tel-' + obraId).value.trim();

        if (!ing || !fecha) {
            alert('Debe ingresar el ingeniero responsable y la fecha programada.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Reubicando...`;

        fetch("{{ route('comercial.pipeline.agendarInspeccion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                ingeniero_asignado: ing,
                fecha_inspeccion: fecha,
                contacto_nombre: contacto,
                contacto_telefono: tel
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al agendar inspección.');
                btn.disabled = false;
            }
        });
    }

    // 2. EL IMÁN: PROGRAMAR COTIZACIÓN -> REUBICA EN 'COTIZACIÓN'
    function enviarProgramarCotizacionDirecto(btn, obraId) {
        const fecha = document.getElementById('prog-fecha-emision-' + obraId).value;

        if (!fecha) {
            alert('Seleccione una fecha de emisión válida.');
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
                fecha_emision: fecha
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al programar la cotización.');
                btn.disabled = false;
            }
        });
    }

    // 3. EL IMÁN: COMPLETAR INSPECCIÓN -> REUBICA EN 'COTIZACIÓN'
    function enviarInspDirecto(btn, obraId, inspId) {
        const resultado = document.getElementById('insp-res-' + obraId).value.trim();

        if (!resultado) {
            alert('Debe ingresar el dictamen o informe técnico de campo.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Reubicando...`;

        fetch("{{ route('comercial.pipeline.completarInspeccion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                inspeccion_id: inspId, 
                resultado: resultado 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al completar la inspección.');
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-check"></i> Finalizar`;
            }
        });
    }

    // 4. EL IMÁN: EMITIR COTIZACIÓN -> REUBICA EN 'CIERRE COMERCIAL'
    function enviarCotDirecto(btn, obraId, cotId) {
        const monto = document.getElementById('cot-monto-' + obraId).value;
        const obs   = document.getElementById('cot-obs-' + obraId).value;

        if (!monto || parseFloat(monto) <= 0) {
            alert('Ingrese un monto válido mayor a 0 para emitir la cotización.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Reubicando...`;

        fetch("{{ route('comercial.pipeline.enviarCotizacion') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                cotizacion_id: cotId,
                monto_total: monto,
                observaciones: obs
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al emitir la cotización.');
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-paper-plane"></i> Emitir Presupuesto Final`;
            }
        });
    }

    // 5. REGISTRAR BITÁCORA
    function enviarBitacoraDirecto(btn, obraId) {
        const desc = document.getElementById('bitacora-desc-' + obraId).value.trim();

        if (!desc) {
            alert('Ingrese la nota de seguimiento para la bitácora.');
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
                descripcion: desc
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Nota registrada en bitácora técnica.');
                cerrarFlyout('flyout-bitacora-' + obraId);
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-save me-1"></i> Guardar en Bitácora`;
                document.getElementById('bitacora-desc-' + obraId).value = '';
            } else {
                alert('Error al registrar en bitácora.');
                btn.disabled = false;
            }
        });
    }

    // 6. RESOLUCIÓN DE CIERRE COMERCIAL
    function ejecutarCierreDirecto(btn, obraId, nuevoEstado) {
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" style="width: 0.65rem; height: 0.65rem;"></span> Procesando...`;

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
                alert(data.message || 'No se pudo actualizar el cierre.');
                btn.disabled = false;
            }
        })
        .catch(() => {
            alert('Error de conexión.');
            btn.disabled = false;
        });
    }

    // ==========================================
    // LIBERTAD TOTAL: DRAG AND DROP MANUAL
    // ==========================================
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
            const targetStatus = col.dataset.colStatus;
            if (draggedCardId && targetStatus) {
                updateStatusBackend(draggedCardId, targetStatus);
            }
        }
    }

    function updateStatusBackend(obraId, newStatus) {
        fetch("{{ route('comercial.pipeline.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ obra_id: obraId, nuevo_estado: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'No se pudo mover el expediente.');
            }
        });
    }
</script>
@endsection