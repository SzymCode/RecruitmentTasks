<?php

use App\Models\Author;
use App\Models\News;
use App\Services\AuthorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('migrate:fresh');
});

describe('200', function () {
    test('return top authors of last week', function () {
        Author::factory()->count(10)->has(News::factory()->count(5))->create(['created_at' => now()->subWeek()]);

        $authorService = new AuthorService();

        $topAuthors = $authorService->getTopAuthorsLastWeek();

        $authorKeys = ['id', 'name', 'created_at', 'updated_at'];

        $this->assertInstanceOf(Collection::class, $topAuthors);
        $this->assertCount(3, $topAuthors);
        foreach ($topAuthors as $authorData) {
            $this->assertArrayHasKey('author', $authorData);
            $this->assertArrayHasKey('news_count', $authorData);
            $this->assertEquals($authorKeys, array_keys($authorData['author']));
        }
    });
});
