<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InventoryStockController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->middleware(['auth', 'role:admin'])->group(function () {
  // dashboard routes
  Route::controller(DashboardController::class)->group(function () {
    Route::get("/dashboard", "index")->name("admin.root");
  });

  //category routes
  Route::controller(CategoryController::class)->group(function () {
    Route::get("/categories", "index")->name("category.index");
    Route::post("/category/store", "store")->name("category.store");
    Route::get("/category/{category}/edit", "edit")->name("category.edit");
    Route::put("/category/{category}/update", "update")->name("category.update");
    Route::delete("/category/{category}/destroy", "destroy")->name("category.destroy");
  });

  // sub category routes
  Route::controller(SubCategoryController::class)->group(function () {
    Route::get("/sub-categories", "index")->name("subCategory.index");
    Route::post("/sub-category/store", "store")->name("subCategory.store");
    Route::get("/sub-category/{subCategory}/edit", "edit")->name("subCategory.edit");
    Route::put("/sub-category/{subCategory}/update", "update")->name("subCategory.update");
    Route::delete("/sub-category/{subCategory}/destroy", "destroy")->name("subCategory.destroy");
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
    Route::get("/product/{product}/edit", "edit")->name("product.edit");
    Route::put("/product/{product}/update", "update")->name("product.update");
  });

  // product variant routes
  Route::controller(ProductVariantController::class)->group(function () {
    Route::post("/product/{product}/variants/bulk", "bulkStore")->name("products.variants.bulkStore");
    Route::delete("/product/{product}/variants/{variant}/destroy", "destroy")->name("product.variants.destroy");
    Route::put("/product/{product}/variants/{variant}/update", "update")->name("product.variants.update");
  });

  // product review routes
  Route::controller(ProductReviewController::class)->group(function () {
    Route::get('/reviews', 'index')->name('admin.reviews.index');
    Route::post('/reviews/{review}/status', 'toggleStatus')->name('admin.reviews.status');
    Route::delete('/reviews/{review}/destroy', 'destroy')->name('admin.reviews.destroy');
  });

  // inventory stock routes
  Route::controller(InventoryStockController::class)->group(function () {
    Route::post("/products/{product}/stock", "bulkUpdate")->name("products.stock.bulkUpdate");
  });

  // coupon routes
  Route::controller(CouponController::class)->group(function () {
    Route::get("/coupons", "index")->name("coupon.index");
    Route::post("/coupon/store", "store")->name("coupon.store");
    Route::put("/coupon/{coupon}/update", "update")->name("coupon.update");
    Route::delete("/coupon/{coupon}/destroy", "destroy")->name("coupon.destroy");
  });

  // user routes
  Route::controller(UserController::class)->group(function () {
    Route::get("/customers", "index")->name("customer.index");
    Route::put("/customers/{user}/update", "update")->name("customer.update");
  });

  // profile routes
  Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('admin.profile.index');
    Route::put('/profile', 'update')->name('admin.profile.update');
    Route::put('/profile/password', 'updatePassword')->name('admin.profile.password.update');
  });

  // order routes
  Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index')->name('admin.order.index');
    Route::get('/order/{order}', 'show')->name('admin.order.show');
    Route::put('/order/{order}/status', 'updateStatus')->name('admin.order.status.update');
    Route::put('/order/{order}/payment', 'updatePayment')->name('admin.order.payment.update');
    Route::get('/order/invoice/{orderNumber}', 'invoice')->name('admin.order.invoice');
    Route::delete('/order/{order}/destroy', 'destroy')->name('admin.order.destroy');
  });

  // newsletter subscriber routes
  Route::controller(NewsletterController::class)->group(function () {
    Route::get('/subscribers', 'index')->name('admin.subscribers.index');
    Route::post('/subscribers/{subscriber}/status', 'toggleStatus')->name('admin.subscribers.status');
    Route::delete('/subscribers/{subscriber}/destroy', 'destroy')->name('admin.subscribers.destroy');
  });

  // contact message routes
  Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact-messages', 'index')->name('admin.contact.index');
    Route::post('/contact-messages/{message}/status', 'toggleStatus')->name('admin.contact.status');
    Route::delete('/contact-messages/{message}/destroy', 'destroy')->name('admin.contact.destroy');
  });

  // hero slider routes
  Route::controller(SliderController::class)->group(function () {
    Route::get('/sliders', 'index')->name('admin.sliders.index');
    Route::post('/sliders', 'store')->name('admin.sliders.store');
    Route::get('/sliders/{slider}/edit', 'edit')->name('admin.sliders.edit');
    Route::put('/sliders/{slider}', 'update')->name('admin.sliders.update');
    Route::delete('/sliders/{slider}', 'destroy')->name('admin.sliders.destroy');
    Route::post('/sliders/{slider}/status', 'toggleStatus')->name('admin.sliders.status');
  });

  // faq routes
  Route::controller(FaqController::class)->group(function () {
    Route::get('/faqs', 'index')->name('admin.faqs.index');
    Route::post('/faqs', 'store')->name('admin.faqs.store');
    Route::get('/faqs/{faq}/edit', 'edit')->name('admin.faqs.edit');
    Route::put('/faqs/{faq}', 'update')->name('admin.faqs.update');
    Route::delete('/faqs/{faq}', 'destroy')->name('admin.faqs.destroy');
    Route::post('/faqs/{faq}/status', 'toggleStatus')->name('admin.faqs.status');
  });

  // settings routes
  Route::controller(SettingController::class)->group(function () {
    Route::get('/settings', 'index')->name('admin.settings.index');
    Route::post('/settings/update', 'update')->name('admin.settings.update');
  });
});
