<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Buyer\ProductController as BuyerProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('products', SellerProductController::class)->except(['show']);
});

Route::middleware(['auth'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::resource('products', BuyerProductController::class)->only(['index', 'show']);
    Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);
    Route::resource('orders', OrderController::class)->only(['index', 'store']);
});

require __DIR__.'/auth.php';
