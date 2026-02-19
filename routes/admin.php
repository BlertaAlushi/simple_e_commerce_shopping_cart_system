<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
//    Route::get('/cart', [CartController::class, 'index'])->name('cart');
//    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
//    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
//    Route::post('/order-cart', [CartController::class, 'orderCart'])->name('order-cart');
//    Route::get('/cart-products-count/',[CartController::class, 'cartProductsCount'])->name('cart-products-count');

});
