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

        // Recuperamos los IDs de los clientes insertados para asociarlos con las obras
        $clienteCosapi = DB::table('clientes')->where('ruc', '20100017491')->first()->id;
        $clienteAesa = DB::table('clientes')->where('ruc', '20100154308')->first()->id;
        $clienteMarcan = DB::table('clientes')->where('ruc', '20512849310')->first()->id;
        $clienteBesco = DB::table('clientes')->where('ruc', '20338572101')->first()->id;
        $clienteAntamina = DB::table('clientes')->where('ruc', '20102030405')->first()->id;

        // ==========================================
        // 3. CREACIÓN DE OBRAS / PROYECTOS (PIPELINE)
        // ==========================================


        $obras = [
            [
                'cliente_id' => $clienteCosapi,
                'user_id' => $comercial->id,
                'codigo' => 'OBR-001',
                'titulo' => 'Ampliación Carretera Central Tramo II',
                'estado' => 'Aprobado',
                'monto' => 340000.00,
                'fecha' => now()->addDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => $clienteAesa,
                'user_id' => $comercial->id,
                'codigo' => 'OBR-002',
                'titulo' => 'Cimentación Obras Civiles Lote B',
                'estado' => 'Cotizado',
                'monto' => 210000.00,
                'fecha' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => $clienteMarcan,
                'user_id' => $comercial->id,
                'codigo' => 'OBR-003',
                'titulo' => 'Edificio Multifamiliar San Isidro Suites',
                'estado' => 'Inspeccion', // <--- Cambiado de 'Por Visitar' a 'Inspeccion' para cumplir con el Enum de la BD
                'monto' => 95000.00,
                'fecha' => now()->addDays(45),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => $clienteBesco,
                'user_id' => $comercial->id,
                'codigo' => 'OBR-004',
                'titulo' => 'Planta Industrial Callao Sur',
                'estado' => 'Aprobado',
                'monto' => 180000.00,
                'fecha' => now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => $clienteAntamina,
                'user_id' => $comercial->id,
                'codigo' => 'OBR-005',
                'titulo' => 'Estabilidad de Taludes Campamento Yanacocha',
                'estado' => 'Cotizado',
                'monto' => 450000.00,
                'fecha' => now()->addDays(60),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('obras')->insert($obras);

        // Recuperamos los IDs de las obras creadas
        $obraCarretera = DB::table('obras')->where('titulo', 'like', '%Carretera Central%')->first()->id;
        $obraCimentacion = DB::table('obras')->where('titulo', 'like', '%Cimentación Obras Civiles%')->first()->id;

        // ==========================================
        // 4. CREACIÓN DE INSPECCIONES TÉCNICAS
        // ==========================================


        $inspecciones = [
            [
                'obra_id' => $obraCarretera,
                'user_id' => $admin->id,
                'ingeniero_asignado' => 'Ing. Marco Antonio Silva (Especialista Vial)',
                'fecha_inspeccion' => now()->subDays(5),
                'resultado' => 'Conforme sin observaciones mayores. Proceder con fase de asfaltado.',
                'estado_inspeccion' => 'Completada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'obra_id' => $obraCimentacion,
                'user_id' => $admin->id,
                'ingeniero_asignado' => 'Ing. Roberto Mendoza (Estructuras)',
                'fecha_inspeccion' => now()->addDays(2),
                'resultado' => 'Pendiente de verificación de juntas de dilatación.',
                'estado_inspeccion' => 'Pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('inspecciones')->insert($inspecciones);

        // ==========================================
        // 5. CREACIÓN DE BITÁCORAS DE SEGUIMIENTO
        // ==========================================

        $bitacoras = [
            [
                'obra_id' => $obraCarretera,
                'user_id' => $comercial->id,
                'comentario' => 'Reunión de coordinación con el Ing. Roberto Benavides. Aprobación final del cronograma de ensayos.',
                'tipo_contacto' => 'Reunión Presencial',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'obra_id' => $obraCimentacion,
                'user_id' => $comercial->id,
                'comentario' => 'Llamada telefónica con la Lic. Sofia Ramos para aclarar detalles de la propuesta económica.',
                'tipo_contacto' => 'Llamada Telefónica',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]
        ];

        DB::table('bitacoras')->insert($bitacoras);

        // ==========================================
        // 6. CREACIÓN DE COTIZACIONES
        // ==========================================

        $cotizaciones = [
            [
                'obra_id' => $obraCarretera,
                'codigo_cotizacion' => 'COT-2026-001',
                'monto_total' => 340000.00,
                'estado_cotizacion' => 'Aceptada',
                'validez_dias' => 30,
                'observaciones' => 'Incluye póliza de seguros y equipos calibrados bajo norma ISO.',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
            [
                'obra_id' => $obraCimentacion,
                'codigo_cotizacion' => 'COT-2026-002',
                'monto_total' => 210000.00,
                'estado_cotizacion' => 'Enviada',
                'validez_dias' => 15,
                'observaciones' => 'Sujeto a renegociación por volumen de metros cúbicos evaluados.',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ]
        ];

        DB::table('cotizaciones')->insert($cotizaciones);
    }
}