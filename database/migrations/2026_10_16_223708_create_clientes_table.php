<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->char('ruc', 11)->unique(); // Criterio 1: RUC único de 11 dígitos
            $table->string('razon_social');    // Criterio 2: Razón Social
            $table->string('direccion')->nullable(); // Dirección fiscal / Oficina principal
            $table->string('nombre_contacto'); // Criterio 2: Persona de contacto
            $table->string('telefono_contacto', 20); // Teléfono del contacto
            $table->string('email_contacto');  // Criterio 2: Correo electrónico
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'EN_EVALUACION'])->default('ACTIVO');
            $table->text('observaciones')->nullable(); // Notas en texto plano (sin PDFs por límite de hardware)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Auditoría: Ejecutivo comercial que registró
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};