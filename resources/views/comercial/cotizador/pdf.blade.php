<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $cotizacion->codigo_cotizacion }} - DTL PREMIER</title>
    <style>
        @page {
            size: a4 portrait;
            margin-top: 14mm;
            margin-left: 14mm;
            margin-right: 14mm;
            margin-bottom: 12mm;
        }

        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-print-color-adjust: exact;
        }

        body {
            color: #334155;
            font-size: 8.5pt;
            line-height: 1.45;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .page-container {
            width: 100%;
        }

        /* UTILIDADES */
        .text-navy      { color: #0f2438; }
        .text-green     { color: #059669; }
        .text-muted     { color: #64748b; }
        .text-danger    { color: #dc2626; }
        .font-mono      { font-family: 'Courier New', Courier, monospace; }
        .fw-bold        { font-weight: bold; }
        .fw-semibold    { font-weight: 600; }
        .text-center    { text-align: center; }
        .text-end       { text-align: right; }
        .text-uppercase { text-transform: uppercase; }

        /* CABECERA: LOGO Y CUADRO RUC */
        .header-top-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-top-table td {
            vertical-align: middle;
        }

        .brand-left-cell {
            width: 60%;
        }
        .brand-logo-img {
            max-height: 50px;
            width: auto;
            display: block;
        }

        .box-right-cell {
            width: 40%;
            text-align: right;
        }
        .official-ruc-box {
            width: 195px;
            border: 1.2px solid #0f2438;
            border-collapse: collapse;
            border-radius: 4px;
            overflow: hidden;
            display: inline-table;
        }
        .ruc-header-line {
            background-color: #0f2438;
            color: #ffffff;
            padding: 5px 6px;
            font-size: 8.5pt;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }
        .ruc-code-line {
            background-color: #ffffff;
            color: #0f2438;
            padding: 5px 6px;
            font-size: 8.5pt;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }

        /* TÍTULO DEL DOCUMENTO */
        .doc-title-container {
            text-align: center;
            margin-top: 35px;
            margin-bottom: 35px;
        }
        .doc-title-text {
            font-size: 13.5pt;
            font-weight: 800;
            color: #0f2438;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: inline-block;
        }

        /* SECCIONES Y TABLAS */
        .section-bar {
            background-color: #f8fafc;
            color: #0f2438;
            font-size: 7.8pt;
            font-weight: 700;
            padding: 5px 9px;
            letter-spacing: 0.4px;
            border-left: 3.5px solid #10b981;
            border-top: 1px solid #edf2f7;
            border-right: 1px solid #edf2f7;
            border-bottom: 1px solid #edf2f7;
            border-radius: 0 4px 4px 0;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .table-info td {
            padding: 5.5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 7.8pt;
            vertical-align: middle;
        }
        .table-info .lbl {
            background-color: #fbfcfd;
            color: #475569;
            font-weight: 600;
            width: 16%;
        }
        .table-info .val {
            color: #0f172a;
            width: 34%;
        }

        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .table-items th {
            background-color: #0f2438;
            color: #ffffff;
            padding: 7px 8px;
            font-size: 7.4pt;
            font-weight: 700;
            border: 1px solid #0f2438;
            letter-spacing: 0.4px;
        }
        .table-items td {
            padding: 8px;
            border: 1px solid #cbd5e1;
            font-size: 7.8pt;
            vertical-align: middle;
        }

        /* TOTALES */
        .table-totals-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .table-totals {
            width: 100%;
            border-collapse: collapse;
        }
        .table-totals td {
            padding: 5.5px 10px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
        }
        .table-totals .tot-lbl {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-align: right;
            width: 55%;
        }
        .table-totals .tot-val {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            color: #0f2438;
            width: 45%;
        }
        .row-grand-total td {
            background-color: #0f2438 !important;
            color: #ffffff !important;
            border: 1px solid #0f2438 !important;
            font-weight: bold;
            font-size: 8.8pt;
        }
        .row-grand-total .tot-val {
            color: #34d399 !important;
            font-size: 9.8pt;
        }

        /* FIRMAS */
        .table-signatures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .sig-empty-col {
            width: 58%;
        }
        .sig-right-col {
            width: 42%;
            text-align: center;
            vertical-align: bottom;
        }
        .sig-box {
            min-height: 55px;
            text-align: center;
            vertical-align: bottom;
            margin-bottom: 4px;
        }
        .sig-img {
            max-height: 55px;
            max-width: 200px;
            display: inline-block;
        }
        .sig-badge-approved {
            border: 1px solid #10b981;
            background-color: #ecfdf5;
            color: #047857;
            font-size: 7pt;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            letter-spacing: 0.5px;
        }
        .sig-line {
            border-top: 1.5px solid #0f2438;
            width: 100%;
            max-width: 220px;
            margin: 0 auto;
            padding-top: 4px;
            font-size: 7.3pt;
            line-height: 1.35;
            color: #475569;
        }

        .footer-fixed {
            position: fixed;
            bottom: 0mm;
            left: 0;
            right: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
            font-size: 7.2pt;
            color: #475569;
            text-align: center;
            line-height: 1.3;
        }
        .footer-fixed strong {
            color: #0f2438;
        }
    </style>
</head>
<body>

@php
    $pathFirmaGerente = file_exists(public_path('images/firma_gerente.JPG'))
        ? public_path('images/firma_gerente.JPG')
        : (file_exists(public_path('images/firma_gerente.jpg')) ? public_path('images/firma_gerente.jpg') : null);

    $estaAprobada = ($cotizacion->estado_cotizacion === 'Aceptada' || $cotizacion->estado_cotizacion === 'Aprobada' || $cotizacion->estado_cotizacion === 'Enviada' || str_contains($cotizacion->observaciones ?? '', '[APROBADO'));

    $montoTotal = (float) $cotizacion->monto_total;
    $subtotal   = $montoTotal / 1.18;
    $igv        = $montoTotal - $subtotal;

    $montoTotalObra = $montoTotalObra ?? (float) \App\Models\Cotizacion::where('obra_id', $cotizacion->obra_id)->sum('monto_total');

    $fechaEmisionCarbon = !empty($cotizacion->fecha_emision) ? \Carbon\Carbon::parse($cotizacion->fecha_emision) : now();
    $diasValidez = (int) ($cotizacion->validez_dias ?? 15);
    $fechaVencimientoCalculada = !empty($cotizacion->fecha_vencimiento)
        ? \Carbon\Carbon::parse($cotizacion->fecha_vencimiento)->format('d/m/Y')
        : $fechaEmisionCarbon->copy()->addDays($diasValidez)->format('d/m/Y');

    $asesorNombre = $cotizacion->comercial->name ?? ($cotizacion->user->name ?? 'Carlos Mendoza (Comercial)');
@endphp

<div class="footer-fixed">
    <strong>Dirección:</strong> PJ. Lima Nro. 115, Huánuco, Perú &nbsp;&bull;&nbsp; <strong>Central Telefónica:</strong> (062) 512345 &bull; contacto@dtlpremier.pe
</div>

<div class="page-container">

    <!-- CABECERA -->
    <table class="header-top-table">
        <tr>
            <td class="brand-left-cell">
                @if(file_exists(public_path('images/logo-dtl.png')))
                    <img src="{{ public_path('images/logo-dtl.png') }}" class="brand-logo-img" alt="DTL PREMIER">
                @else
                    <h1 style="color: #0f2438; margin: 0; font-size: 18pt; font-weight: 900;">DTL PREMIER</h1>
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

    <!-- I. DATOS DEL CLIENTE -->
    <div class="section-bar text-uppercase">I. INFORMACIÓN DE LA EMPRESA / CLIENTE</div>
    <table class="table-info">
        <tr>
            <td class="lbl">Razón Social:</td>
            <td colspan="3" class="val fw-bold text-navy">
                {{ $cotizacion->obra->cliente->razon_social ?? 'NO ESPECIFICADO' }}
            </td>
        </tr>
        <tr>
            <td class="lbl">RUC / DNI:</td>
            <td class="val font-mono fw-semibold">{{ $cotizacion->obra->cliente->ruc ?? '-' }}</td>
            <td class="lbl">Dirección:</td>
            <td class="val">{{ $cotizacion->obra->cliente->direccion ?? 'Huánuco, Perú' }}</td>
        </tr>
        <tr>
            <td class="lbl">Atención:</td>
            <td class="val">{{ $cotizacion->obra->cliente->nombre_contacto ?? 'Atención Dirección' }}</td>
            <td class="lbl">Teléfono:</td>
            <td class="val font-mono">{{ $cotizacion->obra->cliente->telefono_contacto ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Email:</td>
            <td colspan="3" class="val font-mono text-muted">{{ $cotizacion->obra->cliente->email_contacto ?? 'contacto@cliente.com' }}</td>
        </tr>
    </table>

    <!-- II. CONDICIONES GENERALES -->
    <div class="section-bar text-uppercase">II. CONDICIONES GENERALES Y PROYECTO</div>
    <table class="table-info">
        <tr>
            <td class="lbl">Proyecto:</td>
            <td colspan="3" class="val fw-bold text-navy">
                {{ $cotizacion->obra->titulo ?? 'PROYECTO GENERAL' }}
            </td>
        </tr>
        <tr>
            <td class="lbl">Código Obra:</td>
            <td class="val font-mono fw-semibold">{{ $cotizacion->obra->codigo ?? 'OBR-S/N' }}</td>
            <td class="lbl">Emisión:</td>
            <td class="val font-mono fw-semibold">{{ $fechaEmisionCarbon->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="lbl">Validez:</td>
            <td class="val">{{ $diasValidez }} días calendario</td>
            <td class="lbl">Vencimiento:</td>
            <td class="val font-mono fw-bold text-danger">{{ $fechaVencimientoCalculada }}</td>
        </tr>
        <tr>
            <td class="lbl">Asesor:</td>
            <td class="val">{{ $asesorNombre }}</td>
            <td class="lbl">Moneda:</td>
            <td class="val fw-bold text-green">Soles Peruanos (PEN / S/)</td>
        </tr>
    </table>

    <!-- III. ACTIVIDADES -->
    <div class="section-bar text-uppercase">III. DESCRIPCIÓN DE ACTIVIDADES Y ALCANCE</div>
    <table class="table-items">
        <thead>
            <tr class="text-uppercase">
                <th style="width: 6%;" class="text-center">ÍTEM</th>
                <th style="width: 58%; text-align: left;">DESCRIPCIÓN DETALLADA</th>
                <th style="width: 8%;" class="text-center">UND</th>
                <th style="width: 8%;" class="text-center">CANT.</th>
                <th style="width: 20%;" class="text-end">SUBTOTAL (S/)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center fw-bold text-navy">01</td>
                <td>
                    <strong class="text-navy" style="font-size: 8.2pt;">{{ $cotizacion->obra->titulo ?? 'Servicios Generales de Ingeniería y Construcción' }}</strong>
                    <div style="margin-top: 3px; font-size: 7.4pt; color: #475569; line-height: 1.35;">
                        Ejecución de actividades, suministro de materiales certificados y dotación de mano de obra técnica especializada según especificaciones técnicas. Incluye supervisión en seguridad (SST), herramientas, equipos menores y cumplimiento estricto de los estándares de calidad DTL PREMIER.
                    </div>
                </td>
                <td class="text-center font-mono">GLB</td>
                <td class="text-center font-mono fw-bold">1.00</td>
                <td class="text-end font-mono fw-bold text-navy" style="font-size: 8.6pt;">
                    {{ number_format($subtotal, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TOTALES -->
    <table class="table-totals-container">
        <tr>
            <td style="width: 55%;"></td>
            <td style="width: 45%; vertical-align: top;">
                <table class="table-totals">
                    <tr>
                        <td class="tot-lbl">Sub-Total Ventas:</td>
                        <td class="tot-val">S/ {{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="tot-lbl">I.G.V. (18.00%):</td>
                        <td class="tot-val">S/ {{ number_format($igv, 2) }}</td>
                    </tr>
                    <tr class="row-grand-total">
                        <td class="text-end" style="padding-right: 8px;">TOTAL PROPUESTA:</td>
                        <td class="tot-val">S/ {{ number_format($montoTotal, 2) }}</td>
                    </tr>
                    @if($montoTotalObra > 0)
                        <tr>
                            <td class="tot-lbl" style="padding-top: 5px;">TOTAL ACUMULADO OBRA:</td>
                            <td class="tot-val text-green fw-bold" style="padding-top: 5px;">S/ {{ number_format($montoTotalObra, 2) }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- FIRMA -->
    <table class="table-signatures">
        <tr>
            <td class="sig-empty-col"></td>
            <td class="sig-right-col">
                <div class="sig-box">
                    @if($estaAprobada && $pathFirmaGerente)
                        <img src="{{ $pathFirmaGerente }}" class="sig-img" alt="Firma Gerente">
                    @elseif($estaAprobada)
                        <div class="sig-badge-approved">
                            &bull; VISTO BUENO GERENCIA REGISTRADO &bull;
                        </div>
                    @else
                        <div style="height: 48px;"></div>
                    @endif
                </div>
                <div class="sig-line">
                    <strong class="text-navy" style="font-size: 8pt; display: block;">GERENCIA GENERAL</strong>
                    <span>GERENCIA GENERAL &bull; DTL PREMIER S.A.C.</span>
                </div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>