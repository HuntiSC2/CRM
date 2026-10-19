@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos para la Vista Directorio de Clientes DTL PREMIER -->
<style>
    /* Estilo de botones con tamaño y padding estándar uniforme */
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

    /* Botón Principal Verde Corporativo DTL */
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

    /* Botón Secundario Negro Carbón DTL */
    .btn-dtl-dark {
        background-color: #0f172a !important;
        border: 1px solid #0f172a !important;
        color: #ffffff !important;
    }
    .btn-dtl-dark:hover {
        background-color: #1e293b !important;
        border-color: #1e293b !important;
        transform: translateY(-1px);
    }

    /* Botón compacto solo ícono '+' */
    .btn-dtl-icon-only {
        width: 38px;
        height: 38px;
        padding: 0;
    }

    /* Foco del Input de Búsqueda */
    .dtl-search-input:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    /* Placeholder Personalizado */
    .dtl-search-input::placeholder {
        color: #94a3b8 !important;
        font-size: 0.88rem;
    }

    /* Transición en Filas de Tabla */
    .dtl-table-hover tbody tr {
        transition: background-color 0.2s ease;
    }
    .dtl-table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* Indicador de Sesión Activa */
    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<div class="container-fluid px-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <!-- Línea Superior de Acento Verde Corporativo -->
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body px-4 py-3">
            <div class="row align-items-center g-3">
                
                <!-- IZQUIERDA: Logo Oficial Corporativo -->
                <div class="col-12 col-lg-auto text-center text-lg-start">
                    <div class="p-2 rounded-3 bg-white d-inline-flex align-items-center justify-content-center border" style="min-width: 155px; height: 58px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 42px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- CENTRO: Título, Rol y Subtítulo del Módulo -->
                <div class="col-12 col-lg border-start-lg ps-lg-4" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <span class="badge rounded-pill fw-bold px-2.5 py-1 text-uppercase" style="font-size: 0.65rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2.5 py-1 d-inline-flex align-items-center gap-1.5" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Expedientes Activos
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.25rem; color: #0f172a; letter-spacing: -0.3px;">
                        Directorio de Clientes
                    </h3>
                    
                    <p class="mb-0 mt-0.5" style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Registro, consulta y gestión de fichas comerciales y contratistas
                    </p>
                </div>

                <!-- DERECHA: Credenciales de Sesión -->
                <div class="col-12 col-lg-auto text-lg-end">
                    <div class="px-3 py-2 rounded-3 border bg-light d-inline-block text-start text-lg-end w-100 w-lg-auto" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center justify-content-lg-end gap-1.5 mb-0.5">
                            <i class="fas fa-envelope me-1" style="color: #059669; font-size: 0.75rem;"></i>
                            <span class="text-dark fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.8px;">Sesión iniciada como:</span>
                        </div>
                        <span class="fw-bold text-dark small d-block" style="font-size: 0.78rem;">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ALERTA DE ÉXITO AL GUARDAR EN MYSQL -->
    @if(session('success'))
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important;">
            <i class="fas fa-circle-check me-2 fs-5" style="color: #059669;"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    <!-- 2. BARRA DE BÚSQUEDA Y BOTÓN '+' REGISTRAR AL LADO -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-3">
            <form action="{{ route('comercial.clientes.index') }}" method="GET" class="d-flex align-items-center gap-2">
                
                <!-- Buscador e Input Group -->
                <div class="input-group flex-grow-1">
                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #64748b; height: 38px;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 dtl-search-input" value="{{ request('search') }}" placeholder="Buscar por RUC, Razón Social o Contacto..." style="background-color: #f8fafc; border-color: #cbd5e1; font-size: 0.9rem; color: #0f172a; height: 38px;">
                    
                    <!-- Botón Buscar -->
                    <button type="submit" class="btn btn-dtl-action btn-dtl-dark">
                        <i class="fas fa-filter"></i>
                        <span>Buscar</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('comercial.clientes.index') }}" class="btn btn-dtl-action dtl-icon-only" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;" title="Limpiar búsqueda">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>

                <!-- Botón solo ícono '+' al lado del botón buscar -->
                <a href="{{ route('comercial.clientes.create') }}" class="btn btn-dtl-action btn-dtl-primary btn-dtl-icon-only shadow-sm" title="Registrar Ficha">
                    <i class="fas fa-plus fs-6"></i>
                </a>

            </form>
        </div>
    </div>

    <!-- 3. TABLA DE CLIENTES / CONTRATISTAS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 dtl-table-hover" style="font-size: 0.88rem; min-width: 800px;">
                    <thead class="text-uppercase border-bottom" style="font-size: 0.72rem; letter-spacing: 0.8px; background-color: #0f172a; color: #ffffff;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold">RUC</th>
                            <th class="py-3 fw-bold">Razón Social</th>
                            <th class="py-3 fw-bold">Contacto</th>
                            <th class="py-3 fw-bold">Teléfono</th>
                            <th class="py-3 fw-bold">Email</th>
                            <th class="py-3 fw-bold text-center">Estado</th>
                            <th class="py-3 fw-bold text-center">Registrado Por</th>
                            <th class="pe-4 py-3 fw-bold text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="ps-4 fw-bold font-monospace" style="color: #059669;">{{ $cliente->ruc }}</td>
                                <td class="fw-bold" style="color: #0f172a;">{{ $cliente->razon_social }}</td>
                                <td style="color: #334155;"><i class="fas fa-user-tie me-1.5" style="color: #94a3b8;"></i> {{ $cliente->nombre_contacto }}</td>
                                <td style="color: #334155;"><i class="fas fa-phone-alt me-1.5" style="color: #94a3b8;"></i> {{ $cliente->telefono_contacto }}</td>
                                <td style="color: #334155;"><i class="fas fa-envelope me-1.5" style="color: #94a3b8;"></i> {{ $cliente->email_contacto }}</td>
                                <td class="text-center">
                                    @if($cliente->estado === 'ACTIVO')
                                        <span class="badge fw-semibold px-2.5 py-1 rounded-pill" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                            Activo
                                        </span>
                                    @elseif($cliente->estado === 'EN_EVALUACION')
                                        <span class="badge fw-semibold px-2.5 py-1 rounded-pill" style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
                                            En Evaluación
                                        </span>
                                    @else
                                        <span class="badge fw-semibold px-2.5 py-1 rounded-pill" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center small" style="color: #64748b;">{{ $cliente->user->name ?? 'Sistema' }}</td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm rounded-2 px-2.5 py-1" style="background-color: #f8fafc; color: #0f172a; border: 1px solid #cbd5e1;" title="Ver Detalles">
                                        <i class="fas fa-eye" style="color: #059669;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <!-- MENSAJE DE ESTADO VACÍO (EMPTY STATE) -->
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="rounded-circle d-inline-flex p-3.5 mb-3" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-folder-open fs-1"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1" style="color: #0f172a;">No se encontraron clientes registrados</h6>
                                        <p class="small mb-3" style="color: #64748b;">Aún no hay fichas registradas en la base de datos o la búsqueda no arrojó resultados.</p>
                                        <a href="{{ route('comercial.clientes.create') }}" class="btn btn-dtl-action btn-dtl-primary shadow-sm">
                                            <i class="fas fa-plus"></i>
                                            <span>Registrar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINACIÓN AUTOMÁTICA -->
            @if(isset($clientes) && method_exists($clientes, 'links'))
                <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="small" style="color: #64748b;">
                        Mostrando registros del sistema comercial DTL PREMIER.
                    </div>
                    <div>
                        {{ $clientes->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection