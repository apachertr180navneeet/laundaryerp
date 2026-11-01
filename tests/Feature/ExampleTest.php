<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_post_to_root_and_login(): void
    {
        $response = $this->post('/', [
            'email' => 'admin@laundry.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_can_post_to_login_and_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@laundry.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_authenticated_user_can_view_dashboard_and_modules(): void
    {
        $user = \App\Models\User::where('email', 'admin@laundry.com')->first();
        $this->actingAs($user);

        $dashboard = $this->get('/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Dashboard Overview');

        $clients = $this->get('/admin/client');
        $clients->assertStatus(200);
        $clients->assertSee('Client Management');

        $orders = $this->get('/admin/view-order');
        $orders->assertStatus(200);
        $orders->assertSee('Order Management');

        $categories = $this->get('/admin/categories');
        $categories->assertStatus(200);
        $categories->assertSee('Category Management');

        $services = $this->get('/admin/services');
        $services->assertStatus(200);
        $services->assertSee('Service Management');

        $items = $this->get('/admin/items');
        $items->assertStatus(200);
        $items->assertSee('Catalog Items');
    }
}
