<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
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
        Route::get('/carts', 'index')->name('cart.index');
        Route::post('/cart/store', 'store')->name('cart.store');
        Route::post('/cart/update', 'update')->name('cart.update');
        Route::post('/cart/coupon/apply', 'cardCouponApply')->name('cart.coupon.apply');
        Route::delete('/cart/{cart}/destroy', 'destroy')->name('cart.destroy');
    });

    Route::controller(WishlistController::class)->group(function () {
        Route::get('/wishlists', 'index')->name('wishlist.index');
        Route::post('/wishlist/store', 'store')->name('wishlist.store');
        Route::delete('/wishlist/destroy', 'destroy')->name('wishlist.destroy');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.index');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('order.index');
        Route::post('/order/store', 'store')->name('order.store');
        Route::get('/order/{order}/details', 'show')->name('order.show');
        Route::get('/order/{orderNumber}/invoice', 'invoice')->name('order.invoice');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile', 'update')->name('profile.update');
        Route::put('/profile/password', 'updatePassword')->name('profile.password.update');
    });
});

@include("admin.php");
