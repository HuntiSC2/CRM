<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('comercial'); // roles: admin, comercial, soporte
            $table->integer('login_attempts')->default(0); // Criterio: control de intentos fallidos
            $table->boolean('is_active')->default(true);   // Estado de cuenta (Bloqueo al 3er intento)
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'login_attempts', 'is_active']);
        });
    }
};
