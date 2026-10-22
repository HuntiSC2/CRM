@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-4 py-2 py-md-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                <div class="col-auto">
                    <div class="p-1.5 p-md-2 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="min-width: 110px; height: 44px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 32px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <div class="col border-start-md ps-md-3" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-0.5">
                        <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.62rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.62rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            Expedientes Activos
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; font-size: calc(0.9rem + 0.3vw); color: #0f172a; letter-spacing: -0.3px;">
                        Directorio de Clientes
                    </h3>
                    
                    <p class="mb-0 text-muted small d-none d-md-block" style="font-size: 0.8rem; font-weight: 500;">
                        Registro, consulta y gestión de fichas comerciales y contratistas
                    </p>
                </div>

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

    <!-- 2. BÚSQUEDA Y BOTONES DE ACCIÓN -->
    <div class="card border-0 rounded-4 shadow-sm mb-3 bg-white" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3 d-flex justify-content-between align-items-center gap-2">
            <div class="input-group input-group-sm flex-grow-1" style="max-width: 500px;">
                <span class="input-group-text bg-white border-end-0 text-muted ps-3" style="border-color: #cbd5e1;"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control form-control-sm border-start-0 ps-0" placeholder="Buscar por RUC, Razón Social..." style="box-shadow: none; border-color: #cbd5e1; font-size: 0.85rem;">
            </div>
            
            <div class="d-flex gap-1.5">
                <button class="btn btn-sm text-white fw-bold shadow-sm d-flex align-items-center gap-1.5" style="background-color: #0f172a; border: none; height: 38px;">
                    <i class="fas fa-filter"></i>
                    <span class="d-none d-md-inline" style="font-size: 0.85rem;">Buscar</span>
                </button>
                <button class="btn btn-sm text-white fw-bold shadow-sm d-flex align-items-center justify-content-center flex-shrink-0" 
                        style="background-color: #059669; border: none; height: 38px; width: 38px;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalNuevoCliente">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. TABLA DE REGISTROS AUTOMÁTICOS (DESKTOP - FORMATO IMAGEN 1) -->
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden mb-3 d-none d-lg-block" style="border: 1px solid #e2e8f0 !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="border-color: #f1f5f9;">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="ps-3 py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">RUC</th>
                        <th class="py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">RAZÓN SOCIAL</th>
                        <th class="py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">CONTACTO</th>
                        <th class="py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">TELÉFONO</th>
                        <th class="py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">EMAIL</th>
                        <th class="py-2.5 text-center text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">ESTADO</th>
                        <th class="py-2.5 text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">REGISTRADO POR</th>
                        <th class="pe-3 py-2.5 text-center text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes ?? [] as $cliente)
                    <tr>
                        <td class="ps-3">
                            <a href="#" class="fw-bold text-decoration-none" style="color: #059669; font-size: 0.78rem;">
                                {{ $cliente->ruc }}
                            </a>
                        </td>
                        <td>
                            <span class="fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                {{ $cliente->razon_social }}
                            </span>
                        </td>
                        <td>
                            <span class="text-secondary" style="font-size: 0.78rem;">
                                {{ $cliente->contacto }}
                            </span>
                        </td>
                        <td>
                            <span class="text-secondary" style="font-size: 0.78rem;">
                                {{ $cliente->telefono }}
                            </span>
                        </td>
                        <td>
                            <span class="text-secondary" style="font-size: 0.78rem;">
                                {{ $cliente->email }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if(($cliente->estado ?? '') === 'Activo')
                                <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.68rem;">Activo</span>
                            @elseif(($cliente->estado ?? '') === 'En Evaluación' || ($cliente->estado ?? '') === 'Evaluando')
                                <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 0.68rem;">Evaluando</span>
                            @else
                                <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.68rem;">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.78rem;">
                                {{ $cliente->registrado_por ?? 'Asesor Comercial' }}
                            </span>
                        </td>
                        <td class="pe-3 text-center">
                            <button class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center" style="background-color: #ecfdf5; color: #059669; width: 28px; height: 28px;">
                                <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <!-- Fila de muestra alineada a la imagen si no existen registros dinámicos aún -->
                    <tr>
                        <td class="ps-3"><a href="#" class="fw-bold text-decoration-none" style="color: #059669; font-size: 0.78rem;">10479460014</a></td>
                        <td><span class="fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">Desarrollo de software</span></td>
                        <td><span class="text-secondary" style="font-size: 0.78rem;">wilmer matto mendez</span></td>
                        <td><span class="text-secondary" style="font-size: 0.78rem;">925919513</span></td>
                        <td><span class="text-secondary" style="font-size: 0.78rem;">karepa14@gmail.com</span></td>
                        <td class="text-center"><span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.68rem;">Activo</span></td>
                        <td><span class="text-muted" style="font-size: 0.78rem;">Asesor Comercial</span></td>
                        <td class="pe-3 text-center">
                            <button class="btn btn-sm p-1 rounded-3 border-0 d-inline-flex align-items-center justify-content-center" style="background-color: #ecfdf5; color: #059669; width: 28px; height: 28px;">
                                <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. VISTA EN TARJETAS RESPONSIVE (MÓVIL - DISTANCIA REDUCIDA / IMAGEN 2 FLECHA AZUL) -->
    <div class="d-block d-lg-none">
        @forelse($clientes ?? [] as $cliente)
        <div class="card border rounded-3 p-2.5 bg-white shadow-sm" style="border-color: #e2e8f0 !important; border-left: 4px solid #059669 !important; margin-bottom: 6px !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold" style="color: #059669; font-size: 0.82rem;">{{ $cliente->ruc }}</span>
                    @if(($cliente->estado ?? '') === 'Activo')
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.62rem;">Activo</span>
                    @elseif(($cliente->estado ?? '') === 'En Evaluación' || ($cliente->estado ?? '') === 'Evaluando')
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 0.62rem;">Evaluando</span>
                    @else
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.62rem;">Inactivo</span>
                    @endif
                </div>
                <button class="btn btn-sm border bg-light p-1 px-2 rounded-2 text-muted" style="font-size: 0.7rem;" type="button" data-bs-toggle="collapse" data-bs-target="#clienteDetail{{ $loop->index }}">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="fw-bold text-dark text-uppercase mt-1" style="font-size: 0.82rem; line-height: 1.2;">
                {{ $cliente->razon_social }}
            </div>
            
            <div class="collapse mt-2 pt-2 border-top" id="clienteDetail{{ $loop->index }}" style="border-color: #f1f5f9 !important;">
                <div class="text-secondary small mb-1" style="font-size: 0.75rem;"><i class="fas fa-user me-1 text-muted"></i> {{ $cliente->contacto }}</div>
                <div class="text-secondary small mb-1" style="font-size: 0.75rem;"><i class="fas fa-phone me-1 text-muted"></i> {{ $cliente->telefono }}</div>
                <div class="text-secondary small mb-1" style="font-size: 0.75rem;"><i class="fas fa-envelope me-1 text-muted"></i> {{ $cliente->email }}</div>
                <div class="text-muted small" style="font-size: 0.72rem;"><i class="fas fa-user-shield me-1 text-muted"></i> Registrado por: {{ $cliente->registrado_por ?? 'Asesor Comercial' }}</div>
            </div>
        </div>
        @empty
        <!-- Estructura de tarjetas estáticas con espacio vertical reducido (margin-bottom: 6px) -->
        <div class="card border rounded-3 p-2.5 bg-white shadow-sm" style="border-color: #e2e8f0 !important; border-left: 4px solid #059669 !important; margin-bottom: 6px !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold" style="color: #059669; font-size: 0.82rem;">20504825911</span>
                    <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 0.62rem;">Evaluando</span>
                </div>
                <button class="btn btn-sm border bg-light p-1 px-2 rounded-2 text-muted" style="font-size: 0.7rem;">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="fw-bold text-dark text-uppercase mt-1" style="font-size: 0.82rem;">
                JJ CEXA S.A.C. CONTRATISTAS GENE...
            </div>
        </div>

        <div class="card border rounded-3 p-2.5 bg-white shadow-sm" style="border-color: #e2e8f0 !important; border-left: 4px solid #059669 !important; margin-bottom: 6px !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold" style="color: #059669; font-size: 0.82rem;">20512849310</span>
                    <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.62rem;">Activo</span>
                </div>
                <button class="btn btn-sm border bg-light p-1 px-2 rounded-2 text-muted" style="font-size: 0.7rem;">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="fw-bold text-dark text-uppercase mt-1" style="font-size: 0.82rem;">
                INMOBILIARIA Y CONSTRUCTORA MARCAN S.A.C.
            </div>
        </div>
        @endforelse
    </div>

    <!-- 5. PAGINACIÓN ENUMERADA (CÍRCULO ROJO IMAGEN 2 / FORMATO IMAGEN 1 Y 3) -->
    <div class="d-flex justify-content-end align-items-center mt-3 mb-2">
        @if(isset($clientes) && method_exists($clientes, 'links'))
            {{ $clientes->links('pagination::bootstrap-5') }}
        @else
            <nav aria-label="Navegación de páginas">
                <ul class="pagination pagination-sm mb-0 gap-1">
                    <li class="page-item disabled">
                        <a class="page-link px-2.5 py-1 border rounded-2 text-muted text-decoration-none bg-white" href="#" style="font-size: 0.75rem; border-color: #e2e8f0 !important;">&lt;</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link px-2.5 py-1 border rounded-2 text-white fw-bold text-decoration-none" href="#" style="font-size: 0.75rem; background-color: #059669; border-color: #059669 !important;">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link px-2.5 py-1 border rounded-2 text-dark text-decoration-none bg-white" href="#" style="font-size: 0.75rem; border-color: #e2e8f0 !important;">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link px-2.5 py-1 border rounded-2 text-dark text-decoration-none bg-white" href="#" style="font-size: 0.75rem; border-color: #e2e8f0 !important;">&gt;</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>

</div>
@endsection
