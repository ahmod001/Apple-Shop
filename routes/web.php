<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductWishController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyTokenMiddleware;
use Illuminate\Support\Facades\Route;



//_           API Routes         _//

// Brand
Route::get('/brand-list', [BrandController::class, 'brandList']);

// Category
Route::get('/category-list', [CategoryController::class, 'categoryList']);

// Policy
Route::get('/policy-by-type/{type}', [PolicyController::class, 'policyByType']);

// Product
Route::controller(ProductController::class)->group(function () {
    Route::get('/products-by-category/{id}', 'productsByCategory');
    Route::get('/products-by-brand/{id}', 'productsByBrand');
    Route::get('/products-by-remark/{remark}', 'productsByRemark');
    Route::get('/product-slider-list', 'productSliderList');
    Route::get('/product-details/{id}', 'productDetails');
    Route::get('/reviews-by-product/{id}', 'reviewsByProduct');
    Route::post('/create-update-review', 'createUpdateReview')->middleware(VerifyTokenMiddleware::class);
});

// Product Wish
Route::controller(ProductWishController::class)->group(function () {
    Route::post('/create-update-wish/{id}', 'createUpdateProductWish')->middleware(VerifyTokenMiddleware::class);
    Route::get('/remove-wish/{id}', 'removeProductWish')->middleware(VerifyTokenMiddleware::class);
    Route::get('/wish-list', 'productWishList')->middleware(VerifyTokenMiddleware::class);
});

// Product Cart
Route::controller(ProductCartController::class)->group(function () {
    Route::post('/create-update-cart', 'createUpdateProductCart')->middleware(VerifyTokenMiddleware::class);
    Route::get('/remove-cart/{id}', 'removeProductCart')->middleware(VerifyTokenMiddleware::class);
    Route::get('/cart-list', 'productCartList')->middleware(VerifyTokenMiddleware::class);
});

// User Authentication
Route::controller(UserController::class)->group(function () {
    Route::get('/user-login/{email}', 'userLogin');
    Route::post('/verify-otp', 'verifyOtp');
});

// Profile
Route::controller(ProfileController::class)->group(function () {
    Route::post('/create-update-profile', 'createUpdateProfile')->middleware(VerifyTokenMiddleware::class);
    Route::get('/profile-details', 'profileDetails')->middleware(VerifyTokenMiddleware::class);
});