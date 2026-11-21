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

        // Limpieza controlada en orden inverso de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sla_alertas_logs')->truncate();
        DB::table('cotizacion_detalles')->truncate();
        DB::table('historial_precios_partidas')->truncate();
        DB::table('bitacoras')->truncate();
        DB::table('cotizaciones')->truncate();
        DB::table('inspecciones')->truncate();
        DB::table('obras')->truncate();
        DB::table('partidas')->truncate();
        DB::table('clientes')->truncate();
        DB::table('sla_politicas')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =========================================================================
        // 1. USUARIOS CON CONTRASEÑAS ROBUSTAS Y ROLES EMPRESARIALES
        // =========================================================================
        $admin = User::create([
            'name'              => 'Ing. Marcos Benavides (Admin TI)',
            'email'             => 'admin.dtl@dtlpremier.pe',
            'email_verified_at' => $now,
            'password'          => Hash::make('DtlPremier2026#Admin'),
            'role'              => 'administrador',
            'login_attempts'    => 0,
            'is_active'         => true,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $gerente = User::create([
            'name'              => 'Ing. Ricardo Paredes (Gerente General)',
            'email'             => 'gerencia.general@dtlpremier.pe',
            'email_verified_at' => $now,
            'password'          => Hash::make('DtlGerencia2026!Paredes'),
            'role'              => 'directivo',
            'login_attempts'    => 0,
            'is_active'         => true,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $asesor1 = User::create([
            'name'              => 'Carlos Mendoza (Asesor Senior)',
            'email'             => 'carlos.mendoza@dtlpremier.pe',
            'email_verified_at' => $now,
            'password'          => Hash::make('Comercial2026*Mendoza'),
            'role'              => 'ejecutivo',
            'login_attempts'    => 0,
            'is_active'         => true,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $asesor2 = User::create([
            'name'              => 'Lucía Vargas (Asesora Senior)',
            'email'             => 'lucia.vargas@dtlpremier.pe',
            'email_verified_at' => $now,
            'password'          => Hash::make('Comercial2026*Vargas'),
            'role'              => 'ejecutivo',
            'login_attempts'    => 0,
            'is_active'         => true,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $adminId  = $admin->id;
        $asesores = [$asesor1->id, $asesor2->id];

        // =========================================================================
        // 2. POLÍTICAS INSTITUCIONALES SLA
        // =========================================================================
        $politicaVisitaId = DB::table('sla_politicas')->insertGetId([
            'user_id'             => $adminId,
            'etapa_evaluada'      => 'VISITA_INSPECCION',
            'tiempo_limite_horas' => 24,
            'nivel_severidad'     => 'AMARILLO',
            'email_notificacion'  => 'alertas.sla@dtlpremier.pe',
            'notificacion_activa' => true,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        $politicaCotizId = DB::table('sla_politicas')->insertGetId([
            'user_id'             => $adminId,
            'etapa_evaluada'      => 'COTIZACION_PROPUESTA',
            'tiempo_limite_horas' => 48,
            'nivel_severidad'     => 'ROJO',
            'email_notificacion'  => 'alertas.sla@dtlpremier.pe',
            'notificacion_activa' => true,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // =========================================================================
        // 3. DIRECTORIO DE 30 CLIENTES CORPORATIVOS
        // =========================================================================
        $clientesData = [
            ['20100010724', 'COSAPI S.A.', 'Av. República de Colombia 791, San Isidro, Lima', 'Ing. Jorge Ramírez Silva', '987654321', 'jramirez@cosapi.com.pe', 'Contratista principal en megaobras de infraestructura y minería.'],
            ['20508608889', 'AESA INFRAESTRUCTURA Y MINERIA S.A.', 'Av. Javier Prado Este 4403, Surco, Lima', 'Ing. Paola Quispe Ramos', '984112233', 'pquispe@aesa.com.pe', 'Especialistas en obras subterráneas y movimiento de tierras.'],
            ['20100041956', 'JJC CONTRATISTAS GENERALES S.A.', 'Av. República de Chile 388, Jesús María, Lima', 'Ing. Luis Castro Mendoza', '991223344', 'lcastro@jjc.com.pe', 'Constructora líder en edificaciones industriales y viales.'],
            ['20100047211', 'FERREYROS S.A.', 'Jr. Cristóbal de Peralta Norte 820, Surco, Lima', 'Arq. Andrea Torres Benavides', '998776655', 'atorres@ferreyros.com.pe', 'Habilitación de talleres mecánicos y losas pesadas.'],
            ['20100030164', 'MOTA-ENGIL PERU S.A.', 'Av. Nicolás Arriola 740, La Victoria, Lima', 'Ing. Marco Díaz Falconí', '995443322', 'mdiaz@mota-engil.pe', 'Consorcio internacional enfocado en puertos y carreteras.'],
            ['20258930777', 'BESCO S.A.C.', 'Av. Paseo de la República 3832, San Isidro, Lima', 'Ing. Sofía León Barreto', '986554411', 'sleon@besco.com.pe', 'Grandes conjuntos habitacionales y centros urbanos mixtos.'],
            ['20330604217', 'UNION DE CONCRETERAS S.A. (UNICON)', 'Panamericana Sur Km 11.4, San Juan de Miraflores, Lima', 'Ing. Raúl Herrera Prado', '982334455', 'rherrera@unicon.com.pe', 'Pavimentación de plantas industriales y cimentaciones pesadas.'],
            ['20100146383', 'AENZA S.A.A.', 'Av. Petit Thouars 4957, Miraflores, Lima', 'Ing. Valeria Salas Cárdenas', '981223399', 'vsalas@aenza.com.pe', 'Infraestructura vial, túneles y concesiones estratégicas.'],
            ['20512345671', 'HV CONTRATISTAS S.A.', 'Av. El Derby 250, Of. 801, Surco, Lima', 'Ing. Diego Rojas Morales', '977889900', 'drojas@hvcontratistas.pe', 'Edificación de almacenes logísticos y naves industriales.'],
            ['20456789123', 'INVERSIONES CENTENARIO S.A.A.', 'Av. Víctor Andrés Belaúnde 147, San Isidro, Lima', 'Arq. Camila Flores Navarro', '976554433', 'cflores@centenario.com.pe', 'Desarrollo de parques industriales y centros empresariales.'],
            ['20534112233', 'CONSTRUCTORA MALAGA HNOS S.A.', 'Calle Las Begonias 475, San Isidro, Lima', 'Ing. Fernando Vega Delgado', '965443322', 'fvega@malagahnos.com.pe', 'Puentes vehiculares, canales y defensas ribereñas.'],
            ['20498765432', 'CASA CONSTRUCCION Y ADMINISTRACION S.A.', 'Av. Javier Prado Oeste 2108, San Isidro, Lima', 'Ing. Martín Silva Rivas', '964332211', 'msilva@casa.com.pe', 'Conservación vial y pavimentaciones con asfalto en caliente.'],
            ['20511223344', 'INMOBILIARIA EDIFICA S.A.C.', 'Av. Benavides 1944, Miraflores, Lima', 'Arq. Claudia Núñez Vidal', '954321987', 'cnunez@edifica.com.pe', 'Edificios residenciales de gran altura y muelles recreativos.'],
            ['20522334455', 'OHLA PERU S.A.C.', 'Av. Santo Toribio 143, San Isidro, Lima', 'Ing. Héctor Paredes Loyola', '955667788', 'hparedes@ohla.pe', 'Obras de saneamiento, hospitales e ingeniería hidráulica.'],
            ['20533445566', 'CONCREMAX S.A.', 'Av. Materiales 2450, Cercado de Lima, Lima', 'Ing. Bruno Chávez Tello', '944556677', 'bchavez@concremax.com.pe', 'Patios de maniobra para tolvas y naves de prefabricados.'],
            ['20544556677', 'LOS PORTALES S.A.', 'Jr. Mariscal La Mar 991, Magdalena del Mar, Lima', 'Arq. Daniela Cruz Solís', '943219876', 'dcruz@losportales.com.pe', 'Estacionamientos subterráneos y redes de habilitación urbana.'],
            ['20555667788', 'ALICORP S.A.A. - DIV. INFRAESTRUCTURA', 'Av. Argentina 4793, Callao', 'Ing. Oscar Medina Valdivia', '933445566', 'omedina@alicorp.com.pe', 'Líneas de envasado y losas con endurecedores químicos.'],
            ['20566778899', 'APM TERMINALS CALLAO S.A.', 'Av. Contralmirante Raygada 111, Callao', 'Ing. Renato Paz Zegarra', '922334455', 'rpaz@apmterminals.com', 'Mantenimiento de atracaderos y juntas sometidas a salinidad.'],
            ['20577889900', 'RANSA COMERCIAL S.A.', 'Av. Argentina 2833, Callao', 'Ing. Sergio Luna Montoya', '911223344', 'sluna@ransa.net', 'Almacenes frigoríficos y rampas niveladoras para trailers.'],
            ['20588990011', 'CEMENTOS PACASMAYO S.A.A.', 'Calle La Colonia 150, Surco, Lima', 'Ing. Patricia Soto Ugarte', '912345678', 'psoto@cpsaa.com.pe', 'Cerramientos metálicos de tolvas y silos de almacenamiento.'],
            ['20601234567', 'GYM EDIFICACIONES S.A.C.', 'Av. Paseo de la República 4667, Surquillo, Lima', 'Ing. Gonzalo Arana Ruiz', '934567890', 'garana@gym.com.pe', 'Proyectos inmobiliarios premium y centros comerciales.'],
            ['20549812345', 'SACYR CONCESIONES PERU S.A.C.', 'Av. Canaval y Moreyra 452, San Isidro, Lima', 'Ing. Manuel Soriano Gil', '945678901', 'msoriano@sacyr.pe', 'Concesión y mantenimiento estructural de tramos viales.'],
            ['20100153835', 'CORPORACION ACEROS AREQUIPA S.A.', 'Av. Antonio Miró Quesada 425, Magdalena del Mar, Lima', 'Ing. Fabricio Peña Alva', '956789012', 'fpena@acerosarequipa.pe', 'Parques de chatarra y losas para grúas electromagnéticas.'],
            ['20519283746', 'UNACEM PERU S.A.', 'Av. Atocongo 2440, Villa María del Triunfo, Lima', 'Ing. Walter Benavides Castro', '967890123', 'wbenavides@unacem.com.pe', 'Mantenimiento de túneles de faja transportadora de clínker.'],
            ['20485920391', 'STRACON S.A.', 'Av. Mariscal La Mar 1120, Miraflores, Lima', 'Ing. Esteban Prado Zúñiga', '978901234', 'eprado@stracon.com', 'Servicios de excavación y obras civiles para minería a tajo abierto.'],
            ['20563829104', 'TDM ASFALTOS S.A.C.', 'Av. Separadora Industrial 2240, Ate, Lima', 'Ing. Rocío Cárdenas Mora', '989012345', 'rcardenas@tdm.com.pe', 'Suministro y colocación de geomembranas y mezclas asfálticas.'],
            ['20602938475', 'ICCGSA INGENIEROS CIVILES S.A.', 'Calle Aramburú 166, San Isidro, Lima', 'Ing. Jaime Morales Ponce', '990123456', 'jmorales@iccgsa.pe', 'Pavimentos rígidos de concreto y defensas de riberas fluviales.'],
            ['20510293847', 'TECHINT S.A.C.', 'Av. Del Pinar 180, Chacarilla, Surco, Lima', 'Ing. Roberto Fabbri Varsi', '912304958', 'rfabbri@techint.pe', 'Instalación de ductos de hidrocarburos y estaciones de bombeo.'],
            ['20100070972', 'SOUTHERN PERU COPPER CORP.', 'Av. Caminos del Inca 171, Chacarilla, Surco, Lima', 'Ing. Andrés Beltrán Loyola', '923415069', 'abeltran@southernperu.com.pe', 'Ampliación de fundición y diques de relave en Moquegua.'],
            ['20554433221', 'MINERA LAS BAMBAS S.A.', 'Av. El Derby 055, Torre 1, Surco, Lima', 'Ing. Javier Cárdenas Ugarte', '934526170', 'jcardenas@lasbambas.com', 'Construcción de bypasses, bermas de seguridad y campamentos.']
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
                'estado'            => 'INACTIVO',
                'observaciones'     => $c[6],
                'user_id'           => $asesores[$i % 2],
                'created_at'        => $now->copy()->subDays(100 - $i),
                'updated_at'        => $now->copy()->subDays(2),
            ]);
        }

        // =========================================================================
        // 4. CATÁLOGO MAESTRO DE 30 PARTIDAS OFICIALES
        // =========================================================================
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
            ['PAR-021', 'Demolición Controlada de Concreto Armado con Martillo Hidráulico', 'Demoliciones', 'm3', 115.00],
            ['PAR-022', 'Pintura Epóxica de Alto Tráfico para Zonas de Maniobra', 'Acabados Industriales', 'm2', 45.00],
            ['PAR-023', 'Perforación Diamantina en Losas de Concreto (d=4")', 'Ensayos de Control', 'und', 210.00],
            ['PAR-024', 'Instalación de Geomembrana HDPE e=1.5mm Termosellada', 'Obras Hidráulicas', 'm2', 28.50],
            ['PAR-025', 'Muro de Contención Gavionado con Malla Triple Torsión', 'Defensas Ribereñas', 'm3', 195.00],
            ['PAR-026', 'Anclajes Pasivos y Activos en Taludes con Pernos Helicoidales', 'Geotecnia Avanzada', 'ml', 260.00],
            ['PAR-027', 'Shotcrete Vía Húmeda f\'c=250 kg/cm2 con Fibra Metálica', 'Sostenimiento', 'm3', 520.00],
            ['PAR-028', 'Suministro e Hincado de Tablestacas Metálicas Laminadas', 'Obras Portuarias', 'kg', 18.20],
            ['PAR-029', 'Microcemento y Sellado Hidrófugo en Fachadas Comerciales', 'Arquitectura Técnica', 'm2', 85.00],
            ['PAR-030', 'Ensayos de Integridad de Pilotes por Ultrasonido (Crosshole)', 'Control Geotécnico', 'und', 1250.00],
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
                'created_at'      => $now->copy()->subMonths(5),
                'updated_at'      => $now->copy()->subDays(10),
            ]);
            $partidaIds[] = ['id' => $pid, 'precio' => $p[4]];

            // Historial de auditoría para las primeras 15 partidas
            if ($idx < 15) {
                DB::table('historial_precios_partidas')->insert([
                    'partida_id'      => $pid,
                    'user_id'         => $adminId,
                    'precio_anterior' => round($p[4] * 0.90, 2),
                    'precio_nuevo'    => $p[4],
                    'motivo_cambio'   => 'Actualización anual según tarifario de la Cámara Peruana de la Construcción.',
                    'created_at'      => $now->copy()->subDays(30 - $idx),
                    'updated_at'      => $now->copy()->subDays(30 - $idx),
                ]);
            }
        }

        // =========================================================================
        // 5. DISTRIBUCIÓN ESTRATÉGICA DE 30 OBRAS (PIPELINE, SEMÁFOROS Y HISTORIAL)
        // =========================================================================
        $obrasPlan = [
            // PROSPECTOS (5 obras)
            0 => ['titulo' => 'Inspección Estructural Torre Corporativa San Isidro', 'monto' => 48000.00, 'estado' => 'Prospecto', 'creado_h' => 6, 'insp' => [], 'cot' => [], 'bit' => [['Reunión Presencial', 'Reunión inicial de coordinación técnica.']], 'sla' => []],
            1 => ['titulo' => 'Mantenimiento de Túneles y Drenaje Vía de Evitamiento', 'monto' => 185000.00, 'estado' => 'Prospecto', 'creado_h' => 44, 'insp' => [], 'cot' => [], 'bit' => [['Llamada Telefónica', 'Cliente solicita reprogramar visita por huelga de transportistas.']], 'sla' => [['VISITA_INSPECCION', 44, 'VIGENTE', 20]]],
            2 => ['titulo' => 'Evaluación de Losa Industrial y Cargas Almacén Norte', 'monto' => 62000.00, 'estado' => 'Prospecto', 'creado_h' => 10, 'insp' => [], 'cot' => [], 'bit' => [['Correo Electrónico', 'Envío de términos de referencia técnicos para visita.']], 'sla' => []],
            3 => ['titulo' => 'Inspección de Muros Diafragma Proyecto Miraflores', 'monto' => 78000.00, 'estado' => 'Prospecto', 'creado_h' => 14, 'insp' => [], 'cot' => [], 'bit' => [['Llamada Telefónica', 'Revisión de planos estructurales en Autocad.']], 'sla' => []],
            4 => ['titulo' => 'Peritaje Técnico de Filtraciones en Estacionamiento Subterráneo', 'monto' => 54000.00, 'estado' => 'Prospecto', 'creado_h' => 8, 'insp' => [], 'cot' => [], 'bit' => [['Reunión Presencial', 'Coordinación con la junta de propietarios.']], 'sla' => []],

            // INSPECCIÓN (6 obras)
            5 => ['titulo' => 'Reforzamiento de Vigas Puente Grúa Taller Ferreyros', 'monto' => 128000.00, 'estado' => 'Inspeccion', 'creado_h' => 28, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 36, 'futuro' => true, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 6]], 'cot' => [], 'bit' => [['Reunión Presencial', 'Pases de ingreso a taller central gestionados.']], 'sla' => []],
            6 => ['titulo' => 'Cimentación Profunda Subestación Eléctrica Sur', 'monto' => 310000.00, 'estado' => 'Inspeccion', 'creado_h' => 58, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 12, 'futuro' => false, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 35]], 'cot' => [], 'bit' => [['Llamada Telefónica', 'Contratista aún no aprueba el plan de seguridad PETAR.']], 'sla' => [['VISITA_INSPECCION', 35, 'VIGENTE', 11]]],
            7 => ['titulo' => 'Impermeabilización y Prueba de Estanqueidad Cisterna Central', 'monto' => 74500.00, 'estado' => 'Inspeccion', 'creado_h' => 22, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 24, 'futuro' => true, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 10]], 'cot' => [], 'bit' => [['Correo Electrónico', 'Cronograma de ingreso aprobado por la residencia.']], 'sla' => []],
            8 => ['titulo' => 'Pavimentación Rígida y Zanjas Centro Logístico Lurín', 'monto' => 245000.00, 'estado' => 'Inspeccion', 'creado_h' => 30, 'insp' => [['ing' => 'Ing. Patricia Paredes', 'h' => 30, 'futuro' => true, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 12]], 'cot' => [], 'bit' => [['Reunión Presencial', 'Inspección de rasantes en patio de maniobras.']], 'sla' => []],
            9 => ['titulo' => 'Estabilización de Talud con Pernos de Anclaje Autopista Central', 'monto' => 195000.00, 'estado' => 'Inspeccion', 'creado_h' => 62, 'insp' => [['ing' => 'Ing. Mario Eloy', 'h' => 18, 'futuro' => false, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 38]], 'cot' => [], 'bit' => [['Llamada Telefónica', 'Lluvias torrenciales impidieron el descenso técnico a talud.']], 'sla' => [['VISITA_INSPECCION', 38, 'VIGENTE', 14]]],
            10 => ['titulo' => 'Evaluación de Pavimentos de Concreto Pista Aérea Pisco', 'monto' => 165000.00, 'estado' => 'Inspeccion', 'creado_h' => 18, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 24, 'futuro' => true, 'est' => 'Pendiente', 'res' => null, 'cr_h' => 8]], 'cot' => [], 'bit' => [['Correo Electrónico', 'Coordinación con CORPAC para permisos en pista.']], 'sla' => []],

            // COTIZACIÓN (7 obras)
            11 => ['titulo' => 'Edificio Multifamiliar San Isidro Suites - Estructuras', 'monto' => 420000.00, 'estado' => 'Cotización', 'creado_h' => 96, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 74, 'futuro' => false, 'est' => 'Completada', 'res' => '1,200 m2 de losas aligeradas y muros validados.', 'cr_h' => 90]], 'cot' => [], 'bit' => [['Llamada Telefónica', 'Cliente exige envío de propuesta formal hoy mismo.']], 'sla' => [['COTIZACION_PROPUESTA', 74, 'VIGENTE', 26]]],
            12 => ['titulo' => 'Ampliación Planta Industrial Huachipa Etapa II', 'monto' => 390000.00, 'estado' => 'Cotización', 'creado_h' => 60, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 36, 'futuro' => false, 'est' => 'Completada', 'res' => 'Verificación de capacidad portante de vigas metálicas.', 'cr_h' => 48]], 'cot' => [['sub_h' => 18, 'est' => 'Programada', 'monto' => 0.00, 'obs' => 'En proceso de metrado por el área técnica.', 'rech' => null, 'part' => []]], 'bit' => [['Correo Electrónico', 'Metrados recibidos del calculista para costeo.']], 'sla' => []],
            13 => ['titulo' => 'Construcción Muro de Contención y Talud Costa Verde', 'monto' => 275000.00, 'estado' => 'Cotización', 'creado_h' => 72, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 48, 'futuro' => false, 'est' => 'Completada', 'res' => 'Muro de contención en voladizo de h=4.50m requerido.', 'cr_h' => 60]], 'cot' => [['sub_h' => 24, 'est' => 'Enviada', 'monto' => 275000.00, 'obs' => 'Propuesta económica entregada a la gerencia de proyectos.', 'rech' => null, 'part' => [5, 7]]], 'bit' => [['Reunión Presencial', 'Sustento técnico de partidas de concreto premezclado.']], 'sla' => []],
            14 => ['titulo' => 'Canal de Derivación y Drenaje Pluvial Lurín', 'monto' => 185000.00, 'estado' => 'Cotización', 'creado_h' => 96, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 70, 'futuro' => false, 'est' => 'Completada', 'res' => 'Canal trapezoidal de concreto armado validado (450 ml).', 'cr_h' => 85]], 'cot' => [['sub_h' => 60, 'est' => 'Rechazada', 'monto' => 185000.00, 'obs' => 'Oferta rechazada por exceder presupuesto base.', 'rech' => 'Presupuesto excede techo del cliente en 12%. Solicitan optimización.', 'part' => [2, 5]]], 'bit' => [['Llamada Telefónica', 'Cliente solicita reajuste económico de precios unitarios.']], 'sla' => [['COTIZACION_PROPUESTA', 58, 'VIGENTE', 10]]],
            15 => ['titulo' => 'Rehabilitación Integral de Pavimentos Complejo Callao', 'monto' => 315000.00, 'estado' => 'Cotización', 'creado_h' => 50, 'insp' => [['ing' => 'Ing. Mario Eloy', 'h' => 32, 'futuro' => false, 'est' => 'Completada', 'res' => 'Fisuración severa en 3,500 m2. Se requiere recapeo.', 'cr_h' => 42]], 'cot' => [['sub_h' => 20, 'est' => 'Enviada', 'monto' => 315000.00, 'obs' => 'Oferta enviada por mesa de partes virtual.', 'rech' => null, 'part' => [9, 10]]], 'bit' => [['Seguimiento', 'En revisión por el comité evaluador de la empresa.']], 'sla' => []],
            16 => ['titulo' => 'Reforzamiento de Muelle Portuario con Fibra de Carbono', 'monto' => 450000.00, 'estado' => 'Cotización', 'creado_h' => 40, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 28, 'futuro' => false, 'est' => 'Completada', 'res' => 'Se requiere encamisado y aplicación de fibra CFRP.', 'cr_h' => 36]], 'cot' => [['sub_h' => 14, 'est' => 'Enviada', 'monto' => 450000.00, 'obs' => 'Presupuesto técnico enviado con certificación marina.', 'rech' => null, 'part' => [11, 12]]], 'bit' => [['Correo Electrónico', 'Cliente solicita desglose de costos indirectos.']], 'sla' => []],
            17 => ['titulo' => 'Instalación de Geotextil y Gaviones en Ribera Mala', 'monto' => 210000.00, 'estado' => 'Cotización', 'creado_h' => 88, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 64, 'futuro' => false, 'est' => 'Completada', 'res' => 'Se requieren 800 m3 de gaviones tipo caja para defensa.', 'cr_h' => 80]], 'cot' => [['sub_h' => 52, 'est' => 'Rechazada', 'monto' => 210000.00, 'obs' => 'Cliente postergó adjudicación por recorte financiero.', 'rech' => 'Postergado para el siguiente trimestre fiscal.', 'part' => [24, 2]]], 'bit' => [['Llamada Telefónica', 'Confirmación de espera para nueva convocatoria.']], 'sla' => [['COTIZACION_PROPUESTA', 52, 'VIGENTE', 4]]],

            // CIERRE COMERCIAL (4 obras)
            18 => ['titulo' => 'Reparación Estructural y Reforzamiento Muelle Callao Zona 4', 'monto' => 680000.00, 'estado' => 'Cierre Comercial', 'creado_h' => 65, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 45, 'futuro' => false, 'est' => 'Completada', 'res' => 'Corrosión avanzada en pilotes. Requiere encamisado.', 'cr_h' => 55]], 'cot' => [['sub_h' => 18, 'est' => 'Aceptada', 'monto' => 680000.00, 'obs' => 'Propuesta aprobada por directorio de cliente.', 'rech' => null, 'part' => [11, 12]]], 'bit' => [['Correo Electrónico', 'Carta de adjudicación preliminar recibida de Edifica.']], 'sla' => []],
            19 => ['titulo' => 'Instalación Línea Troncal Tubería HDPE Planta Sur', 'monto' => 198000.00, 'estado' => 'Cierre Comercial', 'creado_h' => 52, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 32, 'futuro' => false, 'est' => 'Completada', 'res' => 'Trazado y rasantes validadas para 850 ml de zanja.', 'cr_h' => 44]], 'cot' => [['sub_h' => 10, 'est' => 'Aceptada', 'monto' => 198000.00, 'obs' => 'Propuesta técnica económica acordada al 100%.', 'rech' => null, 'part' => [14, 2]]], 'bit' => [['Seguimiento', 'Validación de cartas fianza y seguros CAR.']], 'sla' => []],
            20 => ['titulo' => 'Construcción de Muro Gavionado y Diques Quebrada Verde', 'monto' => 260000.00, 'estado' => 'Cierre Comercial', 'creado_h' => 45, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 30, 'futuro' => false, 'est' => 'Completada', 'res' => 'Firmeza de roca confirmada para anclaje de mallas.', 'cr_h' => 38]], 'cot' => [['sub_h' => 12, 'est' => 'Aceptada', 'monto' => 260000.00, 'obs' => 'Acuerdo de pagos y cronograma valorizado cerrado.', 'rech' => null, 'part' => [24, 25]]], 'bit' => [['Reunión Presencial', 'Firma de borrador del contrato en sede gerencial.']], 'sla' => []],
            21 => ['titulo' => 'Demolición y Vaciado de Pavimento Patios de Chatarra', 'monto' => 320000.00, 'estado' => 'Cierre Comercial', 'creado_h' => 48, 'insp' => [['ing' => 'Ing. Mario Eloy', 'h' => 26, 'futuro' => false, 'est' => 'Completada', 'res' => 'Demolición de 1,800 m2 con martillos de 30 toneladas.', 'cr_h' => 40]], 'cot' => [['sub_h' => 8, 'est' => 'Aceptada', 'monto' => 320000.00, 'obs' => 'Aprobación definitiva de orden de compra en curso.', 'rech' => null, 'part' => [20, 8]]], 'bit' => [['Llamada Telefónica', 'Envío de pólizas complementarias de trabajo de alto riesgo.']], 'sla' => []],

            // HISTORIAL GENERAL (8 obras cerradas definitivamente)
            22 => ['titulo' => 'Construcción Almacén Central de Agregados Concremax', 'monto' => 890000.00, 'estado' => 'Aceptada', 'creado_h' => 720, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 690, 'futuro' => false, 'est' => 'Completada', 'res' => 'Estudio de suelos y diseño estructural completado.', 'cr_h' => 710]], 'cot' => [['sub_h' => 650, 'est' => 'Aceptada', 'monto' => 890000.00, 'obs' => 'Oferta técnico-económica aceptada. Obra en ejecución.', 'rech' => null, 'part' => [5, 16]]], 'bit' => [['Reunión Presencial', 'Firma de contrato de obra y entrega formal del terreno.']], 'sla' => []],
            23 => ['titulo' => 'Rehabilitación Vial de Accesos y Pavimento Los Portales', 'monto' => 740000.00, 'estado' => 'Aceptada', 'creado_h' => 480, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 450, 'futuro' => false, 'est' => 'Completada', 'res' => 'Metrado vial de 5,200 m2 validado en campo.', 'cr_h' => 470]], 'cot' => [['sub_h' => 420, 'est' => 'Aceptada', 'monto' => 740000.00, 'obs' => 'Adjudicación de obra confirmada. Carta fianza entregada.', 'rech' => null, 'part' => [8, 9]]], 'bit' => [['Reunión Presencial', 'Inicio de trazo y replanteo con supervisión del cliente.']], 'sla' => []],
            24 => ['titulo' => 'Pisos Industriales con Endurecedor Planta Alicorp Callao', 'monto' => 520000.00, 'estado' => 'Aceptada', 'creado_h' => 360, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 330, 'futuro' => false, 'est' => 'Completada', 'res' => 'Ensayos de planicidad F-Number completados.', 'cr_h' => 350]], 'cot' => [['sub_h' => 300, 'est' => 'Aceptada', 'monto' => 520000.00, 'obs' => 'Contrato marco formalizado para losas de alta resistencia.', 'rech' => null, 'part' => [17, 13]]], 'bit' => [['Seguimiento', 'Vaciado de tramo 1 completado con éxito.']], 'sla' => []],
            25 => ['titulo' => 'Sellado de Juntas y Morteros Especiales Terminal Portuario', 'monto' => 340000.00, 'estado' => 'Aceptada', 'creado_h' => 800, 'insp' => [['ing' => 'Ing. Mario Eloy', 'h' => 770, 'futuro' => false, 'est' => 'Completada', 'res' => 'Inspección de 2,400 ml de juntas marinas.', 'cr_h' => 790]], 'cot' => [['sub_h' => 730, 'est' => 'Aceptada', 'monto' => 340000.00, 'obs' => 'Propuesta aceptada con certificación de grado marino.', 'rech' => null, 'part' => [15, 13]]], 'bit' => [['Correo Electrónico', 'Orden de compra formal OC-2026-APM-089 recibida.']], 'sla' => []],
            26 => ['titulo' => 'Cerco Perimétrico y Garitas de Control Almacén Sur', 'monto' => 145000.00, 'estado' => 'Cancelada', 'creado_h' => 600, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 570, 'futuro' => false, 'est' => 'Completada', 'res' => 'Terreno en litigio judicial con predio colindante.', 'cr_h' => 590]], 'cot' => [['sub_h' => 540, 'est' => 'Rechazada', 'monto' => 145000.00, 'obs' => 'Propuesta desestimada por cancelación presupuestal.', 'rech' => 'Proyecto suspendido indefinidamente por problemas legales.', 'part' => [6, 7]]], 'bit' => [['Llamada Telefónica', 'Notificación formal cancelando el proceso de compra.']], 'sla' => []],
            27 => ['titulo' => 'Techado Metálico y Cerramientos Patio de Carga Norte', 'monto' => 220000.00, 'estado' => 'Cancelada', 'creado_h' => 550, 'insp' => [['ing' => 'Ing. Carmen Delgado', 'h' => 520, 'futuro' => false, 'est' => 'Completada', 'res' => 'Verificación de apoyos en columnas existentes.', 'cr_h' => 540]], 'cot' => [['sub_h' => 490, 'est' => 'Rechazada', 'monto' => 220000.00, 'obs' => 'Oferta no priorizada por el comité técnico de planta.', 'rech' => 'Reasignación de CAPEX corporativo al ejercicio 2027.', 'part' => [16, 1]]], 'bit' => [['Reunión Presencial', 'Reunión de cierre con jefa de mantenimiento.']], 'sla' => []],
            28 => ['titulo' => 'Estabilización y Anclajes en Desfiladero Minero Cuajone', 'monto' => 380000.00, 'estado' => 'Perdida', 'creado_h' => 420, 'insp' => [['ing' => 'Ing. Roberto Zúñiga', 'h' => 390, 'futuro' => false, 'est' => 'Completada', 'res' => 'Fisuras por vibración de voladuras mineras en roca.', 'cr_h' => 410]], 'cot' => [['sub_h' => 360, 'est' => 'Rechazada', 'monto' => 380000.00, 'obs' => 'Adjudicación otorgada a consorcio local competidor.', 'rech' => 'Competencia presentó oferta con 18% menor valor.', 'part' => [25, 26]]], 'bit' => [['Correo Electrónico', 'Carta de agradecimiento recibida sin adjudicación.']], 'sla' => []],
            29 => ['titulo' => 'Hincado de Tablestacas Muelle de Barcazas Ilo', 'monto' => 490000.00, 'estado' => 'Perdida', 'creado_h' => 460, 'insp' => [['ing' => 'Ing. Luis Navarro', 'h' => 430, 'futuro' => false, 'est' => 'Completada', 'res' => 'Bateo de olas supera resistencia estimada inicial.', 'cr_h' => 450]], 'cot' => [['sub_h' => 400, 'est' => 'Rechazada', 'monto' => 490000.00, 'obs' => 'Proceso desestimado por rediseño de calado del puerto.', 'rech' => 'Cambio sustancial en especificaciones de la autoridad portuaria.', 'part' => [27, 2]]], 'bit' => [['Seguimiento', 'Expediente cerrado sin costo para el cliente.']], 'sla' => []],
        ];

        $cotCounter = 1;

        foreach ($obrasPlan as $idx => $cfg) {
            $num       = $idx + 1;
            $codigo    = 'OBR-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            $clienteId = $clienteIds[$idx];
            $asesorId  = $asesores[$idx % 2];
            $createdAt = $now->copy()->subHours($cfg['creado_h']);

            $obraId = DB::table('obras')->insertGetId([
                'codigo'     => $codigo,
                'titulo'     => $cfg['titulo'],
                'monto'      => $cfg['monto'],
                'fecha'      => $createdAt->toDateString(),
                'estado'     => $cfg['estado'],
                'cliente_id' => $clienteId,
                'user_id'    => $asesorId,
                'created_at' => $createdAt,
                'updated_at' => $now,
            ]);

            // Bitácoras con tipos estándar
            foreach ($cfg['bit'] as $b) {
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

            // Inspecciones técnicas
            foreach ($cfg['insp'] as $insCfg) {
                $inspCreatedAt = $now->copy()->subHours($insCfg['cr_h']);
                $fechaInsp     = $insCfg['futuro'] ? $now->copy()->addHours($insCfg['h']) : $now->copy()->subHours($insCfg['h']);

                DB::table('inspecciones')->insert([
                    'obra_id'            => $obraId,
                    'user_id'            => $asesorId,
                    'ingeniero_asignado' => $insCfg['ing'],
                    'fecha_inspeccion'   => $fechaInsp,
                    'resultado'          => $insCfg['res'],
                    'estado_inspeccion'  => $insCfg['est'],
                    'created_at'         => $inspCreatedAt,
                    'updated_at'         => ($insCfg['est'] === 'Completada') ? $now->copy()->subHours(max(1, $insCfg['cr_h'] - 4)) : $now,
                ]);
            }

            // Cotizaciones y desglose exacto de partidas
            foreach ($cfg['cot'] as $cotCfg) {
                $codCot       = 'COT-2026-' . str_pad($cotCounter++, 4, '0', STR_PAD_LEFT);
                $cotCreatedAt = $now->copy()->subHours($cotCfg['sub_h']);
                $validezDias  = 15;
                $fechaVenc    = ($cotCfg['est'] === 'Programada') ? null : $cotCreatedAt->copy()->addDays($validezDias);

                $cotId = DB::table('cotizaciones')->insertGetId([
                    'obra_id'           => $obraId,
                    'user_id'           => $asesorId,
                    'codigo_cotizacion' => $codCot,
                    'monto_total'       => $cotCfg['monto'],
                    'fecha_emision'     => $cotCreatedAt->toDateString(),
                    'validez_dias'      => $validezDias,
                    'fecha_vencimiento' => $fechaVenc,
                    'estado_cotizacion' => $cotCfg['est'],
                    'observaciones'     => $cotCfg['obs'], // Texto limpio sin prefijos
                    'motivo_rechazo'    => $cotCfg['rech'],
                    'created_at'        => $cotCreatedAt,
                    'updated_at'        => $now,
                ]);

                // Creación de detalles de cotización vinculados a partidas oficiales
                if ($cotCfg['monto'] > 0 && !empty($cotCfg['part'])) {
                    $montoCot = $cotCfg['monto'];
                    $partidasCount = count($cotCfg['part']);

                    if ($partidasCount === 1) {
                        $pRef = $partidaIds[$cotCfg['part'][0] % count($partidaIds)];
                        DB::table('cotizacion_detalles')->insert([
                            'cotizacion_id'   => $cotId,
                            'partida_id'      => $pRef['id'],
                            'cantidad'        => round($montoCot / $pRef['precio'], 2),
                            'precio_unitario' => $pRef['precio'],
                            'subtotal'        => $montoCot,
                            'created_at'      => $cotCreatedAt,
                            'updated_at'      => $cotCreatedAt,
                        ]);
                    } else {
                        $pRef1 = $partidaIds[$cotCfg['part'][0] % count($partidaIds)];
                        $pRef2 = $partidaIds[$cotCfg['part'][1] % count($partidaIds)];
                        $sub1 = round($montoCot * 0.55, 2);
                        $sub2 = round($montoCot - $sub1, 2);

                        DB::table('cotizacion_detalles')->insert([
                            [
                                'cotizacion_id'   => $cotId,
                                'partida_id'      => $pRef1['id'],
                                'cantidad'        => round($sub1 / $pRef1['precio'], 2),
                                'precio_unitario' => $pRef1['precio'],
                                'subtotal'        => $sub1,
                                'created_at'      => $cotCreatedAt,
                                'updated_at'      => $cotCreatedAt,
                            ],
                            [
                                'cotizacion_id'   => $cotId,
                                'partida_id'      => $pRef2['id'],
                                'cantidad'        => round($sub2 / $pRef2['precio'], 2),
                                'precio_unitario' => $pRef2['precio'],
                                'subtotal'        => $sub2,
                                'created_at'      => $cotCreatedAt,
                                'updated_at'      => $cotCreatedAt,
                            ]
                        ]);
                    }
                }
            }

            // Alertas SLA para el semáforo gerencial
            foreach ($cfg['sla'] as $slaCfg) {
                $polId = ($slaCfg[0] === 'VISITA_INSPECCION') ? $politicaVisitaId : $politicaCotizId;
                DB::table('sla_alertas_logs')->insert([
                    'obra_id'                  => $obraId,
                    'sla_politica_id'          => $polId,
                    'user_id'                  => $asesorId,
                    'horas_retraso_detectadas' => $slaCfg[1],
                    'estado_alerta'            => $slaCfg[2],
                    'fecha_disparo'            => $now->copy()->subHours($slaCfg[3]),
                    'fecha_resolucion'         => null,
                    'created_at'               => $now->copy()->subHours($slaCfg[3]),
                    'updated_at'               => $now,
                ]);
            }
        }

        // =========================================================================
        // 6. SINCRONIZACIÓN DE ESTADOS DINÁMICOS DE LOS 30 CLIENTES
        // =========================================================================
        foreach ($clienteIds as $cId) {
            \App\Http\Controllers\Comercial\PipelineController::actualizarEstadoCliente($cId);
        }
    }
}