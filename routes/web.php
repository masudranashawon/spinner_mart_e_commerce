<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{slug}', [ShopController::class, 'show'])->name('productDetails');

Route::controller(AuthController::class)->group(function () {
  Route::get('register', 'register')->name('register');
  Route::post('register', 'registerStore')->name('register.store');
  Route::get('login', 'login')->name('login');
  Route::post('login', 'loginPost')->name('login.post');
  Route::post('logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::post('/cart/store', 'store')->name('cart.store');
    });
});

@include("admin.php");
