@extends('layouts.app')

@section('content')
<!-- Estilos de Animación, Transiciones e Identidad Visual DTL PREMIER -->
<style>
    .dtl-card-transition {
        transition: all 0.25s ease;
    }
    
    .dtl-card-active {
        background-color: #ffffff !important;
        border: 1px solid #059669 !important;
    }
    .dtl-card-active:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -4px rgba(5, 150, 105, 0.15) !important;
    }
    .dtl-card-active:hover .dtl-icon-box {
        transform: scale(1.05);
        background-color: #059669 !important;
        color: #ffffff !important;
    }

    .dtl-card-disabled {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none !important;
    }

    .btn-dtl-primary {
        background-color: #059669 !important;
        border-color: #059669 !important;
        color: #ffffff !important;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-dtl-primary:hover {
        background-color: #047857 !important;
        border-color: #047857 !important;
    }

    .dtl-icon-box {
        transition: all 0.25s ease;
        flex-shrink: 0;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    /* Regla para garantizar que el botón se quede a la derecha e información a la izquierda */
    .module-flex-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        width: 100%;
    }

    @media (max-width: 576px) {
        .module-flex-container {
            flex-direction: column;
            align-items: stretch;
        }
        .module-flex-container .btn-action-wrapper {
            width: 100%;
        }
    }
</style>

<div class="container-fluid px-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. (ALTURA INICIAL RESTAURADA) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <!-- Línea Superior Verde Corporativo -->
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body px-4 py-3">
            <div class="row align-items-center g-3">
                
                <!-- IZQUIERDA: Logo Oficial Corporativo -->
                <div class="col-12 col-lg-auto text-center text-lg-start">
                    <div class="p-2 rounded-3 bg-white d-inline-flex align-items-center justify-content-center border" style="min-width: 155px; height: 58px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 42px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- CENTRO: Mensaje de Bienvenida y Rol -->
                <div class="col-12 col-lg border-start-lg ps-lg-4" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <span class="badge rounded-pill fw-bold px-2.5 py-1 text-uppercase" style="font-size: 0.65rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-user-shield me-1" style="color: #10b981;"></i> ROL: {{ strtoupper(auth()->user()->role ?? 'INVITADO') }}
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2.5 py-1 d-inline-flex align-items-center gap-1.5" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Sesión Activa
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.25rem; color: #0f172a; letter-spacing: -0.3px;">
                        Bienvenido, {{ auth()->user()->name }}
                    </h3>
                    
                    <p class="mb-0 mt-0.5" style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Ejecución de obras, consultoría y servicios en general 
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

    <!-- 2. MÓDULOS DEL SISTEMA -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2" style="font-size: 1.1rem; color: #0f172a;">
                <i class="fas fa-th-large" style="color: #059669;"></i>
                <span>Módulos del Sistema</span>
            </h5>
        </div>

        <div class="d-flex flex-column gap-3">

            @php
                $userRole = strtolower(trim(auth()->user()->role ?? ''));
                $isEjecutivo     = ($userRole === 'ejecutivo');
                $isDirectivo     = in_array($userRole, ['directivo']);
                $isAdministrador = ($userRole === 'administrador');
            @endphp

            <!-- 1. MÓDULO GESTIÓN COMERCIAL -->
            <div class="card rounded-4 dtl-card-transition {{ $isEjecutivo ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-4">
                    <div class="module-flex-container">
                        
                        <!-- LADO IZQUIERDO: Ícono, Título, Insignia y Descripción -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 52px; height: 52px; background-color: {{ $isEjecutivo ? '#d1fae5' : '#e2e8f0' }}; color: {{ $isEjecutivo ? '#059669' : '#94a3b8' }};">
                                <i class="fas fa-handshake fs-4"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <h5 class="fw-bold mb-0" style="color: {{ $isEjecutivo ? '#0f172a' : '#64748b' }}; font-size: 1.12rem;">
                                        Gestión Comercial
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2.5 py-1 text-uppercase" 
                                          style="font-size: 0.65rem; background-color: {{ $isEjecutivo ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isEjecutivo ? '#047857' : '#64748b' }}; border: 1px solid {{ $isEjecutivo ? '#a7f3d0' : '#cbd5e1' }};">
                                        Front-Office
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.85rem; line-height: 1.45;">
                                    Registro, consulta y administración de fichas de clientes/contratistas con validación automática de RUC.
                                </p>
                            </div>
                        </div>

                        <!-- LADO DERECHO: Botón de Acción -->
                        <div class="btn-action-wrapper text-end">
                            @if($isEjecutivo)
                                <a href="{{ route('comercial.clientes.index') }}" 
                                   class="btn text-white fw-bold py-2.5 px-4 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 btn-dtl-primary" 
                                   style="font-size: 0.9rem;">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Ir a Clientes</span>
                                </a>
                            @else
                                <button class="btn fw-semibold py-2.5 px-4 rounded-3 border d-inline-flex align-items-center justify-content-center gap-2" 
                                        style="background-color: #f1f5f9; color: #64748b; border-color: #cbd5e1 !important; cursor: not-allowed; white-space: nowrap;" disabled>
                                    <i class="fas fa-lock" style="font-size: 0.85rem; color: #64748b;"></i>
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.88rem;">Acceso Restringido</span>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- 2. MÓDULO SUPERVISIÓN EJECUTIVA -->
            <div class="card rounded-4 dtl-card-transition {{ $isDirectivo ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-4">
                    <div class="module-flex-container">
                        
                        <!-- LADO IZQUIERDO: Ícono, Título, Insignia y Descripción -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 52px; height: 52px; background-color: {{ $isDirectivo ? '#0f172a' : '#e2e8f0' }}; color: {{ $isDirectivo ? '#ffffff' : '#94a3b8' }};">
                                <i class="fas fa-chart-line fs-4"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <h5 class="fw-bold mb-0" style="color: {{ $isDirectivo ? '#0f172a' : '#64748b' }}; font-size: 1.12rem;">
                                        Supervisión Ejecutiva
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2.5 py-1 text-uppercase" 
                                          style="font-size: 0.65rem; background-color: {{ $isDirectivo ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isDirectivo ? '#047857' : '#64748b' }}; border: 1px solid {{ $isDirectivo ? '#a7f3d0' : '#cbd5e1' }};">
                                        Management
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.85rem; line-height: 1.45;">
                                    Visibilidad total de estimaciones, avances de obras y métricas clave del sistema comercial.
                                </p>
                            </div>
                        </div>

                        <!-- LADO DERECHO: Botón de Acción -->
                        <div class="btn-action-wrapper text-end">
                            @if($isDirectivo)
                                <a href="#" 
                                   class="btn text-white fw-bold py-2.5 px-4 rounded-3 d-inline-flex align-items-center justify-content-center gap-2" 
                                   style="background-color: #0f172a; border-color: #0f172a; font-size: 0.9rem; white-space: nowrap;">
                                    <i class="fas fa-chart-pie"></i>
                                    <span>Ingresar al Panel</span>
                                </a>
                            @else
                                <button class="btn fw-semibold py-2.5 px-4 rounded-3 border d-inline-flex align-items-center justify-content-center gap-2" 
                                        style="background-color: #f1f5f9; color: #64748b; border-color: #cbd5e1 !important; cursor: not-allowed; white-space: nowrap;" disabled>
                                    <i class="fas fa-lock" style="font-size: 0.85rem; color: #64748b;"></i>
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.88rem;">Acceso Restringido</span>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- 3. MÓDULO SOPORTE Y SEGURIDAD -->
            <div class="card rounded-4 dtl-card-transition {{ $isAdministrador ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-4">
                    <div class="module-flex-container">
                        
                        <!-- LADO IZQUIERDO: Ícono, Título, Insignia y Descripción -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 52px; height: 52px; background-color: {{ $isAdministrador ? '#d1fae5' : '#e2e8f0' }}; color: {{ $isAdministrador ? '#059669' : '#94a3b8' }};">
                                <i class="fas fa-cogs fs-4"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <h5 class="fw-bold mb-0" style="color: {{ $isAdministrador ? '#0f172a' : '#64748b' }}; font-size: 1.12rem;">
                                        Soporte y Seguridad
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2.5 py-1 text-uppercase" 
                                          style="font-size: 0.65rem; background-color: {{ $isAdministrador ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isAdministrador ? '#047857' : '#64748b' }}; border: 1px solid {{ $isAdministrador ? '#a7f3d0' : '#cbd5e1' }};">
                                        Control Total
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.85rem; line-height: 1.45;">
                                    Auditoría de intentos fallidos, control de cuentas bloqueadas y parámetros de infraestructura.
                                </p>
                            </div>
                        </div>

                        <!-- LADO DERECHO: Botón de Acción -->
                        <div class="btn-action-wrapper text-end">
                            @if($isAdministrador)
                                <a href="#" 
                                   class="btn text-white fw-bold py-2.5 px-4 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 btn-dtl-primary" 
                                   style="font-size: 0.9rem;">
                                    <i class="fas fa-shield-halved"></i>
                                    <span>Panel de Seguridad</span>
                                </a>
                            @else
                                <button class="btn fw-semibold py-2.5 px-4 rounded-3 border d-inline-flex align-items-center justify-content-center gap-2" 
                                        style="background-color: #f1f5f9; color: #64748b; border-color: #cbd5e1 !important; cursor: not-allowed; white-space: nowrap;" disabled>
                                    <i class="fas fa-lock" style="font-size: 0.85rem; color: #64748b;"></i>
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.88rem;">Acceso Restringido</span>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection