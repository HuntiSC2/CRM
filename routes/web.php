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

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Invitados
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Hub Principal
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// PDF Cotización
Route::middleware(['auth'])->prefix('comercial')->name('comercial.')->group(function () {
    Route::get('/cotizador/{id}/pdf', [CotizadorController::class, 'generarPdf'])->name('cotizador.pdf');
});

// Módulo Comercial
Route::middleware(['auth', 'role:ejecutivo'])->prefix('comercial')->name('comercial.')->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/check-ruc', [ClienteController::class, 'checkRuc'])->name('clientes.checkRuc');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');

    // Pipeline Kanban y Motor Operativo Central
    Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::post('/pipeline', [PipelineController::class, 'store'])->name('pipeline.store');
    Route::post('/pipeline/update-status', [PipelineController::class, 'updateStatus'])->name('pipeline.updateStatus');
    Route::match(['get', 'post'], '/pipeline/archivar', [PipelineController::class, 'archivar'])->name('pipeline.archivar');
    Route::get('/pipeline/historial', [PipelineController::class, 'historial'])->name('pipeline.historial');
    Route::post('/pipeline/eliminar', [PipelineController::class, 'eliminar'])->name('pipeline.eliminar');
    
    // Acciones de Hitos Técnicos (El Imán del Pipeline)
    Route::post('/pipeline/agendar-inspeccion', [PipelineController::class, 'agendarInspeccion'])->name('pipeline.agendarInspeccion');
    Route::post('/pipeline/completar-inspeccion', [PipelineController::class, 'completarInspeccion'])->name('pipeline.completarInspeccion');
    Route::post('/pipeline/programar-cotizacion', [PipelineController::class, 'programarCotizacion'])->name('pipeline.programarCotizacion');
    Route::post('/pipeline/enviar-cotizacion', [PipelineController::class, 'enviarCotizacion'])->name('pipeline.enviarCotizacion');
    Route::post('/pipeline/agregar-bitacora', [PipelineController::class, 'agregarBitacora'])->name('pipeline.agregarBitacora');
    
    // Módulos de Auditoría y Consulta Histórica
    Route::get('/inspecciones', [InspeccionController::class, 'index'])->name('visitas.index');
    Route::patch('/inspecciones/{id}/completar', [InspeccionController::class, 'completar'])->name('visitas.completar');

    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::post('/bitacora', [BitacoraController::class, 'store'])->name('bitacora.store');

    Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador.index');
});

// Módulo Gerencia / Directorio
Route::middleware(['auth', 'role:directivo'])->prefix('gerencia')->name('gerencia.')->group(function () {
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

Route::middleware(['auth', 'role:directivo'])->get('/directorio', function () {
    return redirect()->route('gerencia.dashboard');
})->name('directorio.index');

Route::middleware(['auth', 'role:administrador'])->prefix('soporte')->name('soporte.')->group(function () {
    // Rutas de administración
});