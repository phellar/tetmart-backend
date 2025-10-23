<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Route
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// Guest checkout routes
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/order-items', [OrderItem::class, 'store']);

// Protected Route (Auth Required)
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/products', [ProductController::class, 'store']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Auth users/vendors can view their orders
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::get('/orders/{order}', [OrderController::class, 'update']);
        


});











Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
