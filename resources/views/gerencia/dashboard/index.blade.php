@extends('layouts.gerencia')

@section('content')
<style>
    :root {
        --dtl-navy: #0f172a;
        --dtl-navy-hover: #1e293b;
        --dtl-green: #059669;
        --dtl-green-hover: #047857;
        --dtl-border: #e2e8f0;
    }

    .bg-dtl-navy { background-color: var(--dtl-navy) !important; }
    .text-dtl-navy { color: var(--dtl-navy) !important; }

    /* BOTONES DE ACCIÓN */
    .btn-dtl-action { 
        height: 38px; 
        padding: 0 16px; 
        font-size: 0.84rem; 
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
        background-color: var(--dtl-green) !important; 
        border: 1px solid var(--dtl-green) !important; 
        color: #ffffff !important; 
    }
    .btn-dtl-primary:hover { 
        background-color: var(--dtl-green-hover) !important;
        border-color: var(--dtl-green-hover) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    /* TARJETAS KPI EJECUTIVAS */
    .kpi-card { 
        border-radius: 14px; 
        background: #ffffff; 
        border: 1px solid var(--dtl-border); 
        position: relative; 
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px -4px rgba(15, 23, 42, 0.08) !important;
    }
    .kpi-card-strip { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 3.5px; 
    }

    /* CONTENEDOR DE GRÁFICOS CON ESPACIO GENEROSO */
    .chart-box-unified {
        height: 290px;
        position: relative;
        width: 100%;
    }

    .status-pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
    }

    .filter-input {
        border-color: #cbd5e1;
        font-size: 0.82rem;
        height: 38px;
        border-radius: 8px;
    }

    /* SCROLL HORIZONTAL TÁCTIL ESTANDARIZADO */
    .dtl-table-scroll-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: block !important;
    }

    .dtl-pure-table {
        min-width: 950px !important;
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .dtl-pure-table thead th {
        background-color: var(--dtl-navy) !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.8px;
        padding: 0.65rem 0.75rem !important;
        text-transform: uppercase;
        white-space: nowrap !important;
    }

    .dtl-pure-table td {
        border: 1px solid #cbd5e1 !important;
        font-size: 0.78rem !important;
        padding: 0.65rem 0.75rem !important;
        vertical-align: middle !important;
    }

    .dtl-pure-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    /* ==========================================================
       OPTIMIZACIÓN EXCLUSIVA PARA RESOLUCIÓN DE CELULAR
    ========================================================== */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .chart-box-unified {
            height: 310px; /* Espacio cómodo en móvil para nombres completos */
        }

        .kpi-card {
            padding: 0.85rem 1rem !important;
        }

        .kpi-value {
            font-size: 1.35rem !important;
        }

        /* Tabla unificada horizontal ultra plana en móvil */
        .dtl-pure-table {
            min-width: 1080px !important;
        }

        .dtl-pure-table thead th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.62rem !important;
        }

        .dtl-pure-table td {
            padding: 0.32rem 0.65rem !important;
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
        }

        .col-mob-etapa        { min-width: 250px !important; width: 250px !important; }
        .col-mob-obras        { min-width: 150px !important; width: 150px !important; }
        .col-mob-distribucion { min-width: 220px !important; width: 220px !important; }
        .col-mob-monto        { min-width: 200px !important; width: 200px !important; }
        .col-mob-porcentaje   { min-width: 140px !important; width: 140px !important; }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid var(--dtl-border) !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3.5px; background-color: var(--dtl-green);"></div>
        
        <div class="card-body p-2.5 p-md-3">
            <div class="d-flex flex-wrap align-items-center gap-1.5 mb-1">
                <span class="badge rounded-pill fw-bold px-2 py-0.5 text-uppercase" style="background-color: var(--dtl-navy); color: #ffffff; font-size: 0.60rem;">
                    <i class="fas fa-chart-line me-1 text-success"></i> DASHBOARD DIRECTIVO
                </span>
                <span class="badge rounded-pill fw-semibold px-2 py-0.5 d-inline-flex align-items-center gap-1" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.60rem;">
                    <span class="status-pulse-green"></span> {{ auth()->user()->name }}
                </span>
            </div>
            
            <h3 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem; color: var(--dtl-navy); letter-spacing: -0.3px;">
                Tablero de Control y Rentabilidad Comercial
            </h3>
        </div>
    </div>

    <!-- 2. BARRA DE FILTROS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid var(--dtl-border) !important;">
        <div class="card-body p-2.5 p-md-3">
            <form method="GET" action="{{ route('gerencia.dashboard') }}" class="row g-2 align-items-end">
                <div class="col-12 col-sm-6 col-md-4">
                    <label class="form-label text-muted fw-bold mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">PERÍODO DESDE</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #cbd5e1; height: 38px;"><i class="far fa-calendar-alt"></i></span>
                        <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="form-control filter-input border-start-0 shadow-none">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <label class="form-label text-muted fw-bold mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">PERÍODO HASTA</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #cbd5e1; height: 38px;"><i class="far fa-calendar-alt"></i></span>
                        <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="form-control filter-input border-start-0 shadow-none">
                    </div>
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <button type="submit" class="btn btn-dtl-action btn-dtl-primary shadow-sm flex-grow-1">
                        <i class="fas fa-filter"></i> Filtrar Información
                    </button>
                    <a href="{{ route('gerencia.dashboard') }}" class="btn btn-dtl-action btn-outline-secondary shadow-sm" style="border-color: #cbd5e1; color: #64748b; width: 38px; padding: 0;" title="Restablecer Período">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. TARJETAS DE KPIS ESTRATÉGICOS -->
    <div class="row g-2.5 mb-3">
        <!-- KPI 1 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #059669;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.66rem; letter-spacing: 0.4px;">Efectividad de Cierre (Win Rate)</span>
                        <span class="badge rounded-pill bg-success-subtle text-success fw-bold px-2 py-0.5" style="font-size: 0.58rem;">ROI</span>
                    </div>
                    <h3 class="fw-bold mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.55rem; color: #047857;">{{ $winRateFinanciero }}%</h3>
                    <div class="progress mt-2" style="height: 5px; background-color: #e2e8f0; border-radius: 4px;">
                        <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{ min(100, $winRateFinanciero) }}%"></div>
                    </div>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.70rem;">
                    {{ $cotizacionesGanadas }} Ganadas de {{ ($cotizacionesGanadas + $cotizacionesPerdidas) }} Obras Cerradas
                </small>
            </div>
        </div>

        <!-- KPI 2 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #10b981;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.66rem; letter-spacing: 0.4px;">Monto Cerrado / Backlog</span>
                        <i class="fas fa-handshake text-success opacity-75"></i>
                    </div>
                    <h3 class="fw-bold mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.45rem; color: #047857;">S/ {{ number_format($montoGanadoTotal, 2) }}</h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.70rem;">Obras contratadas para ejecución</small>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #0284c7;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.66rem; letter-spacing: 0.4px;">Propuestas en Negociación</span>
                        <span class="badge rounded-pill bg-info-subtle text-primary fw-bold px-2 py-0.5" style="font-size: 0.58rem;">{{ $cotizacionesEnviadas }} Obras</span>
                    </div>
                    <h3 class="fw-bold text-primary mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.45rem;">S/ {{ number_format($montoEnNegociacion, 2) }}</h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.70rem;">Enviadas con precio en espera de fallo</small>
            </div>
        </div>

        <!-- KPI 4 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #0f172a;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.66rem; letter-spacing: 0.4px;">Ciclo Promedio de Respuesta</span>
                        <span class="badge rounded-pill bg-light text-dark border px-2 py-0.5" style="font-size: 0.58rem;">SLA</span>
                    </div>
                    <h3 class="fw-bold text-dark mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.55rem;">
                        {{ $tiempoPromedioRespuesta }} <span class="fs-6 text-muted fw-normal">Días</span>
                    </h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.70rem;">
                    <i class="far fa-clock text-primary me-1"></i>Desde registro hasta emisión técnica
                </small>
            </div>
        </div>
    </div>

    <!-- 4. SECCIÓN DE 3 GRÁFICOS ESTRATÉGICOS CON EFECTOS -->
    <div class="row g-2.5 mb-3">
        <!-- Gráfico 1: Dona -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.82rem;">
                        <i class="fas fa-pie-chart text-success me-1"></i> Estado de Cartera
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.65rem;">{{ $totalCotizaciones }} Proyectos</span>
                </div>
                <div class="chart-box-unified d-flex align-items-center justify-content-center">
                    <canvas id="chartEstadosCotizaciones"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Evolución Mensual -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.82rem;">
                        <i class="fas fa-chart-column text-primary me-1"></i> Evolución Mensual
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.65rem;">Soles (S/)</span>
                </div>
                <div class="chart-box-unified">
                    <canvas id="chartEvolucionMensual"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 3: Top Clientes (NOMBRES COMPLETOS SIN PUNTOS SUSPENSIVOS) -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.82rem;">
                        <i class="fas fa-building text-warning me-1"></i> Top Cuentas Clave
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.65rem;">Top 5 Oficial</span>
                </div>
                <div class="chart-box-unified">
                    <canvas id="chartTopClientes"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. TABLA RESUMEN EJECUTIVA HORIZONTAL Y COMPACTA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-3" style="border: 1px solid var(--dtl-border) !important;">
        <div class="card-body p-0">
            <div class="dtl-table-scroll-container">
                <table class="table table-bordered table-hover align-middle dtl-pure-table">
                    <thead>
                        <tr>
                            <th class="ps-3 col-mob-etapa" style="width: 24%;">ETAPA OPERATIVA</th>
                            <th class="text-center col-mob-obras" style="width: 14%;">OBRAS REGISTRADAS</th>
                            <th class="col-mob-distribucion" style="width: 24%;">DISTRIBUCIÓN</th>
                            <th class="text-end col-mob-monto" style="width: 22%;">MONTO FINANCIERO (S/)</th>
                            <th class="text-center pe-3 col-mob-porcentaje" style="width: 16%;">% CARTERA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chartData as $estado => $cantidad)
                            @php 
                                $porcCant = $totalCotizaciones > 0 ? round(($cantidad / $totalCotizaciones) * 100, 1) : 0;
                                $montoEstado = $chartMontosData[$estado] ?? 0;
                                $porcMonto = $montoCotizadoTotal > 0 ? round(($montoEstado / $montoCotizadoTotal) * 100, 1) : 0;

                                $configEstados = [
                                    'Programada'  => ['color' => '#64748b', 'bg' => '#f1f5f9', 'border' => '#cbd5e1', 'desc' => 'En elaboración'],
                                    'Enviada'     => ['color' => '#0284c7', 'bg' => '#f0f9ff', 'border' => '#bae6fd', 'desc' => 'En negociación'],
                                    'Aceptada'    => ['color' => '#059669', 'bg' => '#ecfdf5', 'border' => '#a7f3d0', 'desc' => 'Obra ganada'],
                                    'Rechazada'   => ['color' => '#dc2626', 'bg' => '#fef2f2', 'border' => '#fecaca', 'desc' => 'Desestimada'],
                                ];
                                $st = $configEstados[$estado] ?? ['color' => '#64748b', 'bg' => '#f1f5f9', 'border' => '#e2e8f0', 'desc' => ''];
                            @endphp
                            <tr>
                                <!-- ETAPA -->
                                <td class="ps-3 col-mob-etapa text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <span class="badge rounded-pill fw-bold px-2 py-0.5 d-inline-flex align-items-center gap-1" 
                                              style="background-color: {{ $st['bg'] }}; color: {{ $st['color'] }}; border: 1px solid {{ $st['border'] }}; font-size: 0.65rem;">
                                            <span style="width: 5px; height: 5px; border-radius: 50%; background-color: {{ $st['color'] }};"></span>
                                            {{ $estado }}
                                        </span>
                                        <small class="text-muted" style="font-size: 0.68rem;">({{ $st['desc'] }})</small>
                                    </div>
                                </td>

                                <!-- OBRAS -->
                                <td class="text-center col-mob-obras text-nowrap">
                                    <span class="badge rounded-2 px-2 py-0.5 font-monospace {{ $cantidad > 0 ? 'bg-dark text-white fw-bold' : 'bg-light text-muted border' }}" style="font-size: 0.70rem;">
                                        {{ $cantidad }} obras
                                    </span>
                                </td>

                                <!-- DISTRIBUCIÓN -->
                                <td class="col-mob-distribucion">
                                    <div class="d-flex align-items-center gap-2" style="max-width: 200px;">
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 5px; background-color: #e2e8f0;">
                                            <div class="progress-bar rounded-pill" role="progressbar" 
                                                 style="width: {{ $porcCant }}%; background-color: {{ $st['color'] }};"></div>
                                        </div>
                                        <span class="text-muted font-monospace fw-bold" style="font-size: 0.68rem; min-width: 35px; text-align: right;">
                                            {{ $porcCant }}%
                                        </span>
                                    </div>
                                </td>

                                <!-- MONTO -->
                                <td class="text-end font-monospace col-mob-monto text-nowrap">
                                    <span class="{{ $montoEstado > 0 ? 'fw-bold text-dark' : 'text-muted opacity-50' }}" style="font-size: 0.78rem;">
                                        S/ {{ number_format($montoEstado, 2) }}
                                    </span>
                                </td>

                                <!-- % CARTERA -->
                                <td class="text-center pe-3 col-mob-porcentaje text-nowrap">
                                    @if($porcMonto > 0)
                                        <span class="badge rounded-pill fw-bold px-2 py-0.5" style="background-color: #ecfdf5; color: #047857; font-size: 0.68rem;">
                                            {{ $porcMonto }}%
                                        </span>
                                    @else
                                        <span class="text-muted opacity-50 font-monospace" style="font-size: 0.68rem;">0.0%</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    <tfoot style="background-color: #f8fafc; border-top: 2px solid #cbd5e1;">
                        <tr class="fw-bold">
                            <td class="ps-3 text-dark text-uppercase font-monospace col-mob-etapa text-nowrap" style="font-size: 0.72rem;">
                                Volumen Total Cotizado:
                            </td>
                            <td class="text-center font-monospace text-dark col-mob-obras text-nowrap" style="font-size: 0.74rem;">
                                {{ $totalCotizaciones }} obras
                            </td>
                            <td class="col-mob-distribucion">
                                <div class="d-flex align-items-center gap-2" style="max-width: 200px;">
                                    <div class="progress flex-grow-1 rounded-pill" style="height: 5px; background-color: #e2e8f0;">
                                        <div class="progress-bar bg-dark rounded-pill" style="width: 100%;"></div>
                                    </div>
                                    <span class="text-dark font-monospace fw-bold" style="font-size: 0.68rem; min-width: 35px; text-align: right;">100%</span>
                                </div>
                            </td>
                            <td class="text-end font-monospace text-success fw-bold col-mob-monto text-nowrap" style="font-size: 0.84rem;">
                                S/ {{ number_format($montoCotizadoTotal, 2) }}
                            </td>
                            <td class="text-center pe-3 col-mob-porcentaje text-nowrap">
                                <span class="badge rounded-pill bg-dark text-white font-monospace px-2 py-0.5" style="font-size: 0.66rem;">100%</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        /**
         * FUNCIÓN CLAVE: Evita que Chart.js recorte las palabras largas con '...'
         * Divide el texto corporativo en 2 líneas limpias sin perder información.
         */
        function dividirTextoLargo(str, maxCaracteres = 18) {
            if (!str) return '';
            if (str.length <= maxCaracteres) return str;
            
            const palabras = str.split(' ');
            const lineas = [];
            let lineaActual = '';

            palabras.forEach(palabra => {
                if ((lineaActual + ' ' + palabra).trim().length <= maxCaracteres) {
                    lineaActual = (lineaActual + ' ' + palabra).trim();
                } else {
                    if (lineaActual) lineas.push(lineaActual);
                    lineaActual = palabra;
                }
            });
            if (lineaActual) lineas.push(lineaActual);
            return lineas.length > 1 ? lineas : str;
        }

        const labelsEstados = @json(array_keys($chartData ?? []));
        const dataCantidades = @json(array_values($chartData ?? []));
        const coloresEstados = ['#64748b', '#0284c7', '#059669', '#dc2626'];
        const totalOps = dataCantidades.reduce((a, b) => a + Number(b), 0) || 1;

        // 1. GRÁFICO DE DONA: ESTADO DE CARTERA
        const canvasDona = document.getElementById('chartEstadosCotizaciones');
        if (canvasDona) {
            new Chart(canvasDona.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labelsEstados,
                    datasets: [{
                        data: dataCantidades,
                        backgroundColor: coloresEstados,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '64%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: { size: 9.5, weight: '700' },
                                color: '#334155',
                                padding: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            titleFont: { size: 11, weight: 'bold' },
                            bodyFont: { size: 11 },
                            callbacks: {
                                label: function(context) {
                                    let val = Number(context.raw || 0);
                                    let pct = Math.round((val / totalOps) * 100);
                                    return ` ${context.label}: ${val} obras (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. GRÁFICO EVOLUTIVO: MES A MES (CON GRADIENTES SUAVES)
        const canvasEvolucion = document.getElementById('chartEvolucionMensual');
        if (canvasEvolucion) {
            const ctxEvol = canvasEvolucion.getContext('2d');
            const mesesLabels = @json($historicoLabels ?? []);
            const dataCotizado = @json($historicoCotizado ?? []);
            const dataGanado = @json($historicoGanado ?? []);

            // Gradiente Azul para Cotizado
            const gradAzul = ctxEvol.createLinearGradient(0, 0, 0, 260);
            gradAzul.addColorStop(0, '#0284c7');
            gradAzul.addColorStop(1, '#38bdf8');

            // Gradiente Verde para Ganado
            const gradVerde = ctxEvol.createLinearGradient(0, 0, 0, 260);
            gradVerde.addColorStop(0, '#059669');
            gradVerde.addColorStop(1, '#34d399');

            new Chart(ctxEvol, {
                type: 'bar',
                data: {
                    labels: mesesLabels.length ? mesesLabels : ['Sin registros'],
                    datasets: [
                        {
                            label: 'Cotizado (S/)',
                            data: dataCotizado.length ? dataCotizado : [0],
                            backgroundColor: gradAzul,
                            borderRadius: 5,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            maxBarThickness: 45
                        },
                        {
                            label: 'Ganado (S/)',
                            data: dataGanado.length ? dataGanado : [0],
                            backgroundColor: gradVerde,
                            borderRadius: 5,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            maxBarThickness: 45
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                font: { size: 9, weight: '700' },
                                color: '#334155',
                                padding: 6
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    let val = Number(context.raw || 0);
                                    return ` ${context.dataset.label}: S/ ${val.toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(val) {
                                    if (val >= 1000000) return 'S/ ' + (val / 1000000).toFixed(1) + 'M';
                                    if (val >= 1000) return 'S/ ' + (val / 1000).toFixed(0) + 'k';
                                    return 'S/ ' + val;
                                },
                                color: '#64748b',
                                font: { size: 8.5, weight: '600' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#334155', font: { size: 8.5, weight: '600' } }
                        }
                    }
                }
            });
        }

        // 3. GRÁFICO BARRAS HORIZONTALES: TOP CUENTAS CLAVE (CON NOMBRES COMPLETOS Y GRADIENTE ÁMBAR)
        const canvasTopClientes = document.getElementById('chartTopClientes');
        if (canvasTopClientes) {
            const ctxTop = canvasTopClientes.getContext('2d');
            const rawClientesLabels = @json($clientesLabels ?? []);
            const clientesMontos = @json($clientesMontos ?? []);

            // Mapeamos los nombres usando la función para que NO se corten con '...'
            const labelsFormateados = rawClientesLabels.map(nombre => dividirTextoLargo(nombre, 20));

            // Gradiente Ámbar Oro Corporativo
            const gradAmbar = ctxTop.createLinearGradient(0, 0, 300, 0);
            gradAmbar.addColorStop(0, '#f59e0b');
            gradAmbar.addColorStop(1, '#fbbf24');

            new Chart(ctxTop, {
                type: 'bar',
                data: {
                    labels: labelsFormateados.length ? labelsFormateados : ['Sin registros'],
                    datasets: [{
                        label: 'Monto Total (S/)',
                        data: clientesMontos.length ? clientesMontos : [0],
                        backgroundColor: gradAmbar,
                        borderRadius: 6,
                        barPercentage: 0.65,
                        maxBarThickness: 26
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            right: 15,
                            left: 5
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: {
                                title: function(context) {
                                    // Muestra el nombre corporativo completo sin saltos de línea en el tooltip
                                    const index = context[0].dataIndex;
                                    return rawClientesLabels[index] || '';
                                },
                                label: function(context) {
                                    let val = Number(context.raw || 0);
                                    return ` Presupuesto: S/ ${val.toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: '#f8fafc' },
                            ticks: {
                                callback: function(val) {
                                    if (val >= 1000000) return 'S/ ' + (val / 1000000).toFixed(1) + 'M';
                                    if (val >= 1000) return 'S/ ' + (val / 1000).toFixed(0) + 'k';
                                    return 'S/ ' + val;
                                },
                                color: '#64748b',
                                font: { size: 8 }
                            }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                color: '#0f172a',
                                font: { size: 8.5, weight: '700' },
                                autoSkip: false // Garantiza que siempre se muestren los 5 clientes completos
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection