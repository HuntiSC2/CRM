<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $cotizacion->codigo_cotizacion }} - DTL PREMIER</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 1cm 1.2cm 1cm 1.2cm;
        }
        * {
            box-sizing: border-box;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }
        body {
            color: #1e293b;
            font-size: 8.2pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .page-container {
            width: 100%;
            margin: 0 auto;
        }

        .text-navy { color: #0c192c; }
        .text-green { color: #059669; }
        .font-mono { font-family: monospace; }
        .fw-bold { font-weight: bold; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-uppercase { text-transform: uppercase; }

        /* 1. ENCABEZADO SUPERIOR */
        .table-master-header {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .header-logo-cell {
            width: 42%;
            vertical-align: middle;
            padding-bottom: 20px;
            padding-top: 10px;
        }
        .header-info-cell {
            width: 58%;
            text-align: right;
            vertical-align: middle;
            font-size: 7.5pt;
            color: #334155;
            line-height: 1.35;
            padding-bottom: 20px;
            padding-top: 10px;
        }
        .header-line-cell {
            height: 3px;
            background-color: #0c192c;
            border-bottom: 2px solid #059669;
            padding: 0;
        }
        .title-left-cell {
            padding-top: 50px;
            vertical-align: middle;
            width: 70%;
        }
        .title-right-cell {
            padding-top: 50px;
            vertical-align: middle;
            text-align: right;
            width: 30%;
        }
        .title-main {
            font-size: 13.5pt;
            font-weight: 800;
            color: #0c192c;
            margin: 0;
            letter-spacing: 0.3px;
        }
        .title-sub {
            font-size: 7.6pt;
            color: #64748b;
            margin-top: 2px;
        }
        .badge-code {
            background-color: #0c192c;
            color: #ffffff;
            font-size: 9.5pt;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 4px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        /* 2. TABLAS CLIENTE Y PROYECTO */
        .section-header {
            background-color: #0c192c;
            color: #ffffff;
            font-size: 7.8pt;
            font-weight: bold;
            padding: 5px 9px;
            letter-spacing: 0.4px;
            border-left: 4px solid #059669;
            margin-top: 20px;
            margin-bottom: 4px;
            width: 100%;
            display: block;
        }

        .table-data {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .table-data td {
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
            vertical-align: middle;
        }
        .td-label {
            background-color: #f8fafc;
            font-weight: bold;
            color: #0c192c;
            width: 20%;
        }
        .td-value {
            color: #1e293b;
            width: 30%;
        }

        /* 3. TABLA DE ACTIVIDADES */
        .table-items {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .table-items th {
            background-color: #0c192c;
            color: #ffffff;
            padding: 7px 8px;
            font-size: 7.6pt;
            font-weight: bold;
            border: 1px solid #0c192c;
        }
        .table-items td {
            padding: 10px 8px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
        }

        /* 4. TOTALES */
        .table-totals-container {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .table-totals {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .table-totals td {
            padding: 7px 10px;
            font-size: 8.2pt;
            border: 1px solid #cbd5e1;
        }
        .total-row-highlight {
            background-color: #059669 !important;
            color: #ffffff !important;
            font-weight: bold;
            border: 1px solid #059669 !important;
        }

        /* 5. FIRMA */
        .table-signatures {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 80px;
        }
        .sig-col-right {
            width: 45%;
            text-align: center;
            vertical-align: bottom;
        }
        .sig-wrapper {
            height: 52px;
            margin-bottom: 2px;
            text-align: center;
            vertical-align: bottom;
        }
        .sig-img {
            max-height: 60px;
            max-width: 230px;
            display: inline-block;
        }
        .sig-bar {
            border-top: 1.5px solid #334155;
            width: 230px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 7.8pt;
            line-height: 1.35;
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

        // CÁLCULO SEGURO DE FECHAS (Evita que PHP reviente)
        $fechaEmisionCarbon = !empty($cotizacion->fecha_emision) ? \Carbon\Carbon::parse($cotizacion->fecha_emision) : now();
        $diasValidez = (int) ($cotizacion->validez_dias ?? 15);
        $fechaVencimientoCalculada = !empty($cotizacion->fecha_vencimiento) 
            ? \Carbon\Carbon::parse($cotizacion->fecha_vencimiento)->format('d/m/Y')
            : $fechaEmisionCarbon->copy()->addDays($diasValidez)->format('d/m/Y');
    @endphp

<div class="page-container">

    <!-- 1. ENCABEZADO SUPERIOR -->
    <table class="table-master-header">
        <tr>
            <td class="header-logo-cell">
                @if(file_exists(public_path('images/logo-dtl.png')))
                    <img src="{{ public_path('images/logo-dtl.png') }}" style="max-height: 55px;" alt="DTL PREMIER S.A.C.">
                @else
                    <h2 style="color: #0c192c; margin: 0; font-size: 16pt; font-weight: 900;">DTL PREMIER</h2>
                @endif
            </td>
            <td class="header-info-cell">
                <strong style="color: #059669; font-size: 8.8pt;">DTL PREMIER S.A.C.</strong> &bull; RUC: 20529193719<br>
                PJ. LIMA NRO. 115, Huánuco - Huánuco - Huánuco<br>
                Central: (062) 512345 &bull; comercial@dtlpremier.com &bull; www.dtlpremier.com
            </td>
        </tr>
        <tr>
            <td colspan="2" class="header-line-cell"></td>
        </tr>
        <tr>
            <td class="title-left-cell">
                <div class="title-main text-uppercase">PROPUESTA TÉCNICO - ECONÓMICA</div>
                <div class="title-sub">Construcción, Mantenimiento y Servicios Especializados de Ingeniería</div>
            </td>
            <td class="title-right-cell">
                <div class="badge-code font-mono">{{ $cotizacion->codigo_cotizacion }}</div>
            </td>
        </tr>
    </table>

    <!-- 2. TABLA 1: I. INFORMACIÓN DEL CLIENTE -->
    <div class="section-header text-uppercase">I. INFORMACIÓN DE LA EMPRESA / CLIENTE</div>
    <table class="table-data">
        <tr>
            <td class="td-label">Razón Social:</td>
            <td colspan="3" class="td-value fw-bold text-navy" style="font-size: 8.3pt;">
                {{ $cotizacion->obra->cliente->razon_social ?? 'NO ESPECIFICADO' }}
            </td>
        </tr>
        <tr>
            <td class="td-label">RUC / DNI:</td>
            <td class="td-value font-mono">{{ $cotizacion->obra->cliente->ruc ?? '-' }}</td>
            <td class="td-label">Dirección Fiscal:</td>
            <td class="td-value">{{ $cotizacion->obra->cliente->direccion ?? 'Huánuco, Perú' }}</td>
        </tr>
        <tr>
            <td class="td-label">Contacto Comercial:</td>
            <td class="td-value">{{ $cotizacion->obra->cliente->nombre_contacto ?? 'Atención Dirección' }}</td>
            <td class="td-label">Teléfono / Celular:</td>
            <td class="td-value font-mono">{{ $cotizacion->obra->cliente->telefono_contacto ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Email de Contacto:</td>
            <td colspan="3" class="td-value font-mono">{{ $cotizacion->obra->cliente->email_contacto ?? 'contacto@cliente.com' }}</td>
        </tr>
    </table>

    <!-- 3. TABLA 2: II. CONDICIONES GENERALES Y PROYECTO -->
    <div class="section-header text-uppercase">II. CONDICIONES GENERALES Y PROYECTO</div>
    <table class="table-data">
        <tr>
            <td class="td-label">Nombre Proyecto:</td>
            <td colspan="3" class="td-value fw-bold" style="font-size: 8.3pt;">
                {{ $cotizacion->obra->titulo ?? 'PROYECTO GENERAL' }}
            </td>
        </tr>
        <tr>
            <td class="td-label">Código Obra:</td>
            <td class="td-value font-mono fw-bold">{{ $cotizacion->obra->codigo ?? 'OBR-S/N' }}</td>
            <td class="td-label">Fecha Emisión:</td>
            <td class="td-value font-mono">{{ $fechaEmisionCarbon->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="td-label">Validez Comercial:</td>
            <td class="td-value">{{ $diasValidez }} días calendario</td>
            <td class="td-label">Fecha Vencimiento:</td>
            <td class="td-value font-mono fw-bold" style="color: #dc2626;">
                {{ $fechaVencimientoCalculada }}
            </td>
        </tr>
        <tr>
            <td class="td-label">Asesor Comercial:</td>
            <td class="td-value">{{ $cotizacion->comercial->name ?? 'Wilmer' }}</td>
            <td class="td-label">Moneda:</td>
            <td class="td-value fw-bold text-green">Soles Peruanos (PEN / S/)</td>
        </tr>
    </table>

    <!-- 4. TABLA 3: III. DESCRIPCIÓN DE ACTIVIDADES Y ALCANCE -->
    <div class="section-header text-uppercase">III. DESCRIPCIÓN DE ACTIVIDADES Y ALCANCE</div>
    <table class="table-items">
        <thead>
            <tr class="text-uppercase">
                <th style="width: 7%;" class="text-center">ÍTEM</th>
                <th style="width: 58%; text-align: left;">DESCRIPCIÓN DETALLADA DE ACTIVIDADES</th>
                <th style="width: 8%;" class="text-center">UND</th>
                <th style="width: 9%;" class="text-center">CANT.</th>
                <th style="width: 18%;" class="text-end">TOTAL NETO (S/)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center fw-bold align-top" style="padding-top: 10px;">01</td>
                <td>
                    <strong class="text-navy" style="font-size: 8.4pt;">{{ $cotizacion->obra->titulo ?? 'Servicios Generales de Ingeniería' }}</strong>
                    <p style="margin: 3px 0 0 0; font-size: 7.3pt; color: #475569; line-height: 1.35;">
                        Ejecución de actividades, suministro de materiales certificados y dotación de mano de obra técnica especializada según especificaciones técnicas. Incluye supervisión en seguridad (SST), herramientas, equipos menores y cumplimiento estricto de los estándares de calidad DTL PREMIER.
                    </p>
                </td>
                <td class="text-center align-middle font-mono">GLB</td>
                <td class="text-center align-middle fw-bold font-mono">1.00</td>
                <td class="text-end align-middle fw-bold font-mono" style="font-size: 8.8pt;">
                    {{ number_format($subtotal, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- 5. TABLA 4: TOTALES -->
    <table class="table-totals-container">
        <tr>
            <td style="width: 52%;"></td>
            <td style="width: 48%; vertical-align: top;">
                <table class="table-totals">
                    <tr>
                        <td class="td-label text-end" style="width: 55%; font-size: 7.8pt;">Sub-Total Ventas (S/):</td>
                        <td class="text-end fw-bold font-mono" style="width: 45%; font-size: 8.5pt;">{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="td-label text-end" style="font-size: 7.8pt;">I.G.V. (18.00%):</td>
                        <td class="text-end fw-bold font-mono" style="font-size: 8.5pt;">{{ number_format($igv, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="total-row-highlight text-end" style="font-size: 8.5pt;">TOTAL PROPUESTA (S/):</td>
                        <td class="total-row-highlight text-end font-mono" style="font-size: 9.8pt;">S/ {{ number_format($montoTotal, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- 6. FIRMA ÚNICA: GERENCIA GENERAL -->
    <table class="table-signatures">
        <tr>
            <td style="width: 55%;"></td>
            <td class="sig-col-right">
                <div class="sig-wrapper">
                    @if($estaAprobada && $pathFirmaGerente)
                        <img src="{{ $pathFirmaGerente }}" class="sig-img" alt="Firma Gerente">
                    @elseif($estaAprobada)
                        <div style="border: 1px solid #059669; background-color: #ecfdf5; color: #047857; font-size: 7pt; font-weight: bold; padding: 4px; border-radius: 4px; display: inline-block;">
                            &bull; VISTO BUENO GERENCIA REGISTRADO &bull;
                        </div>
                    @endif
                </div>
                <div class="sig-bar">
                    <strong class="text-navy" style="font-size: 8pt;">GERENCIA GENERAL</strong>
                </div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>