<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->group(function () {
  // category routes
  Route::controller(CategoryController::class)->group(function () {
    Route::get("/categories", "index")->name("category.index");
    Route::post("/category/store", "store")->name("category.store");
  });
});
