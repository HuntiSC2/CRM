<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Comercial\DashboardController;
use App\Http\Controllers\Comercial\PipelineController;

// Controladores Comerciales
use App\Http\Controllers\Comercial\ClienteController;
use App\Http\Controllers\Comercial\InspeccionController;
use App\Http\Controllers\Comercial\BitacoraController;
use App\Http\Controllers\Comercial\CotizadorController;

// Controladores de Gerencia (HU-07 y HU-10)
use App\Http\Controllers\Gerente\AprobacionCotizacionController;
use App\Http\Controllers\Gerente\DashboardGerencialController;

use App\Http\Controllers\Soporte\PartidaController;
use App\Http\Controllers\Soporte\SlaController;

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Invitados
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Hub Principal (Dashboard de Selección de Módulos)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// PDF Cotización (Accesible por cualquier usuario autenticado)
Route::middleware(['auth'])->prefix('comercial')->name('comercial.')->group(function () {
    Route::get('/cotizador/{id}/pdf', [CotizadorController::class, 'generarPdf'])->name('cotizador.pdf');
});

// =========================================================================
// 1. MÓDULO COMERCIAL (FRONT-OFFICE)
// Permitido para: Asesor (ejecutivo), Gerente (directivo) y Administrador
// =========================================================================
Route::middleware(['auth', 'role:ejecutivo,directivo,administrador'])->prefix('comercial')->name('comercial.')->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/check-ruc', [ClienteController::class, 'checkRuc'])->name('clientes.checkRuc');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::patch('/clientes/{id}/toggle-estado', [ClienteController::class, 'toggleEstado'])->name('clientes.toggleEstado');

    // Pipeline Kanban y Motor Operativo Central
    Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::post('/pipeline', [PipelineController::class, 'store'])->name('pipeline.store');
    Route::post('/pipeline/update-status', [PipelineController::class, 'updateStatus'])->name('pipeline.updateStatus');
    Route::match(['get', 'post'], '/pipeline/archivar', [PipelineController::class, 'archivar'])->name('pipeline.archivar');
    Route::get('/pipeline/historial', [PipelineController::class, 'historial'])->name('pipeline.historial');
    Route::post('/pipeline/eliminar', [PipelineController::class, 'eliminar'])->name('pipeline.eliminar');
    
    // Acciones de Hitos Técnicos (El Imán del Pipeline)
    Route::post('/pipeline/agendar-inspeccion', [PipelineController::class, 'agendarInspeccion'])->name('pipeline.agendarInspeccion');
    Route::post('/pipeline/reprogramar-inspeccion', [PipelineController::class, 'reprogramarInspeccion'])->name('pipeline.reprogramarInspeccion');
    Route::post('/pipeline/completar-inspeccion', [PipelineController::class, 'completarInspeccion'])->name('pipeline.completarInspeccion');
    Route::post('/pipeline/programar-cotizacion', [PipelineController::class, 'programarCotizacion'])->name('pipeline.programarCotizacion');
    Route::post('/pipeline/reprogramar-cotizacion', [PipelineController::class, 'reprogramarCotizacion'])->name('pipeline.reprogramarCotizacion');
    Route::post('/pipeline/enviar-cotizacion', [PipelineController::class, 'enviarCotizacion'])->name('pipeline.enviarCotizacion');
    Route::post('/pipeline/ajustar-precio', [PipelineController::class, 'ajustarPrecioCotizacion'])->name('pipeline.ajustarPrecio');
    Route::post('/pipeline/responder-cotizacion', [PipelineController::class, 'responderCotizacion'])->name('pipeline.responderCotizacion');
    Route::post('/pipeline/trasladar-cierre', [PipelineController::class, 'trasladarACierre'])->name('pipeline.trasladarCierre');
    Route::post('/pipeline/cerrar-obra-perdida', [PipelineController::class, 'cerrarObraPerdida'])->name('pipeline.cerrarObraPerdida');
    Route::post('/pipeline/agregar-bitacora', [PipelineController::class, 'agregarBitacora'])->name('pipeline.agregarBitacora');
    
    // Módulos de Auditoría y Consulta Histórica
    Route::get('/inspecciones', [InspeccionController::class, 'index'])->name('visitas.index');
    Route::patch('/inspecciones/{id}/completar', [InspeccionController::class, 'completar'])->name('visitas.completar');

    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::post('/bitacora', [BitacoraController::class, 'store'])->name('bitacora.store');

    Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador.index');
    Route::get('/partidas-catalogo', [PipelineController::class, 'obtenerPartidasCatalogo'])->name('partidas.catalogo');
});

// =========================================================================
// 2. MÓDULO GERENCIAL (GESTIÓN EJECUTIVA)
// Permitido para: Gerente (directivo) y Administrador
// =========================================================================
Route::middleware(['auth', 'role:directivo,administrador'])->prefix('gerencia')->name('gerencia.')->group(function () {
    Route::get('/dashboard', [DashboardGerencialController::class, 'index'])->name('dashboard');
    Route::get('/aprobaciones', [AprobacionCotizacionController::class, 'index'])->name('aprobaciones.index');
    
    Route::patch('/aprobaciones/{cotizacion}/aceptar', [AprobacionCotizacionController::class, 'aceptar'])->name('aprobaciones.aceptar');
    Route::patch('/aprobaciones/{cotizacion}/aprobar', [AprobacionCotizacionController::class, 'aceptar'])->name('aprobaciones.aprobar');
    Route::patch('/aprobaciones/{cotizacion}/rechazar', [AprobacionCotizacionController::class, 'rechazar'])->name('aprobaciones.rechazar');

    Route::patch('/aprobaciones', function (Request $request) {
        if ($request->filled('cotizacion_id')) {
            $cotizacion = Cotizacion::findOrFail($request->input('cotizacion_id'));
            if ($request->filled('motivo_rechazo')) {
                return app(AprobacionCotizacionController::class)->rechazar($request, $cotizacion);
            }
            return app(AprobacionCotizacionController::class)->aceptar($cotizacion);
        }
        return back()->with('error', 'No se pudo identificar la cotización.');
    });
});

Route::middleware(['auth', 'role:directivo,administrador'])->get('/directorio', function () {
    return redirect()->route('gerencia.dashboard');
})->name('directorio.index');

// =========================================================================
// 3. MÓDULO DE SOPORTE Y AJUSTES (BACK-OFFICE)
// Exclusivo para: Administrador
// =========================================================================
Route::middleware(['auth', 'role:administrador'])->prefix('soporte')->name('soporte.')->group(function () {
    // HU-09: Catálogo de Partidas e Historial
    Route::get('/partidas', [PartidaController::class, 'index'])->name('partidas.index');
    Route::post('/partidas', [PartidaController::class, 'store'])->name('partidas.store');
    Route::put('/partidas/{id}', [PartidaController::class, 'update'])->name('partidas.update');
    Route::delete('/partidas/{id}', [PartidaController::class, 'destroy'])->name('partidas.destroy');

    // HU-08: Alertas Semafóricas y SLAs
    Route::get('/sla', [SlaController::class, 'index'])->name('sla.index');
    Route::post('/sla/actualizar', [SlaController::class, 'update'])->name('sla.actualizar');
});