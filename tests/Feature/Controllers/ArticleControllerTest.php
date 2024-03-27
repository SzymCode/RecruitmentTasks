<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Contracts\Support\Renderable;

it('renders the articles view', function () {
    $controller = new ArticleController();

    $response = $controller->render();

    expect($response)->toBeInstanceOf(Renderable::class);
});
