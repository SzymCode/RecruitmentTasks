<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TenancyTest extends TestCase
{
    use DatabaseTransactions;

    // Tests without login
    public function test_login_route_without_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    public function test_register_route_without_login()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
    public function test_home_route_without_login()
    {
        $response = $this->get('/home');
        $response->assertStatus(302);
    }

    // Tests logged in
    public function test_login_route_logged_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/login');
        $response->assertStatus(302);
    }
    public function test_register_route_logged_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/register');
        $response->assertStatus(302);
    }
    public function test_home_route_logged_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertStatus(200);
    }
}
