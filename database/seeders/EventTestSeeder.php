<?php

namespace Database\Seeders;

use App\Models\Cta;
use App\Models\Date;
use App\Models\Dependency_program;
use App\Models\Event;
use App\Models\Event_type;
use App\Models\Group;
use App\Models\Place;
use App\Models\Protocolo;
use App\Models\Responsible;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {




        $dataProtocolo = [
            'id' => 1,
            'tel_extension' => '1234',
            'notes_cta' => 'Se necesita un proyector y audio',
            'notes_protocolo' => 'Se necesita un cofee break',
            'notes_general_service' => 'Se necesita limpieza',
            'link' => 'https://www.google.com',
            'event_id' => 1
        ];

        $dataCTA = [
            'email' => 'example.com@gmail.com',
            'num_participants' => 100,
            'published' => true,
            'event_id' => 2,
            'semester_id' => 1,
        ];

        $dataResponsible = [
            'id' => 1,
            'name' => 'Mtra. Pamela Garcia',            
        ];

        $dataDate = [[
            'id' => 1,
            'date_start' => '2024-11-20 19:00:00',
            'date_end' => '2024-11-20 21:00:00',
        ],
        [
            'id' => 2,
            'date_start' => '2024-11-22 13:00:00',
            'date_end' => '2024-11-22 15:00:00',
        ]
        ];

        $dataEvent = [[
            'Title' => 'Evento de prueba',
            'description' => 'Debe ser un evento de prueba',
            'type_id' => Event_type::where('group_id', 1)->where('id', 1 )->first()->id,
            'dependency_program_id' => Dependency_program::where('group_id', 1)->where('id', 1 )->first()->id,
            'place_id' => Place::where('group_id', 1)->where('id', 1 )->first()->id,
            'group_id' => Group::where('type', 'Protocolo')->first()->id,
            'created_by' => 1,
            'responsible_id' => 1,
            'date_id' => 1],
            [
            'Title' => 'Evento de prueba 2',
            'description' => 'Debe ser un evento de prueba 2',
            'type_id' => Event_type::where('id', 3 )->first()->id,
            'dependency_program_id' => Dependency_program::where('id', 3 )->first()->id,
            'place_id' => Place::where('id', 3 )->first()->id,
            'group_id' => Group::where('type', 'CTA')->first()->id,
            'created_by' => 1,
            'responsible_id' => 1,
            'date_id' => 2
            ]
        ];

        // Date::insert($dataDate);
        // Responsible::insert($dataResponsible);
        // Event::insert($dataEvent);
        Protocolo::insert($dataProtocolo);
        Cta::insert($dataCTA);
    }
}
