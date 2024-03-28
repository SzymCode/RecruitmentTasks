<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;


Route::get('/', [ArticleController::class, 'render'])
    ->name('articles.render');

Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')
        ->name('articles.index');
});
