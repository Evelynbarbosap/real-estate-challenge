<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TaskController;


Route::prefix('v1')->group(function() {
    Route::get('/buildings/{building}/tasks', [TaskController::class, 'index']);
});
