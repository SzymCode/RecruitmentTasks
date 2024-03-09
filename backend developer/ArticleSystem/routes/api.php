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


Route::get('/top-authors-last-week', [AuthorController::class, 'getTopAuthorsLastWeek']);

Route::prefix('news')->controller(NewsController::class)->group(function () {
    Route::get('/{id}', 'getNewsById')
        ->name('news.show');
    Route::get('/author/{authorId}', 'getNewsByAuthor')
        ->name('news.show-by-author');
});
