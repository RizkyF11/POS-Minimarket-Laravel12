<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoriesController::class, 'index'] );
Route::get('categories/add', [CategoriesController::class, 'create'] );
Route::post('categories/add', [CategoriesController::class, 'store'] );

Route::get('categories/{id}/edit', [CategoriesController::class, 'edit']);
Route::patch('categories/{id}/edit', [CategoriesController::class, 'update']);

Route::delete('categories/{id}/delete', [CategoriesController::class, 'destroy']);


Route::get('products', [ProductsController::class, 'index']);
Route::get('products/add', [ProductsController::class, 'create']);
Route::post('products/add', [ProductsController::class, 'store']);

Route::get('products/{id}/edit', [ProductsController::class, 'edit']);
Route::patch('products/{id}/edit', [ProductsController::class, 'update']);

Route::delete('products/{id}/delete', [ProductsController::class, 'destroy']);

Route::get('kasir', [KasirController::class, 'index']);
Route::post('keranjang/add', [KasirController::class, 'tambahKeKeranjang']);
Route::post('keranjang/tambah/{id}', [KasirController::class, 'tambahJumlah']);
Route::post('keranjang/kurang/{id}', [KasirController::class, 'kurangJumlah']);
Route::post('keranjang/hapus-semua', [KasirController::class, 'hapusSemua']);



