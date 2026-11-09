<?php

namespace App\Http\Controllers\Gerente;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardGerencialController extends Controller
{
    public function index(Request $request): View
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfYear()->toDateString());
        $fechaFin    = $request->input('fecha_fin', Carbon::now()->endOfYear()->toDateString());

        $desde = Carbon::parse($fechaInicio)->startOfDay();
        $hasta = Carbon::parse($fechaFin)->endOfDay();

        // Query Base vinculando obras y clientes
        $baseQuery = Cotizacion::whereBetween('fecha_emision', [$desde, $hasta])
            ->join('obras', 'cotizaciones.obra_id', '=', 'obras.id')
            ->join('clientes', 'obras.cliente_id', '=', 'clientes.id');

        $totalCotizaciones    = (clone $baseQuery)->count();
        $cotizacionesGanadas  = (clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Aceptada')->count();
        $cotizacionesPerdidas = (clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Rechazada')->count();
        $cotizacionesEnviadas = (clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Enviada')->count();

        $montoEfectivoSql = 'CASE WHEN cotizaciones.monto_total > 0 THEN cotizaciones.monto_total ELSE COALESCE(obras.monto, 0) END';

        $montoCotizadoTotal = (float)(clone $baseQuery)->selectRaw("SUM({$montoEfectivoSql}) as total")->value('total') ?? 0.0;
        $montoGanadoTotal   = (float)(clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Aceptada')->selectRaw("SUM({$montoEfectivoSql}) as total")->value('total') ?? 0.0;
        $montoPerdidoTotal  = (float)(clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Rechazada')->selectRaw("SUM({$montoEfectivoSql}) as total")->value('total') ?? 0.0;
        $montoEnNegociacion = (float)(clone $baseQuery)->where('cotizaciones.estado_cotizacion', 'Enviada')->selectRaw("SUM({$montoEfectivoSql}) as total")->value('total') ?? 0.0;

        $totalCerrado = $montoGanadoTotal + $montoPerdidoTotal;
        $winRateFinanciero = $totalCerrado > 0 ? round(($montoGanadoTotal / $totalCerrado) * 100, 1) : 0.0;
        $tasaConversion = $totalCotizaciones > 0 ? round(($cotizacionesGanadas / $totalCotizaciones) * 100, 1) : 0.0;

        $promedioDias = (clone $baseQuery)
            ->selectRaw('AVG(DATEDIFF(cotizaciones.fecha_emision, obras.fecha)) as dias_promedio')
            ->value('dias_promedio');
        $tiempoPromedioRespuesta = $promedioDias ? round(max(0, (float)$promedioDias), 1) : 0.0;

        // 1. Dona: Estados
        $distribucionRaw = (clone $baseQuery)
            ->select('cotizaciones.estado_cotizacion', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('cotizaciones.estado_cotizacion')
            ->pluck('cantidad', 'cotizaciones.estado_cotizacion')
            ->toArray();

        $montosRaw = (clone $baseQuery)
            ->select('cotizaciones.estado_cotizacion', DB::raw("SUM({$montoEfectivoSql}) as total_monto"))
            ->groupBy('cotizaciones.estado_cotizacion')
            ->pluck('total_monto', 'cotizaciones.estado_cotizacion')
            ->toArray();

        $estadosEnum = ['Programada', 'Enviada', 'Aceptada', 'Rechazada'];
        $chartData = [];
        $chartMontosData = [];
        foreach ($estadosEnum as $estado) {
            $chartData[$estado] = (int)($distribucionRaw[$estado] ?? 0);
            $chartMontosData[$estado] = (float)($montosRaw[$estado] ?? 0.0);
        }

        // 2. Gráfico Evolución Mensual
        $mesesData = (clone $baseQuery)
            ->select(
                DB::raw("DATE_FORMAT(cotizaciones.fecha_emision, '%Y-%m') as mes_clave"),
                DB::raw("DATE_FORMAT(cotizaciones.fecha_emision, '%b %Y') as mes_nombre"),
                DB::raw("SUM({$montoEfectivoSql}) as total_cotizado"),
                DB::raw("SUM(CASE WHEN cotizaciones.estado_cotizacion = 'Aceptada' THEN {$montoEfectivoSql} ELSE 0 END) as total_ganado")
            )
            ->groupBy('mes_clave', 'mes_nombre')
            ->orderBy('mes_clave', 'asc')
            ->get();

        $historicoLabels   = $mesesData->pluck('mes_nombre')->toArray();
        $historicoCotizado = $mesesData->pluck('total_cotizado')->map(fn($v) => (float)$v)->toArray();
        $historicoGanado   = $mesesData->pluck('total_ganado')->map(fn($v) => (float)$v)->toArray();

        // 3. NUEVO GRÁFICO: Top 5 Clientes Principales por Monto de Proyecto
        $topClientesData = (clone $baseQuery)
            ->select(
                'clientes.razon_social',
                DB::raw("SUM({$montoEfectivoSql}) as total_cliente")
            )
            ->groupBy('clientes.id', 'clientes.razon_social')
            ->orderByDesc('total_cliente')
            ->limit(5)
            ->get();

        $clientesLabels = $topClientesData->pluck('razon_social')->map(fn($nombre) => strlen($nombre) > 18 ? substr($nombre, 0, 16) . '...' : $nombre)->toArray();
        $clientesMontos = $topClientesData->pluck('total_cliente')->map(fn($v) => (float)$v)->toArray();

        return view('gerencia.hu-10.index', compact(
            'fechaInicio',
            'fechaFin',
            'totalCotizaciones',
            'cotizacionesGanadas',
            'cotizacionesPerdidas',
            'cotizacionesEnviadas',
            'tasaConversion',
            'winRateFinanciero',
            'tiempoPromedioRespuesta',
            'montoCotizadoTotal',
            'montoGanadoTotal',
            'montoPerdidoTotal',
            'montoEnNegociacion',
            'chartData',
            'chartMontosData',
            'historicoLabels',
            'historicoCotizado',
            'historicoGanado',
            'clientesLabels',
            'clientesMontos'
        ));
    }
}