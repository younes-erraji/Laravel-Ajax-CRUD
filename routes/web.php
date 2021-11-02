<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('products');
// });

Route::view('/', 'products');

Route::get('/products', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store'])->name('save-product');
Route::get('fetch', [ProductController::class, 'fetch'])->name('fetch');
