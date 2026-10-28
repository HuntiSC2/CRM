<div>
    <!-- Estilos Exclusivos DTL PREMIER -->
    <style>
        .btn-dtl-action { height: 38px; padding: 0 16px; font-size: 0.88rem; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s ease; white-space: nowrap; }
        .btn-dtl-primary { background-color: #059669 !important; border: 1px solid #059669 !important; color: #ffffff !important; }
        .btn-dtl-primary:hover { background-color: #047857 !important; border-color: #047857 !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important; }
        .dtl-card-header-styled { background-color: #0f172a !important; color: #ffffff !important; border-bottom: 3px solid #059669 !important; font-size: 0.72rem !important; letter-spacing: 0.8px; padding: 0.75rem 1rem !important; }
        .dtl-input:focus, .form-control:focus, .form-select:focus { border-color: #059669 !important; box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important; }
        
        .extra-small { font-size: 0.73rem; }
        .status-pulse-green { width: 8px; height: 8px; background-color: #10b981; border-radius: 50%; display: inline-block; }
        .tarjeta-pizarra { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .tarjeta-pizarra:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important; }
        .bg-purple { background-color: #a855f7 !important; }
        .border-purple { border-color: #a855f7 !important; }
        .active-mobile-tab { font-weight: 800 !important; }

        @media (max-width: 767.98px) {
            .kanban-col { width: 100% !important; }
            .container-fluid { padding-left: 4px !important; padding-right: 4px !important; }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

        <!-- ALERTA DE ÉXITO REACTIVA -->
        @if(session()->has('success'))
            <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
                <i class="fas fa-circle-check me-2 fs-5 flex-shrink-0" style="color: #059669;"></i>
                <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('success') }}</div>
            </div>
        @endif

        <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER -->
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
                                <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> PIPELINE COMERCIAL (LIVEWIRE)
                            </span>
                            <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                <span class="status-pulse-green"></span> Tiempo Real
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                            Pipeline de Obras y Proyectos
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. MODAL / OVERLAY REACTIVO DE LIVEWIRE -->
        @if($mostrarFormulario)
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(15, 23, 42, 0.55); backdrop-filter: blur(2px); z-index: 1050;">
                <div class="bg-white rounded-4 shadow-lg overflow-hidden border w-100" style="max-width: 600px; border-color: #cbd5e1 !important;">
                    <div class="dtl-card-header-styled px-4 d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.8px;">
                            <i class="fas fa-bolt text-success me-1.5"></i> Alta Rápida de Obra - DTL PREMIER S.A.C.
                        </h6>
                        <button type="button" class="btn-close btn-close-white opacity-75 shadow-none" wire:click="cerrarFormulario"></button>
                    </div>

                    <form wire:submit.prevent="guardarObra">
                        <div class="p-4" style="background-color: #f8fafc;">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Cliente Empresarial <span class="text-danger">*</span></label>
                                    <select wire:model="cliente_id" class="form-select form-select-sm py-2 dtl-input" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                                        <option value="" selected disabled>-- Seleccione un Cliente --</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->razon_social }} (RUC: {{ $cliente->ruc }})</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id') <span class="text-danger extra-small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Título del Proyecto / Obra <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="titulo" class="form-control form-control-sm py-2 dtl-input" placeholder="Ej. Construcción de Edificio Comercial" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                                    @error('titulo') <span class="text-danger extra-small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Monto Estimado (S/) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted fw-bold" style="border-color: #cbd5e1;">S/</span>
                                        <input type="number" step="0.01" wire:model="monto" class="form-control form-control-sm py-2 dtl-input" placeholder="0.00" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                                    </div>
                                    @error('monto') <span class="text-danger extra-small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Estado Inicial <span class="text-danger">*</span></label>
                                    <select wire:model="estado" class="form-select form-select-sm py-2 dtl-input" style="font-size: 0.85rem; border-color: #cbd5e1;" required>
                                        @foreach($statuses as $st)
                                            <option value="{{ $st }}">{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-semibold extra-small mb-1 text-dark">Fecha Estimada</label>
                                    <input type="date" wire:model="fecha" class="form-control form-control-sm py-2 dtl-input" style="font-size: 0.85rem; border-color: #cbd5e1;">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white px-4 py-3 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                            <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" wire:click="cerrarFormulario">Cancelar</button>
                            <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">
                                <span wire:loading.remove><i class="fas fa-save me-1"></i> Guardar al Instante</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin me-1"></i> Procesando...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- 3. TABLERO KANBAN -->
        @php
            $columnStyles = [
                'Inspección' => ['card_bg' => '#2563eb', 'card_text' => '#ffffff', 'header_color' => '#1d4ed8'], 
                'Cotizado'    => ['card_bg' => '#a855f7', 'card_text' => '#ffffff', 'header_color' => '#7e22ce'], 
                'Aprobado'    => ['card_bg' => '#10b981', 'card_text' => '#ffffff', 'header_color' => '#047857']
            ];
        @endphp

        <div class="d-flex gap-3 overflow-auto justify-content-md-center align-items-start pb-3">
            @foreach($statuses as $status)
                @php $colStyle = $columnStyles[$status] ?? ['card_bg' => '#64748b', 'card_text' => '#ffffff', 'header_color' => '#334155']; @endphp

                <div class="kanban-col bg-white rounded-4 p-3 shadow-sm border d-flex flex-column flex-shrink-0" style="width: 340px; min-height: 520px; border-color: #cbd5e1 !important;">
                    <div class="text-center pb-2 mb-3 border-bottom border-2" style="border-color: #f1f5f9 !important;">
                        <h5 class="fw-bold text-uppercase mb-1" style="color: {{ $colStyle['header_color'] }}; font-size: 0.92rem;">
                            {{ $status }}
                        </h5>
                        <span class="badge rounded-pill px-3 py-1 fw-bold" style="background-color: #f8fafc; color: #475569; font-size: 0.72rem; border: 1px solid #cbd5e1;">
                            {{ count($obras[$status] ?? []) }} Expedientes
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3 flex-grow-1">
                        @forelse($obras[$status] ?? [] as $obra)
                            <div class="card border-0 shadow-sm rounded-3 tarjeta-pizarra" style="background-color: {{ $colStyle['card_bg'] }}; color: {{ $colStyle['card_text'] }};">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge px-2 py-1 fw-bold text-uppercase" style="background-color: rgba(255, 255, 255, 0.22); font-size: 0.65rem;">
                                            #{{ $obra['codigo'] }}
                                        </span>
                                    </div>
                                    <h6 class="fw-bold mb-2 text-truncate text-white" style="font-size: 0.88rem;">{{ $obra['titulo'] }}</h6>
                                    <div class="pt-2 mt-2 border-top" style="border-color: rgba(255, 255, 255, 0.22) !important;">
                                        <div class="d-flex align-items-center justify-content-between" style="font-size: 0.74rem;">
                                            <span class="text-truncate me-2 opacity-90"><i class="fas fa-building me-1 opacity-75"></i>{{ $obra['cliente'] }}</span>
                                            <span class="fw-bold px-2 py-0.5 rounded" style="background-color: rgba(255, 255, 255, 0.25); font-size: 0.72rem;">{{ $obra['monto'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 my-auto text-muted">
                                <i class="fas fa-folder-open fs-3 mb-2 opacity-30"></i>
                                <p class="mb-0 small fw-medium text-uppercase" style="font-size: 0.7rem;">Sin proyectos</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 4. BOTÓN FLOTANTE QUE ABRE EL FORMULARIO LIVEWIRE -->
        <div class="position-fixed bottom-0 end-0 p-3 p-md-4" style="z-index: 1040;">
            <button class="btn btn-success shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center" 
                    wire:click="abrirFormulario"
                    style="width: 52px; height: 52px; background-color: #059669; border: none;" title="Nueva Oportunidad">
                <i class="fas fa-plus fs-4 text-white"></i>
            </button>
        </div>

    </div>
</div>