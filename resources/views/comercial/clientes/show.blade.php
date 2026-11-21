
@extends('layouts.app')

@section('content')
<style>
    :root {
        --dtl-navy: #0f172a;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
    }

    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    /* Tabla base en escritorio */
    .dtl-pure-table {
        min-width: 1100px !important;
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th, .dtl-card-header-styled {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding: 0.60rem 0.75rem !important;
        text-transform: uppercase;
        white-space: nowrap !important;
    }

    .dtl-pure-table td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.50rem 0.70rem !important;
        vertical-align: middle !important;
    }

    .dtl-pure-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .extra-small {
        font-size: 0.73rem !important;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    .btn-floating-volver {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1050;
        background-color: var(--dtl-green);
        color: #ffffff !important;
        border: none;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4);
        font-weight: 700;
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-floating-volver:hover {
        background-color: var(--dtl-green-hover);
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    /* CONTENEDOR DE REGISTROS (Tiras horizontales continuas) */
    .compact-records-container {
        display: flex;
        flex-direction: column;
        gap: 3px;
        max-height: 120px;
        overflow-y: auto;
        padding-right: 2px;
    }

    .compact-records-container::-webkit-scrollbar { width: 4px; }
    .compact-records-container::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
    .compact-records-container::-webkit-scrollbar-track { background: transparent; }

    /* TIRA DE 1 SOLA LÍNEA HORIZONTAL (NO APILA ELEMENTOS HACIA ABAJO) */
    .compact-record-strip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        padding: 3px 8px;
        font-size: 0.72rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        white-space: nowrap !important;
        transition: all 0.15s ease-in-out;
    }

    .compact-record-strip:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
    }

    .compact-record-strip.record-primary-highlight { border-left: 3.5px solid var(--dtl-green); }
    .compact-record-strip.record-cot-highlight     { border-left: 3.5px solid #3b82f6; }

    /* ==========================================================
       OPTIMIZACIÓN ULTRA HORIZONTAL PARA RESOLUCIÓN DE CELULAR
    ========================================================== */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        /* 1. Ancho total ampliado para no comprimir ninguna columna */
        .dtl-pure-table {
            min-width: 1550px !important;
        }

        /* 2. Reducción vertical drástica de altura de celdas */
        .dtl-pure-table thead th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.65rem !important;
            font-size: 0.72rem !important;
        }

        /* 3. Anchos generosos por columna para mostrar 100% de la información */
        .col-mob-codobra  { min-width: 130px !important; width: 130px !important; }
        .col-mob-proyecto { min-width: 380px !important; width: 380px !important; }
        .col-mob-estado   { min-width: 135px !important; width: 135px !important; }
        .col-mob-insp     { min-width: 450px !important; width: 450px !important; }
        .col-mob-cot      { min-width: 455px !important; width: 455px !important; }

        .compact-record-strip {
            padding: 2.5px 6px !important;
            font-size: 0.68rem !important;
            gap: 10px !important;
        }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3" style="background-color: #f8fafc; min-height: 92vh;">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="font-size: 0.60rem; background-color: var(--dtl-navy); color: #ffffff;">
                    <i class="fas fa-address-book me-1" style="color: #10b981;"></i> BITÁCORA CLIENTE 360°
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="font-size: 0.60rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span class="status-pulse-green"></span> RUC: {{ $cliente->ruc }}
                </span>
            </div>

            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                {{ $cliente->razon_social }}
            </h3>
        </div>
    </div>

    <!-- 2. DATOS GENERALES (INFORMACIÓN COMPLETA SIN CORTAR) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3 overflow-hidden" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-header dtl-card-header-styled px-3 d-flex align-items-center" style="border-bottom: 3px solid #059669;">
            <h6 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                Ficha General y Contacto Corporativo
            </h6>
        </div>
        <div class="card-body p-3">
            <div class="row g-2 g-md-3">
                <div class="col-12 col-md-4">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Dirección Fiscal:</span>
                    <span class="text-dark fw-semibold d-block" style="font-size: 0.80rem; line-height: 1.35;">{{ $cliente->direccion ?: 'No registrada' }}</span>
                </div>
                <div class="col-12 col-md-3">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Contacto Principal:</span>
                    <span class="text-dark fw-semibold d-block" style="font-size: 0.80rem; line-height: 1.35;">{{ $cliente->nombre_contacto }} ({{ $cliente->telefono_contacto }})</span>
                </div>
                <div class="col-12 col-md-3">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Correo:</span>
                    <span class="text-dark fw-semibold d-block" style="font-size: 0.80rem; line-height: 1.35;">{{ $cliente->email_contacto }}</span>
                </div>
                <div class="col-12 col-md-2">
                    <span class="d-block text-muted extra-small fw-bold text-uppercase">Asignado:</span>
                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.68rem;">{{ $cliente->user->name ?? 'Asesor CRM' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABLA DE OBRAS: ANCHA HORIZONTALMENTE Y ULTRA PLANA VERTICALMENTE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2" style="border: 1px solid #cbd5e1 !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 col-mob-codobra">CÓDIGO OBRA</th>
                            <th class="col-mob-proyecto">PROYECTO / OBRA</th>
                            <th class="text-center col-mob-estado">ESTADO OBRA</th>
                            <th class="col-mob-insp">INSPECCIONES TÉCNICAS</th>
                            <th class="pe-3 col-mob-cot">COTIZACIONES OFICIALES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cliente->obras as $obra)
                            @php
                                $cantInsp = $obra->inspecciones ? $obra->inspecciones->count() : 0;
                                $cantCot  = $obra->cotizaciones ? $obra->cotizaciones->count() : 0;
                            @endphp
                            <tr>
                                <!-- CÓDIGO OBRA -->
                                <td class="ps-3 font-monospace fw-bold col-mob-codobra text-nowrap" style="color: var(--dtl-green); font-size: 0.76rem;">
                                    {{ $obra->codigo }}
                                </td>

                                <!-- PROYECTO / OBRA: TÍTULO COMPLETO Y FECHA EN LÍNEA -->
                                <td class="col-mob-proyecto">
                                    <div class="d-flex align-items-baseline justify-content-between gap-2">
                                        <span class="fw-bold text-dark text-uppercase" style="font-size: 0.76rem; line-height: 1.3;">
                                            {{ $obra->titulo }}
                                        </span>
                                        <span class="badge bg-light text-muted border font-monospace text-nowrap px-1.5 py-0.5" style="font-size: 0.64rem;">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $obra->fecha ? \Carbon\Carbon::parse($obra->fecha)->format('d/m/Y') : '-' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- ESTADO OBRA -->
                                <td class="text-center col-mob-estado text-nowrap">
                                    <span class="badge rounded-pill fw-semibold px-2 py-0.5" style="font-size: 0.64rem; background-color: #f1f5f9; color: var(--dtl-navy); border: 1px solid #cbd5e1;">
                                        {{ $obra->estado_real }}
                                    </span>
                                </td>

                                <!-- INSPECCIONES: TIRAS DE 1 SOLA LÍNEA CONTINUA (TODO VISIBLE) -->
                                <td class="col-mob-insp">
                                    @if($cantInsp > 0)
                                        <div class="compact-records-container">
                                            @foreach($obra->inspecciones as $insp)
                                                <div class="compact-record-strip record-primary-highlight">
                                                    <!-- Lado Izquierdo: Código + Badge + Ingeniero Completo -->
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="fw-bold font-monospace" style="color: var(--dtl-navy);">
                                                            #INS-{{ str_pad($insp->id, 4, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        
                                                        @if($insp->estado_inspeccion === 'Completada')
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.58rem;">
                                                                <i class="fas fa-check-circle me-0.5"></i>Completada
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 0.58rem;">
                                                                <i class="fas fa-clock me-0.5"></i>Pendiente
                                                            </span>
                                                        @endif

                                                        <span class="text-dark fw-semibold ms-1">
                                                            <i class="fas fa-user-tie text-muted me-1"></i>{{ $insp->ingeniero_asignado ?: 'No asignado' }}
                                                        </span>
                                                    </div>

                                                    <!-- Lado Derecho: Fecha y Hora Completa -->
                                                    <div class="text-muted font-monospace ps-2" style="font-size: 0.65rem;">
                                                        <i class="far fa-calendar-check me-1 opacity-75"></i>{{ $insp->fecha_inspeccion ? \Carbon\Carbon::parse($insp->fecha_inspeccion)->format('d/m/Y H:i') : '-' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted extra-small fst-italic py-1">
                                            <i class="fas fa-minus-circle me-1 opacity-50"></i>Sin visitas agendadas
                                        </div>
                                    @endif
                                </td>

                                <!-- COTIZACIONES: TIRAS DE 1 SOLA LÍNEA CONTINUA (TODO VISIBLE) -->
                                <td class="pe-3 col-mob-cot">
                                    @if($cantCot > 0)
                                        <div class="compact-records-container">
                                            @foreach($obra->cotizaciones as $cot)
                                                <div class="compact-record-strip record-cot-highlight">
                                                    <!-- Lado Izquierdo: Código + Botón PDF + Estado -->
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="fw-bold font-monospace text-primary">
                                                            {{ $cot->codigo_cotizacion }}
                                                        </span>

                                                        <button type="button" 
                                                                class="btn btn-outline-danger p-0 d-inline-flex align-items-center justify-content-center" 
                                                                style="width: 17px; height: 17px; border-radius: 3px; font-size: 0.58rem;" 
                                                                onclick="abrirVisorPdf('{{ route('comercial.cotizador.pdf', $cot->id) }}', '{{ $cot->codigo_cotizacion }}')" 
                                                                title="Ver PDF Oficial">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>

                                                        @php $estCot = strtoupper($cot->estado_cotizacion ?? ''); @endphp
                                                        @if($estCot === 'ACEPTADA')
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2" style="background-color: #ecfdf5; color: #047857; font-size: 0.58rem;">Aceptada</span>
                                                        @elseif($estCot === 'ENVIADA')
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2" style="background-color: #e0f2fe; color: #0369a1; font-size: 0.58rem;">Enviada</span>
                                                        @elseif($estCot === 'RECHAZADA')
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2" style="background-color: #fef2f2; color: #b91c1c; font-size: 0.58rem;">Rechazada</span>
                                                        @else
                                                            <span class="badge rounded-pill fw-semibold px-1.5 py-0.2 bg-light text-dark border" style="font-size: 0.58rem;">{{ $estCot }}</span>
                                                        @endif
                                                    </div>

                                                    <!-- Lado Derecho: Monto Completo + Fecha -->
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="font-monospace fw-bold text-dark" style="font-size: 0.74rem;">
                                                            {{ $cot->monto_total > 0 ? 'S/ ' . number_format($cot->monto_total, 2) : 'Por cotizar' }}
                                                        </span>
                                                        <span class="text-muted font-monospace" style="font-size: 0.65rem;">
                                                            <i class="far fa-clock me-1 opacity-75"></i>{{ $cot->fecha_emision ? \Carbon\Carbon::parse($cot->fecha_emision)->format('d/m/Y') : '-' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted extra-small fst-italic py-1">
                                            <i class="fas fa-minus-circle me-1 opacity-50"></i>Sin cotizaciones
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted small">Este cliente aún no registra proyectos u obras asociadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BOTÓN VOLVER -->
    <a href="{{ route('comercial.clientes.index') }}" class="btn-floating-volver" title="Volver al Directorio">
        <i class="fas fa-arrow-left"></i>
        <span>Volver</span>
    </a>

</div>

<!-- VISOR PDF FLOTANTE -->
<div id="cardVisorPdfOverlay" class="d-none" onclick="cerrarVisorPdfCard()" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(3px); z-index: 1080;"></div>

<div id="cardVisorPdfCompact" class="d-none" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 92%; max-width: 900px; height: 86vh; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 24px 50px -12px rgba(15, 23, 42, 0.45); z-index: 1090; display: flex; flex-direction: column; overflow: hidden; animation: popCardVisorPdf 0.18s cubic-bezier(0.16, 1, 0.3, 1);">
    <div class="py-2 px-3 text-white d-flex align-items-center justify-content-between" style="background-color: var(--dtl-navy); border-bottom: 3.5px solid var(--dtl-green);">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger p-1"><i class="fas fa-file-pdf"></i></span>
            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.82rem; letter-spacing: 0.3px;">
                PDF: <span id="visorPdfCodigo" class="text-success font-monospace fw-bold"></span>
            </h6>
        </div>
        <button type="button" class="btn btn-sm p-0 text-white opacity-75 border-0 bg-transparent" onclick="cerrarVisorPdfCard()" style="font-size: 0.90rem; line-height: 1;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="flex-grow-1 p-0" style="background-color: #525659;">
        <iframe id="visorPdfIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
    </div>

    <div class="bg-white py-2 px-3 border-top d-flex justify-content-end" style="border-color: #e2e8f0 !important;">
        <button type="button" class="btn btn-sm btn-secondary fw-semibold px-4 rounded-2" onclick="cerrarVisorPdfCard()" style="font-size: 0.80rem;">
            Cerrar
        </button>
    </div>
</div>

<style>
    @keyframes popCardVisorPdf {
        from { opacity: 0; transform: translate(-50%, -46%) scale(0.96); }
        to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }
</style>

<script>
    function abrirVisorPdf(urlPdf, codigoCotizacion) {
        document.getElementById('visorPdfCodigo').innerText = codigoCotizacion;
        document.getElementById('visorPdfIframe').src = urlPdf;
        
        document.getElementById('cardVisorPdfOverlay').classList.remove('d-none');
        const card = document.getElementById('cardVisorPdfCompact');
        card.classList.remove('d-none');
        card.style.display = 'flex';
    }

    function cerrarVisorPdfCard() {
        document.getElementById('cardVisorPdfOverlay').classList.add('d-none');
        const card = document.getElementById('cardVisorPdfCompact');
        card.classList.add('d-none');
        card.style.display = 'none';
        document.getElementById('visorPdfIframe').src = '';
    }
</script>
@endsection