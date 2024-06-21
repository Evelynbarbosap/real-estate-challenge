<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TaskController;
use App\Http\Controllers\Api\v1\CommentController;

Route::prefix('v1')->group(function() {
    Route::get('/buildings/{building}/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
});
