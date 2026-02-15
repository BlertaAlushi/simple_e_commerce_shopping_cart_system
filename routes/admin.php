<?php
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {

});
