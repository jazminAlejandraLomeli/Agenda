<?php

namespace Tests\Feature\Agenda;

use App\Models\Cta;
use App\Models\Date;
use App\Models\Event;
use App\Models\Protocolo;
use App\Models\Responsible;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;


class AgendaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar el seeder
        Artisan::call('db:seed', [
            '--class' => 'TestSeeder',
        ]);
    }

    public function test_get_events_to_dates(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $response = $this->get('/agenda/get-events?start=2023-10-01&end=2023-10-31');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'date_id',
                'place_id',
                'group_id'
            ],
        ]);
    }

    public function test_get_events_to_dates_with_no_auth(): void
    {
        $response = $this->get('/agenda/get-events?start=2023-10-01&end=2023-10-31');
        // Response sin autenticación
        $response->assertStatus(302);
    }

    public function test_get_events_to_dates_with_no_dates(): void
    {
        $user = User::factory()->create([
            'status' => 1,
        ]);

        $this->actingAs($user);
        $response = $this->get('/agenda/get-events?start=&end=');
        // Response sin fechas
        $response->assertStatus(302);
    }

    public function test_get_events_to_dates_with_no_dates_and_no_auth(): void
    {
        $response = $this->get('/agenda/get-events?start=&end=');
        // Response sin autenticación y sin fechas
        $response->assertStatus(302);
    }

    public function test_get_details_event_protocolo(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $date = Date::factory()->create();
        $responsible = Responsible::factory()->create([
            'group_id' => $user->group_id,
        ]);

        $event = Event::factory()->create([
            'date_id' => $date->id,
            'responsible_id' => $responsible->id,
            'group_id' => $user->group_id,
            'created_by' => $user->id,
        ]);

        $protocolo = Protocolo::factory()->create([
            'event_id' => $event->id,
        ]);

        $response = $this->get('/agenda/get-event/' . $event->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'title',
            'date_id',
            'place_id',
            'group_id',
            'type_id',
            'dependency_program_id',
            'responsible_id',
            'created_by',
            'protocolo' => [
                'id',
                'event_id',
                'tel_extension',
                'notes_cta',
                'notes_protocolo',
                'notes_general_service',
                'link',
            ],
        ]);
    }

    public function test_get_details_event_cta(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('admin');

        $this->actingAs($user);
        $date = Date::factory()->create();
        $responsible = Responsible::factory()->create([
            'group_id' => $user->group_id,
        ]);

        $event = Event::factory()->create([
            'date_id' => $date->id,
            'responsible_id' => $responsible->id,
            'group_id' => $user->group_id,
            'created_by' => $user->id,
        ]);

        $cta = Cta::factory()->create([
            'event_id' => $event->id,
        ]);

        $response = $this->get('/agenda/get-event/' . $event->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'title',
            'date_id',
            'place_id',
            'group_id',
            'type_id',
            'dependency_program_id',
            'responsible_id',
            'created_by',
            'cta' => [
                'id',
                'event_id',
                'email',
                'num_participants',
                'published',
                'semester_id',                
            ],
        ]);
    }


    public function test_get_details_event_with_no_auth(): void
    {
        $response = $this->get('/agenda/get-event/1');
        // Response sin autenticación
        $response->assertStatus(302);
    }

    public function test_get_details_event_with_no_event(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $response = $this->get('/agenda/get-event/0');
        // Response sin evento
        $response->assertStatus(404);
    }

    public function test_get_details_event_with_no_event_and_no_auth(): void
    {
        $response = $this->get('/agenda/get-event/0');
        // Response sin autenticación y sin evento
        $response->assertStatus(302);
    }

    public function test_get_details_event_with_no_dates(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $response = $this->get('/agenda/get-event/');
        // Response sin fechas
        $response->assertStatus(404);
    }

    public function test_get_details_event_with_incorrect_user_protocolo(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $date = Date::factory()->create();
        $responsible = Responsible::factory()->create([
            'group_id' => $user->group_id,
        ]);

        $event = Event::factory()->create([
            'date_id' => $date->id,
            'responsible_id' => $responsible->id,
            'group_id' => $user->group_id,
            'created_by' => $user->id,
        ]);

        // $cta = Cta::factory()->create([
        //     'event_id' => $event->id,
        // ]);

        $protocolo = Protocolo::factory()->create([
            'event_id' => $event->id,
        ]);

        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('superadmin');

        $this->actingAs($user);

        $response = $this->get('/agenda/get-event/' . ($event->id));
        $response->assertStatus(403);
    }


    public function test_get_details_event_with_incorrect_user_cta(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('admin');

        $this->actingAs($user);
        $date = Date::factory()->create();
        $responsible = Responsible::factory()->create([
            'group_id' => $user->group_id,
        ]);

        $event = Event::factory()->create([
            'date_id' => $date->id,
            'responsible_id' => $responsible->id,
            'group_id' => $user->group_id,
            'created_by' => $user->id,
        ]);

        $cta = Cta::factory()->create([
            'event_id' => $event->id,
        ]);

        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);

        $response = $this->get('/agenda/get-event/' . ($event->id));
        $response->assertStatus(403);
    }

    public function test_get_details_event_with_user_superadmin(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $this->actingAs($user);
        $date = Date::factory()->create();
        $responsible = Responsible::factory()->create([
            'group_id' => $user->group_id,
        ]);

        $event = Event::factory()->create([
            'date_id' => $date->id,
            'responsible_id' => $responsible->id,
            'group_id' => $user->group_id,
            'created_by' => $user->id,
        ]);

        $cta = Cta::factory()->create([
            'event_id' => $event->id,
        ]);

        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 3,
        ])->assignRole('superadmin');

        $this->actingAs($user);

        $response = $this->get('/agenda/get-event/' . ($event->id));
        $response->assertStatus(200);
    }
}
