<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('authors')->controller(AuthorController::class)->group(function () {
    Route::get('/top-authors','getTopAuthorsLastWeekApi')
        ->name('authors.top-authors-api');
});


Route::prefix('news')->controller(NewsController::class)->group(function () {
    Route::get('/{id}', 'getNewsByIdApi')
        ->name('news.show-api');
    Route::get('/author/{authorId}', 'getNewsByAuthorApi')
        ->name('news.show-by-author-api');
});
