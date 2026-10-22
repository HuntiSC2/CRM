<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PipelineController;

// Importaciones de los controladores del Módulo Comercial
use App\Http\Controllers\Comercial\ClienteController;
use App\Http\Controllers\Comercial\VisitaTecnicaController;
use App\Http\Controllers\Comercial\BitacoraController;
use App\Http\Controllers\Comercial\CotizadorController;

// Redirección inicial a la vista de login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Invitados (Login y Logout)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// =========================================================================
// Panel de Control Unificado (Dashboard)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// =========================================================================
// Módulo Comercial: Gestión Completa (HU-02, HU-03, HU-04, HU-05 y HU-06)
// Acceso protegido para el rol 'ejecutivo'
// =========================================================================
Route::middleware(['auth', 'role:ejecutivo'])->prefix('comercial')->name('comercial.')->group(function () {
    
    // HU-02: Directorio de Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/check-ruc', [ClienteController::class, 'checkRuc'])->name('clientes.checkRuc');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // HU-03: Pipeline CRM / Tablero Kanban
    Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::post('/pipeline/update-status', [PipelineController::class, 'updateStatus'])->name('pipeline.updateStatus');

    // HU-04: Visitas Técnicas e Inspección a Obra
    Route::get('/visitas', [VisitaTecnicaController::class, 'index'])->name('visitas.index');
    Route::post('/visitas', [VisitaTecnicaController::class, 'store'])->name('visitas.store');

    // HU-05: Bitácora CRM y Cronología de Interacciones
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::post('/bitacora', [BitacoraController::class, 'store'])->name('bitacora.store');

    // HU-06: Cotizador Express y Generador PDF Membretado
    Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador.index');
    Route::post('/cotizador/pdf', [CotizadorController::class, 'generarPdf'])->name('cotizador.pdf');
});

// =========================================================================
// Módulo Gerencia: Supervisión Ejecutiva (Rol 'directivo')
// =========================================================================
Route::middleware(['auth', 'role:directivo'])->prefix('gerencia')->name('gerencia.')->group(function () {
    // Rutas del panel gerencial
});

// =========================================================================
// Módulo Soporte y Seguridad: Control Total (Rol 'administrador')
// =========================================================================
Route::middleware(['auth', 'role:administrador'])->prefix('soporte')->name('soporte.')->group(function () {
    // Rutas de auditoría y seguridad
});