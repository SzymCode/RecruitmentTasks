<?php

use App\Models\Author;
use App\Models\News;


beforeEach(function () {
    $this->createAuthors();
    $this->createNews();
});

describe('200', function () {
    test('index api', function () {
        News::factory(3)->create();

        $this->getJson(route('news.index-api'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'created_at',
                    'updated_at'
                ],
            ]);
    });
    test('destroy api', function () {
        $news = News::factory()->create();

        $this->deleteJson(route('news.delete-api', $news->id))
            ->assertOk()
            ->assertJsonFragment([
                'deleted' => true
            ]);
        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    });


    test('show news by id', function () {
        $expectedNews = News::findOrFail(1);

        $response = $this->getJson(route('news.show-api', 1));

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'created_at',
                'updated_at'
            ])
            ->assertJsonFragment([
                'id' => $expectedNews->id,
                'title' => $expectedNews->title,
                'description' => $expectedNews->description,
                'created_at' => $expectedNews->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $expectedNews->updated_at->format('Y-m-d H:i:s')
            ]);
    });

    test('show all news by author', function () {
        $author = Author::factory()->create();
        $news = News::factory()->count(3)->create();

        $author->news()->attach($news->pluck('id'));

        $response = $this->getJson(route('news.show-by-author-api', $author->id));

        $expectedData = $news->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'created_at' => $article->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $article->updated_at->format('Y-m-d H:i:s')
            ];
        })->toArray();

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);

        foreach ($expectedData as $articleData) {
            $response->assertJsonFragment($articleData);
        }
    });
});
