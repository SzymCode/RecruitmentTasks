<?php

use App\Http\Controllers\NewsController;
use App\Models\Author;
use App\Models\News;
use App\Services\NewsService;

beforeEach(function () {
    $this->controller = app()->makeWith(NewsController::class, ['service' => app()->make(NewsService::class)]);
});

it('runs show by id method successfully', function () {
    $user = News::factory()->create();

    $response = $this->controller->getNewsById($user->id);

    expect($response->getStatusCode())->toEqual(200);
    expect($response->getData(true)['id'])->toEqual($user->id);
    expect($response->getData(true)['title'])->toEqual($user->title);
    expect($response->getData(true)['description'])->toEqual($user->description);
    expect($response->getData(true)['created_at'])->toEqual($user->created_at);
    expect($response->getData(true)['updated_at'])->toEqual($user->updated_at);
});

it('runs show news by author method successfully', function () {
    $author = Author::factory()->create();

    $response = $this->controller->getNewsByAuthor($author->id);

    $responseData = json_decode($response->getContent(), true);

    $expectedData = $author->news->map(function ($news) {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'description' => $news->description,
            'created_at' => $news->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $news->updated_at->format('Y-m-d H:i:s'),
        ];
    })->toArray();

    expect($responseData)->toBeArray();
    expect($responseData)->toEqual($expectedData);
});
