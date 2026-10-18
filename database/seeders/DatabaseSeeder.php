<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuario Administrador / Soporte Técnico (Acceso Total y Seguridad)
        User::create([
            'name' => 'Soporte Técnico',
            'email' => 'soporte_tecnico@dtl.premier',
            'password' => Hash::make('soporteWWm.14'),
            'role' => 'administrador',
            'is_active' => true,
        ]);

        // 2. Usuario Ejecutivo Comercial (Gestión de Clientes y Contratistas - HU-02)
        User::create([
            'name' => 'Asesor Comercial',
            'email' => 'asesor_comercial@dtl.premier',
            'password' => Hash::make('asesorCRm.14'),
            'role' => 'ejecutivo',
            'is_active' => true,
        ]);
          User::create([
            'name' => 'Gerencia General',
            'email' => 'supervisor@dtl.premier',
            'password' => Hash::make('supervisorEVEr.14'),
            'role' => 'directivo',
            'is_active' => true,
        ]);
    }
}