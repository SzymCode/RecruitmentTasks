<?php

Route::prefix('users')->namespace('Users')->group(function() {
    Route::get('/', [App\Http\Controllers\UsersController::class, 'index']);
});

Route::prefix('posts')->namespace('Posts')->group(function() {
    Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
});