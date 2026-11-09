<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        // Modifica la columna enum permitiendo todos los nuevos estados comerciales
        DB::statement("ALTER TABLE cotizaciones MODIFY COLUMN estado_cotizacion ENUM('Programada', 'Aprobada', 'Enviada', 'Aceptada', 'Rechazada', 'Vencida', 'Reemplazada') DEFAULT 'Programada';");
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        // Opcional: Vuelve al estado anterior en caso de un rollback
        DB::statement("ALTER TABLE cotizaciones MODIFY COLUMN estado_cotizacion ENUM('Programada', 'Pendiente', 'Aprobada') DEFAULT 'Programada';");
    }
};