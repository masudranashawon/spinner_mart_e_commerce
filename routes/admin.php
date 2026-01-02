<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TagController;
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

  // brand routes
  Route::controller(BrandController::class)->group(function () {
    Route::get("/brands", "index")->name("brand.index");
    Route::post("/brand/store", "store")->name("brand.store");
    Route::get("/brand/{brand}/edit", "edit")->name("brand.edit");
    Route::put("/brand/{brand}/update", "update")->name("brand.update");
    Route::delete("/brand/{brand}/destroy", "destroy")->name("brand.destroy");
  });

  // color routes
  Route::controller(ColorController::class)->group(function () {
    Route::get("/colors", "index")->name("color.index");
    Route::post("/color/store", "store")->name("color.store");
    Route::put("/color/{color}/update", "update")->name("color.update");
    Route::delete("/color/{color}/destroy", "destroy")->name("color.destroy");
  });

  // size routes
  Route::controller(SizeController::class)->group(function () {
    Route::get("/sizes", "index")->name("size.index");
    Route::post("/size/store", "store")->name("size.store");
    Route::put("/size/{size}/update", "update")->name("size.update");
    Route::delete("/size/{size}/destroy", "destroy")->name("size.destroy");
  });

  // tag routes
  Route::controller(TagController::class)->group(function () {
    Route::get("/tags", "index")->name("tag.index");
    Route::post("/tag/store", "store")->name("tag.store");
    Route::put("/tag/{tag}/update", "update")->name("tag.update");
    Route::delete("/tag/{tag}/destroy", "destroy")->name("tag.destroy");
  });

  // product routes
  Route::controller(ProductController::class)->group(function () {
    Route::get("/products", "index")->name("product.index");
    Route::get("/product/create", "create")->name("product.create");
    Route::post("/product/store", "store")->name("product.store");
    Route::get("/product/{product}/show", "show")->name("product.show");
  });
});
