<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\TaskController;

 Route::prefix('tasks')->group(function () {
        Route::get('report', [TaskController::class, 'report']);

    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::patch('{task}/status', [TaskController::class, 'updateStatus']);
    Route::delete('{task}', [TaskController::class, 'destroy']);

 });

