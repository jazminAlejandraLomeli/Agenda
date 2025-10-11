<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Dependency_program;
use App\Models\Event_type;
use App\Models\Group;
use App\Models\Place;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $data = [
            ['id' => 1, 'type' => 'Protocolo'],
            ['id' => 2, 'type' => 'CTA'],
            ['id' => 3, 'type' => 'Superadmin'],            
        ];

        $dataRole = [
            [
                'id' => 1,
                'name' => 'superadmin',
                'guard_name' => 'web'
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'id' => 3,
                'name' => 'read',
                'guard_name' => 'web'
            ]
        ];
        Group::insert($data);
        Role::insert($dataRole);

        User::create([
            'id' => 1,
            'user_name' => 'protocolo',
            'name' => 'PAMELA GARCIA GARCIA',
            'password' => bcrypt('Aa@1'),
            'status' => 1,
            'group_id' => 1,
        ])->assignRole(2);


        User::create([
            'id' => 2,
            'user_name' => 'CTA',
            'name' => 'CTA',
            'password' => bcrypt('Cu@1t0s'),
            'status' => 1,
            'group_id' => 2,
        ])->assignRole(2);


        User::create([
            'id' => 3,
            'user_name' => 'Super',
            'name' => 'SuperAdministrador',
            'password' => bcrypt('Aa@1'),
            'status' => 1,
            'group_id' => 3,
        ])->assignRole(1);

        User::create([
            'id' => 4,
            'user_name' => 'guest',            
            'password' => bcrypt('Aa@1'),
            'status' => 1,
            'group_id' => 3,
        ])->assignRole(2);

        $places = [
            ['name' => 'Auditorio "Rodolfo Camarena Báez"', 'group_id' => 1, 'color' => '#2E1F27', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Edificio de Usos Múltiples', 'group_id' => 1, 'color' => '#854D27', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Explanada Principal', 'group_id' => 1, 'color' => '#DD7230', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Galería de Rectoría', 'group_id' => 1, 'color' => '#E7E393', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Video Aula "Cecilia González Gómez"', 'group_id' => 1, 'color' => '#0A2472', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Asta de Bandera', 'group_id' => 1, 'color' => '#0E6BA8', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Sala de Juicios Orales', 'group_id' => 1, 'color' => '#6C0E23', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Sala de Ex Rectores', 'group_id' => 1, 'color' => '#C42021', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Biblioteca', 'group_id' => 1, 'color' => '#F3FFB9', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Gusanito', 'group_id' => 1, 'color' => '#F26DF9', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Rotonda', 'group_id' => 1, 'color' => '#069E2D', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Auditorio al Aire Libre', 'group_id' => 1, 'color' => '#508991', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Plaza de los Cipreses', 'group_id' => 1, 'color' => '#000411', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cafetería del Árbol', 'group_id' => 1, 'color' => '#160C28', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Laboratorio de Servicios Alimenticios', 'group_id' => 1, 'color' => '#EFF1C5', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Baloncesto 1', 'group_id' => 1, 'color' => '#002E2C', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Baloncesto 2', 'group_id' => 1, 'color' => '#F4442E', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Baloncesto 3', 'group_id' => 1, 'color' => '#C2EABD', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Baloncesto 4', 'group_id' => 1, 'color' => '#78C0E0', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Fútbol', 'group_id' => 1, 'color' => '#E63946', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Cancha de Usos Múltiples', 'group_id' => 1, 'color' => '#CBA135', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Plaza de las Lámparas', 'group_id' => 1, 'color' => '#C1A5A9', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Jardín de Rectoria', 'group_id' => 1,'color' => '#2B3D41','text_color' => '#ffffff','created_by' => 3],
            ['name' => 'Sala de Ajustes del Auditorio', 'group_id' => 1, 'color' => '#9b9b9b', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Sala de Juntas de Rectoría', 'group_id' => 1, 'color' => '#d34615', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Secretaría Académica', 'group_id' => 1, 'color' => '#298B93', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Secretaría Administrativa', 'group_id' => 1, 'color' => '#29936B', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Lab. de Sistemas Operativos e IOT', 'group_id' => 1, 'color' => '#00F7FF', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Mesa de juntas Auditorio "Rodolfo Camarena Báez"', 'group_id' => 1, 'color' => '#086096', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Grandes Especies', 'group_id' => 1, 'color' => '#086096', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Explanda de Rectoría', 'group_id' => 1, 'color' => '#F4C95D', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Lobby Auditorio "Rodolfo Camarena Báez"', 'group_id' => 1, 'color' => '#086096', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'Fuera del CUAltos', 'group_id' => 1, 'color' => '#086096', 'text_color' => '#ffffff', 'created_by' => 3],
            ['name' => 'I-105 (Virtual 1)', 'group_id' => 2, 'created_by' => 3, 'color' => '#EE8732', 'text_color' => '#000000'],
            ['name' => 'J-101 Aula de PTC', 'group_id' => 2, 'created_by' => 3, 'color' => '#FFCC66', 'text_color' => '#000000'],
            ['name' => 'I-108 (Virtual 2)', 'group_id' => 2, 'created_by' => 3, 'color' => '#CC99FF', 'text_color' => '#000000'],
            ['name' => 'K-104 (Cómputo 1)', 'group_id' => 2, 'created_by' => 3, 'color' => '#00B0F0', 'text_color' => '#000000'],
            ['name' => 'K-105 (Cómputo 2)', 'group_id' => 2, 'created_by' => 3, 'color' => '#92D050', 'text_color' => '#000000'],
            ['name' => 'K-106 (Aula. Sistemas Operativos)', 'group_id' => 2, 'created_by' => 3, 'color' => '#FF99FF', 'text_color' => '#000000'],
        ];

        $dependency_programs = [
            ['name' => 'Almacen', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Área de Fondos Externos', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Asuntos Jurídicos', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Bolsa de Trabajo', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Centro de Atención Médica Integral (CAMI)', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Clínica Veterinaria de Pequeñas Especies', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Clínica Veterinaria de Grandes Especies', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Consultorio Médico', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Contraloría', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Carreras', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Control Escolar', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Evaluación y Acreditación', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Extensión', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Finanzas', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Investigación y Posgrados', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Carrera de Abogado', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Carrera en Médico Cirujano y Partero', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Especialidad en Producción Animal', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Especialidad en Endodoncia', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Especialidad en Odontopediatría', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Administración', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Cirujano Dentista', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Contaduría Pública', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Enfermería', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Ingeniería Agroindustrial', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Ingeniería en Computación', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Ingeniería en Sistemas Pecuarios', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Medicina Veterinaria y Zootecnia', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Negocios Internacionales', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Nutrición', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Psicología', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Maestría en Administración de Negocios', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Maestría en Procesos Innovadores en el Aprendizaje', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Personal', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Planeación', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Servicios Académicos', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Servicios Generales', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Tecnologías para el Aprendizaje (CTA)', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación del Doctorado en Biociencias', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Ciencias de la Salud', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Ciencias Pecuarias y Agrícolas', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Clínicas', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Oficialía de Partes', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Patrimonio', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Programa Institucional de Tutorías', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Rectoría', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Secretaría Académica', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Secretaría Académica / Posgrado', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Secretaría Académica / PTC', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Secretaría Administrativa', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Secretaria Particular', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Atención', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Becas e Intercambios', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Biblioteca', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Compras y Suministros', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Cómputo y Telecomunicaciones para el Aprendizaje', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Contabilidad', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Control', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Deportes', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Difusión', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Ingreso', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Mantenimiento', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Multimedia Instruccional', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Nóminas', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Personal Académico', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Personal Administrativo', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Presupuestos', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Protocolo', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Servicio Social', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Vinculación', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad Interna de Protección Civil', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Otra', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Externa', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Licenciatura en Químico Farmacéutico Biólogo', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'División de Ciencias Sociales y de la Cultura', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'División de Ciencias Biomédicas', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'División de Ciencias Agropecuarias e Ingenerías', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Estudios Jurídicos, Socialees y de la Cultura', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Estudios Organizacionales', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Departamento de Ingenerías', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación del Doctorado en Biociencias', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de Investigación', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Egresados', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Unidad de Autoacceso', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Supervisión y Control de Obras', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'CIIO', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Grandes Especies', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'FEU', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Coordinación de la Especialidad en Medicina Familiar', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Abogado', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Administración', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Cirujano Dentista', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Contaduría Pública', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Enfermería', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Ingeniería Agroindustrial', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Ingeniería en Computación', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Ingeniería en Sistemas Pecuarios', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Medicina Veterinaria y Zootecnia', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Médico Cirujano y Partero', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Negocios Internacionales', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Nivelación de la Licenciatura en Enfermería', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Nutrición', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Psicología', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Químico Farmacéutico Biólogo', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Maestrías', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Maestría en Administración de Negocios', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Maestría en Procesos Innovadores en el Aprendizaje', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad en Odontopediatría', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad en Endodoncia', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad de Ortodoncia', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad Médica en Medicina Familiar', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad Médica en Medicina de Urgencias', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad en Enfermería en Cuidados Intensivos', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad en Enfermería Quirúrgica', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Pie y Tobillo', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Artroscopia, Cirugía Artroscópica y Lesiones Deportivas', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Mano', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Preservación y Reemplazo Artícular', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Doctorado en Biociencias', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Diplomados', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Diplomado en Desarrollo de Negocios y Cultura del Emprendimiento', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Diplomado en Intervención en Crisis', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Diplomado en Justicia Alternativa', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad y Maestría en Producción Animal Sustentable', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Pie y Tobillo',  'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Artroscopia, Cirugía Artroscópica y Lesiones Deportivas', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Mano', 'group_id' => 2,  'created_by' => 3],
            ['name' => 'Curso de Alta Especialidad Médica en Cirugía de Preservación y Reemplazo Artícular', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Maestría en Administración de Negocios', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Maestría en Procesos Innovadores en el Aprendizaje', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Especialidad y Maestría en Producción Animal Sustentable', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Doctorado en Biociencias', 'group_id' => 2, 'created_by' => 3],

        ];

        $event_types = [
            ['name' => 'Actividad académica', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Acto académico', 'group_id' => 1, 'created_by' =>  3],
            ['name' => 'Acto protocolar', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Aplicación de examen', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Clase', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Coloquio', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Conferencia', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Curso', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Diplomado', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Foro', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Conversatorio', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Presentación de libro', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Seminario', 'group_id' => 1, 'created_by' =>   3],
            ['name' => 'Taller', 'group_id' => 1, 'created_by' =>  3],
            ['name' => 'Videoconferencia', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Reunión', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Cultural', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Otro', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Externo', 'group_id' => 1, 'created_by' => 3],
            ['name' => 'Clase', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso-Taller (Alumnos)', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Examen Parcial/Ordinario', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Examen Departamental', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Examen Extraordinario', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Examen Global Teórico/Práctico', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Examen de Grado', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Reunión', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Curso-Taller (Administrativos/Académicos)', 'group_id' => 2, 'created_by' => 3],
            ['name' => 'Asignatura (Semestral)', 'group_id' => 2, 'created_by' => 3],
        ];

        $Semester = [
            ['name' => 'No aplica'],
            ['name' => '1°'],
            ['name' => '2°'],
            ['name' => '3°'],
            ['name' => '4°'],
            ['name' => '5°'],
            ['name' => '6°'],
            ['name' => '7°'],
            ['name' => '8°'],
            ['name' => '9°'],
            ['name' => '10°'],
        ];

        Place::insert($places);
        Dependency_program::insert($dependency_programs);
        Event_type::insert($event_types);
        Semester::insert($Semester);


        $this->call([
            PermissionSeeder::class,
            AssigPermissionSeeder::class
        ]);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
