<?php

Route::prefix('users')->namespace('Users')->group(function() {
    Route::get('/', [App\Http\Controllers\UsersController::class, 'index']);
    Route::post('/', [App\Http\Controllers\UsersController::class, 'store']);
    Route::put('{user}', [App\Http\Controllers\UsersController::class, 'update']);
    Route::delete('{user}', [App\Http\Controllers\UsersController::class, 'delete']);
});

Route::prefix('posts')->namespace('Posts')->group(function() {
    Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
    Route::post('/', [App\Http\Controllers\PostsController::class, 'store']);
    Route::put('{post}', [App\Http\Controllers\PostsController::class, 'update']);
    Route::delete('{post}', [App\Http\Controllers\PostsController::class, 'delete']);
});
