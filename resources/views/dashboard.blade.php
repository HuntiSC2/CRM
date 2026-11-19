@extends('layouts.app')

@section('content')
<!-- Estilos e Identidad Visual DTL PREMIER -->
<style>
    :root {
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
        --dtl-dark: #0f172a;
    }

    /* Tipografía Estricta */
    .font-title { font-size: 14px !important; line-height: 1.35 !important; }
    .font-subtitle { font-size: 12px !important; line-height: 1.4 !important; }
    .font-minor { font-size: 10px !important; line-height: 1.2 !important; }

    /* Estados de Tarjetas */
    .dtl-card-transition { transition: all 0.25s ease; }
    
    .dtl-card-active {
        background-color: #ffffff !important;
        border: 1px solid var(--dtl-green) !important;
    }
    .dtl-card-active:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -4px rgba(5, 150, 105, 0.15) !important;
    }
    .dtl-card-active:hover .dtl-icon-box {
        transform: scale(1.05);
        background-color: var(--dtl-green) !important;
        color: #ffffff !important;
    }

    .dtl-card-disabled {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        opacity: 0.75;
    }

    .dtl-icon-box {
        width: 48px;
        height: 48px;
        transition: all 0.25s ease;
        flex-shrink: 0;
    }

    /* Botones */
    .btn-dtl-primary {
        background-color: var(--dtl-green) !important;
        border-color: var(--dtl-green) !important;
        color: #ffffff !important;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-dtl-primary:hover {
        background-color: var(--dtl-green-hover) !important;
        border-color: var(--dtl-green-hover) !important;
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
        .module-flex-container .btn-action-wrapper,
        .module-flex-container .btn-action-wrapper .btn {
            width: 100%;
        }
    }
</style>

@php
    $user = auth()->user();
    $userRole = strtolower(trim($user->role ?? ''));

    // Configuración Centralizada de Módulos (Escalable y Limpia)
    $modulos = [
        [
            'id'          => 'comercial',
            'titulo'      => 'Gestión Comercial',
            'etiqueta'    => 'Front-Office',
            'descripcion' => 'Registro, consulta y administración de fichas de clientes/contratistas con validación automática de RUC.',
            'icono'       => 'fas fa-handshake',
            'permitido'   => ($userRole === 'ejecutivo'),
            'ruta'        => Route::has('comercial.clientes.index') 
                                ? route('comercial.clientes.index') 
                                : (Route::has('comercial.pipeline.index') ? route('comercial.pipeline.index') : '#'),
        ],
        [
            'id'          => 'gerencia',
            'titulo'      => 'Directorio y Control de Obras',
            'etiqueta'    => 'Gestión Ejecutiva',
            'descripcion' => 'Monitoreo de pipeline corporativo, revisión de expedientes, estados de avance y métricas comerciales.',
            'icono'       => 'fas fa-chart-line',
            'permitido'   => ($userRole === 'directivo'),
            'ruta'        => Route::has('directorio.index') 
                                ? route('directorio.index') 
                                : (Route::has('gerencia.dashboard') ? route('gerencia.dashboard') : '#'),
        ],
        [
            'id'          => 'soporte',
            'titulo'      => 'Administración y Ajustes',
            'etiqueta'    => 'Back-Office',
            'descripcion' => 'Gestión centralizada del catálogo de partidas, tarifarios oficiales y auditoría de alertas semafóricas (SLA).',
            'icono'       => 'fas fa-user-cog',
            'permitido'   => ($userRole === 'administrador'),
            'ruta'        => Route::has('soporte.partidas.index') ? route('soporte.partidas.index') : '#',
        ]
    ];
@endphp

<div class="container-fluid px-3 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                
                <!-- Datos de Sesión -->
                <div class="col ps-md-3" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase font-minor" style="background-color: var(--dtl-dark); color: #ffffff;">
                            <i class="fas fa-user-shield me-1" style="color: #10b981;"></i> ROL: {{ strtoupper($userRole ?: 'INVITADO') }}
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1 font-minor" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            <span class="status-pulse-green"></span> Sesión Activa
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark font-title" style="letter-spacing: -0.3px;">
                        Bienvenido, {{ $user->name ?? 'Usuario' }}
                    </h3>
                    
                    <p class="mb-0 text-muted d-none d-md-block font-subtitle" style="font-weight: 500;">
                        Ejecución de obras, consultoría y servicios en general 
                    </p>
                </div>

                <!-- Credenciales -->
                <div class="col-12 col-md-auto text-end d-none d-lg-block">
                    <div class="px-3 py-2 rounded-3 border bg-light d-inline-block text-end" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center justify-content-end gap-1.5 mb-0.5">
                            <i class="fas fa-envelope me-1" style="color: var(--dtl-green); font-size: 10px;"></i>
                            <span class="text-dark fw-bold text-uppercase font-minor" style="letter-spacing: 0.8px;">Sesión iniciada como:</span>
                        </div>
                        <span class="fw-bold text-dark d-block font-subtitle">
                            {{ $user->email ?? 'correo@dtlpremier.pe' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. MÓDULOS DEL SISTEMA -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2 font-title">
                <i class="fas fa-th-large" style="color: var(--dtl-green);"></i>
                <span>Módulos del Sistema</span>
            </h5>
        </div>

        <div class="d-flex flex-column gap-3">
            @foreach($modulos as $mod)
                <div class="card rounded-4 dtl-card-transition {{ $mod['permitido'] ? 'dtl-card-active' : 'dtl-card-disabled' }}">
                    <div class="card-body p-3 p-md-3.5">
                        <div class="module-flex-container">
                            
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center dtl-icon-box" 
                                     style="background-color: {{ $mod['permitido'] ? '#d1fae5' : '#e2e8f0' }}; color: {{ $mod['permitido'] ? '#059669' : '#94a3b8' }};">
                                    <i class="{{ $mod['icono'] }} fs-5"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-0.5">
                                        <h5 class="fw-bold mb-0 font-title" style="color: {{ $mod['permitido'] ? '#0f172a' : '#64748b' }};">
                                            {{ $mod['titulo'] }}
                                        </h5>
                                        <span class="badge fw-bold rounded-pill px-2 py-0.5 text-uppercase font-minor" 
                                              style="background-color: {{ $mod['permitido'] ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $mod['permitido'] ? '#047857' : '#64748b' }}; border: 1px solid {{ $mod['permitido'] ? '#a7f3d0' : '#cbd5e1' }};">
                                            {{ $mod['etiqueta'] }}
                                        </span>
                                    </div>
                                    <p class="mb-0 text-secondary font-subtitle">
                                        {{ $mod['descripcion'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="btn-action-wrapper text-end">
                                @if($mod['permitido'])
                                    <a href="{{ $mod['ruta'] }}" 
                                       class="btn btn-dtl-primary fw-bold py-2 px-3.5 rounded-3 d-inline-flex align-items-center justify-content-center gap-2 font-subtitle shadow-sm">
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
            @endforeach
        </div>
    </div>
</div>
@endsection