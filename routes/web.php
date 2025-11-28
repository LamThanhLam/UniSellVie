<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PlatformsController;
use App\Http\Controllers\GenresController;
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
    // Add route for Cart
    Route::resource('cart', CartController::class);
    // Add route for Order
    Route::resource('order', OrderController::class);
});





