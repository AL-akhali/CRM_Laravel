<?php 

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ClientContactController;
use App\Http\Controllers\Api\ClientActivityController;




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});
// العملاء

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
});

// الجهات

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('client-contacts', ClientContactController::class);
});

// الانشطه

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('client-activities', ClientActivityController::class);
});

