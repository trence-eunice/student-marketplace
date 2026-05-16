<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\SalesController;
use App\Http\Controllers\Buyer\ProductController as BuyerProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\PaymentController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Seller Routes
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('products', SellerProductController::class)->except(['show']);
    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::patch('sales/{order}/status', [SalesController::class, 'updateStatus'])->name('sales.status');
});

// Buyer Routes
Route::middleware(['auth'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::resource('products', BuyerProductController::class)->only(['index', 'show']);
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('cart/{id}/remove', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::resource('orders', OrderController::class)->only(['index']);
    Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('products/{product}/review', [ReviewController::class, 'store'])->name('products.review');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders');
    Route::patch('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
});

require __DIR__.'/auth.php';


Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('read');
    Route::post('/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('readAll');
    Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unreadCount');
});

Route::middleware('auth')->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{order}/{seller}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{order}/{seller}', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{order}/{seller}/fetch', [App\Http\Controllers\MessageController::class, 'fetch'])->name('messages.fetch');
});
