<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('authors')->controller(AuthorController::class)->group(function () {
    Route::get('/', 'index')
        ->name('authors.index');
    Route::get('/top-authors','getTopAuthorsLastWeek')
        ->name('authors.top-authors');
});

Route::prefix('news')->controller(NewsController::class)->group(function () {
    Route::get('/', 'index')
        ->name('news.index');
    Route::get('/{id}', 'getNewsById')
        ->name('news.show');
    Route::get('/author/{authorId}', 'getNewsByAuthor')
        ->name('news.show-by-author');
});
