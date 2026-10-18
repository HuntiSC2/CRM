<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Comercial\ClienteController;
use App\Http\Controllers\DashboardController;

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
// Módulo Comercial: Gestión de Clientes / Contratistas (HU-02)
// Acceso protegido para el rol 'ejecutivo'
// =========================================================================
Route::middleware(['auth', 'role:ejecutivo'])->prefix('comercial')->name('comercial.')->group(function () {
    
    // Directorio / Listado de Clientes (comercial.clientes.index)
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

    // Formulario para Registrar Nueva Ficha
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');

    // Endpoint AJAX ultraligero para detección en tiempo real de RUC duplicado
    Route::get('/clientes/check-ruc', [ClienteController::class, 'checkRuc'])->name('clientes.checkRuc');

    // Guardar Ficha en MySQL
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
});

// =========================================================================
// Módulo Gerencia: Supervisión Ejecutiva (Rol 'directivo')
// =========================================================================
Route::middleware(['auth', 'role:directivo'])->prefix('gerencia')->name('gerencia.')->group(function () {
    // Rutas del panel gerencial para el próximo sprint
});

// =========================================================================
// Módulo Soporte y Seguridad: Control Total (Rol 'administrador')
// =========================================================================
Route::middleware(['auth', 'role:administrador'])->prefix('soporte')->name('soporte.')->group(function () {
    // Rutas de auditoría y seguridad para el próximo sprint
});