<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions; // https://stackoverflow.com/questions/51776768/laravel-reset-database-after-test

    public function test_index_returns_posts()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        Post::factory()->count(10)->create();

        $response = $this->getJson('/data/posts');

        $response->assertStatus(200)
            ->assertJsonStructure(['results']);
    }

    public function test_store_creates_post()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $postData = [
            'title' => 'Example Post',
            'description' => 'Description of the new post minimum 20 characters.',
            'tags' => 'tag123, tag231, tag321',
            'created_at' => now()->format('Y-m-d'),
        ];

        $response = $this->postJson('/data/posts', $postData);

        $response->assertStatus(201)
            ->assertJsonStructure(['post']);

        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'description' => $postData['description'],
            'tags' => $postData['tags'],
            'created_at' => $postData['created_at'],
        ]);
    }

    public function test_update_updates_post()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $postToUpdate = Post::factory()->create();

        $newData = [
            'title' => 'Updated Title',
            'description' => 'Updated description of the post.',
            'tags' => 'updated_tag1, updated_tag2',
            'created_at' => now()->toDateTimeString(),
        ];

        $response = $this->putJson("/data/posts/{$postToUpdate->id}", $newData);

        $response->assertStatus(200)
            ->assertJsonStructure(['post']);

        $this->assertDatabaseHas('posts', [
            'id' => $postToUpdate->id,
            'title' => 'Updated Title',
            'description' => 'Updated description of the post.',
            'tags' => 'updated_tag1, updated_tag2',
        ]);
    }

    public function test_delete_deletes_post()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $postToDelete = Post::factory()->create();

        $response = $this->delete("/data/posts/{$postToDelete->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully deleted post.']);

        $this->assertDatabaseMissing('posts', ['id' => $postToDelete->id]);
    }
}
