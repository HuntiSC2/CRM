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

        // 3. CLIENTES
        $clientesData = [
            ['20100010724', 'COSAPI S.A.', 'Av. República de Colombia 791, San Isidro', 'Ing. Jorge Ramírez', '987654321', 'jramirez@cosapi.com.pe', 'ACTIVO'],
            ['20508608889', 'AESA INFRAESTRUCTURA Y MINERIA S.A.', 'Av. Javier Prado Este 4403, Surco', 'Ing. Paola Quispe', '984112233', 'pquispe@aesa.com.pe', 'ACTIVO'],
            ['20100041956', 'JJC CONTRATISTAS GENERALES S.A.', 'Av. República de Chile 388, Jesús María', 'Ing. Luis Castro', '991223344', 'lcastro@jjc.com.pe', 'ACTIVO'],
            ['20100047211', 'FERREYROS S.A.', 'Jr. Cristóbal de Peralta Norte 820, Surco', 'Arq. Andrea Torres', '998776655', 'atorres@ferreyros.com.pe', 'EN_EVALUACION'],
            ['20100030164', 'MOTA-ENGIL PERU S.A.', 'Av. Nicolás Arriola 740, La Victoria', 'Ing. Marco Díaz', '995443322', 'mdiaz@mota-engil.pe', 'EN_EVALUACION'],
            ['20258930777', 'BESCO S.A.C.', 'Av. Paseo de la República 3832, San Isidro', 'Ing. Sofía León', '986554411', 'sleon@besco.com.pe', 'EN_EVALUACION'],
            ['20330604217', 'UNION DE CONCRETERAS S.A. (UNICON)', 'Panamericana Sur Km 11.4, SJM', 'Ing. Raúl Herrera', '982334455', 'rherrera@unicon.com.pe', 'EN_EVALUACION'],
            ['20100146383', 'AENZA S.A.A.', 'Av. Petit Thouars 4957, Miraflores', 'Ing. Valeria Salas', '981223399', 'vsalas@aenza.com.pe', 'EN_EVALUACION'],
            ['20512345671', 'HV CONTRATISTAS S.A.', 'Av. El Derby 250, Surco', 'Ing. Diego Rojas', '977889900', 'drojas@hvcontratistas.pe', 'EN_EVALUACION'],
            ['20456789123', 'INVERSIONES CENTENARIO S.A.A.', 'Av. Víctor Andrés Belaúnde 147, San Isidro', 'Arq. Camila Flores', '976554433', 'cflores@centenario.com.pe', 'EN_EVALUACION'],
            ['20534112233', 'CONSTRUCTORA MALAGA HNOS S.A.', 'Calle Las Begonias 475, San Isidro', 'Ing. Fernando Vega', '965443322', 'fvega@malagahnos.com.pe', 'EN_EVALUACION'],
            ['20498765432', 'CASA CONSTRUCCION Y ADMINISTRACION S.A.', 'Av. Javier Prado Oeste 2108, San Isidro', 'Ing. Martín Silva', '964332211', 'msilva@casa.com.pe', 'EN_EVALUACION'],
            ['20511223344', 'INMOBILIARIA EDIFICA S.A.C.', 'Av. Benavides 1944, Miraflores', 'Arq. Claudia Núñez', '954321987', 'cnunez@edifica.com.pe', 'EN_EVALUACION'],
            ['20522334455', 'OHLA PERU S.A.C.', 'Av. Santo Toribio 143, San Isidro', 'Ing. Héctor Paredes', '955667788', 'hparedes@ohla.pe', 'EN_EVALUACION'],
            ['20533445566', 'CONCREMAX S.A.', 'Av. Materiales 2450, Cercado de Lima', 'Ing. Bruno Chávez', '944556677', 'bchavez@concremax.com.pe', 'EN_EVALUACION'],
            ['20544556677', 'LOS PORTALES S.A.', 'Jr. Mariscal La Mar 991, Magdalena', 'Arq. Daniela Cruz', '943219876', 'dcruz@losportales.com.pe', 'INACTIVO'],
            ['20555667788', 'ALICORP S.A.A. - DIV. INFRAESTRUCTURA', 'Av. Argentina 4793, Callao', 'Ing. Oscar Medina', '933445566', 'omedina@alicorp.com.pe', 'INACTIVO'],
            ['20566778899', 'APM TERMINALS CALLAO S.A.', 'Av. Contralmirante Raygada 111, Callao', 'Ing. Renato Paz', '922334455', 'rpaz@apmterminals.com', 'INACTIVO'],
            ['20577889900', 'RANSA COMERCIAL S.A.', 'Av. Argentina 2833, Callao', 'Ing. Sergio Luna', '911223344', 'sluna@ransa.net', 'INACTIVO'],
            ['20588990011', 'CEMENTOS PACASMAYO S.A.A.', 'Calle La Colonia 150, Surco', 'Ing. Patricia Soto', '912345678', 'psoto@cpsaa.com.pe', 'INACTIVO'],
        ];

        $clienteIds = [];
        foreach ($clientesData as $i => $c) {
            $clienteIds[] = DB::table('clientes')->insertGetId([
                'ruc'               => $c[0],
                'razon_social'      => $c[1],
                'direccion'         => $c[2],
                'nombre_contacto'   => $c[3],
                'telefono_contacto' => $c[4],
                'email_contacto'    => $c[5],
                'estado'            => $c[6],
                'observaciones'     => 'Cliente corporativo incorporado en cartera DTL Premier.',
                'user_id'           => $asesores[$i % 2],
                'created_at'        => $now->copy()->subDays(90 - $i),
                'updated_at'        => $now->copy()->subDays(10),
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

        // 5. OBRAS
        $obrasConfig = [
            ['Inspección Estructural Torre San Isidro',        48000.00,  'Prospecto',        141, 'PROSPECTO_SIN_VISITA'],
            ['Mantenimiento de Túneles Vía de Evitamiento',    185000.00, 'Prospecto',        165, 'PROSPECTO_SIN_VISITA'],
            ['Evaluación de Losa Industrial Almacén Norte',    62000.00,  'Prospecto',        4,   'PROSPECTO_NUEVO'],
            ['Pavimentación y Zanjas Centro Logístico Lurín',  245000.00, 'Inspeccion',       69,  'INSP_VENCIDA_2_PARTES'],
            ['Cimentación Profunda Subestación Eléctrica Sur', 310000.00, 'Inspeccion',       52,  'INSP_VENCIDA'],
            ['Reforzamiento de Vigas Puente Peatonal Rimac',   128000.00, 'Inspeccion',       8,   'INSP_PENDIENTE_A_TIEMPO'],
            ['Impermeabilización Reservorio Planta Callao',    74500.00,  'Inspeccion',       14,  'INSP_PENDIENTE_A_TIEMPO'],
            ['Edificio Multifamiliar San Isidro Suites',       420000.00, 'Inspeccion',       120, 'INSP_COMPLETADA_SIN_COTIZ'],
            ['Estudio de Mecánica de Suelos Torre Ferreyros',  38500.00,  'Inspeccion',       96,  'INSP_COMPLETADA_SIN_COTIZ'],
            ['Nave Industrial y Piso Pulido Chilca KM 62',     560000.00, 'Inspeccion',       72,  'INSP_COMPLETADA_SIN_COTIZ'],
            ['Ampliación Planta Industrial Huachipa Etapa II', 390000.00, 'Cotización',       10,  'COTIZ_PROGRAMADA'],
            ['Construcción Muro de Contención Costa Verde',    275000.00, 'Cotización',       18,  'COTIZ_ENVIADA'],
            ['Rehabilitación de Pavimentos Complejo Callao',   315000.00, 'Cotización',       25,  'COTIZ_ACEPTADA'],
            ['Canal de Derivación y Drenaje Pluvial Lurín',    185000.00, 'Cotización',       30,  'COTIZ_RECHAZADA'],
            ['Reparación Estructural Muelle Callao Zona 4',    680000.00, 'Cierre Comercial', 2,   'CIERRE_COMERCIAL'],
            ['Instalación Línea Tubería HDPE Planta Cementos', 198000.00, 'Cierre Comercial', 1,   'CIERRE_COMERCIAL'],
            ['Construcción Almacén Central Cosapi Sur',        890000.00, 'Aceptada',         1,   'GANADA_HISTORIAL'],
            ['Rehabilitación Vial Acceso Mina Aesa',           740000.00, 'Aceptada',         2,   'GANADA_HISTORIAL'],
            ['Cerco Perimétrico y Garitas Condominio Sur',     145000.00, 'Cancelada',        1,   'CANCELADA_HISTORIAL'],
            ['Techado Metálico Patio de Carga Norte',          220000.00, 'Cancelada',        2,   'CANCELADA_HISTORIAL'],
        ];

        $ingenieros = ['Ing. Luis Navarro', 'Ing. Carmen Delgado', 'Ing. Roberto Zúñiga', 'Ing. Patricia Paredes'];
        $tiposContacto = ['Llamada Telefónica', 'Reunión Presencial', 'Correo Electrónico', 'Seguimiento'];
        $cotCounter = 1;

        foreach ($obrasConfig as $idx => $cfg) {
            $num       = $idx + 1;
            $codigo    = 'OBR-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            $titulo    = $cfg[0];
            $monto     = $cfg[1];
            $estado    = $cfg[2];
            $tiempo    = $cfg[3];
            $escenario = $cfg[4];

            $clienteId = $clienteIds[$idx];
            $asesorId  = $asesores[$idx % 2];
            $ingeniero = $ingenieros[$idx % count($ingenieros)];

            if (str_contains($escenario, 'HISTORIAL')) {
                $createdAt = $now->copy()->subMonths(1)->startOfMonth()->addDays(5 + $idx);
            } elseif ($estado === 'Prospecto') {
                $createdAt = $now->copy()->subHours($tiempo);
            } elseif ($estado === 'Inspeccion') {
                $createdAt = $now->copy()->subHours($tiempo + 24);
            } elseif ($estado === 'Cotización') {
                $createdAt = $now->copy()->subHours($tiempo + 48);
            } else {
                $createdAt = $now->copy()->subDays(15 - $tiempo);
            }

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

            DB::table('bitacoras')->insert([
                'obra_id'       => $obraId,
                'user_id'       => $asesorId,
                'comentario'    => "Seguimiento técnico comercial de {$titulo}. Coordinación inicial con el cliente.",
                'tipo_contacto' => $tiposContacto[$idx % count($tiposContacto)],
                'archivo_path'  => null,
                'created_at'    => $createdAt->copy()->addHours(2),
                'updated_at'    => $createdAt->copy()->addHours(2),
            ]);

            if ($estado !== 'Prospecto') {
                if ($escenario === 'INSP_VENCIDA_2_PARTES') {
                    DB::table('inspecciones')->insert([
                        'obra_id'            => $obraId,
                        'user_id'            => $asesorId,
                        'ingeniero_asignado' => 'Ing. Mario Eloy',
                        'fecha_inspeccion'   => $now->copy()->subDays(5),
                        'resultado'          => 'Levantamiento topográfico inicial completado en sector 1.',
                        'estado_inspeccion'  => 'Completada',
                        'created_at'         => $now->copy()->subDays(5),
                        'updated_at'         => $now->copy()->subDays(5),
                    ]);
                    DB::table('inspecciones')->insert([
                        'obra_id'            => $obraId,
                        'user_id'            => $asesorId,
                        'ingeniero_asignado' => 'Ing. Patricia Paredes',
                        'fecha_inspeccion'   => $now->copy()->subHours(24),
                        'resultado'          => null,
                        'estado_inspeccion'  => 'Pendiente',
                        'created_at'         => $now->copy()->subDays(2),
                        'updated_at'         => $now,
                    ]);
                } elseif ($escenario === 'INSP_VENCIDA') {
                    DB::table('inspecciones')->insert([
                        'obra_id'            => $obraId,
                        'user_id'            => $asesorId,
                        'ingeniero_asignado' => $ingeniero,
                        'fecha_inspeccion'   => $now->copy()->subHours(36),
                        'resultado'          => null,
                        'estado_inspeccion'  => 'Pendiente',
                        'created_at'         => $now->copy()->subDays(2),
                        'updated_at'         => $now,
                    ]);
                } elseif ($escenario === 'INSP_PENDIENTE_A_TIEMPO') {
                    DB::table('inspecciones')->insert([
                        'obra_id'            => $obraId,
                        'user_id'            => $asesorId,
                        'ingeniero_asignado' => $ingeniero,
                        'fecha_inspeccion'   => $now->copy()->addDays(2),
                        'resultado'          => null,
                        'estado_inspeccion'  => 'Pendiente',
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ]);
                } else {
                    DB::table('inspecciones')->insert([
                        'obra_id'            => $obraId,
                        'user_id'            => $asesorId,
                        'ingeniero_asignado' => $ingeniero,
                        'fecha_inspeccion'   => $createdAt->copy()->addHours(12),
                        'resultado'          => 'Visita técnica completada sin incidencias. Metrados validados en campo.',
                        'estado_inspeccion'  => 'Completada',
                        'created_at'         => $createdAt->copy()->addHours(12),
                        'updated_at'         => $createdAt->copy()->addHours(14),
                    ]);
                }
            }

            $requiereCotizacion = in_array($escenario, [
                'COTIZ_PROGRAMADA', 'COTIZ_ENVIADA', 'COTIZ_ACEPTADA', 'COTIZ_RECHAZADA',
                'CIERRE_COMERCIAL', 'GANADA_HISTORIAL', 'CANCELADA_HISTORIAL'
            ]);

            if ($requiereCotizacion) {
                $codCot = 'COT-2026-' . str_pad($cotCounter++, 4, '0', STR_PAD_LEFT);

                $estadoCot = match ($escenario) {
                    'COTIZ_PROGRAMADA'    => 'Programada',
                    'COTIZ_ENVIADA'       => 'Enviada',
                    'COTIZ_ACEPTADA'      => 'Aceptada',
                    'COTIZ_RECHAZADA'     => 'Rechazada',
                    'CIERRE_COMERCIAL'    => 'Aceptada',
                    'GANADA_HISTORIAL'    => 'Aceptada',
                    default               => 'Rechazada',
                };

                $fechaEmision = $createdAt->copy()->addDays(2);
                $fechaEnvio   = ($estadoCot === 'Programada') ? null : $fechaEmision->copy()->addHours(12);
                $montoCot     = ($estadoCot === 'Programada') ? 0.00 : $monto;

                $cotId = DB::table('cotizaciones')->insertGetId([
                    'obra_id'           => $obraId,
                    'user_id'           => $asesorId,
                    'codigo_cotizacion' => $codCot,
                    'monto_total'       => $montoCot,
                    'fecha_emision'     => $fechaEmision->toDateString(),
                    'validez_dias'      => 15,
                    'fecha_vencimiento' => $fechaEnvio,
                    'estado_cotizacion' => $estadoCot,
                    'observaciones'     => ($estadoCot === 'Programada') ? null : 'Oferta técnico-económica formal con validez de 15 días.',
                    'motivo_rechazo'    => ($estadoCot === 'Rechazada') ? 'Presupuesto excede el techo financiero del cliente.' : null,
                    'created_at'        => $fechaEmision,
                    'updated_at'        => $fechaEnvio ?? $fechaEmision,
                ]);

                if ($montoCot > 0) {
                    $p1 = $partidaIds[$idx % 20];
                    $p2 = $partidaIds[($idx + 5) % 20];
                    $sub1 = round($montoCot * 0.60, 2);
                    $sub2 = round($montoCot - $sub1, 2);

                    DB::table('cotizacion_detalles')->insert([
                        [
                            'cotizacion_id'   => $cotId,
                            'partida_id'      => $p1['id'],
                            'cantidad'        => round($sub1 / $p1['precio'], 2),
                            'precio_unitario' => $p1['precio'],
                            'subtotal'        => $sub1,
                            'created_at'      => $fechaEmision,
                            'updated_at'      => $fechaEmision,
                        ],
                        [
                            'cotizacion_id'   => $cotId,
                            'partida_id'      => $p2['id'],
                            'cantidad'        => round($sub2 / $p2['precio'], 2),
                            'precio_unitario' => $p2['precio'],
                            'subtotal'        => $sub2,
                            'created_at'      => $fechaEmision,
                            'updated_at'      => $fechaEmision,
                        ],
                    ]);
                }
            }

            if ($escenario === 'INSP_VENCIDA' || $escenario === 'INSP_VENCIDA_2_PARTES') {
                DB::table('sla_alertas_logs')->insert([
                    'obra_id'                  => $obraId,
                    'sla_politica_id'          => $politicaVisitaId,
                    'user_id'                  => $asesorId,
                    'horas_retraso_detectadas' => $tiempo,
                    'estado_alerta'            => 'VIGENTE',
                    'fecha_disparo'            => $now->copy()->subHours(12),
                    'fecha_resolucion'         => null,
                    'created_at'               => $now->copy()->subHours(12),
                    'updated_at'               => $now,
                ]);
            }
        }
    }
}