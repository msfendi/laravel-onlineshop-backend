<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route Login
Route::get('/', function () {
    return view('pages.auth.login');
});

// Route Register
Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {

    // Route Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // Route User
    Route::resource('user', UserController::class);

    // Route Category
    Route::resource('category', CategoryController::class);
    Route::post('upload', [CategoryController::class, 'upload'])->name('upload');
    Route::delete('revert', [CategoryController::class, 'revert'])->name('revert');

    // Route Product
    Route::resource('product', ProductController::class);

    // Route Order
    Route::resource('order', OrderController::class);
});


// Route::get('/login', function () {
//     return view('pages.auth.login');
// });
