<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

// admin's routes
Route::middleware(['auth','admin'])->group(function () {
    Route::resource('products', App\Http\Controllers\admin\ProductController::class);
    Route::resource('admin', App\Http\Controllers\admin\AdminUserController::class);
    Route::get('/dashboard', [App\Http\Controllers\admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', App\Http\Controllers\admin\OrderController::class);
    Route::resource('category', App\Http\Controllers\admin\CategoryController::class);
});


// user's routes
Route::get('/', [App\Http\Controllers\user\HomeController::class, 'index'])->name('home');
Route::get('/product/search', [App\Http\Controllers\user\HomeController::class, 'search'])->name('search');

Route::get('/product/detail/{id}', [App\Http\Controllers\user\HomeController::class, 'productDetail'])->name('productDetail');

Route::get('home/products', [App\Http\Controllers\user\HomeController::class, 'viewAll'])->name('viewAll');


Route::middleware('auth')->group(function () {
    Route::resource('cart', App\Http\Controllers\user\CartController::class);
    Route::resource('order', App\Http\Controllers\user\UserOrderController::class);
    Route::resource('rate', App\Http\Controllers\user\RatingController::class);
    Route::post('password/update/{user}', [App\Http\Controllers\user\ProfileController::class, 'updatePassword'])->name('password.change');
    Route::resource('profile/user', App\Http\Controllers\user\ProfileController::class);
});