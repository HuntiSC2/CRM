<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Redirección inicial a la vista de login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Invitados (Login)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rutas Protegidas para Administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// Rutas Protegidas para el Departamento Comercial
Route::middleware(['auth', 'role:comercial'])->group(function () {
    Route::get('/comercial/dashboard', function () {
        return view('comercial.dashboard');
    });
});