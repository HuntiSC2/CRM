@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos DTL PREMIER - Sincronizado y Funcional para Celulares -->
<style>
    .btn-dtl-action { height: 38px; padding: 0 16px; font-size: 0.88rem; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s ease; white-space: nowrap; }
    .btn-dtl-primary { background-color: #059669 !important; border: 1px solid #059669 !important; color: #ffffff !important; }
    .btn-dtl-primary:hover { background-color: #047857 !important; border-color: #047857 !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important; }
    
    /* Cabecera Corporativa Original */
    .dtl-card-header-styled { 
        background-color: #0f172a !important; 
        color: #ffffff !important; 
        border-bottom: 3px solid #059669 !important; 
        font-size: 0.72rem !important; 
        letter-spacing: 0.8px; 
        padding: 0.75rem 1rem !important; 
    }

    /* Inputs y Tamaños Originales */
    .dtl-input {
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 0.875rem !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .dtl-input:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12) !important;
    }

    /* OVERLAY ESTILO MODAL CENTRADO ORIGINAL */
    .dtl-overlay-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(2px);
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease-in-out;
    }

    .dtl-overlay-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }

    .dtl-overlay-card {
        width: 100%;
        max-width: 650px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: scale(0.96) translateY(10px);
        transition: transform 0.25s ease-in-out;
        overflow: hidden;
        border: 1px solid #cbd5e1;
    }

    .dtl-overlay-backdrop.show .dtl-overlay-card {
        transform: scale(1) translateY(0);
    }

    /* Separación horizontal amplia entre columnas del Kanban */
    .kanban-board-container {
        gap: 2rem !important;
    }

    .kanban-col { 
        width: 390px !important; 
        min-height: 560px; 
        border-color: #cbd5e1 !important;
        background-color: #ffffff !important;
    }

    /* Estilo de tarjetas limpias */
    .tarjeta-pizarra {
        border-radius: 8px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none !important;
    }

    .tarjeta-pizarra:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .extra-small { font-size: 0.73rem; }
    .status-pulse-green { width: 8px; height: 8px; background-color: #10b981; border-radius: 50%; display: inline-block; }
    .bg-purple { background-color: #a855f7 !important; }
    .border-purple { border-color: #a855f7 !important; }
    .active-mobile-tab { font-weight: 800 !important; }

    @media (max-width: 767.98px) {
        .kanban-col { width: 100% !important; }
        .container-fluid { padding-left: 4px !important; padding-right: 4px !important; }
        .dtl-overlay-card { max-width: 92vw; margin: 1rem; }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3 position-relative" style="background-color: #f0fdf4; min-height: 92vh;">

    <!-- ALERTA DE ÉXITO -->
    @if(session('success'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check me-2 fs-5 flex-shrink-0" style="color: #059669;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('success') }}</div>
        </div>
    @endif

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
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
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> PIPELINE COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Expedientes Activos
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                        Pipeline de Obras y Proyectos
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CONTENEDOR FLOTANTE TIPO MODAL (REGISTRO) -->
    <div class="dtl-overlay-backdrop" id="overlayNuevaObra">
        <div class="dtl-overlay-card">
            <div class="card-header dtl-card-header-styled d-flex align-items-center justify-content-between">
                <span class="fw-bold text-white text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.8px;">
                    <i class="fas fa-plus-circle text-success me-1.5"></i> REGISTRO DE NUEVA OBRA / OPORTUNIDAD - DTL PREMIER S.A.C.
                </span>
                <button type="button" class="btn-close btn-close-white opacity-75 shadow-none" onclick="toggleOverlayObra()"></button>
            </div>

            <form action="{{ route('comercial.pipeline.store') }}" method="POST">
                @csrf
                <div class="p-4" style="background-color: #f8fafc;">
                    <div class="row g-3">
                        
                        <!-- Cliente Empresarial -->
                        <div class="col-12">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Cliente Empresarial <span class="text-danger">*</span></label>
                            <select name="cliente_id" class="form-select form-select-sm dtl-input" required>
                                <option value="" selected disabled>-- Seleccione un Cliente del Directorio --</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->razon_social }} (RUC: {{ $cliente->ruc }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1" style="font-size: 0.68rem;">* El cliente debe estar previamente registrado en el Directorio.</small>
                        </div>

                        <!-- Título del Proyecto / Obra -->
                        <div class="col-12">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Título del Proyecto / Obra <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" class="form-control form-control-sm dtl-input" placeholder="Ej. Construcción de Edificio Comercial Surco" required>
                        </div>

                        <!-- Monto Estimado -->
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted fw-bold" style="border-color: #cbd5e1;">S/</span>
                                <input type="number" step="0.01" name="monto" class="form-control dtl-input" placeholder="0.00" required>
                            </div>
                        </div>

                        <!-- Estado Inicial (Sincronizado a Inspección) -->
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Estado Inicial <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select form-select-sm dtl-input" required>
                                @foreach($statuses as $st)
                                    <option value="{{ $st }}" {{ in_array($st, ['Inspección', 'Por Visitar']) ? 'selected' : '' }}>
                                        {{ $st === 'Por Visitar' ? 'Inspección' : $st }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha Estimada de Inicio -->
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Fecha Estimada de Inicio</label>
                            <input type="date" name="fecha" class="form-control form-control-sm dtl-input" value="{{ date('Y-m-d') }}">
                        </div>

                    </div>
                </div>

                <div class="bg-white px-4 py-3 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" onclick="toggleOverlayObra()">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">
                        <i class="fas fa-save me-1"></i> Registrar Expediente
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- PESTAÑAS MÓVILES (< 768px) CON CAMBIO DE COLUMNA 100% FUNCIONAL -->
    @php
        $columnStyles = [
            'Inspección' => [
                'card_bg' => '#15803d', 'card_text' => '#ffffff', 'header_color' => '#166534'
            ],
            'Por Visitar' => [
                'card_bg' => '#15803d', 'card_text' => '#ffffff', 'header_color' => '#166534'
            ], 
            'Cotizado'    => [
                'card_bg' => '#16a34a', 'card_text' => '#ffffff', 'header_color' => '#15803d'
            ], 
            'Aprobado'    => [
                'card_bg' => '#22c55e', 'card_text' => '#ffffff', 'header_color' => '#16a34a'
            ]
        ];
    @endphp

    <div class="d-flex d-md-none mb-3 bg-white p-1 rounded-3 shadow-sm border justify-content-between gap-1" style="border-color: #cbd5e1 !important;">
        @foreach($statuses as $index => $status)
            @php 
                $displayName = ($status === 'Por Visitar') ? 'Inspección' : $status;
            @endphp
            <button type="button" class="btn btn-sm flex-fill fw-bold py-1.5 px-1 mobile-tab-btn {{ $index === 0 ? 'btn-success text-white border-success active-mobile-tab' : 'btn-light text-secondary border' }}" 
                    onclick="switchMobileTab('{{ $status }}')" id="tab-btn-{{ Str::slug($status) }}"
                    style="font-size: 0.7rem; border-radius: 6px; transition: all 0.2s ease;">
                {{ $displayName }} 
                <span class="badge rounded-pill bg-white text-dark ms-1" style="font-size: 0.65rem;">
                    {{ count($obras[$status] ?? []) }}
                </span>
            </button>
        @endforeach
    </div>

    <!-- 3. TABLERO KANBAN -->
    <div class="d-flex kanban-board-container overflow-auto justify-content-md-center align-items-start pb-3" id="kanban-main-board">

        @foreach($statuses as $status)
            @php 
                $colStyle = $columnStyles[$status] ?? [
                    'card_bg' => '#15803d', 'card_text' => '#ffffff', 'header_color' => '#166534'
                ];
                $displayColName = ($status === 'Por Visitar') ? 'Inspección' : $status;
            @endphp

            <div class="kanban-col bg-white rounded-4 p-3 shadow-sm border d-flex flex-column flex-shrink-0" 
                 id="col-{{ Str::slug($status) }}"
                 data-col-status="{{ $status }}" style="border-color: #cbd5e1 !important;">
                
                <div class="text-center pb-2 mb-3 border-bottom border-2" style="border-color: #f1f5f9 !important;">
                    <h5 class="fw-bold text-uppercase mb-1" style="color: {{ $colStyle['header_color'] }}; font-size: 0.95rem; letter-spacing: 0.5px;">
                        {{ $displayColName }}
                    </h5>
                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background-color: #f8fafc; color: #475569; font-size: 0.72rem; border: 1px solid #cbd5e1;">
                        {{ count($obras[$status] ?? []) }} Expedientes
                    </span>
                </div>

                <div class="kanban-cards-container d-flex flex-column gap-3 flex-grow-1" 
                     data-status="{{ $status }}" 
                     ondragover="allowDrop(event)" 
                     ondrop="dropCard(event)">

                    @if(isset($obras[$status]) && count($obras[$status]) > 0)
                        @foreach($obras[$status] as $obra)
                            
                            <div class="card shadow-sm tarjeta-pizarra" 
                                 draggable="true" 
                                 ondragstart="dragStart(event)" 
                                 id="obra-card-{{ $obra['id'] }}" 
                                 data-id="{{ $obra['id'] }}"
                                 style="background-color: {{ $colStyle['card_bg'] }}; color: {{ $colStyle['card_text'] }}; cursor: grab;">
                                
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge px-2 py-1 fw-bold text-uppercase" style="background-color: rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.65rem;">
                                            #{{ $obra['codigo'] }}
                                        </span>

                                        <div class="dropdown">
                                            <button class="btn btn-sm p-0 border-0 text-white d-flex align-items-center justify-content-center opacity-75 opacity-100-hover" 
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="width: 24px; height: 24px;">
                                                <i class="fas fa-ellipsis-v" style="font-size: 0.75rem;"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-1.5" style="font-size: 0.8rem; min-width: 170px; z-index: 1050;">
                                                <li><h6 class="dropdown-header text-uppercase fw-bold px-2 py-0.5" style="font-size: 0.58rem;">Mover Etapa</h6></li>
                                                @foreach($statuses as $targetStatus)
                                                    @if($targetStatus !== $status)
                                                        @php $targetDisplayName = ($targetStatus === 'Por Visitar') ? 'Inspección' : $targetStatus; @endphp
                                                        <li>
                                                            <button class="dropdown-item rounded-2 py-1 px-2 fw-medium" onclick="updateStatusBackend('{{ $obra['id'] }}', '{{ $targetStatus }}')">
                                                                <i class="fas fa-arrow-right me-1.5 text-success"></i>Mover a {{ $targetDisplayName }}
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endforeach
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li><button class="dropdown-item rounded-2 py-1 px-2 text-danger fw-semibold" onclick="updateStatusBackend('{{ $obra['id'] }}', 'Perdido')"><i class="fas fa-times-circle me-1.5"></i>Marcar Perdido</button></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h6 class="fw-bold mb-2 text-truncate text-white" style="font-size: 0.88rem; line-height: 1.3;" title="{{ $obra['titulo'] }}">
                                        {{ $obra['titulo'] }}
                                    </h6>

                                    <div class="pt-2 mt-2 border-top" style="border-color: rgba(255, 255, 255, 0.25) !important;">
                                        <div class="d-flex align-items-center justify-content-between" style="font-size: 0.74rem;">
                                            <span class="text-truncate me-2 fw-medium text-white" style="max-width: 160px; opacity: 0.95;">
                                                <i class="fas fa-building me-1 opacity-75"></i>{{ $obra['cliente'] }}
                                            </span>
                                            <span class="fw-bold px-2 py-0.5 rounded text-white" style="background-color: rgba(255, 255, 255, 0.3); font-size: 0.72rem;">
                                                {{ $obra['monto'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @else
                        <div class="text-center py-5 my-auto text-muted">
                            <i class="fas fa-folder-open fs-3 mb-2 opacity-30"></i>
                            <p class="mb-0 small fw-medium text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Sin proyectos pendientes</p>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>

    <!-- 4. BOTÓN FLOTANTE CIRCULAR CLÁSICO PARA ABRIR EL MODAL -->
    <div class="position-fixed bottom-0 end-0 p-3 p-md-4" style="z-index: 1040;">
        <button class="btn btn-success shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center" 
                onclick="toggleOverlayObra()"
                style="width: 52px; height: 52px; background-color: #059669; border: none; transition: transform 0.2s ease;" title="Nueva Oportunidad">
            <i class="fas fa-plus fs-4 text-white"></i>
        </button>
    </div>

</div>

<script>
    // Función para mostrar u ocultar el Modal flotante
    function toggleOverlayObra() {
        const overlay = document.getElementById('overlayNuevaObra');
        overlay.classList.toggle('show');
    }

    // Cerrar el modal si se hace clic fuera de la tarjeta central
    document.getElementById('overlayNuevaObra').addEventListener('click', function(e) {
        if (e.target === this) {
            toggleOverlayObra();
        }
    });

    let draggedElement = null;

    function allowDrop(ev) { ev.preventDefault(); }
    
    function dragStart(ev) {
        draggedElement = ev.target;
        if(ev.dataTransfer) {
            ev.dataTransfer.setData("text/plain", ev.target.id);
            ev.dataTransfer.setData("obra_id", ev.target.dataset.id);
        }
    }

    function dropCard(ev) {
        ev.preventDefault();
        const obraId = ev.dataTransfer ? ev.dataTransfer.getData("obra_id") : (draggedElement ? draggedElement.dataset.id : null);
        
        let dropzone = ev.target;
        while (dropzone && !dropzone.classList.contains('kanban-cards-container')) {
            dropzone = dropzone.parentElement;
        }

        if (dropzone && draggedElement && obraId) {
            const newStatus = dropzone.dataset.status;
            dropzone.appendChild(draggedElement);
            updateStatusBackend(obraId, newStatus);
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
        }).then(response => {
            if(response.ok) location.reload();
        }).catch(err => console.error("Error al actualizar:", err));
    }

    // Funcionalidad interactiva corregida para conmutar columnas en móviles
    function switchMobileTab(statusName) {
        if (window.innerWidth >= 768) return;
        
        // Ocultar todas las columnas y mostrar estrictamente la seleccionada por su dataset
        document.querySelectorAll('.kanban-col').forEach(col => {
            if (col.dataset.colStatus === statusName) {
                col.style.display = 'flex';
            } else {
                col.style.display = 'none';
            }
        });

        // Actualizar el estado visual de los botones superiores
        document.querySelectorAll('.mobile-tab-btn').forEach(btn => {
            btn.classList.remove('btn-success', 'text-white', 'border-success', 'active-mobile-tab');
            btn.classList.add('btn-light', 'text-secondary', 'border');
        });

        const activeBtn = document.getElementById('tab-btn-' + statusName.toLowerCase().replace(/ /g, '-'));
        if(activeBtn) {
            activeBtn.classList.remove('btn-light', 'text-secondary', 'border');
            activeBtn.classList.add('btn-success', 'text-white', 'border-success', 'active-mobile-tab');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.innerWidth < 768) {
            const firstCol = document.querySelector('.kanban-col');
            if (firstCol) {
                switchMobileTab(firstCol.dataset.colStatus);
            }
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            document.querySelectorAll('.kanban-col').forEach(col => col.style.display = 'flex');
        } else {
            const firstCol = document.querySelector('.kanban-col');
            if (firstCol) {
                switchMobileTab(firstCol.dataset.colStatus);
            }
        }
    });
</script>
@endsection