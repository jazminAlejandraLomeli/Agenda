<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar el seeder
        Artisan::call('db:seed', [
            '--class' => 'TestSeeder',
        ]);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
       
        $user = User::factory()->create([
            'status' => 1,
        ]);

        $response = $this->post('/login', [
            'user_name' => $user->user_name,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        
        $user = User::factory()->create([
            'status' => 1,
        ]);

        $this->post('/login', [
            'user_name' => $user->user_name,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_status_inactive(): void
    {
        $user = User::factory()->create([
            'status' => 0,
        ]);

        $response = $this->post('/login', [
            'user_name' => $user->user_name,
            'password' => 'password',
        ]);

        $this->assertGuest();        
        $response->assertSessionHasErrors(['user_name']);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
