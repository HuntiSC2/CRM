<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $cotizacion->codigo_cotizacion }} - DTL PREMIER</title>
    <style>
        /* CONFIGURACIÓN DE PÁGINA */
        @page {
            size: a4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-print-color-adjust: exact;
        }

        body {
            margin: 0;
            padding: 0;
            color: #1e293b;
            font-size: 8pt;
            line-height: 1.35;
            background-color: #ffffff;
            position: relative;
        }

        /* 1. PLANTILLA MEMBRETADA AL FONDO */
        .plantilla-fondo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -100;
        }

        /* ==========================================================
           2. SELLO GIGANTE DIAGONAL (AJUSTE FINO: SOLO UN POQUITO MENOS)
           ========================================================== */
        .marca-agua-rechazada-container {
            position: fixed;
            top: 41%;
            left: -12%;
            width: 124%; /* Reducción mínima para no tocar los filos */
            text-align: center;
            z-index: 9999;
            transform: rotate(-35deg);
            -webkit-transform: rotate(-35deg);
            pointer-events: none;
        }

        .sello-rechazado-caja {
            display: inline-block;
            border: 7px dashed #dc2626;
            padding: 15px 42px; /* Apenas un poquito menos de relleno */
            border-radius: 16px;
            background-color: transparent;
            opacity: 0.18;
        }

        .sello-texto-principal {
            color: #dc2626;
            font-size: 52pt; /* Mantiene la imponencia visual de la foto */
            font-weight: 900;
            letter-spacing: 10px;
            line-height: 1.05;
            text-transform: uppercase;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .sello-texto-secundario {
            color: #dc2626;
            font-size: 13.5pt;
            font-weight: 800;
            letter-spacing: 5px;
            margin-top: 9px;
            text-transform: uppercase;
            border-top: 2.8px solid #dc2626;
            padding-top: 5px;
        }

        /* CONTENEDOR DE DATOS CON MÁRGENES */
        .contenedor-documento {
            padding-top: 32mm;
            padding-left: 14mm;
            padding-right: 14mm;
            padding-bottom: 22mm;
            position: relative;
            z-index: 10;
        }

        /* COLORES CORPORATIVOS DTL PREMIER */
        .text-navy      { color: #0f2438; }
        .text-green     { color: #059669; }
        .text-slate     { color: #475569; }
        .text-muted     { color: #64748b; }
        .font-mono      { font-family: 'Courier New', Courier, monospace; }
        .fw-bold        { font-weight: bold; }
        .fw-semibold    { font-weight: 600; }
        .text-center    { text-align: center; }
        .text-end       { text-align: right; }
        .text-uppercase { text-transform: uppercase; }

        /* CABECERA (LOGO Y RUC) */
        .header-top-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        .header-top-table td {
            vertical-align: middle;
        }
        .brand-left-cell {
            width: 60%;
        }
        .brand-logo-img {
            max-height: 52px;
            width: auto;
            display: block;
        }
        .box-right-cell {
            width: 40%;
            text-align: right;
        }
        .official-ruc-box {
            width: 185px;
            border: 1.5px solid #0f2438;
            border-collapse: collapse;
            border-radius: 4px;
            overflow: hidden;
            display: inline-table;
            background-color: #ffffff;
        }
        .ruc-header-line {
            background-color: #0f2438;
            color: #ffffff;
            padding: 4px 6px;
            font-size: 8pt;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }
        .ruc-code-line {
            background-color: #ffffff;
            color: #0f2438;
            padding: 4px 6px;
            font-size: 8.5pt;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }

        /* TÍTULO */
        .doc-title-container {
            text-align: center;
            margin-top: 70px;
            margin-bottom: 50px;
        }
        .doc-title-text {
            font-size: 13.5pt;
            font-weight: 900;
            color: #0f2438;
            letter-spacing: 2.2px;
            text-transform: uppercase;
        }

        /* DATOS CLIENTE Y PROYECTO */
        .info-layout-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            background: transparent;
        }
        .info-layout-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }
        .info-lbl {
            color: #475569;
            font-weight: 700;
            font-size: 7.2pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .val-primary {
            color: #0f2438;
            font-weight: 800;
            font-size: 8pt;
            line-height: 1.25;
        }
        .val-code {
            color: #0f2438;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            font-size: 7.8pt;
        }
        .val-regular {
            color: #1e293b;
            font-weight: 600;
            font-size: 7.6pt;
        }

        /* TABLA DE ÍTEMS */
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 60px;
            margin-bottom: 12px;
        }
        .table-items thead th {
            background-color: #0f2438;
            color: #ffffff;
            padding: 7px 6px;
            font-size: 7.2pt;
            font-weight: 700;
            border: none;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .table-items tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }
        .table-items tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .table-items td {
            padding: 6.5px 8px;
            font-size: 7.6pt;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        /* TOTALES */
        .table-totals {
            width: 44%;
            border-collapse: collapse;
            margin-left: auto;
            margin-top: 6px;
        }
        .table-totals td {
            padding: 5px 9px;
            font-size: 7.8pt;
        }
        .table-totals .tot-lbl {
            color: #475569;
            font-weight: 700;
            text-align: right;
            width: 50%;
        }
        .table-totals .tot-val {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            color: #0f2438;
            width: 50%;
        }
        .row-grand-total td {
            background-color: #0f2438 !important;
            color: #ffffff !important;
            font-weight: bold;
            font-size: 8.6pt;
            padding: 7px 9px;
        }
        .row-grand-total .tot-val {
            color: #34d399 !important;
            font-size: 9.4pt;
        }

        /* SECCIÓN DE FIRMAS FÍSICAS */
        .table-dual-signatures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 55px;
            page-break-inside: avoid;
        }
        .table-dual-signatures td {
            vertical-align: bottom;
            text-align: center;
            padding: 0;
        }
        .sig-physical-box {
            height: 60px;
            width: 100%;
        }
        .sig-physical-line {
            border-top: 1.4px solid #0f2438;
            width: 85%;
            margin: 0 auto;
            padding-top: 5px;
        }
        .sig-physical-title {
            color: #0f2438;
            font-size: 7.5pt;
            font-weight: 800;
            letter-spacing: 0.3px;
            display: block;
            text-transform: uppercase;
        }
        .sig-physical-subtitle {
            font-size: 6.8pt;
            color: #64748b;
            display: block;
            margin-top: 1px;
        }
        .sig-physical-fields {
            margin-top: 4px;
            font-size: 6.5pt;
            color: #94a3b8;
            letter-spacing: 0.2px;
        }
    </style>
</head>
<body>

@php
    $pathPlantilla = null;
    $posiblesPlantillas = ['plantilla.png', 'plantilla.jpg', 'plantilla.jpeg', 'plantilla.PNG'];
    foreach ($posiblesPlantillas as $archivo) {
        if (file_exists(public_path('images/' . $archivo))) {
            $pathPlantilla = public_path('images/' . $archivo);
            break;
        }
    }

    $esRechazada = (strtoupper($cotizacion->estado_cotizacion ?? '') === 'RECHAZADA');

    $montoTotal = (float) $cotizacion->monto_total;
    $subtotal   = $montoTotal / 1.18;
    $igv        = $montoTotal - $subtotal;

    $fechaEmisionCarbon = !empty($cotizacion->fecha_emision) ? \Carbon\Carbon::parse($cotizacion->fecha_emision) : now();
    $diasValidez = (int) ($cotizacion->validez_dias ?? 15);
@endphp

<!-- CARGA LA IMAGEN DE LA PLANTILLA DE FONDO -->
@if($pathPlantilla)
    <img src="{{ $pathPlantilla }}" class="plantilla-fondo">
@endif

<!-- =======================================================
     SELLO GIGANTE DIAGONAL (AJUSTADO PARA NO SALIR DE LOS BORDES)
     ======================================================= -->
@if($esRechazada)
    <div class="marca-agua-rechazada-container">
        <div class="sello-rechazado-caja">
            <div class="sello-texto-principal">RECHAZADA</div>
            <div class="sello-texto-secundario">DOCUMENTO SIN VALOR LEGAL NI CONTRACTUAL</div>
        </div>
    </div>
@endif

<div class="contenedor-documento">

    <!-- CABECERA -->
    <table class="header-top-table">
        <tr>
            <td class="brand-left-cell">
                @if(file_exists(public_path('images/logo-dtl.png')))
                    <img src="{{ public_path('images/logo-dtl.png') }}" class="brand-logo-img" alt="DTL PREMIER">
                @else
                    <h1 style="color: #0f2438; margin: 0; font-size: 16pt; font-weight: 900;">
                        <span style="color: #0f2438;">DTL</span> <span style="color: #059669;">PREMIER</span>
                    </h1>
                @endif
            </td>
            <td class="box-right-cell">
                <table class="official-ruc-box" align="right">
                    <tr>
                        <td class="ruc-header-line">R.U.C. N° 20529193719</td>
                    </tr>
                    <tr>
                        <td class="ruc-code-line">{{ $cotizacion->codigo_cotizacion }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TÍTULO -->
    <div class="doc-title-container">
        <span class="doc-title-text">PROPUESTA ECONÓMICA</span>
    </div>

    <!-- DATOS DEL CLIENTE Y PROYECTO -->
    <table class="info-layout-table">
        <tr>
            <!-- BLOQUE IZQUIERDO -->
            <td style="width: 48%; vertical-align: top;">
                <table style="border-collapse: collapse; border: none;">
                    <tr>
                        <td class="info-lbl" style="width: 75px; padding: 3px 6px 3px 0;">CLIENTE:</td>
                        <td class="val-primary" style="padding: 3px 0;">
                            {{ $cotizacion->obra->cliente->razon_social ?? 'NO ESPECIFICADO' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-lbl" style="padding: 3px 6px 3px 0;">RUC / DNI:</td>
                        <td class="val-code" style="padding: 3px 0;">
                            {{ $cotizacion->obra->cliente->ruc ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-lbl" style="padding: 3px 6px 3px 0;">ATENCIÓN:</td>
                        <td class="val-regular" style="padding: 3px 0;">
                            {{ $cotizacion->obra->cliente->nombre_contacto ?? 'Atención Dirección' }}
                        </td>
                    </tr>
                </table>
            </td>

            <!-- BLOQUE DERECHO -->
            <td style="width: 52%; vertical-align: top; text-align: right;">
                <table align="right" style="border-collapse: collapse; border: none; margin-left: auto; float: right; text-align: left;">
                    <tr>
                        <td class="info-lbl" style="width: 80px; padding: 3px 6px 3px 0; vertical-align: top;">PROYECTO:</td>
                        <td class="val-primary" style="width: 195px; padding: 3px 0; text-align: left; vertical-align: top;">
                            {{ $cotizacion->obra->titulo ?? 'PROYECTO GENERAL' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-lbl" style="width: 80px; padding: 3px 6px 3px 0; vertical-align: top;">EXPEDIENTE:</td>
                        <td class="val-code" style="width: 195px; padding: 3px 0; text-align: left; vertical-align: top;">
                            {{ $cotizacion->obra->codigo ?? 'OBR-S/N' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-lbl" style="width: 80px; padding: 3px 6px 3px 0; vertical-align: top;">EMISIÓN / PLAZO:</td>
                        <td style="width: 195px; padding: 3px 0; text-align: left; vertical-align: top;">
                            <span class="val-code">{{ $fechaEmisionCarbon->format('d/m/Y') }}</span> 
                            <span style="color: #64748b; font-size: 7.2pt; font-weight: 500;">({{ $diasValidez }} días validez)</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TABLA DE PARTIDAS -->
    <table class="table-items">
        <thead>
            <tr>
                <th style="width: 6%;" class="text-center">ÍTEM</th>
                <th style="width: 14%;" class="text-center">CÓDIGO</th>
                <th style="width: 48%; text-align: left;">DESCRIPCIÓN DE LA PARTIDA / ALCANCE</th>
                <th style="width: 7%;" class="text-center">UND</th>
                <th style="width: 7%;" class="text-center">CANT.</th>
                <th style="width: 9%;" class="text-end">P.U. (S/)</th>
                <th style="width: 9%;" class="text-end">TOTAL (S/)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cotizacion->detalles as $index => $det)
                <tr>
                    <td class="text-center font-mono fw-bold text-navy">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="text-center font-mono text-muted" style="font-size: 7.2pt;">
                        {{ $det->partida->codigo ?? 'PAR-S/N' }}
                    </td>
                    <td>
                        <strong class="text-navy" style="font-size: 7.8pt;">
                            {{ $det->partida->descripcion ?? 'Partida Oficial' }}
                        </strong>
                    </td>
                    <td class="text-center font-mono text-uppercase" style="font-size: 7.2pt;">
                        {{ $det->partida->unidad_medida ?? 'glb' }}
                    </td>
                    <td class="text-center font-mono fw-bold">
                        {{ number_format($det->cantidad, 2) }}
                    </td>
                    <td class="text-end font-mono">
                        {{ number_format($det->precio_unitario, 2) }}
                    </td>
                    <td class="text-end font-mono fw-bold text-navy" style="font-size: 8pt;">
                        {{ number_format($det->subtotal, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center font-mono fw-bold text-navy">01</td>
                    <td class="text-center font-mono text-muted">-</td>
                    <td>
                        <strong class="text-navy">
                            {{ $cotizacion->obra->titulo ?? 'Servicios Generales de Construcción e Ingeniería' }}
                        </strong>
                    </td>
                    <td class="text-center font-mono">GLB</td>
                    <td class="text-center font-mono fw-bold">1.00</td>
                    <td class="text-end font-mono">{{ number_format($subtotal, 2) }}</td>
                    <td class="text-end font-mono fw-bold text-navy">
                        {{ number_format($subtotal, 2) }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTALES -->
    <table class="table-totals" align="right">
        <tr>
            <td class="tot-lbl">SUBTOTAL:</td>
            <td class="tot-val">S/ {{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="tot-lbl">I.G.V. (18.00%):</td>
            <td class="tot-val">S/ {{ number_format($igv, 2) }}</td>
        </tr>
        <tr class="row-grand-total">
            <td class="text-end" style="padding-right: 6px;">TOTAL:</td>
            <td class="tot-val">S/ {{ number_format($montoTotal, 2) }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <!-- SECCIÓN DE FIRMAS FÍSICAS -->
    <table class="table-dual-signatures">
        <tr>
            <!-- 1. FIRMA CLIENTE: CONFORMIDAD -->
            <td style="width: 46%;">
                <div class="sig-physical-box"></div>
                <div class="sig-physical-line">
                    <span class="sig-physical-title">CONFORMIDAD DEL CLIENTE</span>
                    <span class="sig-physical-subtitle">{{ $cotizacion->obra->cliente->razon_social ?? 'Aceptación de Propuesta' }}</span>
                    <div class="sig-physical-fields">
                        Nombre / DNI: ____________________ Fecha: ___/___/______
                    </div>
                </div>
            </td>

            <td style="width: 8%;"></td>

            <!-- 2. FIRMA EMPRESA: GERENCIA GENERAL -->
            <td style="width: 46%;">
                <div class="sig-physical-box"></div>
                <div class="sig-physical-line">
                    <span class="sig-physical-title">GERENCIA GENERAL</span>
                    <span class="sig-physical-subtitle">DTL PREMIER S.A.C.</span>
                    <div class="sig-physical-fields" style="color: transparent;">.</div>
                </div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>