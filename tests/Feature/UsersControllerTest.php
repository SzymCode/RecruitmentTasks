<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class UsersControllerTest extends TestCase
{
    use DatabaseTransactions; // https://stackoverflow.com/questions/51776768/laravel-reset-database-after-test

    public function test_index_method_returns_users()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        User::factory()->count(100)->create();
        $response = $this->get('/data/users');

        $response->assertStatus(200)
            ->assertJsonStructure(['results']);
    }

    public function test_store_method_creates_user()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'user',
            'password' => 'Password123:_',
            'confirm_password' => 'Password123:_'
        ];

        $response = $this->post('/data/users', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => $userData['role'],
        ]);
    }

    public function test_update_method_updates_user()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $userToUpdate = User::factory()->create();
        $newData = [
            'name' => 'Updated Name',
            'email' => 'updated_email@example.com',
            'role' => 'admin',
            'password' => 'Password123:_',
            'confirm_password' => 'Password123:_'
        ];

        $response = $this->put("/data/users/{$userToUpdate->id}", $newData);

        $response->assertStatus(200)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => $newData['name'],
            'email' => $newData['email'],
            'role' => $newData['role'],
        ]);
    }

    public function test_delete_method_deletes_user()
    {

        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $userToDelete = User::factory()->create();

        $response = $this->delete("/data/users/{$userToDelete->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully deleted user.']);

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }


    public function test_invalid_user_creation()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $invalidUserData = [
            'name' => '1',
            'email' => 'invalid-email',
            'role' => 'u',
            'password' => '123',
        ];
    
        $response = $this->post('/data/users', $invalidUserData);
    
        $response->assertRedirect()
        ->assertSessionHasErrors([
            'name' => 'The name field must be at least 3 characters.',
            'email' => 'The email field must be a valid email address.',
            'role' => 'The selected role is invalid.',
            'password' => 'The password field must be at least 8 characters.',
        ]);
    }
    

    public function test_unauthorized_user_action()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $userToUpdate = User::factory()->create();
        $newRoleData = ['role' => 'admin'];

        $response = $this->put("/data/users/{$userToUpdate->id}", $newRoleData);

        $response->assertStatus(403);
    }

}
