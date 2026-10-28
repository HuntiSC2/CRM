@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos DTL PREMIER -->
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
    .dtl-search-input:focus, .dtl-input:focus, .form-control:focus, .form-select:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-search-input::placeholder, .dtl-input::placeholder {
        color: #94a3b8 !important;
        font-size: 0.82rem;
    }

    /* Tabla Base Escritorio */
    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .dtl-table-hover thead th, .dtl-card-header-styled {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
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
    }

    /* REDUCCIÓN COMPACTA EXCLUSIVA PARA PANTALLAS MÓVILES (CELULAR) */
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

    /* Tarjetas Móviles opcionales */
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

    /* Paginación Numerada alineada a la derecha */
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

    .dtl-pagination-wrapper nav > div:first-child,
    .dtl-pagination-wrapper p.small.text-muted,
    .dtl-pagination-wrapper .text-muted {
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
        color: #0f172a !important;
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
                            <i class="fas fa-book-bookmark me-1" style="color: #10b981;"></i> SEGUIMIENTO OPERATIVO
                        </span>

                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Historial de Interacciones
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: #0f172a; letter-spacing: -0.3px;">
                        Bitácora de Eventos y Comunicaciones
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

    @if (session('error'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-triangle-exclamation me-2 fs-5 flex-shrink-0" style="color: #dc2626;"></i>
            <div class="fw-medium small" style="font-size: 0.80rem;">{{ session('error') }}</div>
        </div>
    @endif

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN DE ACCIÓN (+) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('comercial.bitacora.index') }}" method="GET" class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar en la bitácora por Obra, Comentario..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.85rem; color: #0f172a; height: 38px;">
                    
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span class="d-none d-sm-inline">Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('comercial.bitacora.index') }}" class="btn btn-dtl-action btn-dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>

                <button type="button" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm flex-shrink-0" data-bs-toggle="collapse" data-bs-target="#seccionFormularioBitacora" aria-expanded="false" aria-controls="seccionFormularioBitacora" title="Registrar Nota de Bitácora">
                    <i class="fas fa-plus fs-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. FORMULARIO DINÁMICO COMPACTO (COLAPSABLE) -->
    <div class="collapse mb-3" id="seccionFormularioBitacora">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
            <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center justify-content-between" style="border-bottom: 3px solid #059669;">
                <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">Registro de Nueva Anotación en Bitácora</h6>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-toggle="collapse" data-bs-target="#seccionFormularioBitacora" aria-label="Close"></button>
            </div>

            <form action="{{ route('comercial.bitacora.store') }}" method="POST">
                @csrf
                <div class="card-body p-3" style="background-color: #f8fafc;">
                    <div class="row g-2.5">
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Obra / Proyecto Relacionado <span class="text-danger">*</span></label>
                            <select name="obra_id" class="form-select form-select-sm py-1" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                <option value="">Seleccione un proyecto...</option>
                                @foreach($obrasDisponibles ?? [] as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->codigo }} - {{ $obra->titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Tipo de Contacto <span class="text-danger">*</span></label>
                            <select name="tipo_contacto" class="form-select form-select-sm py-1" style="font-size: 0.82rem; border-color: #cbd5e1;" required>
                                <option value="Llamada Telefónica">Llamada Telefónica</option>
                                <option value="Reunión Presencial">Reunión Presencial</option>
                                <option value="Correo Electrónico">Correo Electrónico / WhatsApp</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold extra-small mb-1 text-dark">Comentarios / Acuerdos Logrados <span class="text-danger">*</span></label>
                            <textarea name="comentario" class="form-control form-control-sm py-1" rows="2" placeholder="Escriba los detalles de la conversación, acuerdos..." style="font-size: 0.82rem; border-color: #cbd5e1;" required></textarea>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white px-3 py-2 border-top d-flex justify-content-end gap-2" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 fw-bold rounded-2" data-bs-toggle="collapse" data-bs-target="#seccionFormularioBitacora">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-dtl-primary px-4 fw-bold rounded-2">Registrar Evento</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. TABLA Y VISTA MÓVIL DE BITÁCORAS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            
            <!-- VISTA TABLA RESPONSIVA (ESCRITORIO Y ADAPTADA A CELULAR) -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 dtl-table-hover" style="min-width: 600px;">
                    <thead>
                        <tr>
                            <th class="ps-3 py-2.5 fw-bold">FECHA / HORA</th>
                            <th class="py-2.5 fw-bold">OBRA / PROYECTO</th>
                            <th class="py-2.5 fw-bold text-center">TIPO CONTACTO</th>
                            <th class="py-2.5 fw-bold">COMENTARIO / ACUERDO</th>
                            <th class="py-2.5 fw-bold text-center">REGISTRADO POR</th>
                            <th class="pe-3 py-2.5 fw-bold text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bitacoras ?? [] as $bitacora)
                            <tr style="border-top: 1px solid #cbd5e1;">
                                <td class="ps-3">
                                    <span class="fw-bold text-dark" style="font-size: 0.75rem;">
                                        <i class="far fa-clock me-1 text-success"></i>
                                        {{ \Carbon\Carbon::parse($bitacora->created_at ?? now())->format('d/m/Y h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem;">
                                        {{ $bitacora->obra->titulo ?? 'Seguimiento General' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php $tipo = $bitacora->tipo_contacto ?? 'Llamada Telefónica'; @endphp
                                    @if(str_contains(strtolower($tipo), 'reunión') || str_contains(strtolower($tipo), 'presencial'))
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-users me-1"></i> Reunión
                                        </span>
                                    @elseif(str_contains(strtolower($tipo), 'llamada'))
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                            <i class="fas fa-phone me-1"></i> Llamada
                                        </span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="font-size: 0.65rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                            <i class="fas fa-envelope me-1"></i> Correo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-secondary" style="font-size: 0.78rem;">
                                        {{ Str::limit($bitacora->comentario, 50) ?: 'Sin detalles anotados' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted" style="font-size: 0.78rem;">
                                        {{ $bitacora->user->name ?? 'Asesor Comercial' }}
                                    </span>
                                </td>
                                <td class="pe-3 text-center">
                                    <button class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center" style="background-color: #ecfdf5; color: #059669; width: 28px; height: 28px;" title="Ver Detalle">
                                        <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">No se encontraron anotaciones en la bitácora.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- 5. PAGINACIÓN ENUMERADA AL LADO DERECHO -->
    <div class="dtl-pagination-wrapper">
        @if(isset($bitacoras) && method_exists($bitacoras, 'links'))
            {{ $bitacoras->withQueryString()->links('pagination::bootstrap-5') }}
        @endif
    </div>

</div>
@endsection