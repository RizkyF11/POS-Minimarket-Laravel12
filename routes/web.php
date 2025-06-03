<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

//Route untuk yang belom login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Route yang butuh login
Route::middleware('auth')->group(function () {

    
    Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/add', [UserController::class, 'create']);
        Route::post('users/add', [UserController::class, 'store']);
        Route::get('users/{id}/edit', [UserController::class, 'edit']);
        Route::patch('users/{id}/edit', [UserController::class, 'update']);
        Route::delete('users/{id}/delete', [UserController::class, 'destroy']);

        Route::get('/categories', [CategoriesController::class, 'index']);
        Route::get('categories/add', [CategoriesController::class, 'create']);
        Route::post('categories/add', [CategoriesController::class, 'store']);
        Route::get('categories/{id}/edit', [CategoriesController::class, 'edit']);
        Route::patch('categories/{id}/edit', [CategoriesController::class, 'update']);
        Route::delete('categories/{id}/delete', [CategoriesController::class, 'destroy']);


        Route::get('products', [ProductsController::class, 'index']);
        Route::get('products/add', [ProductsController::class, 'create']);
        Route::post('products/add', [ProductsController::class, 'store']);
        Route::get('products/{id}/edit', [ProductsController::class, 'edit']);
        Route::patch('products/{id}/edit', [ProductsController::class, 'update']);
        Route::delete('products/{id}/delete', [ProductsController::class, 'destroy']);
    });

    Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

    //route pdf
    Route::get('laporan/pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');


    Route::middleware(RoleMiddleware::class . ':kasir')->group(function () {

        Route::get('kasir', [KasirController::class, 'index'])->name('kasir');
        Route::post('keranjang/add', [KasirController::class, 'tambahKeKeranjang']);
        Route::post('keranjang/tambah/{id}', [KasirController::class, 'tambahJumlah']);
        Route::post('keranjang/kurang/{id}', [KasirController::class, 'kurangJumlah']);
        Route::post('keranjang/hapus-semua', [KasirController::class, 'hapusSemua']);
        Route::post('bayar', [OrderController::class, 'bayar']);
    });

    Route::get('laporan', [LaporanController::class, 'laporan'])->name('laporan');
});



