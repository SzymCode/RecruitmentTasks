<?php

Route::prefix('users')->namespace('Users')->group(function() {
    Route::get('/', [App\Http\Controllers\UsersController::class, 'index']);
    Route::post('/', [App\Http\Controllers\UsersController::class, 'store']);
});

Route::prefix('posts')->namespace('Posts')->group(function() {
    Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
    Route::post('/', [App\Http\Controllers\PostsController::class, 'store']);
});
