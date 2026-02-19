<?php

use App\Http\Controllers\Collections\ProductsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu',[MenuController::class, 'index'])->name('menu');

Route::prefix('/collection')->group(function(){
    Route::get('/all',[ProductsController::class, 'index'])->name('collection.all');
    Route::get('/type/{bodyPart:slug}',[ProductsController::class, 'index'])->name('collection.types');
    Route::get('/mark/{mark:slug}',[ProductsController::class, 'index'])->name('collection.marks');
    Route::get('/skin-type/{skinType:slug}',[ProductsController::class, 'index'])->name('collection.skin.types');
    Route::get('/skin-concerns/{skinConcern:slug}',[ProductsController::class, 'index'])->name('collection.skin.concerns');
    Route::get('/product-type/{productType:slug}',[ProductsController::class, 'index'])->name('collection.product.types');
    Route::get('/extra/{extra:slug}',[ProductsController::class, 'index'])->name('collection.extras');
});
