<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;


Route::get('/', [ArticleController::class, 'render'])
    ->name('articles');
