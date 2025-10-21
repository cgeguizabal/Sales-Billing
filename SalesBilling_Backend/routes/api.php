<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;  
use App\Http\Controllers\API\UserController;
 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//Auth routes
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected routes for user management
Route::middleware(['auth:sanctum', 'role:Admin,RH'])->group(function () {
    Route::get('/v1/users', [UserController::class, 'index']);
    Route::get('/v1/users/{user}', [UserController::class, 'show']);
    Route::put('/v1/users/{user}', [UserController::class, 'update']);
    Route::delete('/v1/users/{user}', [UserController::class, 'destroy']);
});