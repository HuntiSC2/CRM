@extends('layouts.app')

@section('content')
<!-- Estilos de Animación, Transiciones e Identidad Visual DTL PREMIER -->
<style>
    /* Jerarquía Tipográfica Estricta (14px, 12px, 10px) */
    .font-title {
        font-size: 14px !important;
        line-height: 1.35 !important;
    }
    .font-subtitle {
        font-size: 12px !important;
        line-height: 1.4 !important;
    }
    .font-minor {
        font-size: 10px !important;
        line-height: 1.2 !important;
    }

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
        opacity: 0.75;
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
        width: 6px;
        height: 6px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

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
        .module-flex-container .btn-action-wrapper .btn {
            width: 100%;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                
                <!-- Logo -->
                <div class="col-auto">
                    <div class="p-1.5 p-md-2 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="min-width: 125px; height: 48px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 34px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- Datos de Sesión -->
                <div class="col border-start-md ps-md-3" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase font-minor" style="background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-user-shield me-1" style="color: #10b981;"></i> ROL: {{ strtoupper(auth()->user()->role ?? 'INVITADO') }}
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1 font-minor" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Sesión Activa
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark font-title" style="color: #0f172a; letter-spacing: -0.3px;">
                        Bienvenido, {{ auth()->user()->name }}
                    </h3>
                    
                    <p class="mb-0 text-muted d-none d-md-block font-subtitle" style="font-weight: 500;">
                        Ejecución de obras, consultoría y servicios en general 
                    </p>
                </div>

                <!-- Credenciales -->
                <div class="col-12 col-md-auto text-end d-none d-lg-block">
                    <div class="px-3 py-2 rounded-3 border bg-light d-inline-block text-end" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center justify-content-end gap-1.5 mb-0.5">
                            <i class="fas fa-envelope me-1" style="color: #059669; font-size: 10px;"></i>
                            <span class="text-dark fw-bold text-uppercase font-minor" style="letter-spacing: 0.8px;">Sesión iniciada como:</span>
                        </div>
                        <span class="fw-bold text-dark d-block font-subtitle">
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
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2 font-title" style="color: #0f172a;">
                <i class="fas fa-th-large" style="color: #059669;"></i>
                <span>Módulos del Sistema</span>
            </h5>
        </div>

        <div class="d-flex flex-column gap-3">

            @php
                $userRole = strtolower(trim(auth()->user()->role ?? ''));

                // ASIGNACIÓN ESTRICTA DE 1 ROL A 1 MÓDULO EXCLUSIVO
                $isEjecutivo     = ($userRole === 'ejecutivo');
                $isDirectivo     = ($userRole === 'directivo');
                $isAdministrador = ($userRole === 'administrador');

                // RUTAS DE NAVEGACIÓN
                $routeComercial  = Route::has('comercial.clientes.index') ? route('comercial.clientes.index') : (Route::has('comercial.pipeline.index') ? route('comercial.pipeline.index') : '#');
                
                // Ruta exclusiva para Directivo (evita el 403 de la ruta comercial)
                $routeDirectorio = Route::has('directorio.index') ? route('directorio.index') : (Route::has('directivo.pipeline.index') ? route('directivo.pipeline.index') : (Route::has('directivo.index') ? route('directivo.index') : '#'));
                
                // Ruta exclusiva para Administrador
                $routeAdmin      = Route::has('admin.users.index') ? route('admin.users.index') : (Route::has('admin.dashboard') ? route('admin.dashboard') : '#');
            @endphp

            <!-- MÓDULO 1: GESTIÓN COMERCIAL (Exclusivo ROL: ejecutivo) -->
            <div class="card rounded-4 dtl-card-transition {{ $isEjecutivo ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-3.5">
                    <div class="module-flex-container">
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 48px; height: 48px; background-color: {{ $isEjecutivo ? '#d1fae5' : '#e2e8f0' }}; color: {{ $isEjecutivo ? '#059669' : '#94a3b8' }};">
                                <i class="fas fa-handshake fs-5"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-0.5">
                                    <h5 class="fw-bold mb-0 font-title" style="color: {{ $isEjecutivo ? '#0f172a' : '#64748b' }};">
                                        Gestión Comercial
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2 py-0.5 text-uppercase font-minor" 
                                          style="background-color: {{ $isEjecutivo ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isEjecutivo ? '#047857' : '#64748b' }}; border: 1px solid {{ $isEjecutivo ? '#a7f3d0' : '#cbd5e1' }};">
                                        Front-Office
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary font-subtitle">
                                    Registro, consulta y administración de fichas de clientes/contratistas con validación automática de RUC.
                                </p>
                            </div>
                        </div>

                        <div class="btn-action-wrapper text-end">
                            @if($isEjecutivo)
                                <a href="{{ $routeComercial }}" 
                                   class="btn btn-dtl-primary fw-bold py-2 px-3.5 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 font-subtitle">
                                    <span>Ingresar al Módulo</span>
                                    <i class="fas fa-arrow-right font-minor"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary fw-semibold py-2 px-3 rounded-3 font-subtitle" disabled style="opacity: 0.65;">
                                    Sin Acceso
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- MÓDULO 2: DIRECTORIO Y CONTROL DE OBRAS (Exclusivo ROL: directivo) -->
            <div class="card rounded-4 dtl-card-transition {{ $isDirectivo ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-3.5">
                    <div class="module-flex-container">
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 48px; height: 48px; background-color: {{ $isDirectivo ? '#d1fae5' : '#e2e8f0' }}; color: {{ $isDirectivo ? '#059669' : '#94a3b8' }};">
                                <i class="fas fa-chart-line fs-5"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-0.5">
                                    <h5 class="fw-bold mb-0 font-title" style="color: {{ $isDirectivo ? '#0f172a' : '#64748b' }};">
                                        Directorio y Control de Obras
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2 py-0.5 text-uppercase font-minor" 
                                          style="background-color: {{ $isDirectivo ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isDirectivo ? '#047857' : '#64748b' }}; border: 1px solid {{ $isDirectivo ? '#a7f3d0' : '#cbd5e1' }};">
                                        Gestión Ejecutiva
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary font-subtitle">
                                    Monitoreo de pipeline corporativo, revisión de expedientes, estados de avance y métricas comerciales.
                                </p>
                            </div>
                        </div>

                        <div class="btn-action-wrapper text-end">
                            @if($isDirectivo)
                                <a href="{{ $routeDirectorio }}" 
                                   class="btn btn-dtl-primary fw-bold py-2 px-3.5 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 font-subtitle">
                                    <span>Ingresar al Módulo</span>
                                    <i class="fas fa-arrow-right font-minor"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary fw-semibold py-2 px-3 rounded-3 font-subtitle" disabled style="opacity: 0.65;">
                                    Sin Acceso
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- MÓDULO 3: ADMINISTRACIÓN Y AJUSTES (Exclusivo ROL: administrador) -->
            <div class="card rounded-4 dtl-card-transition {{ $isAdministrador ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                <div class="card-body p-3 p-md-3.5">
                    <div class="module-flex-container">
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center dtl-icon-box" 
                                 style="width: 48px; height: 48px; background-color: {{ $isAdministrador ? '#d1fae5' : '#e2e8f0' }}; color: {{ $isAdministrador ? '#059669' : '#94a3b8' }};">
                                <i class="fas fa-user-cog fs-5"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-0.5">
                                    <h5 class="fw-bold mb-0 font-title" style="color: {{ $isAdministrador ? '#0f172a' : '#64748b' }};">
                                        Administración y Ajustes
                                    </h5>
                                    <span class="badge fw-bold rounded-pill px-2 py-0.5 text-uppercase font-minor" 
                                          style="background-color: {{ $isAdministrador ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $isAdministrador ? '#047857' : '#64748b' }}; border: 1px solid {{ $isAdministrador ? '#a7f3d0' : '#cbd5e1' }};">
                                        Back-Office
                                    </span>
                                </div>
                                <p class="mb-0 text-secondary font-subtitle">
                                    Gestión centralizada de usuarios, asignación de roles y permisos corporativos del sistema.
                                </p>
                            </div>
                        </div>

                        <div class="btn-action-wrapper text-end">
                            @if($isAdministrador)
                                <a href="{{ $routeAdmin }}" 
                                   class="btn btn-dtl-primary fw-bold py-2 px-3.5 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 font-subtitle">
                                    <span>Ingresar al Módulo</span>
                                    <i class="fas fa-arrow-right font-minor"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary fw-semibold py-2 px-3 rounded-3 font-subtitle" disabled style="opacity: 0.65;">
                                    Sin Acceso
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