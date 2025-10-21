<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;  
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SupplierController;
use App\Http\Controllers\API\PurchaseController;
 

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


// Public routes for category listing
Route::middleware(['auth:sanctum', 'role:Admin,Cashier,Counter'])->group(function () {
    Route::post('/v1/categories', [CategoryController::class, 'store']);
    Route::get('/v1/categories', [CategoryController::class, 'index']);
    Route::get('/v1/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/v1/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/v1/categories/{id}', [CategoryController::class, 'destroy']);
});


// Protected routes for product management
Route::middleware(['auth:sanctum', 'role:Admin,Cashier,Counter'])->group(function () {
    Route::post('/v1/products', [ProductController::class, 'store']);
    Route::get('/v1/products', [ProductController::class, 'index']);
    Route::get('/v1/products/{id}', [ProductController::class, 'show']);
    Route::put('/v1/products/{id}', [ProductController::class, 'update']);
    Route::delete('/v1/products/{id}', [ProductController::class, 'destroy']);
});


// Protected routes for supplier management
Route::middleware(['auth:sanctum', 'role:Admin,Counter'])->group(function () {
    Route::post('/v1/suppliers', [SupplierController::class, 'store']);
    Route::get('/v1/suppliers', [SupplierController::class, 'index']);
    Route::get('/v1/suppliers/{id}', [SupplierController::class, 'show']);
    Route::put('/v1/suppliers/{id}', [SupplierController::class, 'update']);
    Route::delete('/v1/suppliers/{id}', [SupplierController::class, 'destroy']);
});

// Protected routes for purchase management
Route::middleware(['auth:sanctum', 'role:Admin,Counter'])->group(function () {
    Route::post('/v1/purchases', [PurchaseController::class, 'store']);
    Route::get('/v1/purchases', [PurchaseController::class, 'index']);
});