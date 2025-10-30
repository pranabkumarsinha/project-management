<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardColtroller;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function() {
    return response()->json(['message' => 'Message from Test API']);
});

Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');
Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/dashboard-stats', [DashboardColtroller::class, 'stats'])->middleware('auth:sanctum');
