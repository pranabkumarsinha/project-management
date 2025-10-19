<?php

use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function() {
    return response()->json(['message' => 'Message from Test API']);
});

Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
