<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. CREACIÓN DE USUARIOS DEL SISTEMA
        // ==========================================
        
        $admin = User::create([
            'name' => 'Soporte Técnico',
            'email' => 'soporte_tecnico@dtl.premier',
            'password' => Hash::make('soporteWWm.14'),
            'role' => 'administrador',
            'is_active' => true,
        ]);

        $comercial = User::create([
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

        // ==========================================
        // 2. CREACIÓN DE CLIENTES (EMPRESAS CONSTRUCTORAS) - 15 REGISTROS
        // ==========================================
        
        $clientes = [
            [
                'ruc' => '20100017491',
                'razon_social' => 'COSAPI S.A. ORGANIZACION DE INGENIERIA Y CONSTRUCCION',
                'direccion' => 'Av. Javier Prado Este 4200, Surco, Lima',
                'nombre_contacto' => 'Ing. Roberto Benavides',
                'telefono_contacto' => '+51 987654321',
                'email_contacto' => 'rbenavides@cosapi.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Cliente prioritario para proyectos de infraestructura vial y edificaciones corporativas.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20100154308',
                'razon_social' => 'AIG - AESA INFRAESTRUCTURA Y MINERIA S.A.C.',
                'direccion' => 'Av. Primavera 120, Piso 8, Chacarilla, San Borja, Lima',
                'nombre_contacto' => 'Lic. Sofia Ramos',
                'telefono_contacto' => '+51 912345678',
                'email_contacto' => 'contacto@aesa.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Contratista especializado en obras subterráneas y movimiento de tierras.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20504825911',
                'razon_social' => 'JJ CEXA S.A.C. CONTRATISTAS GENERALES',
                'direccion' => 'Calle Las Camelias 780, San Isidro, Lima',
                'nombre_contacto' => 'Ing. Carlos Mendoza',
                'telefono_contacto' => '+51 945612378',
                'email_contacto' => 'cmendoza@jjcexa.pe',
                'estado' => 'EN_EVALUACION',
                'observaciones' => 'Pendiente de homologación para servicios de ensayos no destructivos de concreto.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20512849310',
                'razon_social' => 'INMOBILIARIA Y CONSTRUCTORA MARCAN S.A.C.',
                'direccion' => 'Av. Camino Real 456, Torre Real, San Isidro, Lima',
                'nombre_contacto' => 'Arq. Elena Torres',
                'telefono_contacto' => '+51 932165498',
                'email_contacto' => 'etorres@marcan.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Solicitud urgente de evaluación estructural para proyecto multifamiliar en Miraflores.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20338572101',
                'razon_social' => 'BESCO S.A.C. CONTRATISTAS GENERALES',
                'direccion' => 'Av. Victor Andrés Belaunde 147, Via Principal 110, San Isidro',
                'nombre_contacto' => 'Ing. Miguel Ugarte',
                'telefono_contacto' => '+51 978451236',
                'email_contacto' => 'mugarte@besco.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Visita técnica programada para inspección de losa de cimentación masiva.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20492817452',
                'razon_social' => 'CONSTRUCTORA DHMONT & H S.A.C.',
                'direccion' => 'Av. República de Panamá 3535, San Isidro, Lima',
                'nombre_contacto' => 'Ing. Fernando Castro',
                'telefono_contacto' => '+51 965412387',
                'email_contacto' => 'fcastro@dhmont.com.pe',
                'estado' => 'INACTIVO',
                'observaciones' => 'Cuenta suspendida temporalmente por reestructuración de proyectos de saneamiento.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20601928374',
                'razon_social' => 'GRUPO INMOBILIARIO IMAGINA S.A.C.',
                'direccion' => 'Av. Javier Prado Oeste 757, Magdalena del Mar, Lima',
                'nombre_contacto' => 'Dra. Patricia Arbulú',
                'telefono_contacto' => '+51 951236478',
                'email_contacto' => 'parbulu@imagina.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Interesados en servicio de escaneo de acero estructural y prueba de esclerometría.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20100047218',
                'razon_social' => 'AENZA S.A.A. (EX-GRAÑA Y MONTERO)',
                'direccion' => 'Av. Paseo de la República 4675, Surquillo, Lima',
                'nombre_contacto' => 'Ing. Alejandro Morales',
                'telefono_contacto' => '+51 981234567',
                'email_contacto' => 'amorales@aenza.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Participación en consorcios viales y grandes obras de ingeniería civil.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20509874312',
                'razon_social' => 'PROTISA DEL PERU S.A.',
                'direccion' => 'Av. Argentina 4793, Callao',
                'nombre_contacto' => 'Lic. Gonzalo Vargas',
                'telefono_contacto' => '+51 974125896',
                'email_contacto' => 'gvargas@protisa.com.pe',
                'estado' => 'EN_EVALUACION',
                'observaciones' => 'Requerimiento de mantenimiento industrial y refuerzo metálico en planta.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20301478523',
                'razon_social' => 'CONSTRUCTORA SAN MARTIN S.A.C.',
                'direccion' => 'Calle Los Eucaliptos 391, San Isidro, Lima',
                'nombre_contacto' => 'Arq. Lucía Paredes',
                'telefono_contacto' => '+51 923456789',
                'email_contacto' => 'lparedes@sanmartin.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Proveedor recurrente para movimiento de tierras masivo en proyectos mineros.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20451238976',
                'razon_social' => 'INMOBILIARIA LAS BRISAS DEL SUR S.A.C.',
                'direccion' => 'Av. Larco 1011, Miraflores, Lima',
                'nombre_contacto' => 'Ing. Javier Solís',
                'telefono_contacto' => '+51 956789123',
                'email_contacto' => 'jsolis@lasbrisas.com.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Desarrollo de proyectos residenciales en la zona sur de Lima.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20604512893',
                'razon_social' => 'EDIFICACIONES Y OBRAS CIVILES DEL PERU S.A.',
                'direccion' => 'Av. Angamos Oeste 555, Miraflores, Lima',
                'nombre_contacto' => 'Ing. Mónica Reyes',
                'telefono_contacto' => '+51 989123456',
                'email_contacto' => 'mreyes@eocperu.pe',
                'estado' => 'INACTIVO',
                'observaciones' => 'Contrato concluido en fase de garantía y post-venta.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20102030405',
                'razon_social' => 'COMPAÑIA MINERA ANTAMINA S.A.',
                'direccion' => 'Av. El Derby 055, Torre Ícon, Surco, Lima',
                'nombre_contacto' => 'Lic. Ricardo Alarcón',
                'telefono_contacto' => '+51 912876543',
                'email_contacto' => 'ralarcon@antamina.com',
                'estado' => 'ACTIVO',
                'observaciones' => 'Revisión y consultoría para estabilidad de taludes y campamentos mineros.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20567891234',
                'razon_social' => 'OBRAS CIVILES Y MONTAJES INDUSTRIALES S.A.C.',
                'direccion' => 'Calle Manuel Olguín 335, Surco, Lima',
                'nombre_contacto' => 'Ing. David Espinoza',
                'telefono_contacto' => '+51 934567812',
                'email_contacto' => 'despinoza@ocmi.com.pe',
                'estado' => 'EN_EVALUACION',
                'observaciones' => 'Evaluación técnica para montaje de estructuras metálicas pesadas.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ruc' => '20609871235',
                'razon_social' => 'CONSORCIO VIAL LIMA NORTE S.A.C.',
                'direccion' => 'Panamericana Norte Km 24, Puente Piedra, Lima',
                'nombre_contacto' => 'Arq. Carmen Gutiérrez',
                'telefono_contacto' => '+51 967812345',
                'email_contacto' => 'cgutierrez@viallimanorte.pe',
                'estado' => 'ACTIVO',
                'observaciones' => 'Supervisión de pavimentación asfáltica y control de calidad de materiales.',
                'user_id' => $comercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('clientes')->insert($clientes);
    }
}