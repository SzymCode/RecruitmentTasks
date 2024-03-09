<?php

use App\Http\Controllers\AuthorController;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

beforeEach(function () {
    $this->controller = app()->makeWith(AuthorController::class, ['service' => app()->make(AuthorService::class)]);
});

it('runs api method top authors of the last week successfully', function () {
    $authorsWithNews = Author::factory()->count(3)->create();

    $response = $this->controller->getTopAuthorsLastWeekApi();

    $this->assertInstanceOf(JsonResponse::class, $response);

    $responseData = $response->getData(true);

    $expectedAuthors = $authorsWithNews->map(function ($author) {
        return [
            'news_count' => $author->news()->count(),
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'created_at' => $author->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $author->updated_at->format('Y-m-d H:i:s'),
            ]
        ];
    })->toArray();

    // Sort the arrays based on the 'id' of the authors
    $expectedAuthors = collect($expectedAuthors)->sortBy('author.id')->values()->toArray();
    $responseData = collect($responseData)->sortBy('author.id')->values()->toArray();

    expect($responseData)->toEqual($expectedAuthors);
});
