<?php

use App\Http\Controllers\TestResultsController;
use Illuminate\Support\Facades\Route;

Route::prefix('test-results')->group(function () {
    Route::get('/', [TestResultsController::class, 'index']);
});
