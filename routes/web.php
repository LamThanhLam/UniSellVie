<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PlatformsController;
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
    // ...
});





