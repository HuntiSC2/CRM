<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index()
    {
        // Las 5 columnas requeridas según la HU-03
        $statuses = ['Contactado', 'Visita', 'Cotizado', 'Aprobado', 'Perdido'];

        // Obras simuladas para renderizado inmediato
        $obras = [
            'Contactado' => [
                ['id' => 101, 'titulo' => 'Remodelación Oficinas San Isidro', 'cliente' => 'Grupo Vega S.A.C.', 'monto' => 'S/ 45,000', 'fecha' => '20/10/2026'],
                ['id' => 102, 'titulo' => 'Construcción Almacén Lurín', 'cliente' => 'Logística del Sur', 'monto' => 'S/ 120,000', 'fecha' => '22/10/2026'],
            ],
            'Visita' => [
                ['id' => 103, 'titulo' => 'Mantenimiento Planta Industrial', 'cliente' => 'Corp. Alicorp', 'monto' => 'S/ 85,000', 'fecha' => '18/10/2026'],
            ],
            'Cotizado' => [
                ['id' => 104, 'titulo' => 'Cimentación Obras Civiles Lote B', 'cliente' => 'Constructora Patria', 'monto' => 'S/ 210,000', 'fecha' => '15/10/2026'],
            ],
            'Aprobado' => [
                ['id' => 105, 'titulo' => 'Pavimentación Acceso Principal', 'cliente' => 'Municipalidad de Lima', 'monto' => 'S/ 340,000', 'fecha' => '12/10/2026'],
            ],
            'Perdido' => [
                ['id' => 106, 'titulo' => 'Saneamiento de Terreno Miraflores', 'cliente' => 'Inmobiliaria DTL', 'monto' => 'S/ 30,000', 'fecha' => '05/10/2026'],
            ]
        ];

        return view('comercial.pipeline.index', compact('statuses', 'obras'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'obra_id' => 'required',
            'nuevo_estado' => 'required|string',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado de la obra actualizado correctamente en el Kanban.'
        ]);
    }
}