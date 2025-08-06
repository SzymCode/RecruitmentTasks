<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportCsvController;
use App\Http\Controllers\TestResultsController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/test-results', [TestResultsController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/import/csv', [ImportCsvController::class, 'import']);
});
