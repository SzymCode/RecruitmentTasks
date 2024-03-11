<?php

use App\Models\Author;
use App\Models\News;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('migrate:fresh');
});

describe('200', function () {
    test('index api', function () {
        Author::factory(3)->create();

        $this->getJson(route('authors.index-api'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ],
            ]);
    });
    test('store api', function () {
        $data = [
            'name' => 'Example Name',
        ];

        $this->postJson(route('authors.store-api', $data))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'created_at',
                'updated_at'
            ]);
    });
    test('update api', function () {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Example Name',
        ];

        $this->putJson(route('authors.update-api', $author->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'created_at',
                'updated_at'
            ])
            ->assertJsonFragment([
                'name' => $data['name'],
            ]);
    });
    test('destroy api', function () {
        $author = Author::factory()->create();

        $this->deleteJson(route('authors.delete-api', $author->id))
            ->assertOk()
            ->assertJsonFragment([
                'deleted' => true
            ]);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    });


    test('show top authors of the last week', function () {
        Author::factory()->count(10)->has(News::factory()->count(5))->create(['created_at' => now()->subWeek()]);

        $response = $this->getJson(route('authors.top-authors-api'));

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'author' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                    'news_count',
                ],
            ])
            ->assertJsonCount(3, '*')
            ->assertJson(function ($json) {
                foreach ($json as $author) {
                    $author
                        ->has('author')
                        ->has('news_count');
                }
            });
    });
});
