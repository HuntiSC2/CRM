@extends('layouts.app')

@section('content')
<!-- Estilos Exclusivos para Ficha de Registro DTL PREMIER -->
<style>
    /* Botón Principal Verde Corporativo DTL */
    .btn-dtl-primary {
        background-color: #059669 !important;
        border-color: #059669 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-dtl-primary:hover {
        background-color: #047857 !important;
        border-color: #047857 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    /* Botón Secundario / Volver */
    .btn-dtl-outline {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #475569 !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-dtl-outline:hover {
        background-color: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
    }

    /* Enfoque e interacción de Campos de Formulario */
    .dtl-input:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        background-color: #ffffff !important;
    }

    .dtl-input::placeholder {
        color: #94a3b8 !important;
        opacity: 0.7 !important;
        font-size: 0.9rem;
    }

    .extra-small {
        font-size: 0.75rem;
    }
</style>

<div class="container-fluid px-3 py-2">

    <!-- 1. ENCABEZADO INSTITUCIONAL DTL PREMIER S.A.C. (ESTILO UNIFICADO CON LOGO) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <!-- Línea Superior de Acento Verde Corporativo -->
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: #059669;"></div>
        
        <div class="card-body px-4 py-3">
            <div class="row align-items-center g-3">
                
                <!-- Logo Oficial Corporativo -->
                <div class="col-12 col-lg-auto text-center text-lg-start">
                    <div class="p-2 rounded-3 bg-white d-inline-flex align-items-center justify-content-center border" style="min-width: 155px; height: 58px; border-color: #cbd5e1 !important;">
                        <img src="{{ asset('images/logo-dtl.png') }}" alt="DTL PREMIER S.A.C." style="max-height: 42px; width: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- Título y Subtítulo del Módulo -->
                <div class="col-12 col-lg border-start-lg ps-lg-4" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <!-- BADGE DE MÓDULO -->
                        <span class="badge rounded-pill fw-bold px-2.5 py-1 text-uppercase" style="font-size: 0.65rem; background-color: #0f172a; color: #ffffff;">
                            <i class="fas fa-file-signature me-1" style="color: #10b981;"></i> GESTIÓN COMERCIAL
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2.5 py-1 d-inline-flex align-items-center gap-1.5" style="font-size: 0.65rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                            FORMULARIO TRIBUTARIO
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.25rem; color: #0f172a; letter-spacing: -0.3px;">
                        Ficha de Registro
                    </h3>
                    
                    <p class="mb-0 mt-0.5" style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Alta e incorporación de nuevos clientes/contratistas en la base comercial
                    </p>
                </div>

                <!-- Botón de Acción / Regreso al Directorio -->
                <div class="col-12 col-lg-auto text-lg-end">
                    <a href="{{ route('comercial.clientes.index') }}" class="btn btn-dtl-outline px-3.5 py-2 rounded-3 shadow-sm fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 0.88rem;">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver al Directorio</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. ALERTA DE ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
        <div class="alert border-0 rounded-4 shadow-sm mb-3 p-3 d-flex align-items-center" role="alert" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
            <i class="fas fa-circle-exclamation me-3 fs-4" style="color: #ef4444;"></i>
            <div>
                <span class="fw-bold d-block">Formulario incompleto:</span>
                <span class="small">Existen campos requeridos sin llenar o con datos no válidos. Verifique los campos marcados en rojo.</span>
            </div>
        </div>
    @endif

    <!-- 3. FORMULARIO PRINCIPAL EN DOS TARJETAS PARALELAS -->
    <form action="{{ route('comercial.clientes.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3 mb-3">
            
            <!-- TARJETA IZQUIERDA: DATOS TRIBUTARIOS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-header bg-white border-bottom p-3 px-4 d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center">
                            <span class="badge text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.82rem; background-color: #0f172a;">1</span>
                            <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px; color: #0f172a;">Información Tributaria y Empresa</h6>
                        </div>
                        <i class="fas fa-landmark opacity-50 fs-5" style="color: #059669;"></i>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- RUC -->
                            <div class="col-12">
                                <label for="ruc" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Número de RUC (11 Dígitos) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('ruc') is-invalid @enderror" id="ruc" name="ruc" value="{{ old('ruc') }}" placeholder="Ej. 20601234567" maxlength="11" style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;" required>
                                </div>
                                <span class="form-text extra-small ms-1" style="color: #64748b;"><i class="fas fa-circle-info me-1" style="color: #059669;"></i> Unicidad tributaria obligatoria en SUNAT.</span>
                                @error('ruc')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <!-- Contenedor dinámico AJAX para RUC duplicado -->
                                <div id="ruc-error-feedback" class="invalid-feedback d-none">Este RUC ya se encuentra registrado en el sistema.</div>
                            </div>

                            <!-- Razón Social -->
                            <div class="col-12">
                                <label for="razon_social" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Razón Social / Denominación Legal <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('razon_social') is-invalid @enderror" id="razon_social" name="razon_social" value="{{ old('razon_social') }}" placeholder="Ej. Constructora e Inmobiliaria del Sur S.A.C." style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;" required>
                                </div>
                                <span class="form-text extra-small ms-1" style="color: #64748b;">Nombre o razón social registrada en SUNAT.</span>
                                @error('razon_social')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dirección Fiscal -->
                            <div class="col-12">
                                <label for="direccion" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Dirección Fiscal / Oficina Principal
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-map-location-dot"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Ej. Av. Larco 123, Oficina 402, Miraflores" style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;">
                                </div>
                                @error('direccion')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA DERECHA: CONTACTO COMERCIAL -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-header bg-white border-bottom p-3 px-4 d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center">
                            <span class="badge text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.82rem; background-color: #0f172a;">2</span>
                            <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px; color: #0f172a;">Contacto Comercial Directo</h6>
                        </div>
                        <i class="fas fa-address-book opacity-50 fs-5" style="color: #059669;"></i>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Persona de Contacto -->
                            <div class="col-12">
                                <label for="nombre_contacto" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Persona de Contacto <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-user-tie"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('nombre_contacto') is-invalid @enderror" id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto') }}" placeholder="Ej. Ing. Carlos Mendoza" style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;" required>
                                </div>
                                @error('nombre_contacto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="col-12">
                                <label for="email_contacto" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('email_contacto') is-invalid @enderror" id="email_contacto" name="email_contacto" value="{{ old('email_contacto') }}" placeholder="Ej. contacto@constructorasur.com" style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;" required>
                                </div>
                                @error('email_contacto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono / Celular -->
                            <div class="col-12">
                                <label for="telefono_contacto" class="form-label fw-semibold small mb-1" style="color: #0f172a;">
                                    Teléfono / Celular <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 ps-3" style="background-color: #f8fafc; border-color: #cbd5e1; color: #059669;">
                                        <i class="fas fa-phone-flip"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0 py-2.5 dtl-input @error('telefono_contacto') is-invalid @enderror" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}" placeholder="Ej. 987654321" style="border-color: #cbd5e1; font-size: 0.95rem; color: #0f172a;" required>
                                </div>
                                @error('telefono_contacto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 4. BARRA FLOTANTE DE GUARDADO Y ACCIÓN -->
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 px-4" style="border: 1px solid #e2e8f0 !important;">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <span class="extra-small" style="color: #64748b;">
                    <i class="fas fa-circle-check me-1" style="color: #059669;"></i> Asegúrese de completar todos los campos obligatorios (*) antes de proceder.
                </span>
                <button type="submit" id="btn-submit" class="btn btn-dtl-primary px-4 py-2.5 rounded-3 shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                    <i class="fas fa-floppy-disk"></i>
                    <span>Guardar Ficha</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- SCRIPT AJAX PARA VERIFICAR RUC DUPLICADO EN TIEMPO REAL -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rucInput = document.getElementById('ruc');
        const rucError = document.getElementById('ruc-error-feedback');
        const submitBtn = document.getElementById('btn-submit');

        if(rucInput) {
            rucInput.addEventListener('blur', function() {
                const rucVal = this.value.trim();
                if(rucVal.length === 11) {
                    fetch(`{{ route('comercial.clientes.checkRuc') }}?ruc=${rucVal}`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.exists) {
                                rucInput.classList.add('is-invalid');
                                rucError.classList.remove('d-none');
                                submitBtn.disabled = true;
                            } else {
                                rucInput.classList.remove('is-invalid');
                                rucError.classList.add('d-none');
                                submitBtn.disabled = false;
                            }
                        })
                        .catch(error => console.error('Error al verificar RUC:', error));
                }
            });
        }
    });
</script>
@endpush
@endsection