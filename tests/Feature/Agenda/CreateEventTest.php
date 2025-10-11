<?php

namespace Tests\Feature\Agenda;

use App\Models\Dependency_program;
use App\Models\Event_type;
use App\Models\Place;
use App\Models\Responsible;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateEventTest extends TestCase
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

    public function test_create_cta_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('admin');

        $permissionCTA = [
            'reserve classroom',
            'create event type',
            'create dependency',
            'create place',
            'delete reserve classroom',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
            'update reserve classroom',
        ];

        $permissionGetCTA = Permission::whereIn('name', $permissionCTA)->get();
        $user->givePermissionTo($permissionGetCTA);

        $this->actingAs($user);

        $response = $this->get(route('agenda.create'));

        // dd($response->getContent());

        $response->assertStatus(200);
        $response->assertSee('Agregar reservación');
    }

    public function test_create_protocolo_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $permissionProtocolo = [
            'create event',
            'create event type',
            'update event',
            'delete event',
            'create dependency',
            'create place',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
        ];

        $permissionGetProtocolo = Permission::whereIn('name', $permissionProtocolo)->get();
        $user->givePermissionTo($permissionGetProtocolo);

        $this->actingAs($user);

        $response = $this->get(route('agenda.create'));

        $response->assertStatus(200);
        $response->assertSee('Agregar evento');
    }

    public function test_create_protocolo_event_without_permission_create_event(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 1,
        ])->assignRole('admin');

        $permissionProtocolo = [
            // 'create event',
            'create event type',
            'update event',
            'delete event',
            'create dependency',
            'create place',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
        ];

        $permissionGetProtocolo = Permission::whereIn('name', $permissionProtocolo)->get();
        $user->givePermissionTo($permissionGetProtocolo);

        $this->actingAs($user);

        $response = $this->get(route('agenda.create'));

        $response->assertStatus(403);
        // $response->assertSee('No tienes permiso para realizar esta acción');

    }

    public function test_create_cta_event_without_permission_create_reservation(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('admin');

        $permissionCTA = [
            // 'reserve classroom',
            'create event type',
            'create dependency',
            'create place',
            'delete reserve classroom',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
            'update reserve classroom',
        ];

        $permissionGetCTA = Permission::whereIn('name', $permissionCTA)->get();
        $user->givePermissionTo($permissionGetCTA);

        $this->actingAs($user);

        $response = $this->get(route('agenda.create'));
        $response->assertStatus(403);
    }

    public function test_store_cta_reservacion_event(): void
    {
        $user = User::factory()->create([
            'status' => 1,
            'group_id' => 2,
        ])->assignRole('admin');

        $permissionCTA = [
            'reserve classroom',
            'create event type',
            'create dependency',
            'create place',
            'delete reserve classroom',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
            'update reserve classroom',
        ];

        $permissionGetCTA = Permission::whereIn('name', $permissionCTA)->get();
        $user->givePermissionTo($permissionGetCTA);

        $this->actingAs($user);

        $event_type = Event_type::where('group_id', 1)->random()->first();
        $dependency_program = Dependency_program::where('group_id', 1)->random()->first();
        $places = Place::where('group_id', 1)->random()->first();
        $responsible = Responsible::where('group_id', 1)->random()->first();
        

        $response = $this->post(route('agenda.store'), [
            'title' => $this->faker->sentence,
            'event_type' => $event_type->id,
            'dependency_program' => $dependency_program->id,
            'places' => $places,
            'responsible' => $responsible->id,
            'phone' => $this->faker->phoneNumber,
            // 'days' => $this->faker->randomElement(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']),
            'notes_cta'=> $this->faker->paragraph,
            'notes_general_services' => $this->faker->paragraph,
            'notes_protocolo' => $this->faker->paragraph,
            'date_start' => now(),
            'repetition' => 0,
            // 'date_end' => 
            'hour_start' => now()->format('H:i'),
            'hour_end' => now()->addHours(2)->format('H:i'),
            

        ]);

        // dd($response->getContent());

        $response->assertStatus(302);
        $response->assertRedirect(route('agenda.index'));
    }

    // public function test_create_event(): void
    // {
    //     $user = User::factory()->create([
    //         'status' => 1,
    //         'group_id' => 2,
    //     ])->assignRole('admin');

    //     $permissionCTA = [
    //         'reserve classroom',
    //         'create event type',
    //         'create dependency',
    //         'create place',
    //         'delete reserve classroom',
    //         'update event type',
    //         'update dependency',
    //         'update place',
    //         'view event type',
    //         'view dependency',
    //         'view place',
    //         'update reserve classroom',
    //     ];

    //     $permissionGetCTA = Permission::whereIn('name',$permissionCTA)->get();
    //     $user->givePermissionTo($permissionGetCTA);

    //     $this->actingAs($user);

    //     $response = $this->post(route('agenda.store'), [
    //         'title' => $this->faker->sentence,
    //         'description' => $this->faker->paragraph,
    //         'start' => now(),
    //         'end' => now()->addHours(2),
    //         'place_id' => 1,
    //     ]);

    //     // dd($response->getContent());

    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('agenda.index'));
    // }
}
