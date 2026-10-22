<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitas_tecnicas', function (Blueprint $table) {
            $table->id();
            // Relación con el cliente usando el RUC o ID de la tabla clientes
            $table->char('cliente_ruc', 11);
            $table->foreign('cliente_ruc')->references('ruc')->on('clientes')->onDelete('cascade');
            
            $table->string('ubicacion_obra'); // Dirección exacta de la inspección
            $table->string('servicio_requerido'); // Ej: Evaluación Estructural, Topografía
            $table->dateTime('fecha_programada'); // Fecha y hora de la visita
            $table->string('ingeniero_asignado'); // Ingeniero responsable (Ej: Ing. Carlos Mendoza)
            $table->enum('estado_visita', ['PENDIENTE', 'COMPLETADA', 'CANCELADA'])->default('PENDIENTE');
            $table->text('observaciones_campo')->nullable(); // Notas del ingeniero tras la visita
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Ejecutivo comercial que solicita
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitas_tecnicas');
    }
};