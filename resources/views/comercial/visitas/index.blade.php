@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. (ESTÁNDAR UNIFORME) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 mb-md-4 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <!-- Línea Superior de Acento Verde Corporativo -->
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="row align-items-center g-2 g-md-3">
                
                <!-- MITAD IZQUIERDA (Logo) -->
                <div class="col-6 col-md-auto d-flex align-items-center justify-content-center justify-content-md-start">
                    <div class="p-1.5 p-md-2 rounded-3 bg-white d-flex align-items-center justify-content-center border" style="min-width: 125px; height: 48px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER" style="max-height: 34px; width: auto; object-fit: contain;" onerror="this.style.display='none'">
                        <span class="fw-bold text-dark d-none d-block-fallback" style="font-size: 0.8rem;">DTL PREMIER</span>
                    </div>
                </div>

                <!-- MITAD DERECHA (Información) -->
                <div class="col-6 col-md d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center gap-1.5 mb-0.5 flex-wrap">
                        <span class="badge rounded-pill text-white px-2 py-0.5 fw-bold text-uppercase" style="font-size: 0.62rem; background-color: #0f172a;">
                            <i class="fas fa-briefcase me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.62rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            ● Visitas Técnicas (HU-04)
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1rem; color: #0f172a; letter-spacing: -0.3px;">
                        Solicitudes de Inspección Técnica 
                    </h3>
                    <p class="mb-0 text-muted small d-none d-md-block" style="font-size: 0.8rem; font-weight: 500;">
                        Registro, consulta y asignación de ingenieros especializados para visitas técnicas
                    </p>
                </div>

                <!-- BLOQUE USUARIO (Escritorio) -->
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

    <!-- 2. BARRA DE ACCIÓN Y BUSCADOR (MEDIDAS Y BOTÓN UNIFORMADOS CON EL RESTO) -->
    <div class="card border-0 rounded-4 shadow-sm mb-3 bg-white" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-2.5 p-md-3">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3" style="border-color: #cbd5e1; height: 38px;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control form-control-sm border-start-0 ps-0" placeholder="Buscar por cliente, ubicación o ingeniero..." style="box-shadow: none; border-color: #cbd5e1; font-size: 0.88rem; height: 38px;">
                    </div>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button class="btn btn-sm text-white w-100 w-md-auto px-3 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-1.5" 
                            style="background-color: #059669; border: none; height: 38px; font-size: 0.88rem;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalNuevaVisita">
                        <i class="fas fa-plus fs-6"></i>
                        <span>Solicitar Inspección</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CONTENEDOR DE REGISTROS -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white mb-4" style="border: 1px solid #e2e8f0 !important;">
        
        <!-- VISTA TABULAR (PC / Tablet) -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr class="text-uppercase fw-bold text-slate-600" style="font-size: 0.72rem; letter-spacing: 0.3px;">
                        <th class="py-3 px-3">Cliente / RUC</th>
                        <th class="py-3">Ubicación de Obra</th>
                        <th class="py-3">Servicio Requerido</th>
                        <th class="py-3">Fecha y Hora</th>
                        <th class="py-3">Ingeniero Asignado</th>
                        <th class="py-3">Estado</th>
                        <th class="py-3 text-end px-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-3">
                            <span class="fw-bold text-dark d-block">Desarrollo de Software S.A.C.</span>
                            <span class="badge border fw-semibold" style="background-color: #f1f5f9; color: #059669; font-size: 0.65rem;">
                                RUC: 10479460014
                            </span>
                        </td>
                        <td><i class="fas fa-map-marker-alt text-danger me-1"></i>Av. Javier Prado Este 4200, Surco</td>
                        <td><span class="badge border bg-light text-dark">Evaluación Estructural</span></td>
                        <td><i class="far fa-calendar-alt text-muted me-1"></i>25/10/2026 10:00 AM</td>
                        <td><i class="fas fa-user-tie text-secondary me-1"></i>Ing. Carlos Mendoza (CIP 14205)</td>
                        <td>
                            <span class="badge rounded-pill border px-2 py-1" style="color: #b45309; background-color: #fffbeb; border-color: #fde68a !important;">
                                ● Pendiente
                            </span>
                        </td>
                        <td class="text-end px-3">
                            <button class="btn btn-sm btn-light border rounded-circle p-1" style="width:28px; height:28px;"><i class="fas fa-eye text-primary"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- VISTA DE TARJETAS FLUIDAS (Exclusivo Celulares < 768px) -->
        <div class="d-block d-md-none p-2.5">
            <div class="card border shadow-sm rounded-3 p-3 mb-2" style="border-left: 4px solid #059669 !important; border-color: #e2e8f0;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge border fw-bold mb-1" style="background-color: #f1f5f9; color: #059669; font-size: 0.62rem;">
                            RUC: 10479460014
                        </span>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">Desarrollo de Software S.A.C.</h6>
                    </div>
                    <span class="badge rounded-pill border px-2 py-1" style="color: #b45309; background-color: #fffbeb; border-color: #fde68a !important; font-size: 0.62rem;">
                        Pendiente
                    </span>
                </div>
                
                <p class="text-muted small mb-1" style="font-size: 0.78rem;">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i>Av. Javier Prado Este 4200, Surco
                </p>
                <p class="text-muted small mb-2" style="font-size: 0.78rem;">
                    <i class="fas fa-tools text-secondary me-1"></i>Evaluación Estructural de Muros
                </p>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #f1f5f9 !important;">
                    <span class="text-dark small fw-medium" style="font-size: 0.75rem;">
                        <i class="far fa-calendar-alt text-muted me-1"></i>25/10/2026 10:00 AM
                    </span>
                    <span class="fw-bold text-slate-700" style="font-size: 0.75rem;">
                        <i class="fas fa-user-tie text-success me-1"></i>Ing. Carlos Mendoza
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- 4. MODAL: SOLICITAR INSPECCIÓN TÉCNICA (HU-04) -->
<div class="modal fade" id="modalNuevaVisita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            
            <div class="modal-header text-white p-3.5" style="background-color: #0f172a;">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-1.5 bg-warning text-dark rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold mb-0" style="font-size: 0.98rem;">Solicitud de Inspección Técnica a Obra</h6>
                        <span class="text-muted small" style="font-size: 0.72rem; color: #94a3b8 !important;">Complete los datos para la asignación del especialista</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('comercial.visitas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-3.5 p-md-4" style="background-color: #f8fafc;">
                    <div class="row g-3">
                        
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Cliente / Contratista <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-sm" name="cliente_ruc" required style="font-size: 0.85rem;">
                                <option value="10479460014" selected>10479460014 - Desarrollo de Software S.A.C.</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Ubicación de la Obra / Inspección <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="ubicacion_obra" placeholder="Ej: Av. Javier Prado Este 4200, Surco, Lima" required style="font-size: 0.85rem;">
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Servicio Requerido <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-sm" name="servicio_requerido" required style="font-size: 0.85rem;">
                                <option>Evaluación Estructural</option>
                                <option>Inspección de Cimentación</option>
                                <option>Levantamiento Topográfico</option>
                                <option>Prueba de Calidad de Concreto</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Fecha y Hora Programada <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control form-control-sm" name="fecha_programada" required style="font-size: 0.85rem;">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Ingeniero Asignado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-sm" name="ingeniero_asignado" required style="font-size: 0.85rem;">
                                <option value="Ing. Carlos Mendoza (CIP 14205)">Ing. Carlos Mendoza (CIP 14205)</option>
                                <option value="Ing. Roberto Flores (CIP 18920)">Ing. Roberto Flores (CIP 18920)</option>
                                <option value="Ing. Ana Valdivia (CIP 21045)">Ing. Ana Valdivia (CIP 21045)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark mb-1">Observaciones / Notas para el Ingeniero</label>
                            <textarea class="form-control form-control-sm" name="observaciones_campo" rows="2" placeholder="Ingrese detalles técnicos o puntos de contacto en obra..." style="font-size: 0.85rem;"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-white border-top p-3" style="border-color: #e2e8f0 !important;">
                    <button type="button" class="btn btn-sm btn-light border px-3 fw-medium" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm text-white fw-bold px-4 shadow-sm" style="background-color: #059669; border: none;">
                        <i class="fas fa-paper-plane me-1"></i> Registrar & Notificar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection