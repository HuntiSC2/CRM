<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. USUARIOS DEL SISTEMA / DIRECTORIO INSTITUCIONAL
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['administrador', 'directivo', 'ejecutivo'])->default('ejecutivo');
            $table->integer('login_attempts')->default(0);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. RECUPERACIÓN DE CONTRASEÑA
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. SESIONES
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 4. CLIENTES / DIRECTORIO COMERCIAL
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->char('ruc', 11)->unique();
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('nombre_contacto');
            $table->string('telefono_contacto', 20);
            $table->string('email_contacto');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'EN_EVALUACION'])->default('INACTIVO')->index();
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 5. OBRAS / EXPEDIENTES (KANBAN)
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('titulo');
            $table->decimal('monto', 12, 2)->default(0.00);
            $table->date('fecha');
            $table->enum('estado', [
                'Prospecto',
                'Inspeccion',
                'Cotización',
                'Cierre Comercial',
                'Aceptada',
                'Cancelada',
                'Perdida'
            ])->default('Prospecto')->index();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 6. INSPECCIONES TÉCNICAS
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ingeniero_asignado');
            $table->dateTime('fecha_inspeccion');
            $table->text('resultado')->nullable();
            $table->enum('estado_inspeccion', ['Pendiente', 'Completada'])->default('Pendiente')->index();
            $table->timestamps();
        });

        // 7. BITÁCORAS DE SEGUIMIENTO
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comentario');
            $table->string('tipo_contacto')->default('Reunión');
            $table->string('archivo_path')->nullable();
            $table->timestamps();
        });

        // 8. COTIZACIONES
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('codigo_cotizacion')->unique();
            $table->decimal('monto_total', 12, 2)->default(0.00);
            $table->date('fecha_emision');
            $table->integer('validez_dias')->default(15);
            $table->dateTime('fecha_vencimiento')->nullable();
            $table->enum('estado_cotizacion', [
                'Programada',
                'Enviada',
                'Aceptada',
                'Rechazada',
            ])->default('Programada')->index();
            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();
        });

        // 9. CATÁLOGO MAESTRO DE PARTIDAS
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('codigo', 30)->unique();
            $table->string('descripcion', 255);
            $table->string('categoria', 100)->default('Obras Civiles');
            $table->string('unidad_medida', 20);
            $table->decimal('precio_unitario', 12, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 10. HISTORIAL DE PRECIOS UNITARIOS
        Schema::create('historial_precios_partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partidas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('precio_anterior', 12, 2);
            $table->decimal('precio_nuevo', 12, 2);
            $table->string('motivo_cambio', 255)->nullable();
            $table->timestamps();
        });

        // 11. DETALLES DE COTIZACIÓN
        Schema::create('cotizacion_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('partida_id')->constrained('partidas')->onDelete('restrict');
            $table->decimal('cantidad', 10, 2)->default(1.00);
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        // 12. POLÍTICAS INSTITUCIONALES SLA
        Schema::create('sla_politicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('etapa_evaluada', ['VISITA_INSPECCION', 'COTIZACION_PROPUESTA']);
            $table->integer('tiempo_limite_horas');
            $table->enum('nivel_severidad', ['AMARILLO', 'ROJO']);
            $table->string('email_notificacion', 150);
            $table->boolean('notificacion_activa')->default(true);
            $table->timestamps();
        });

        // 13. LOG AUDITABLE DE ALERTAS SLA
        Schema::create('sla_alertas_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('sla_politica_id')->constrained('sla_politicas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('horas_retraso_detectadas');
            $table->enum('estado_alerta', ['VIGENTE', 'RESUELTA'])->default('VIGENTE')->index();
            $table->timestamp('fecha_disparo')->useCurrent();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sla_alertas_logs');
        Schema::dropIfExists('sla_politicas');
        Schema::dropIfExists('cotizacion_detalles');
        Schema::dropIfExists('historial_precios_partidas');
        Schema::dropIfExists('partidas');
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