<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Register
Route::post('/register', [AuthController::class, 'register']);

// Auth logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Auth login
Route::post('/login', [AuthController::class, 'login']);

// Route Category
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show']);

// Route Product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Route Address
Route::apiResource('address', AddressController::class)->middleware('auth:sanctum');

// Route Order
Route::post('/order', [OrderController::class, 'order'])->middleware('auth:sanctum');

// Route Callback
Route::post('/callback', [CallbackController::class, 'callback']);
