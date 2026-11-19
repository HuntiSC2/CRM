@extends('layouts.gerencia')

@section('content')
<style>
    /* Tipografía y variables base */
    :root {
        --dtl-emerald: #059669;
        --dtl-emerald-dark: #047857;
        --dtl-slate: #0f172a;
        --dtl-border: #e2e8f0;
    }

    /* Botones de Acción */
    .btn-dtl-action { 
        height: 40px; 
        padding: 0 18px; 
        font-size: 0.85rem; 
        font-weight: 700; 
        border-radius: 10px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        gap: 8px;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
    }
    .btn-dtl-primary { 
        background-color: var(--dtl-emerald) !important; 
        border: 1px solid var(--dtl-emerald) !important; 
        color: #ffffff !important; 
    }
    .btn-dtl-primary:hover { 
        background-color: var(--dtl-emerald-dark) !important;
        border-color: var(--dtl-emerald-dark) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    /* Tarjetas de KPI */
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
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.08) !important;
    }
    .kpi-card-strip { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 4px; 
    }

    /* Contenedor Gráficos Unificado */
    .chart-box-unified {
        height: 250px;
        position: relative;
        width: 100%;
    }

    .status-pulse-green {
        width: 7px;
        height: 7px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    }

    /* Filtros Inputs */
    .filter-input {
        border-color: #cbd5e1;
        font-size: 0.85rem;
        height: 40px;
        border-radius: 8px;
    }

    /* RESPONSIVIDAD AVANZADA (MÓVIL Y TABLET) */
    @media (max-width: 767.98px) {
        .chart-box-unified {
            height: 260px; /* Mayor espacio para leyendas en celular */
        }

        .kpi-card {
            padding: 1rem !important;
        }

        .kpi-value {
            font-size: 1.35rem !important;
        }

        /* Transformación inteligente de la tabla a Tarjetas en Celular */
        .dtl-responsive-table thead {
            display: none; /* Oculta encabezados tradicionales */
        }
        .dtl-responsive-table, 
        .dtl-responsive-table tbody, 
        .dtl-responsive-table tr, 
        .dtl-responsive-table td {
            display: block;
            width: 100% !important;
        }
        .dtl-responsive-table tr {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 12px 14px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }
        .dtl-responsive-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0 !important;
            border: none !important;
            border-bottom: 1px dashed #f1f5f9 !important;
            text-align: right !important;
        }
        .dtl-responsive-table td:last-child {
            border-bottom: none !important;
        }
        /* Asigna la etiqueta completa en cada fila de la tarjeta */
        .dtl-responsive-table td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.4px;
            text-align: left;
            padding-right: 12px;
            white-space: nowrap;
        }

        .dtl-responsive-table tfoot {
            display: block;
            width: 100%;
        }
        .dtl-responsive-table tfoot tr {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
        }
    }
</style>

<div class="container-fluid px-2 px-md-4 py-3">

    <!-- 1. ENCABEZADO -->
    <div class="card border-0 shadow-sm rounded-4 mb-3 position-relative overflow-hidden" style="border: 1px solid var(--dtl-border) !important;">
        <div class="position-absolute top-0 start-0 w-100" style="height: 3.5px; background-color: var(--dtl-emerald);"></div>
        
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-12">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1.5">
                        <span class="badge rounded-pill fw-bold px-2.5 py-1 text-uppercase" style="background-color: var(--dtl-slate); color: #ffffff; font-size: 0.65rem; letter-spacing: 0.4px;">
                            <i class="fas fa-chart-line me-1 text-success"></i> DASHBOARD DIRECTIVO
                        </span>
                        <span class="badge rounded-pill fw-semibold px-2.5 py-1 d-inline-flex align-items-center gap-1.5" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem;">
                            <span class="status-pulse-green"></span> {{ auth()->user()->name }}
                        </span>
                    </div>
                    
                    <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem; color: #0f172a; letter-spacing: -0.3px;">
                        Tablero de Control
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. BARRA DE FILTROS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-3" style="border: 1px solid var(--dtl-border) !important;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('gerencia.dashboard') }}" class="row g-2 align-items-end">
                <div class="col-12 col-sm-6 col-md-4">
                    <label class="form-label text-muted fw-bold mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">PERÍODO DESDE</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #cbd5e1; height: 40px;"><i class="far fa-calendar-alt"></i></span>
                        <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="form-control filter-input border-start-0 shadow-none">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <label class="form-label text-muted fw-bold mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">PERÍODO HASTA</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #cbd5e1; height: 40px;"><i class="far fa-calendar-alt"></i></span>
                        <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="form-control filter-input border-start-0 shadow-none">
                    </div>
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center gap-2 mt-3 mt-md-0">
                    <button type="submit" class="btn btn-dtl-action btn-dtl-primary shadow-sm flex-grow-1">
                        <i class="fas fa-filter"></i> Filtrar Información
                    </button>
                    <a href="{{ route('gerencia.dashboard') }}" class="btn btn-dtl-action btn-outline-secondary shadow-sm" style="border-color: #cbd5e1; color: #64748b; width: 40px; padding: 0;" title="Restablecer Año Actual">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. TARJETAS DE KPIS ESTRATÉGICOS -->
    <div class="row g-2 g-md-3 mb-3">
        <!-- KPI 1 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #059669;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.4px;">Efectividad de Cierre (Win Rate)</span>
                        <span class="badge rounded-pill bg-success-subtle text-success fw-bold px-2 py-0.5" style="font-size: 0.60rem;">ROI</span>
                    </div>
                    <h3 class="fw-bold mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.55rem; color: #047857;">{{ $winRateFinanciero }}%</h3>
                    <div class="progress mt-2" style="height: 5px; background-color: #e2e8f0; border-radius: 4px;">
                        <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{ min(100, $winRateFinanciero) }}%"></div>
                    </div>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">
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
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.4px;">Monto Cerrado / Backlog</span>
                        <i class="fas fa-handshake text-success opacity-75"></i>
                    </div>
                    <h3 class="fw-bold mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.45rem; color: #047857;">S/ {{ number_format($montoGanadoTotal, 2) }}</h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">Obras contratadas para ejecución</small>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #0284c7;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.4px;">Propuestas en Negociación</span>
                        <span class="badge rounded-pill bg-info-subtle text-primary fw-bold px-2 py-0.5" style="font-size: 0.60rem;">{{ $cotizacionesEnviadas }} Obras</span>
                    </div>
                    <h3 class="fw-bold text-primary mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.45rem;">S/ {{ number_format($montoEnNegociacion, 2) }}</h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">Enviadas con precio en espera de fallo</small>
            </div>
        </div>

        <!-- KPI 4 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card p-3 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div class="kpi-card-strip" style="background-color: #0f172a;"></div>
                <div>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.4px;">Ciclo Promedio de Respuesta</span>
                        <span class="badge rounded-pill bg-light text-dark border px-2 py-0.5" style="font-size: 0.60rem;">SLA</span>
                    </div>
                    <h3 class="fw-bold text-dark mt-2 mb-0 font-monospace kpi-value" style="font-size: 1.55rem;">
                        {{ $tiempoPromedioRespuesta }} <span class="fs-6 text-muted fw-normal">Días</span>
                    </h3>
                </div>
                <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">
                    <i class="far fa-clock text-primary me-1"></i>Desde registro hasta emisión técnica
                </small>
            </div>
        </div>
    </div>

    <!-- 4. SECCIÓN DE 3 GRÁFICOS ESTRATÉGICOS -->
    <div class="row g-2 g-md-3 mb-3">
        <!-- Gráfico 1: Dona -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.85rem;">
                        <i class="fas fa-pie-chart text-success me-1"></i> Estado de Cartera
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.68rem;">{{ $totalCotizaciones }} Proyectos</span>
                </div>
                <div class="chart-box-unified d-flex align-items-center justify-content-center">
                    <canvas id="chartEstadosCotizaciones"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Evolución Mensual -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.85rem;">
                        <i class="fas fa-chart-column text-primary me-1"></i> Evolución Mensual
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.68rem;">Soles (S/)</span>
                </div>
                <div class="chart-box-unified">
                    <canvas id="chartEvolucionMensual"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 3: Top Clientes -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--dtl-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.85rem;">
                        <i class="fas fa-building text-warning me-1"></i> Top Cuentas Clave
                    </h6>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.68rem;">Top 5</span>
                </div>
                <div class="chart-box-unified">
                    <canvas id="chartTopClientes"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. TABLA RESUMEN EJECUTIVA COMPLETA -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-2.5 p-md-3 mb-3" style="border: 1px solid var(--dtl-border) !important;">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0 dtl-responsive-table w-100" style="font-size: 0.80rem; border-color: #e2e8f0;">
                <thead style="background-color: #f8fafc;">
                    <tr class="text-uppercase" style="font-size: 0.70rem; letter-spacing: 0.6px; color: #475569;">
                        <th class="ps-3 py-2.5 fw-bold" style="width: 25%;">Etapa Operativa</th>
                        <th class="text-center py-2.5 fw-bold" style="width: 14%;">Obras Registradas</th>
                        <th class="py-2.5 fw-bold" style="width: 23%;">Distribución</th>
                        <th class="text-end py-2.5 fw-bold" style="width: 24%;">Monto Financiero (S/)</th>
                        <th class="text-center pe-3 py-2.5 fw-bold" style="width: 14%;">Porcentaje de Cartera</th>
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
                            <td class="ps-md-3 py-2" data-label="Etapa Operativa">
                                <div class="d-inline-flex flex-wrap align-items-center gap-1.5 justify-content-end justify-content-md-start">
                                    <span class="badge rounded-pill fw-bold px-2.5 py-1 d-inline-flex align-items-center gap-1.5" 
                                          style="background-color: {{ $st['bg'] }}; color: {{ $st['color'] }}; border: 1px solid {{ $st['border'] }}; font-size: 0.72rem;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background-color: {{ $st['color'] }};"></span>
                                        {{ $estado }}
                                    </span>
                                    <small class="text-muted" style="font-size: 0.70rem;">({{ $st['desc'] }})</small>
                                </div>
                            </td>

                            <td class="text-center py-2" data-label="Obras Registradas">
                                <span class="badge rounded-2 px-2.5 py-1 font-monospace {{ $cantidad > 0 ? 'bg-dark text-white fw-bold' : 'bg-light text-muted border' }}" style="font-size: 0.74rem;">
                                    {{ $cantidad }} obras
                                </span>
                            </td>

                            <td class="py-2" data-label="Distribución">
                                <div class="d-flex align-items-center gap-2 justify-content-end justify-content-md-start w-100" style="max-width: 220px;">
                                    <div class="progress flex-grow-1 rounded-pill" style="height: 6px; background-color: #e2e8f0; min-width: 60px;">
                                        <div class="progress-bar rounded-pill" role="progressbar" 
                                             style="width: {{ $porcCant }}%; background-color: {{ $st['color'] }};"></div>
                                    </div>
                                    <span class="text-muted font-monospace fw-bold" style="font-size: 0.72rem; min-width: 38px; text-align: right;">
                                        {{ $porcCant }}%
                                    </span>
                                </div>
                            </td>

                            <td class="text-end py-2" data-label="Monto Financiero">
                                <span class="font-monospace {{ $montoEstado > 0 ? 'fw-bold text-dark' : 'text-muted opacity-50' }}" style="font-size: 0.84rem;">
                                    S/ {{ number_format($montoEstado, 2) }}
                                </span>
                            </td>

                            <td class="text-center pe-md-3 py-2" data-label="Porcentaje de Cartera">
                                @if($porcMonto > 0)
                                    <span class="badge rounded-pill fw-bold px-2.5 py-0.5" style="background-color: #ecfdf5; color: #047857; font-size: 0.72rem;">
                                        {{ $porcMonto }}%
                                    </span>
                                @else
                                    <span class="text-muted opacity-50 font-monospace" style="font-size: 0.72rem;">0.0%</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
                <tfoot style="background-color: #f8fafc; border-top: 2px solid #cbd5e1;">
                    <tr class="fw-bold">
                        <td class="ps-md-3 py-2.5 text-dark text-uppercase font-monospace" data-label="Resumen General" style="font-size: 0.74rem;">
                            Volumen Total Cotizado:
                        </td>
                        <td class="text-center py-2.5 font-monospace text-dark" data-label="Total Obras" style="font-size: 0.76rem;">
                            {{ $totalCotizaciones }} obras
                        </td>
                        <td class="py-2.5" data-label="Distribución Total">
                            <div class="d-flex align-items-center gap-2 justify-content-end justify-content-md-start w-100" style="max-width: 220px;">
                                <div class="progress flex-grow-1 rounded-pill" style="height: 6px; background-color: #e2e8f0; min-width: 60px;">
                                    <div class="progress-bar bg-dark rounded-pill" style="width: 100%;"></div>
                                </div>
                                <span class="text-dark font-monospace fw-bold" style="font-size: 0.72rem; min-width: 38px; text-align: right;">100%</span>
                            </div>
                        </td>
                        <td class="text-end py-2.5 font-monospace text-success fw-bold" data-label="Monto Acumulado" style="font-size: 0.90rem;">
                            S/ {{ number_format($montoCotizadoTotal, 2) }}
                        </td>
                        <td class="text-center pe-md-3 py-2.5" data-label="Participación">
                            <span class="badge rounded-pill bg-dark text-white font-monospace px-2.5 py-1" style="font-size: 0.70rem;">100%</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: { size: 10, weight: '600' },
                                color: '#334155',
                                padding: 10
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
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

        // 2. GRÁFICO EVOLUTIVO: MES A MES
        const canvasEvolucion = document.getElementById('chartEvolucionMensual');
        if (canvasEvolucion) {
            const mesesLabels = @json($historicoLabels ?? []);
            const dataCotizado = @json($historicoCotizado ?? []);
            const dataGanado = @json($historicoGanado ?? []);

            new Chart(canvasEvolucion.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: mesesLabels.length ? mesesLabels : ['Sin registros'],
                    datasets: [
                        {
                            label: 'Cotizado (S/)',
                            data: dataCotizado.length ? dataCotizado : [0],
                            backgroundColor: '#0284c7',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            maxBarThickness: 50
                        },
                        {
                            label: 'Ganado (S/)',
                            data: dataGanado.length ? dataGanado : [0],
                            backgroundColor: '#059669',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            maxBarThickness: 50
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
                                font: { size: 9.5, weight: '700' },
                                color: '#334155',
                                padding: 8
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
                                font: { size: 9, weight: '600' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#334155', font: { size: 9, weight: '600' } }
                        }
                    }
                }
            });
        }

        // 3. GRÁFICO BARRAS HORIZONTALES: TOP CLIENTES
        const canvasTopClientes = document.getElementById('chartTopClientes');
        if (canvasTopClientes) {
            const clientesLabels = @json($clientesLabels ?? []);
            const clientesMontos = @json($clientesMontos ?? []);

            new Chart(canvasTopClientes.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: clientesLabels.length ? clientesLabels : ['Sin registros'],
                    datasets: [{
                        label: 'Monto Total (S/)',
                        data: clientesMontos.length ? clientesMontos : [0],
                        backgroundColor: '#f59e0b',
                        borderRadius: 4,
                        barPercentage: 0.65,
                        maxBarThickness: 28
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    let val = Number(context.raw || 0);
                                    return ` Monto: S/ ${val.toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(val) {
                                    if (val >= 1000000) return 'S/ ' + (val / 1000000).toFixed(1) + 'M';
                                    if (val >= 1000) return 'S/ ' + (val / 1000).toFixed(0) + 'k';
                                    return 'S/ ' + val;
                                },
                                color: '#64748b',
                                font: { size: 8.5 }
                            }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                color: '#334155',
                                font: { size: 9, weight: '600' }
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