<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
  Route::get('/', 'index')->name('home');
});

Route::controller(AuthController::class)->group(function () {
  Route::get('login', 'login')->name('login');
});

@include("admin.php");
