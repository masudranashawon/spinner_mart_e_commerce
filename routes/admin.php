<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->group(function () {
  // category routes
  Route::controller(CategoryController::class)->group(function () {
    Route::get("/categories", "index")->name("category.index");
    Route::post("/category/store", "store")->name("category.store");
    Route::get("/category/{category}/edit", "edit")->name("category.edit");
    Route::put("/category/{category}/update", "update")->name("category.update");
  });

  // sub category routes
  Route::controller(SubCategoryController::class)->group(function () {
    Route::get("/sub-categories", "index")->name("subCategory.index");
    Route::post("/sub-category/store", "store")->name("subCategory.store");
    Route::get("/sub-category/{subCategory}/edit", "edit")->name("subCategory.edit");
    Route::put("/sub-category/{subCategory}/update", "update")->name("subCategory.update");
  });
});
