<?php

use App\Models\Author;
use App\Models\News;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('migrate:fresh');
});

describe('200', function () {
    test('show top authors of the last week', function () {
        Author::factory()->count(10)->has(News::factory()->count(5))->create(['created_at' => now()->subWeek()]);

        $response = $this->getJson(route('authors.top-authors-api'));

        $response->assertOk();

        $response->assertJsonStructure([
            '*' => [
                'author' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
                'news_count',
            ],
        ]);

        $response->assertJsonCount(3, '*');

        $response->assertJson(function ($json) {
            foreach ($json as $author) {
                $author->has('author')
                    ->has('news_count')
                    ->etc();
            }
        });
    });
});
