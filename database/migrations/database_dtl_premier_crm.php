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
        // 1. Tabla de Usuarios (Con roles y seguridad integrados)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('comercial'); // admin, comercial, gerente
            $table->integer('login_attempts')->default(0); 
            $table->boolean('is_active')->default(true); 
            $table->rememberToken();
            $table->timestamps();
        });

        // Tokens de restablecimiento de contraseña (Nativo Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Control de sesiones (Nativo Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 2. Tabla de Clientes (Directorio - Punto de partida del flujo)
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->char('ruc', 11)->unique(); 
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('nombre_contacto');
            $table->string('telefono_contacto', 20);
            $table->string('email_contacto');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'EN_EVALUACION'])->default('INACTIVO');
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });

        // 3. Tabla Principal de Obras (Pipeline / Kanban)
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); 
            $table->string('titulo'); 
            $table->decimal('monto', 12, 2)->default(0.00);
            $table->date('fecha');
            $table->enum('estado', ['Prospecto', 'Inspeccion', 'Cotización', 'Cierre Comercial', 'Aceptada', 'Cancelada'])->default('Prospecto');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });

        // 4. Tabla de Inspecciones Técnicas
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ingeniero_asignado'); 
            $table->dateTime('fecha_inspeccion');
            $table->text('resultado')->nullable();
            $table->enum('estado_inspeccion', ['Registrada', 'Pendiente', 'Completada', 'Cancelada'])->default('Registrada');
            $table->timestamps();
        });

        // 5. Tabla de Bitácoras (Historial e incidencias)
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->text('comentario');
            $table->string('tipo_contacto')->default('Reunión'); 
            $table->string('archivo_path')->nullable(); 
            $table->timestamps();
        });

        // 6. Tabla de Cotizaciones (Optimizada para control del sistema)
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Auditoría: Quién emitió la cotización
            $table->string('codigo_cotizacion')->unique();
            $table->decimal('monto_total', 12, 2);
            
            // Fechas de control gobernadas por el backend
            $table->date('fecha_emision');
            $table->integer('validez_dias')->default(15);
            $table->date('fecha_vencimiento'); // Calculada automáticamente por el sistema al emitir
            
            // Estados controlados estrictamente por la lógica de negocio
            $table->enum('estado_cotizacion', [
                'Registrada', 
                'Enviada', 
                'Aceptada', 
                'Rechazada', 
                'Vencida', 
                'Reemplazada'
            ])->default('Registrada');


           

            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable(); 
            
            // Control de versiones para enlazar re-cotizaciones de una misma obra
            $table->unsignedBigInteger('cotizacion_padre_id')->nullable();
            $table->foreign('cotizacion_padre_id')->references('id')->on('cotizaciones')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
        Schema::dropIfExists('bitacoras');
        Schema::dropIfExists('inspecciones');
        Schema::dropIfExists('obras');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};





