@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. (ESTÁNDAR UNIFORME) -->
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
                            ● Cotizador Express (HU-06)
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1rem; color: #0f172a; letter-spacing: -0.3px;">
                        Cotizaciones
                    </h3>
                    
                    <p class="mb-0 text-muted small d-none d-md-block" style="font-size: 0.8rem; font-weight: 500;">
                        Elaboración rápida de propuestas comerciales con cálculo automático e impresión institucional
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

    <!-- 2. FORMULARIO COTIZADOR EXPRESS -->
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-3 p-md-4" style="border: 1px solid #e2e8f0 !important;">
                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.95rem;">
                    <i class="fas fa-calculator text-success me-2"></i>Parámetros de la Propuesta Comercial
                </h6>
                
                <form action="{{ route('comercial.cotizador.pdf') }}" method="POST" target="_blank">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">Cliente Destino (RUC)</label>
                            <select class="form-select form-select-sm" name="cliente_ruc" required style="font-size: 0.85rem;">
                                <option value="10479460014">10479460014 - Desarrollo de Software S.A.C.</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">Código de Obra / Proyecto</label>
                            <input type="text" class="form-control form-control-sm" name="codigo_obra" value="#OBR-101" required style="font-size: 0.85rem;">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark mb-1">Descripción del Servicio / Partida</label>
                            <textarea class="form-control form-control-sm" name="detalle_servicio" rows="2" required style="font-size: 0.85rem;">Remodelación integral de oficinas administrativas, incluye falso techo y tabiquería dry-wall.</textarea>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-dark mb-1">Monto Subtotal (S/)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="subtotal" name="subtotal" value="45000.00" required oninput="calcularTotal()" style="font-size: 0.85rem;">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-dark mb-1">IGV (18%)</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="igv" readonly value="8100.00" style="font-size: 0.85rem;">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-success mb-1">Total Neto (S/)</label>
                            <input type="text" class="form-control form-control-sm fw-bold bg-light text-success" id="total" readonly value="53100.00" style="font-size: 0.85rem;">
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2" style="border-color: #f1f5f9 !important;">
                        <button type="submit" class="btn btn-sm text-white fw-bold px-4 py-2 shadow-sm d-flex align-items-center gap-1.5" style="background-color: #059669; border-radius: 8px;">
                            <i class="fas fa-print me-1"></i> Generar & Imprimir PDF Membretado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PANEL DE VISTA PREVIA INSTITUCIONAL -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm text-white p-3 p-md-4 h-100" style="background-color: #0f172a;">
                <h6 class="fw-bold mb-3 text-success" style="font-size: 0.95rem;">
                    <i class="fas fa-shield-alt me-2"></i>Membrete DTL PREMIER S.A.C.
                </h6>
                <p class="small text-muted mb-3" style="font-size: 0.78rem; color: #94a3b8 !important;">
                    El documento generado incluirá automáticamente la firma corporativa, los datos fiscales de la empresa y el sello de garantía estructural DTL.
                </p>
                <div class="p-3 rounded-3 border text-center" style="background-color: #020617; border-color: #334155 !important;">
                    <span class="badge mb-2" style="background-color: #059669; color: #ffffff;">LISTO PARA EMISIÓN</span>
                    <p class="small mb-0 font-monospace text-light" style="font-size: 0.75rem;">RUC: 20600000001<br>Lima, Perú</p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function calcularTotal() {
        let subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        let igv = subtotal * 0.18;
        let total = subtotal + igv;
        document.getElementById('igv').value = igv.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }
</script>
@endsection