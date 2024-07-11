<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Product\Http\Controllers\ProductController;

Route::get('/v1/product', [ProductController::class, 'index'])->name('product_index');
Route::post('/v1/product', [ProductController::class, 'create'])->name('product_create');
Route::get('/v1/product/{id}', [ProductController::class, 'read'])->where('id', '[0-9]+')->name('product_read');
Route::post('/v1/product/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->name('product_update');
Route::delete('/v1/product/{id}', [ProductController::class, 'delete'])->where('id', '[0-9]+')->name('product_delete');
