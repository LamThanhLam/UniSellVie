<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PlatformsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return view('welcome');
});

//About
Route::get('/about', function () {
    return view('about');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductsController::class);
    // Adds route for Platforms
    Route::resource('platforms', PlatformsController::class); 
    // Add route for Genres
    Route::resource('genres', GenresController::class);


    // CART: index and destroy
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // CART: Add product to cart (need Route Model Binding for Product)
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');

    // ORDERS/CHECKOUT
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});





