@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. (AJUSTADO A LAS MEDIDAS DEL DIRECTORIO) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <!-- Línea Superior de Acento Verde Corporativo -->
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                
                <!-- IZQUIERDA: Logo Oficial Corporativo -->
                <div class="col-auto">
                    <div class="p-1.5 p-md-2 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="min-width: 125px; height: 48px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 34px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- CENTRO: Título, Rol y Subtítulo del Módulo -->
                <div class="col border-start-md ps-md-3" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.62rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.62rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            ● Expedientes Activos
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1rem; color: #0f172a; letter-spacing: -0.3px;">
                        Pipeline de Obras
                    </h3>
                    
                    <p class="mb-0 text-muted small d-none d-md-block" style="font-size: 0.8rem; font-weight: 500;">
                        Registro, consulta y gestión de fichas comerciales y contratistas
                    </p>
                </div>

                <!-- DERECHA: Credenciales de Sesión -->
                <div class="col-12 col-md-auto text-end d-none d-lg-block">
                    <div class="px-3 py-2 rounded-3 border bg-light d-inline-block text-end" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center justify-content-end gap-1.5 mb-0.5">
                            <i class="fas fa-envelope me-1" style="color: #059669; font-size: 0.75rem;"></i>
                            <span class="text-dark fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.8px;">Sesión iniciada como:</span>
                        </div>
                        <span class="fw-bold text-dark small d-block" style="font-size: 0.78rem;">
                            {{ auth()->user()->email ?? 'asesor_comercial@dtl.premier' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. TABLERO KANBAN -->
    <div class="d-flex gap-2.5 gap-md-3 overflow-auto custom-kanban-board" id="kanban-main-board" style="align-items: flex-start; scroll-snap-type: x mandatory;">

        @php
            // COLORES DE BORDE Y BADGES: CLAROS, SOVALES Y SUAVES (SIN TONOS FOSFORECENTES NI OSCUROS)
            $badgeColors = [
                'Contactado' => ['color' => '#3b82f6', 'bg' => '#eff6ff', 'border' => '#bfdbfe'], 
                'Visita'     => ['color' => '#f59e0b', 'bg' => '#fffbeb', 'border' => '#fde68a'], 
                'Cotizado'   => ['color' => '#8b5cf6', 'bg' => '#f5f3ff', 'border' => '#ddd6fe'], 
                'Aprobado'   => ['color' => '#10b981', 'bg' => '#ecfdf5', 'border' => '#a7f3d0'], 
                'Perdido'    => ['color' => '#ef4444', 'bg' => '#fef2f2', 'border' => '#fecaca']  
            ];
        @endphp

        @foreach($statuses as $status)
            @php 
                $style = $badgeColors[$status] ?? ['color' => '#64748b', 'bg' => '#f8fafc', 'border' => '#cbd5e1'];
            @endphp

            <!-- Columna Kanban -->
            <div class="kanban-col d-flex flex-column flex-shrink-0 mb-3" style="background: transparent; scroll-snap-align: start;">
                
                <!-- Cabecera de Columna (Fondo plomo/gris formal cercano al blanco) -->
                <div class="p-2.5 mb-2.5 d-flex align-items-center justify-content-between rounded-3 border shadow-sm kanban-col-header" 
                     style="background-color: #f8fafc; border-color: #cbd5e1 !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle status-dot" style="width: 10px; height: 10px; background-color: {{ $style['color'] }};"></span>
                        <h6 class="fw-bold mb-0 col-title-text" style="color: #1e293b; font-size: 0.92rem;">{{ $status }}</h6>
                    </div>
                    <span class="badge rounded-pill fw-bold col-badge-count" style="background-color: {{ $style['bg'] }}; color: {{ $style['color'] }}; border: 1px solid {{ $style['border'] }}; font-size: 0.78rem; padding: 4px 10px;">
                        {{ count($obras[$status] ?? []) }}
                    </span>
                </div>

                <!-- Contenedor Arrastrable de Tarjetas -->
                <div class="kanban-cards-container d-flex flex-column" 
                     data-status="{{ $status }}" 
                     ondragover="allowDrop(event)" 
                     ondrop="dropCard(event)" 
                     style="min-height: 400px; gap: 0.5rem;">

                    @if(isset($obras[$status]))
                        @foreach($obras[$status] as $obra)
                            <!-- Tarjeta Kanban (Borde izquierdo claro/suave) -->
                            <div class="card border-0 shadow-sm rounded-3 p-3 kanban-card position-relative" 
                                 draggable="true" 
                                 ondragstart="dragStart(event)" 
                                 id="obra-card-{{ $obra['id'] }}" 
                                 data-id="{{ $obra['id'] }}"
                                 style="background: #ffffff; cursor: grab; border-left: 4px solid {{ $style['color'] }} !important; border: 1px solid #e2e8f0;">
                                
                                <!-- Parte Superior de la Tarjeta -->
                                <div class="d-flex justify-content-between align-items-center mb-1.5 card-header-row">
                                    <span class="badge border fw-bold card-code-badge" style="background-color: #f1f5f9; color: #475569; font-size: 0.68rem; padding: 3px 6px; border-color: #e2e8f0 !important;">
                                        #OBR-{{ $obra['id'] }}
                                    </span>
                                    <span class="text-muted fw-medium card-date" style="font-size: 0.72rem;">
                                        <i class="far fa-calendar-alt me-1 text-muted"></i>{{ $obra['fecha'] }}
                                    </span>
                                </div>

                                <!-- Título -->
                                <h6 class="fw-bold mb-1 card-title-text" style="color: #0f172a; font-size: 0.9rem; line-height: 1.35;">
                                    {{ $obra['titulo'] }}
                                </h6>

                                <!-- Cliente -->
                                <p class="text-muted small mb-2 card-client-text" style="font-size: 0.8rem;">
                                    <i class="fas fa-building text-secondary me-1"></i>{{ $obra['cliente'] }}
                                </p>

                                <!-- Footer con Monto DTL -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-1 card-footer-row" style="border-color: #f1f5f9 !important;">
                                    <span class="fw-bold px-2 py-0.5 rounded-2 card-monto-badge" style="color: #059669; background-color: #ecfdf5; border: 1px solid #a7f3d0; font-size: 0.88rem;">
                                        {{ $obra['monto'] }}
                                    </span>
                                    
                                    <!-- Menú Opción -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light p-0 text-secondary rounded-circle d-flex align-items-center justify-content-center card-menu-btn" 
                                                type="button" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false"
                                                style="width: 30px; height: 30px; background-color: #f8fafc;">
                                            <i class="fas fa-ellipsis-v" style="font-size: 0.78rem;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.82rem;">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2 text-primary"></i>Ver Detalles</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2 text-warning"></i>Editar Oportunidad</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
        @endforeach

    </div>

    <!-- 3. CONTROLES FLOTANTES VERTICALES -->
    <div class="floating-controls-container d-flex flex-column gap-2">
        <div class="btn-group-vertical shadow-lg rounded-3 bg-white border p-1" role="group" aria-label="Cambiar vista">
            <button type="button" class="btn btn-sm btn-light text-dark fw-bold border-0 py-2 px-2.5 rounded-2 active" id="btn-view-detailed" title="Vista Detallada" onclick="setKanbanView('detailed')">
                <i class="fas fa-th-large text-success"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light text-secondary fw-bold border-0 py-2 px-2.5 rounded-2 mt-1" id="btn-view-compact" title="Vista Compacta" onclick="setKanbanView('compact')">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <button class="btn btn-floating-dtl shadow-lg d-flex align-items-center justify-content-center" 
                title="Nueva Oportunidad">
            <i class="fas fa-plus fs-4"></i>
        </button>
    </div>

</div>

<script>
    let draggedElement = null;
    let autoScrollInterval = null;
    const board = document.getElementById('kanban-main-board');

    function allowDrop(ev) {
        ev.preventDefault();
        handleEdgeScroll(ev.clientX);
    }

    function dragStart(ev) {
        draggedElement = ev.target;
        ev.dataTransfer.setData("text/plain", ev.target.id);
        ev.dataTransfer.setData("obra_id", ev.target.dataset.id);
    }

    function dropCard(ev) {
        ev.preventDefault();
        stopEdgeScroll();
        
        const cardId = ev.dataTransfer.getData("text/plain");
        const obraId = ev.dataTransfer.getData("obra_id");
        const cardElement = document.getElementById(cardId) || draggedElement;
        
        if(!cardElement) return;

        let dropzone = ev.target;
        while (dropzone && !dropzone.classList.contains('kanban-cards-container')) {
            dropzone = dropzone.parentElement;
        }

        if (dropzone) {
            const newStatus = dropzone.dataset.status;
            dropzone.appendChild(cardElement);
            updateStatusBackend(obraId, newStatus);
        }
    }

    function handleEdgeScroll(clientX) {
        if (window.innerWidth < 768) return;

        const boardRect = board.getBoundingClientRect();
        const edgeThreshold = 70;
        const scrollSpeed = 15;

        stopEdgeScroll();

        if (clientX > boardRect.right - edgeThreshold) {
            autoScrollInterval = setInterval(() => {
                board.scrollLeft += scrollSpeed;
            }, 16);
        } else if (clientX < boardRect.left + edgeThreshold) {
            autoScrollInterval = setInterval(() => {
                board.scrollLeft -= scrollSpeed;
            }, 16);
        }
    }

    function stopEdgeScroll() {
        if (autoScrollInterval) {
            clearInterval(autoScrollInterval);
            autoScrollInterval = null;
        }
    }

    document.addEventListener('dragend', stopEdgeScroll);

    let touchCard = null;
    let touchClone = null;

    document.addEventListener('touchstart', function(e) {
        const card = e.target.closest('.kanban-card');
        if (!card || e.target.closest('.dropdown')) return;

        touchCard = card;
        draggedElement = card;
    }, {passive: true});

    document.addEventListener('touchmove', function(e) {
        if (!touchCard) return;

        const touch = e.touches[0];
        handleEdgeScroll(touch.clientX);

        if (!touchClone) {
            touchClone = touchCard.cloneNode(true);
            touchClone.style.position = 'fixed';
            touchClone.style.opacity = '0.85';
            touchClone.style.pointerEvents = 'none';
            touchClone.style.zIndex = '9999';
            touchClone.style.width = touchCard.offsetWidth + 'px';
            document.body.appendChild(touchClone);
            touchCard.style.opacity = '0.4';
        }

        touchClone.style.left = (touch.clientX - touchCard.offsetWidth / 2) + 'px';
        touchClone.style.top = (touch.clientY - 30) + 'px';
    }, {passive: true});

    document.addEventListener('touchend', function(e) {
        stopEdgeScroll();

        if (!touchCard || !touchClone) {
            touchCard = null;
            touchClone = null;
            return;
        }

        const touch = e.changedTouches[0];
        const dropTarget = document.elementFromPoint(touch.clientX, touch.clientY);

        if (dropTarget) {
            let dropzone = dropTarget.closest('.kanban-cards-container');
            if (dropzone) {
                const newStatus = dropzone.dataset.status;
                const obraId = touchCard.dataset.id;
                dropzone.appendChild(touchCard);
                updateStatusBackend(obraId, newStatus);
            }
        }

        touchCard.style.opacity = '1';
        if (touchClone && touchClone.parentNode) {
            touchClone.parentNode.removeChild(touchClone);
        }

        touchCard = null;
        touchClone = null;
    });

    function updateStatusBackend(obraId, newStatus) {
        fetch("{{ route('comercial.pipeline.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                obra_id: obraId,
                nuevo_estado: newStatus
            })
        });
    }

    function setKanbanView(mode) {
        const btnDetailed = document.getElementById('btn-view-detailed');
        const btnCompact = document.getElementById('btn-view-compact');

        if (mode === 'compact') {
            board.classList.add('mode-compact-view');
            btnCompact.classList.add('active', 'bg-light');
            btnDetailed.classList.remove('active', 'bg-light');
        } else {
            board.classList.remove('mode-compact-view');
            btnDetailed.classList.add('active', 'bg-light');
            btnCompact.classList.remove('active', 'bg-light');
        }
    }
</script>

<style>
    .kanban-col {
        width: 85vw;
        max-width: 310px;
    }
    @media (min-width: 768px) {
        .kanban-col {
            width: 290px;
            max-width: 290px;
        }
    }

    /* CONTENEDOR FLOTANTE DERECHO */
    .floating-controls-container {
        position: fixed;
        bottom: 24px;
        right: 20px;
        z-index: 1060;
        align-items: center;
    }

    .btn-floating-dtl {
        width: 52px;
        height: 52px;
        background-color: #059669;
        color: #ffffff;
        border: none;
        border-radius: 16px;
        transition: all 0.25s ease;
    }

    .btn-floating-dtl:hover, .btn-floating-dtl:focus {
        background-color: #047857 !important;
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 10px 20px -4px rgba(5, 150, 105, 0.4) !important;
    }

    /* BARRA DE SCROLL HORIZONTAL ESTÁNDAR */
    .custom-kanban-board {
        padding-bottom: 3.2rem !important;
    }

    .custom-kanban-board::-webkit-scrollbar {
        height: 7px;
        transition: all 0.25s ease;
    }

    .custom-kanban-board::-webkit-scrollbar-track {
        background: rgba(226, 232, 240, 0.5);
        border-radius: 12px;
        margin-left: 10px;
        margin-right: 75px;
    }

    .custom-kanban-board::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.35);
        border-radius: 12px;
        transition: all 0.25s ease;
    }

    .custom-kanban-board:hover::-webkit-scrollbar {
        height: 9px !important;
    }

    .custom-kanban-board:hover::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.5) !important;
    }

    /* Tarjetas Kanban */
    .kanban-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease, padding 0.2s ease;
        touch-action: none;
    }
    .kanban-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -4px rgba(15, 23, 42, 0.12) !important;
    }

    /* MODO COMPACTO */
    .mode-compact-view .kanban-card {
        padding: 0.55rem 0.8rem !important;
    }
    .mode-compact-view .card-client-text,
    .mode-compact-view .card-date {
        display: none !important;
    }
    .mode-compact-view .card-title-text {
        font-size: 0.82rem !important;
        margin-bottom: 0.15rem !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .mode-compact-view .card-monto-badge {
        font-size: 0.78rem !important;
        padding: 1px 6px !important;
    }
    .mode-compact-view .card-footer-row {
        padding-top: 0.35rem !important;
        margin-top: 0.2rem !important;
    }

    /* =======================================================
       📱 REGLAS Y DISEÑO EXCLUSIVO PARA MÓVILES (< 768px)
       ======================================================= */
    @media (max-width: 767.98px) {
        .custom-kanban-board {
            flex-direction: column !important;
            overflow-x: visible !important;
        }

        .kanban-col {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 1.5rem !important;
        }

        /* Cabecera formal con tono plomo claro elegante */
        .kanban-col-header {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05) !important;
        }

        .kanban-cards-container {
            min-height: 80px !important;
        }
    }

    /* =======================================================
       📱 REGLAS DE DIVISIÓN PROPORCIONAL 50/50 (< 576px)
       ======================================================= */
    @media (max-width: 575.98px) {
        .custom-kanban-wrapper {
            padding: 0.85rem 0.9rem !important;
        }

        .custom-header-card .card-body {
            padding: 0.85rem !important;
        }

        /* Lado Izquierdo (Logo) - Ocupa 50% */
        .header-logo-box {
            height: 48px !important;
            max-width: 100% !important;
            padding: 0.2rem !important;
        }

        .header-logo-box img {
            max-height: 32px !important;
        }

        /* Lado Derecho (Texto) - Ocupa 50% */
        .header-info-box {
            padding-left: 0.2rem !important;
        }

        .badge-comercial, .badge-status {
            font-size: 0.56rem !important;
            padding: 2px 5px !important;
        }

        .header-title-text {
            font-size: 0.92rem !important;
            line-height: 1.25 !important;
            letter-spacing: -0.2px !important;
        }

        .kanban-card {
            padding: 0.75rem 0.85rem !important;
        }

        .card-code-badge {
            font-size: 0.62rem !important;
            padding: 2px 5px !important;
        }

        .card-date {
            font-size: 0.65rem !important;
        }

        .card-title-text {
            font-size: 0.84rem !important;
            margin-bottom: 0.25rem !important;
            line-height: 1.3 !important;
        }

        .card-client-text {
            font-size: 0.74rem !important;
            margin-bottom: 0.4rem !important;
        }

        .card-monto-badge {
            font-size: 0.78rem !important;
            padding: 2px 7px !important;
        }

        .card-menu-btn {
            width: 26px !important;
            height: 26px !important;
        }

        .col-title-text {
            font-size: 0.86rem !important;
        }

        .col-badge-count {
            font-size: 0.72rem !important;
            padding: 2px 7px !important;
        }

        .kanban-col-header {
            padding: 0.55rem 0.75rem !important;
            margin-bottom: 0.55rem !important;
        }

        .floating-controls-container {
            bottom: 22px;
            right: 18px;
        }

        .btn-floating-dtl {
            width: 48px;
            height: 48px;
        }

        .custom-kanban-board::-webkit-scrollbar-track {
            margin-right: 65px;
        }
    }
</style>
@endsection