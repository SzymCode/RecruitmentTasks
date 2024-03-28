<?php

use Illuminate\Contracts\Support\Renderable;

use App\Models\Article;
use App\Http\Controllers\ArticleController;
use App\Services\ArticleService;

beforeEach(function () {
    $this->controller = app()->makeWith(ArticleController::class, ['articleService' => app()->make(ArticleService::class)]);
});

it('renders the articles view successfully', function () {
    $response = $this->controller->render();

    expect($response)->toBeInstanceOf(Renderable::class);
});

it('runs index method successfully', function () {
    $response = $this->controller->index();

    expect($response->getStatusCode())->toEqual(200);
});
