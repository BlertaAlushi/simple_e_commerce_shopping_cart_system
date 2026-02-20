<?php

use App\Http\Controllers\Admin\BodyPartsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SkinTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{product:slug}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product:slug}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{product:slug}', [ProductsController::class, 'destroy'])->name('products.destroy');
//    Route::get('/cart', [CartController::class, 'index'])->name('cart');
//    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
//    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
//    Route::post('/order-cart', [CartController::class, 'orderCart'])->name('order-cart');
//    Route::get('/cart-products-count/',[CartController::class, 'cartProductsCount'])->name('cart-products-count');

    Route::get('/body-parts', [BodyPartsController::class, 'index'])->name('body-parts.index');
    Route::get('/body-parts/create', [BodyPartsController::class, 'create'])->name('body-parts.create');
    Route::post('/body-parts', [BodyPartsController::class, 'store'])->name('body-parts.store');
    Route::get('/body-parts/{bodyPart:slug}/edit', [BodyPartsController::class, 'edit'])->name('body-parts.edit');
    Route::put('/body-parts/{id}', [BodyPartsController::class, 'update'])->name('body-parts.update');
    Route::delete('/body-parts/{id}', [BodyPartsController::class, 'destroy'])->name('body-parts.destroy');


    Route::get('/skin-types',[SkinTypeController::class, 'index'])->name('skin-types.index');

});
