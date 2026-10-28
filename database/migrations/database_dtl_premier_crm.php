_<?php

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
            // Campos de control y roles
            $table->string('role')->default('comercial'); // admin, comercial, gerente
            $table->integer('login_attempts')->default(0); // Control de intentos fallidos
            $table->boolean('is_active')->default(true); // Bloqueo de cuenta
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

        // 2. Tabla de Clientes (Directorio)
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->char('ruc', 11)->unique(); // RUC de 11 dígitos
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('nombre_contacto');
            $table->string('telefono_contacto', 20);
            $table->string('email_contacto');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'EN_EVALUACION'])->default('ACTIVO');
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Ejecutivo asignado
            $table->timestamps();
        });

        // 3. Tabla Principal de Obras (Pipeline / Kanban con los 3 estados exactos)
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej: #OBR-101
            $table->string('titulo'); 
            $table->decimal('monto', 12, 2)->default(0.00);
            $table->date('fecha');
            // Los 3 estados definidos para tu Kanban
            $table->enum('estado', ['Inspeccion', 'Cotizado', 'Aprobado'])->default('Inspeccion');
            
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Comercial responsable
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
            $table->enum('estado_inspeccion', ['Pendiente', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->timestamps();
        });

        // 5. Tabla de Bitácoras (Historial e incidencias con captura automática de sesión)
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Se registra solo desde la sesión
            $table->text('comentario');
            $table->string('tipo_contacto')->default('Reunión'); // Llamada, Visita, WhatsApp, Correo
            $table->string('archivo_path')->nullable(); // Para adjuntar fotos o minutas
            $table->timestamps();
        });

        // 6. Tabla de Cotizaciones
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->string('codigo_cotizacion');
            $table->decimal('monto_total', 12, 2);
            $table->enum('estado_cotizacion', ['Borrador', 'Enviada', 'Aceptada', 'Rechazada'])->default('Borrador');
            $table->integer('validez_dias')->default(15);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Se eliminan en orden inverso estricto para evitar conflictos de claves foráneas
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