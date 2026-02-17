<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Collections\BodyPartsController;
use App\Http\Controllers\Collections\ExtrasController;
use App\Http\Controllers\Collections\MarksController;
use App\Http\Controllers\Collections\ProductTypesController;
use App\Http\Controllers\Collections\SkinConcernsController;
use App\Http\Controllers\Collections\SkinTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Collections\ProductsController as ProductsCollectionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu',[MenuController::class, 'index'])->name('menu');

Route::prefix('/collection')->group(function(){
    Route::get('/all',[ProductsCollectionController::class, 'index'])->name('collection.all');
    Route::get('/type/{slug}',[BodyPartsController::class, 'index'])->name('collection.types');
    Route::get('/mark/{mark:slug}',[MarksController::class, 'index'])->name('collection.marks');
    Route::get('/skin-type/{skinType:slug}',[SkinTypeController::class, 'index'])->name('collection.skin.types');
    Route::get('/skin-concerns/{skinConcern:slug}',[SkinConcernsController::class, 'index'])->name('collection.skin.concerns');
    Route::get('/product-type/{productType:slug}',[ProductTypesController::class, 'index'])->name('collection.product.types');
    Route::get('/extra/{extra:slug}',[ExtrasController::class, 'index'])->name('collection.extras');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
Route::post('/order-cart', [CartController::class, 'orderCart'])->name('order-cart');
Route::get('/cart-products-count/',[CartController::class, 'cartProductsCount'])->name('cart-products-count');
