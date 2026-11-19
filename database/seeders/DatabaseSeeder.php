<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. USUARIOS (Con Hash::make para permitir login)
        $admin = User::firstOrCreate(
            ['email' => 'admin@dtlpremier.pe'],
            [
                'name'              => 'Administrador Sistema',
                'email_verified_at' => $now,
                'password'          => Hash::make('admin123'),
                'role'              => 'administrador',
                'login_attempts'    => 0,
                'is_active'         => true,
            ]
        );

        $gerente = User::firstOrCreate(
            ['email' => 'gerencia@dtlpremier.pe'],
            [
                'name'              => 'Ing. Ricardo Paredes (Gerencia)',
                'email_verified_at' => $now,
                'password'          => Hash::make('gerencia123'),
                'role'              => 'directivo',
                'login_attempts'    => 0,
                'is_active'         => true,
            ]
        );

        $asesor1 = User::firstOrCreate(
            ['email' => 'cmendoza@dtlpremier.pe'],
            [
                'name'              => 'Carlos Mendoza (Comercial)',
                'email_verified_at' => $now,
                'password'          => Hash::make('comercial123'),
                'role'              => 'ejecutivo',
                'login_attempts'    => 0,
                'is_active'         => true,
            ]
        );

        $asesor2 = User::firstOrCreate(
            ['email' => 'lvargas@dtlpremier.pe'],
            [
                'name'              => 'Lucía Vargas (Comercial)',
                'email_verified_at' => $now,
                'password'          => Hash::make('comercial123'),
                'role'              => 'ejecutivo',
                'login_attempts'    => 0,
                'is_active'         => true,
            ]
        );

        $adminId  = $admin->id;
        $asesores = [$asesor1->id, $asesor2->id];

        // 2. POLÍTICAS SLA
        $politicaVisitaId = DB::table('sla_politicas')->insertGetId([
            'user_id'             => $adminId,
            'etapa_evaluada'      => 'VISITA_INSPECCION',
            'tiempo_limite_horas' => 24,
            'nivel_severidad'     => 'AMARILLO',
            'email_notificacion'  => 'soporte@dtlpremier.pe',
            'notificacion_activa' => true,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        $politicaCotizId = DB::table('sla_politicas')->insertGetId([
            'user_id'             => $adminId,
            'etapa_evaluada'      => 'COTIZACION_PROPUESTA',
            'tiempo_limite_horas' => 48,
            'nivel_severidad'     => 'ROJO',
            'email_notificacion'  => 'soporte@dtlpremier.pe',
            'notificacion_activa' => true,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // 3. CLIENTES (20 Clientes Corporativos)
        $clientesData = [
            // [RUC, Razón Social, Dirección Fiscal, Contacto, Teléfono, Email, Obs, Sector]
            [
                '20100010724', 'COSAPI S.A.', 'Av. República de Colombia 791, San Isidro, Lima',
                'Ing. Jorge Ramírez Silva', '987654321', 'jramirez@cosapi.com.pe',
                'Contratista principal en megaobras de infraestructura y minería. Cartera prioritaria AAA.',
            ],
            [
                '20508608889', 'AESA INFRAESTRUCTURA Y MINERIA S.A.', 'Av. Javier Prado Este 4403, Surco, Lima',
                'Ing. Paola Quispe Ramos', '984112233', 'pquispe@aesa.com.pe',
                'Especialistas en obras subterráneas y movimiento de tierras para proyectos mineros.',
            ],
            [
                '20100041956', 'JJC CONTRATISTAS GENERALES S.A.', 'Av. República de Chile 388, Jesús María, Lima',
                'Ing. Luis Castro Mendoza', '991223344', 'lcastro@jjc.com.pe',
                'Constructora líder con más de 65 años en edificaciones industriales y viales.',
            ],
            [
                '20100047211', 'FERREYROS S.A.', 'Jr. Cristóbal de Peralta Norte 820, Surco, Lima',
                'Arq. Andrea Torres Benavides', '998776655', 'atorres@ferreyros.com.pe',
                'Corporación de bienes de capital; requiere constante habilitación de talleres y losas pesadas.',
            ],
            [
                '20100030164', 'MOTA-ENGIL PERU S.A.', 'Av. Nicolás Arriola 740, La Victoria, Lima',
                'Ing. Marco Díaz Falconí', '995443322', 'mdiaz@mota-engil.pe',
                'Consorcio internacional enfocado en puertos, autopistas y obras civiles de gran envergadura.',
            ],
            [
                '20258930777', 'BESCO S.A.C.', 'Av. Paseo de la República 3832, San Isidro, Lima',
                'Ing. Sofía León Barreto', '986554411', 'sleon@besco.com.pe',
                'Constructora e inmobiliaria referente en grandes conjuntos multifamiliares y centros urbanos.',
            ],
            [
                '20330604217', 'UNION DE CONCRETERAS S.A. (UNICON)', 'Panamericana Sur Km 11.4, San Juan de Miraflores, Lima',
                'Ing. Raúl Herrera Prado', '982334455', 'rherrera@unicon.com.pe',
                'Productora líder de concreto premezclado; requiere obras viales y cimentaciones de plantas.',
            ],
            [
                '20100146383', 'AENZA S.A.A.', 'Av. Petit Thouars 4957, Miraflores, Lima',
                'Ing. Valeria Salas Cárdenas', '981223399', 'vsalas@aenza.com.pe',
                'Grupo regional de ingeniería y construcción, concesiones de infraestructura y servicios petroleros.',
            ],
            [
                '20512345671', 'HV CONTRATISTAS S.A.', 'Av. El Derby 250, Of. 801, Surco, Lima',
                'Ing. Diego Rojas Morales', '977889900', 'drojas@hvcontratistas.pe',
                'Firma constructora especializada en plantas industriales y centros comerciales de alta exigencia.',
            ],
            [
                '20456789123', 'INVERSIONES CENTENARIO S.A.A.', 'Av. Víctor Andrés Belaúnde 147, San Isidro, Lima',
                'Arq. Camila Flores Navarro', '976554433', 'cflores@centenario.com.pe',
                'Desarrollador inmobiliario e industrial con múltiples hubs logísticos en Lima y provincias.',
            ],
            [
                '20534112233', 'CONSTRUCTORA MALAGA HNOS S.A.', 'Calle Las Begonias 475, San Isidro, Lima',
                'Ing. Fernando Vega Delgado', '965443322', 'fvega@malagahnos.com.pe',
                'Empresa con amplia trayectoria en puentes, túneles y estabilización de taludes carreteros.',
            ],
            [
                '20498765432', 'CASA CONSTRUCCION Y ADMINISTRACION S.A.', 'Av. Javier Prado Oeste 2108, San Isidro, Lima',
                'Ing. Martín Silva Rivas', '964332211', 'msilva@casa.com.pe',
                'Especialistas en pavimentos asfálticos y conservación vial a nivel nacional.',
            ],
            [
                '20511223344', 'INMOBILIARIA EDIFICA S.A.C.', 'Av. Benavides 1944, Miraflores, Lima',
                'Arq. Claudia Núñez Vidal', '954321987', 'cnunez@edifica.com.pe',
                'Desarrollador de proyectos urbanos residenciales y edificios inteligentes de uso mixto.',
            ],
            [
                '20522334455', 'OHLA PERU S.A.C.', 'Av. Santo Toribio 143, San Isidro, Lima',
                'Ing. Héctor Paredes Loyola', '955667788', 'hparedes@ohla.pe',
                'Subsidiaria de grupo global; ejecuta obras hospitalarias, viales e hidráulicas en Perú.',
            ],
            [
                '20533445566', 'CONCREMAX S.A.', 'Av. Materiales 2450, Cercado de Lima, Lima',
                'Ing. Bruno Chávez Tello', '944556677', 'bchavez@concremax.com.pe',
                'Proveedor de premezclados y prefabricados de concreto para proyectos industriales pesados.',
            ],
            [
                '20544556677', 'LOS PORTALES S.A.', 'Jr. Mariscal La Mar 991, Magdalena del Mar, Lima',
                'Arq. Daniela Cruz Solís', '943219876', 'dcruz@losportales.com.pe',
                'Compañía diversificada en habilitaciones urbanas, estacionamientos y hotelería.',
            ],
            [
                '20555667788', 'ALICORP S.A.A. - DIV. INFRAESTRUCTURA', 'Av. Argentina 4793, Callao',
                'Ing. Oscar Medina Valdivia', '933445566', 'omedina@alicorp.com.pe',
                'Líder de consumo masivo con expansión constante de almacenes, muelles y líneas de envasado.',
            ],
            [
                '20566778899', 'APM TERMINALS CALLAO S.A.', 'Av. Contralmirante Raygada 111, Callao',
                'Ing. Renato Paz Zegarra', '922334455', 'rpaz@apmterminals.com',
                'Operador portuario del Terminal Norte; requiere reparación de muelles y patios de maniobras.',
            ],
            [
                '20577889900', 'RANSA COMERCIAL S.A.', 'Av. Argentina 2833, Callao',
                'Ing. Sergio Luna Montoya', '911223344', 'sluna@ransa.net',
                'Operador logístico integral 3PL con centros de almacenamiento en frío y secos.',
            ],
            [
                '20588990011', 'CEMENTOS PACASMAYO S.A.A.', 'Calle La Colonia 150, Surco, Lima',
                'Ing. Patricia Soto Ugarte', '912345678', 'psoto@cpsaa.com.pe',
                'Productora cementera con operaciones de ampliación en plantas industriales y terminales.',
            ],
        ];

        // Definición de las 20 Obras asociadas 1:1 a los 20 Clientes
        // Estructura: [
        //   0: titulo,
        //   1: monto,
        //   2: estado (obras.estado),
        //   3: escenario_clave,
        //   4: sub_horas_creacion,
        //   5: inspecciones_array [ [ingeniero, sub_dias_o_horas, estado_insp, resultado], ... ],
        //   6: cotizaciones_array  [ [sub_dias_o_horas, estado_cot, monto_cot, obs, motivo_rechazo, partida_indices], ... ],
        //   7: bitacoras_array     [ [tipo_contacto, comentario], ... ],
        //   8: sla_alertas_array   [ [politica_tipo, horas_retraso, estado_alerta, fecha_disparo_sub] ]
        // ]
        $obrasPlan = [
            // -------------------------------------------------------------------------
            // GRUPO 1: PROSPECTOS (3 obras vivas)
            // -------------------------------------------------------------------------
            // Obra 1 (Cliente 1: COSAPI S.A.) -> Prospecto recién creado (dentro de plazo 24h SLA)
            0 => [
                'titulo'    => 'Inspección Estructural Torre Corporativa San Isidro',
                'monto'     => 48000.00,
                'estado'    => 'Prospecto',
                'escenario' => 'PROSPECTO_VERDE',
                'creado_h'  => 8, // Hace 8 horas (dentro de 24h SLA => VERDE)
                'inspecciones' => [],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Reunión Presencial', 'Reunión de coordinación inicial con Ing. Jorge Ramírez para alcance de evaluación patológica.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 2 (Cliente 2: AESA) -> Prospecto demorado sin visita agendada (42h > 24h SLA => AMARILLO)
            1 => [
                'titulo'    => 'Mantenimiento de Túneles y Drenaje Vía de Evitamiento',
                'monto'     => 185000.00,
                'estado'    => 'Prospecto',
                'escenario' => 'PROSPECTO_DEMORADO',
                'creado_h'  => 42, // Hace 42 horas (> 24h SLA => AMARILLO)
                'inspecciones' => [],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Llamada Telefónica', 'Cliente solicitó reprogramar la reunión inicial de campo por disponibilidad técnica.'],
                ],
                'sla_alertas' => [
                    ['VISITA_INSPECCION', 42, 'VIGENTE', 18],
                ],
            ],
            // Obra 3 (Cliente 3: JJC) -> Prospecto recién registrado (4h < 24h SLA => VERDE)
            2 => [
                'titulo'    => 'Evaluación de Losa Industrial y Cargas Almacén Norte',
                'monto'     => 62000.00,
                'estado'    => 'Prospecto',
                'escenario' => 'PROSPECTO_NUEVO_VERDE',
                'creado_h'  => 4, // Hace 4 horas (VERDE)
                'inspecciones' => [],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Correo Electrónico', 'Recepción de planos estructurales del almacén para revisión previa a la visita.'],
                ],
                'sla_alertas' => [],
            ],

            // -------------------------------------------------------------------------
            // GRUPO 2: INSPECCIÓN (4 obras vivas)
            // -------------------------------------------------------------------------
            // Obra 4 (Cliente 4: FERREYROS) -> Inspección Pendiente a tiempo (Agendada a futuro, creada hace 6h => VERDE)
            3 => [
                'titulo'    => 'Reforzamiento de Vigas Puente Grúa Taller Ferreyros',
                'monto'     => 128000.00,
                'estado'    => 'Inspeccion',
                'escenario' => 'INSP_PENDIENTE_A_TIEMPO',
                'creado_h'  => 28, // Obra creada hace 28h
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Luis Navarro',
                        'fecha_rel' => 48, // Programada para dentro de 48 horas en el futuro
                        'futuro'    => true,
                        'estado'    => 'Pendiente',
                        'resultado' => null,
                        'creado_h'  => 6, // Creada hace 6 horas (< 24h => VERDE)
                    ],
                ],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Reunión Presencial', 'Coordinación con gerencia técnica de Ferreyros para pases de ingreso a taller central.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 5 (Cliente 5: MOTA-ENGIL) -> Inspección Pendiente demorada (Creada hace 34h > 24h => AMARILLO)
            4 => [
                'titulo'    => 'Cimentación Profunda Subestación Eléctrica Sur',
                'monto'     => 310000.00,
                'estado'    => 'Inspeccion',
                'escenario' => 'INSP_PENDIENTE_DEMORADA',
                'creado_h'  => 56,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Carmen Delgado',
                        'fecha_rel' => 10, // Programada hace 10h (no completada a tiempo)
                        'futuro'    => false,
                        'estado'    => 'Pendiente',
                        'resultado' => null,
                        'creado_h'  => 34, // Creada hace 34h (> 24h SLA => AMARILLO)
                    ],
                ],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Llamada Telefónica', 'Pendiente confirmación de entrega de permisos de trabajo seguro (PETAR) por parte del contratista.'],
                ],
                'sla_alertas' => [
                    ['VISITA_INSPECCION', 34, 'VIGENTE', 10],
                ],
            ],
            // Obra 6 (Cliente 6: BESCO) -> Inspección Pendiente a tiempo (creada hace 12h => VERDE)
            5 => [
                'titulo'    => 'Impermeabilización y Prueba de Estanqueidad Cisterna Central',
                'monto'     => 74500.00,
                'estado'    => 'Inspeccion',
                'escenario' => 'INSP_PENDIENTE_VERDE',
                'creado_h'  => 20,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Roberto Zúñiga',
                        'fecha_rel' => 24, // En 24 horas a futuro
                        'futuro'    => true,
                        'estado'    => 'Pendiente',
                        'resultado' => null,
                        'creado_h'  => 12, // Hace 12h (< 24h => VERDE)
                    ],
                ],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Correo Electrónico', 'Se remite cronograma de visita de inspección preliminar a la residencia de obra.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 7 (Cliente 7: UNICON) -> Inspección Pendiente a tiempo (Creada hace 15h < 24h SLA => VERDE)
            6 => [
                'titulo'    => 'Pavimentación Rígida y Zanjas Centro Logístico Lurín',
                'monto'     => 245000.00,
                'estado'    => 'Inspeccion',
                'escenario' => 'INSP_PENDIENTE_A_TIEMPO_UNICON',
                'creado_h'  => 30,
                'inspecciones' => [
                    [
                        'ingeniero'      => 'Ing. Patricia Paredes',
                        'fecha_rel'      => 36, // Programada para dentro de 36h a futuro
                        'futuro'         => true,
                        'estado'         => 'Pendiente',
                        'resultado'      => null,
                        'creado_h'       => 15, // Creada hace 15h (< 24h SLA => VERDE)
                    ],
                ],
                'cotizaciones' => [],
                'bitacoras' => [
                    ['Reunión Presencial', 'Coordinación con gerencia técnica de UNICON para acceso a balanzas y patio de maniobras.'],
                ],
                'sla_alertas' => [],
            ],

            // -------------------------------------------------------------------------
            // GRUPO 3: COTIZACIÓN (4 obras vivas)
            // -------------------------------------------------------------------------
            // Obra 8 (Cliente 8: AENZA) -> Inspección completada hace 72h SIN cotización programada (> 48h SLA => ROJO)
            7 => [
                'titulo'    => 'Edificio Multifamiliar San Isidro Suites - Estructuras',
                'monto'     => 420000.00,
                'estado'    => 'Cotización',
                'escenario' => 'INSP_COMPLETADA_SIN_COTIZ_ROJO',
                'creado_h'  => 96,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Luis Navarro',
                        'fecha_rel' => 74,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Inspección técnica completada. Se validaron 1,200 m2 de losas aligeradas y muros pantalla.',
                        'creado_h'  => 90,
                    ],
                ],
                'cotizaciones' => [], // Sin cotización -> getEstadoRealAttribute() da 'Cotización', SLA da ROJO (> 48h)
                'bitacoras' => [
                    ['Llamada Telefónica', 'Cliente solicita con urgencia el presupuesto técnico para presentarlo a su comité de compras.'],
                ],
                'sla_alertas' => [
                    ['COTIZACION_PROPUESTA', 74, 'VIGENTE', 26],
                ],
            ],
            // Obra 9 (Cliente 9: HV CONTRATISTAS) -> Cotización Programada a tiempo (Inspección OK + Cotiz Programada hace 18h => VERDE)
            8 => [
                'titulo'    => 'Ampliación Planta Industrial Huachipa Etapa II',
                'monto'     => 390000.00,
                'estado'    => 'Cotización',
                'escenario' => 'COTIZ_PROGRAMADA_A_TIEMPO',
                'creado_h'  => 60,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Roberto Zúñiga',
                        'fecha_rel' => 36,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Levantamiento de naves existentes y verificación de capacidad portante de vigas metálicas.',
                        'creado_h'  => 48,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 18, // Hace 18h (< 48h => VERDE)
                        'estado'     => 'Programada',
                        'monto'      => 0.00, // Programada tiene monto 0.00 hasta emisión
                        'obs'        => '[Fase #1 ⇄ Inspección #1 - Ing. Roberto Zúñiga] En proceso de metrado por el área técnica.',
                        'rechazo'    => null,
                        'partidas'   => [],
                    ],
                ],
                'bitacoras' => [
                    ['Correo Electrónico', 'Se reciben consultas de metrados por parte del ingeniero calculista para cerrar costos.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 10 (Cliente 10: CENTENARIO) -> Cotización Rechazada por precio (Rechazada hace 16h < 48h SLA => VERDE)
            9 => [
                'titulo'    => 'Construcción Muro de Contención y Talud Costa Verde',
                'monto'     => 275000.00,
                'estado'    => 'Cotización',
                'escenario' => 'COTIZ_RECHAZADA_VERDE',
                'creado_h'  => 72,
                'inspecciones' => [
                    [
                        'ingeniero'      => 'Ing. Luis Navarro',
                        'fecha_rel'      => 48,
                        'futuro'         => false,
                        'estado'         => 'Completada',
                        'resultado'      => 'Suelo gravoso consolidado. Se requiere muro de contención en voladizo de h=4.50m.',
                        'creado_h'       => 60,
                        'actualizado_h'  => 55,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'          => 24,
                        'actualizado_h'  => 16, // Rechazada hace 16h (< 48h SLA => VERDE)
                        'estado'         => 'Rechazada',
                        'monto'          => 275000.00,
                        'obs'            => '[Fase #1 ⇄ Inspección #1 - Ing. Luis Navarro] Oferta formal emitida. Cliente solicita descuento por volumen.',
                        'rechazo'        => 'Presupuesto ligeramente superior al estimado. Requiere ajuste comercial.',
                        'partidas'       => [5, 7], // Concreto y Encofrado
                    ],
                ],
                'bitacoras' => [
                    ['Reunión Presencial', 'Presentación de la propuesta económica al equipo de proyectos de Inversiones Centenario.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 11 (Cliente 11: MALAGA HNOS) -> Cotización Rechazada por precio (Rechazada hace 56h > 48h SLA sin reajuste => ROJO)
            10 => [
                'titulo'    => 'Canal de Derivación y Drenaje Pluvial Lurín',
                'monto'     => 185000.00,
                'estado'    => 'Cotización',
                'escenario' => 'COTIZ_RECHAZADA_ROJO',
                'creado_h'  => 96,
                'inspecciones' => [
                    [
                        'ingeniero'      => 'Ing. Carmen Delgado',
                        'fecha_rel'      => 70,
                        'futuro'         => false,
                        'estado'         => 'Completada',
                        'resultado'      => 'Topografía de cuenca verificada. Se valida canal trapezoidal de concreto armado de 450 ml.',
                        'creado_h'       => 85,
                        'actualizado_h'  => 80,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'          => 60,
                        'actualizado_h'  => 56, // Rechazada hace 56h (> 48h SLA => ROJO)
                        'estado'         => 'Rechazada',
                        'monto'          => 185000.00,
                        'obs'            => '[Fase #1 ⇄ Inspección #1 - Ing. Carmen Delgado] Oferta formal emitida por canal de derivación.',
                        'rechazo'        => 'Presupuesto excede el techo financiero del cliente en un 12%. Solicitan optimización.',
                        'partidas'       => [2, 5], // Excavación y Concreto
                    ],
                ],
                'bitacoras' => [
                    ['Llamada Telefónica', 'Conversación con Ing. Fernando Vega: cliente solicita reajuste económico de precios unitarios.'],
                ],
                'sla_alertas' => [
                    ['COTIZACION_PROPUESTA', 56, 'VIGENTE', 8],
                ],
            ],

            // -------------------------------------------------------------------------
            // GRUPO 4: CIERRE COMERCIAL (3 obras vivas)
            // -------------------------------------------------------------------------
            // Obra 12 (Cliente 12: CASA CONSTRUCCION) -> Cotización Aceptada lista para Cierre Comercial (En Cotización)
            11 => [
                'titulo'    => 'Rehabilitación Integral de Pavimentos Complejo Callao',
                'monto'     => 315000.00,
                'estado'    => 'Cotización',
                'escenario' => 'COTIZ_ACEPTADA_LISTA_CIERRE',
                'creado_h'  => 48,
                'inspecciones' => [
                    [
                        'ingeniero'      => 'Ing. Mario Eloy',
                        'fecha_rel'      => 30,
                        'futuro'         => false,
                        'estado'         => 'Completada',
                        'resultado'      => 'Se verificó fisuración severa en 3,500 m2 de carpeta asfáltica. Se requiere fresado y recapeo.',
                        'creado_h'       => 40,
                        'actualizado_h'  => 38,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'          => 20,
                        'actualizado_h'  => 14, // Aceptada hace 14h
                        'estado'         => 'Aceptada',
                        'monto'          => 315000.00,
                        'obs'            => '[Fase #1 ⇄ Inspección #1 - Ing. Mario Eloy] Propuesta técnica aceptada por cliente. Lista para Cierre Comercial.',
                        'rechazo'        => null,
                        'partidas'       => [9, 10], // Carpeta asfáltica y Base granular
                    ],
                ],
                'bitacoras' => [
                    ['Reunión Presencial', 'Reunión de cierre comercial en oficinas de CASA. Borrador contractual en revisión legal.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 13 (Cliente 13: EDIFICA) -> Cierre Comercial con Cotización Aceptada (Aceptada hace 18h => VERDE)
            12 => [
                'titulo'    => 'Reparación Estructural y Reforzamiento Muelle Callao Zona 4',
                'monto'     => 680000.00,
                'estado'    => 'Cierre Comercial',
                'escenario' => 'CIERRE_COTIZ_ACEPTADA_VERDE',
                'creado_h'  => 65,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Roberto Zúñiga',
                        'fecha_rel' => 45,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Corrosión avanzada en pilotes marinos. Se requiere encamisado y fibra de carbono CFRP.',
                        'creado_h'  => 55,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 18,
                        'estado'     => 'Aceptada',
                        'monto'      => 680000.00,
                        'obs'        => '[Fase #1 ⇄ Inspección #1 - Ing. Roberto Zúñiga] Propuesta aprobada por directorio de cliente.',
                        'rechazo'    => null,
                        'partidas'   => [11, 12], // Fibra de carbono e Inyección epóxica
                    ],
                ],
                'bitacoras' => [
                    ['Correo Electrónico', 'Carta de adjudicación preliminar recibida de Edifica. Pendiente emisión de orden de servicio.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 14 (Cliente 14: OHLA PERU) -> Cierre Comercial con Cotización Aceptada (Aceptada hace 10h => VERDE)
            13 => [
                'titulo'    => 'Instalación Línea Troncal Tubería HDPE Planta Sur',
                'monto'     => 198000.00,
                'estado'    => 'Cierre Comercial',
                'escenario' => 'CIERRE_COTIZ_ACEPTADA_VERDE_2',
                'creado_h'  => 52,
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Carmen Delgado',
                        'fecha_rel' => 32,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Trazado y rasantes validadas para 850 ml de zanja en terreno conglomerado.',
                        'creado_h'  => 44,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 10,
                        'estado'     => 'Aceptada',
                        'monto'      => 198000.00,
                        'obs'        => '[Fase #1 ⇄ Inspección #1 - Ing. Carmen Delgado] Propuesta técnica económica acordada al 100%.',
                        'rechazo'    => null,
                        'partidas'   => [14, 2], // Tubería HDPE y Excavación
                    ],
                ],
                'bitacoras' => [
                    ['Seguimiento', 'Validación de póliza CAR y cartas fianza requeridas para firma de acta de inicio.'],
                ],
                'sla_alertas' => [],
            ],

            // -------------------------------------------------------------------------
            // GRUPO 5: HISTORIAL CERRADAS DEFINITIVAMENTE (6 obras)
            // -------------------------------------------------------------------------
            // Obra 15 (Cliente 15: CONCREMAX) -> Ganada/Aceptada (Mes anterior, cliente ACTIVO)
            14 => [
                'titulo'    => 'Construcción Almacén Central de Agregados Concremax',
                'monto'     => 890000.00,
                'estado'    => 'Aceptada',
                'escenario' => 'GANADA_HISTORIAL_1',
                'creado_h'  => 720, // 30 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Luis Navarro',
                        'fecha_rel' => 690,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Estudio de suelos y diseño estructural de naves con puente grúa completado.',
                        'creado_h'  => 710,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 650,
                        'estado'     => 'Aceptada',
                        'monto'      => 890000.00,
                        'obs'        => 'Oferta técnico-económica aceptada por gerencia de Concremax. Obra en ejecución.',
                        'rechazo'    => null,
                        'partidas'   => [5, 16], // Concreto y Estructura metálica
                    ],
                ],
                'bitacoras' => [
                    ['Reunión Presencial', 'Firma de contrato de obra y entrega de terreno con presencia notarial.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 16 (Cliente 16: LOS PORTALES) -> Ganada/Aceptada (Mes actual, cliente ACTIVO)
            15 => [
                'titulo'    => 'Rehabilitación Vial de Accesos y Pavimento Los Portales',
                'monto'     => 740000.00,
                'estado'    => 'Aceptada',
                'escenario' => 'GANADA_HISTORIAL_2',
                'creado_h'  => 480, // 20 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Carmen Delgado',
                        'fecha_rel' => 450,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Metrado vial de 5,200 m2 validado en campo con equipo topográfico georreferenciado.',
                        'creado_h'  => 470,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 420,
                        'estado'     => 'Aceptada',
                        'monto'      => 740000.00,
                        'obs'        => 'Adjudicación de obra confirmada. Carta fianza entregada al cliente.',
                        'rechazo'    => null,
                        'partidas'   => [8, 9], // Pavimento rígido y Carpeta asfáltica
                    ],
                ],
                'bitacoras' => [
                    ['Reunión Presencial', 'Inicio de trazo y replanteo con supervisión del cliente.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 17 (Cliente 17: ALICORP) -> Ganada/Aceptada (Mes actual, cliente ACTIVO)
            16 => [
                'titulo'    => 'Pisos Industriales con Endurecedor Planta Alicorp Callao',
                'monto'     => 520000.00,
                'estado'    => 'Aceptada',
                'escenario' => 'GANADA_HISTORIAL_3',
                'creado_h'  => 360, // 15 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Roberto Zúñiga',
                        'fecha_rel' => 330,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Ensayos de planicidad F-Number y verificación de juntas de dilatación.',
                        'creado_h'  => 350,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 300,
                        'estado'     => 'Aceptada',
                        'monto'      => 520000.00,
                        'obs'        => 'Contrato marco formalizado para losas de alta resistencia al impacto.',
                        'rechazo'    => null,
                        'partidas'   => [17, 13], // Piso industrial y Mortero
                    ],
                ],
                'bitacoras' => [
                    ['Seguimiento', 'Vaciado de 첫er tramo de 1,200 m2 con presencia de control de calidad.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 18 (Cliente 18: APM TERMINALS) -> Ganada/Aceptada (Mes anterior, cliente ACTIVO)
            17 => [
                'titulo'    => 'Sellado de Juntas y Morteros Especiales Terminal Portuario',
                'monto'     => 340000.00,
                'estado'    => 'Aceptada',
                'escenario' => 'GANADA_HISTORIAL_4',
                'creado_h'  => 800, // 33 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Mario Eloy',
                        'fecha_rel' => 770,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Inspección de 2,400 ml de juntas sometidas a salinidad extrema en muelle norte.',
                        'creado_h'  => 790,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 730,
                        'estado'     => 'Aceptada',
                        'monto'      => 340000.00,
                        'obs'        => 'Propuesta aceptada con certificación de materiales grado marino.',
                        'rechazo'    => null,
                        'partidas'   => [15, 13], // Sellado juntas e Impermeabilización
                    ],
                ],
                'bitacoras' => [
                    ['Correo Electrónico', 'Recepción de orden de compra formal N° OC-2026-APM-089.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 19 (Cliente 19: RANSA) -> Cancelada (Desestimada por cliente, cliente INACTIVO)
            18 => [
                'titulo'    => 'Cerco Perimétrico y Garitas de Control Almacén Sur',
                'monto'     => 145000.00,
                'estado'    => 'Cancelada',
                'escenario' => 'CANCELADA_HISTORIAL_1',
                'creado_h'  => 600, // 25 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Luis Navarro',
                        'fecha_rel' => 570,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Levantamiento de linderos completado. Terreno en litigio con colindante.',
                        'creado_h'  => 590,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 540,
                        'estado'     => 'Rechazada',
                        'monto'      => 145000.00,
                        'obs'        => 'Propuesta desestimada por cancelación presupuestal del cliente.',
                        'rechazo'    => 'Proyecto suspendido indefinidamente por problemas legales en los linderos del predio.',
                        'partidas'   => [6, 7], // Acero y Encofrado
                    ],
                ],
                'bitacoras' => [
                    ['Llamada Telefónica', 'Notificación formal del departamento de compras de Ransa cancelando el proceso.'],
                ],
                'sla_alertas' => [],
            ],
            // Obra 20 (Cliente 20: PACASMAYO) -> Cancelada (Postergada para 2027, cliente INACTIVO)
            19 => [
                'titulo'    => 'Techado Metálico y Cerramientos Patio de Carga Norte',
                'monto'     => 220000.00,
                'estado'    => 'Cancelada',
                'escenario' => 'CANCELADA_HISTORIAL_2',
                'creado_h'  => 550, // 22 días atrás
                'inspecciones' => [
                    [
                        'ingeniero' => 'Ing. Carmen Delgado',
                        'fecha_rel' => 520,
                        'futuro'    => false,
                        'estado'    => 'Completada',
                        'resultado' => 'Verificación de apoyos en columnas existentes y dimensionamiento de tijerales.',
                        'creado_h'  => 540,
                    ],
                ],
                'cotizaciones' => [
                    [
                        'sub_h'      => 490,
                        'estado'     => 'Rechazada',
                        'monto'      => 220000.00,
                        'obs'        => 'Oferta técnica y económica no priorizada para el ejercicio en curso.',
                        'rechazo'    => 'Reasignación de CAPEX corporativo. Proyecto postergado para el siguiente año.',
                        'partidas'   => [16, 1], // Estructura metálica y Calicatas
                    ],
                ],
                'bitacoras' => [
                    ['Reunión Presencial', 'Reunión de cierre con jefa de mantenimiento. Se agradece la participación técnica.'],
                ],
                'sla_alertas' => [],
            ],
        ];

        // Inserción de los 20 Clientes con estado derivado inicialmente
        // (Se recalculará dinámicamente con actualizarEstadoCliente al final del seeder)
        $clienteIds = [];
        foreach ($clientesData as $i => $c) {
            $clienteIds[] = DB::table('clientes')->insertGetId([
                'ruc'               => $c[0],
                'razon_social'      => $c[1],
                'direccion'         => $c[2],
                'nombre_contacto'   => $c[3],
                'telefono_contacto' => $c[4],
                'email_contacto'    => $c[5],
                'estado'            => 'INACTIVO', // Se actualiza luego según la regla de negocio
                'observaciones'     => $c[6],
                'user_id'           => $asesores[$i % 2],
                'created_at'        => $now->copy()->subDays(90 - $i),
                'updated_at'        => $now->copy()->subDays(5),
            ]);
        }

        // 4. PARTIDAS
        $partidasData = [
            ['PAR-001', 'Inspección Estructural con Esclerómetro y Ultrasonido', 'Evaluación Estructural', 'global', 3850.00],
            ['PAR-002', 'Estudio de Mecánica de Suelos con Calicatas (hasta 3m)', 'Geotecnia', 'global', 4500.00],
            ['PAR-003', 'Excavación Masiva en Terreno Semirocoso con Maquinaria', 'Movimiento de Tierras', 'm3', 48.50],
            ['PAR-004', 'Relleno Compactado con Material Propio Seleccionado', 'Movimiento de Tierras', 'm3', 36.00],
            ['PAR-005', 'Eliminación de Material Excedente D=15km', 'Movimiento de Tierras', 'm3', 42.00],
            ['PAR-006', 'Concreto Premezclado f\'c=280 kg/cm2 en Cimentaciones', 'Estructuras', 'm3', 465.00],
            ['PAR-007', 'Acero Corrugado FY=4200 kg/cm2 Habilitado y Colocado', 'Estructuras', 'kg', 6.80],
            ['PAR-008', 'Encofrado y Desencofrado Metálico en Muros de Contención', 'Estructuras', 'm2', 82.00],
            ['PAR-009', 'Pavimento Rígido de Concreto e=20cm f\'c=280 kg/cm2', 'Pavimentos', 'm2', 145.00],
            ['PAR-010', 'Carpeta Asfáltica en Caliente e=3"', 'Pavimentos', 'm2', 98.00],
            ['PAR-011', 'Base Granular Compactada e=20cm al 100% Proctor', 'Pavimentos', 'm2', 39.50],
            ['PAR-012', 'Reforzamiento Estructural con Fibra de Carbono (CFRP)', 'Reforzamiento', 'm2', 620.00],
            ['PAR-013', 'Inyección de Resina Epóxica en Fisuras Estructurales', 'Reforzamiento', 'ml', 185.00],
            ['PAR-014', 'Impermeabilización de Cisternas y Reservorios con Mortero', 'Acabados Técnicos', 'm2', 110.00],
            ['PAR-015', 'Instalación de Tubería HDPE SDR-17 DN 200mm para Zanjas', 'Saneamiento', 'ml', 135.00],
            ['PAR-016', 'Mantenimiento y Sellado de Juntas de Dilatación en Túneles', 'Mantenimiento Vial', 'ml', 95.00],
            ['PAR-017', 'Suministro e Instalación de Estructura Metálica para Nave', 'Estructuras Metálicas', 'kg', 14.50],
            ['PAR-018', 'Piso Industrial de Concreto Pulido con Endurecedor de Cuarzo', 'Naves Industriales', 'm2', 128.00],
            ['PAR-019', 'Jornada Técnica de Supervisión y Ensayos de Laboratorio', 'Ingeniería y Control', 'jor', 950.00],
            ['PAR-020', 'Levantamiento Topográfico con Estación Total y Dron RTK', 'Topografía', 'global', 2900.00],
        ];

        $partidaIds = [];
        foreach ($partidasData as $idx => $p) {
            $pid = DB::table('partidas')->insertGetId([
                'user_id'         => $adminId,
                'codigo'          => $p[0],
                'descripcion'     => $p[1],
                'categoria'       => $p[2],
                'unidad_medida'   => $p[3],
                'precio_unitario' => $p[4],
                'is_active'       => true,
                'created_at'      => $now->copy()->subMonths(4),
                'updated_at'      => $now->copy()->subDays(15),
            ]);
            $partidaIds[] = ['id' => $pid, 'precio' => $p[4]];

            if ($idx < 10) {
                DB::table('historial_precios_partidas')->insert([
                    'partida_id'      => $pid,
                    'user_id'         => $adminId,
                    'precio_anterior' => round($p[4] * 0.92, 2),
                    'precio_nuevo'    => $p[4],
                    'motivo_cambio'   => 'Actualización anual por índice de insumos de construcción.',
                    'created_at'      => $now->copy()->subDays(20 - $idx),
                    'updated_at'      => $now->copy()->subDays(20 - $idx),
                ]);
            }
        }

        // 5. OBRAS Y ECOSISTEMA RELACIONAL (INSPECCIONES, COTIZACIONES, BITÁCORAS, SLA)
        $cotCounter = 1;

        foreach ($obrasPlan as $idx => $cfg) {
            $num       = $idx + 1;
            $codigo    = 'OBR-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            $titulo    = $cfg['titulo'];
            $monto     = $cfg['monto'];
            $estado    = $cfg['estado'];
            $creadoH   = $cfg['creado_h'];
            $escenario = $cfg['escenario'];

            $clienteId = $clienteIds[$idx];
            $asesorId  = $asesores[$idx % 2];

            // Fecha base de creación de la obra
            $createdAt = $now->copy()->subHours($creadoH);

            $obraId = DB::table('obras')->insertGetId([
                'codigo'     => $codigo,
                'titulo'     => $titulo,
                'monto'      => $monto,
                'fecha'      => $createdAt->toDateString(),
                'estado'     => $estado,
                'cliente_id' => $clienteId,
                'user_id'    => $asesorId,
                'created_at' => $createdAt,
                'updated_at' => $now,
            ]);

            // Inserción de Bitácoras técnicas
            foreach ($cfg['bitacoras'] as $b) {
                DB::table('bitacoras')->insert([
                    'obra_id'       => $obraId,
                    'user_id'       => $asesorId,
                    'tipo_contacto' => $b[0],
                    'comentario'    => $b[1],
                    'archivo_path'  => null,
                    'created_at'    => $createdAt->copy()->addMinutes(30),
                    'updated_at'    => $createdAt->copy()->addMinutes(30),
                ]);
            }

            // Inserción de Inspecciones
            $inspeccionIds = [];
            foreach ($cfg['inspecciones'] as $insCfg) {
                $inspCreatedAt = $now->copy()->subHours($insCfg['creado_h']);
                
                if (!empty($insCfg['futuro'])) {
                    $fechaInsp = $now->copy()->addHours($insCfg['fecha_rel']);
                } else {
                    $fechaInsp = $now->copy()->subHours($insCfg['fecha_rel']);
                }

                $inspUpdatedAt = ($insCfg['estado'] === 'Completada') 
                    ? $now->copy()->subHours($insCfg['actualizado_h'] ?? ($insCfg['creado_h'] - 2))
                    : $now;

                $insId = DB::table('inspecciones')->insertGetId([
                    'obra_id'            => $obraId,
                    'user_id'            => $asesorId,
                    'ingeniero_asignado' => $insCfg['ingeniero'],
                    'fecha_inspeccion'   => $fechaInsp,
                    'resultado'          => $insCfg['resultado'],
                    'estado_inspeccion'  => $insCfg['estado'],
                    'created_at'         => $inspCreatedAt,
                    'updated_at'         => $inspUpdatedAt,
                ]);
                $inspeccionIds[] = $insId;
            }

            // Inserción de Cotizaciones y Detalles
            foreach ($cfg['cotizaciones'] as $cotCfg) {
                $codCot = 'COT-2026-' . str_pad($cotCounter++, 4, '0', STR_PAD_LEFT);
                $cotCreatedAt = $now->copy()->subHours($cotCfg['sub_h']);
                $validezDias  = 15;
                $fechaVenc    = ($cotCfg['estado'] === 'Programada') 
                    ? null 
                    : $cotCreatedAt->copy()->addDays($validezDias);

                $cotUpdatedAt = ($cotCfg['estado'] === 'Programada') 
                    ? $cotCreatedAt 
                    : $now->copy()->subHours($cotCfg['actualizado_h'] ?? ($cotCfg['sub_h'] - 1));

                $cotId = DB::table('cotizaciones')->insertGetId([
                    'obra_id'           => $obraId,
                    'user_id'           => $asesorId,
                    'codigo_cotizacion' => $codCot,
                    'monto_total'       => $cotCfg['monto'],
                    'fecha_emision'     => $cotCreatedAt->toDateString(),
                    'validez_dias'      => $validezDias,
                    'fecha_vencimiento' => $fechaVenc,
                    'estado_cotizacion' => $cotCfg['estado'],
                    'observaciones'     => $cotCfg['obs'],
                    'motivo_rechazo'    => $cotCfg['rechazo'],
                    'created_at'        => $cotCreatedAt,
                    'updated_at'        => $cotUpdatedAt,
                ]);

                // Detalles de cotización si tiene monto > 0 y partidas especificadas
                if ($cotCfg['monto'] > 0 && !empty($cotCfg['partidas'])) {
                    $montoCot = $cotCfg['monto'];
                    $numPartidas = count($cotCfg['partidas']);
                    
                    if ($numPartidas === 1) {
                        $pIdx = $cotCfg['partidas'][0];
                        $partidaRef = $partidaIds[$pIdx % count($partidaIds)];
                        DB::table('cotizacion_detalles')->insert([
                            'cotizacion_id'   => $cotId,
                            'partida_id'      => $partidaRef['id'],
                            'cantidad'        => round($montoCot / $partidaRef['precio'], 2),
                            'precio_unitario' => $partidaRef['precio'],
                            'subtotal'        => $montoCot,
                            'created_at'      => $cotCreatedAt,
                            'updated_at'      => $cotCreatedAt,
                        ]);
                    } else {
                        $pIdx1 = $cotCfg['partidas'][0];
                        $pIdx2 = $cotCfg['partidas'][1];
                        $partidaRef1 = $partidaIds[$pIdx1 % count($partidaIds)];
                        $partidaRef2 = $partidaIds[$pIdx2 % count($partidaIds)];

                        $sub1 = round($montoCot * 0.60, 2);
                        $sub2 = round($montoCot - $sub1, 2);

                        DB::table('cotizacion_detalles')->insert([
                            [
                                'cotizacion_id'   => $cotId,
                                'partida_id'      => $partidaRef1['id'],
                                'cantidad'        => round($sub1 / $partidaRef1['precio'], 2),
                                'precio_unitario' => $partidaRef1['precio'],
                                'subtotal'        => $sub1,
                                'created_at'      => $cotCreatedAt,
                                'updated_at'      => $cotCreatedAt,
                            ],
                            [
                                'cotizacion_id'   => $cotId,
                                'partida_id'      => $partidaRef2['id'],
                                'cantidad'        => round($sub2 / $partidaRef2['precio'], 2),
                                'precio_unitario' => $partidaRef2['precio'],
                                'subtotal'        => $sub2,
                                'created_at'      => $cotCreatedAt,
                                'updated_at'      => $cotCreatedAt,
                            ],
                        ]);
                    }
                }
            }

            // Inserción de Alertas SLA auditables
            foreach ($cfg['sla_alertas'] as $slaCfg) {
                $polId = ($slaCfg[0] === 'VISITA_INSPECCION') ? $politicaVisitaId : $politicaCotizId;
                $horasRetraso = $slaCfg[1];
                $estadoAlerta = $slaCfg[2];
                $subHDisparo  = $slaCfg[3];

                DB::table('sla_alertas_logs')->insert([
                    'obra_id'                  => $obraId,
                    'sla_politica_id'          => $polId,
                    'user_id'                  => $asesorId,
                    'horas_retraso_detectadas' => $horasRetraso,
                    'estado_alerta'            => $estadoAlerta,
                    'fecha_disparo'            => $now->copy()->subHours($subHDisparo),
                    'fecha_resolucion'         => null,
                    'created_at'               => $now->copy()->subHours($subHDisparo),
                    'updated_at'               => $now,
                ]);
            }
        }

        // 6. ACTUALIZACIÓN AUTOMÁTICA DEL ESTADO DE LOS CLIENTES SEGÚN REGLA DE NEGOCIO INSTITUCIONAL
        // Si tiene obras Aceptadas -> ACTIVO
        // Si no tiene Aceptadas pero tiene vivas -> EN_EVALUACION
        // Si no tiene vivas ni ganadas (todas canceladas o sin obras) -> INACTIVO
        foreach ($clienteIds as $cId) {
            \App\Http\Controllers\Comercial\PipelineController::actualizarEstadoCliente($cId);
        }
    }
}