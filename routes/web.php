<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController; // <-- toevoegen
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', fn () => view('welcome'))->name('home');

// Shop (publiek) via controller zodat $products wordt meegegeven
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// Alleen ingelogd
Route::middleware('auth')->group(function () {
    Route::get('/cart', fn () => view('cart'))->name('cart');
    Route::get('/checkout', fn () => view('checkout'))->name('checkout');
    Route::get('/orders', fn () => view('orders'))->name('orders');

    Route::get('/account', [ProfileController::class, 'edit'])->name('account');
    Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';
