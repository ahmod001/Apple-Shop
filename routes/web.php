<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



// API Routes

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
    Route::get('/reviews-by-product/{id}', 'reviewsByProduct');
    Route::get('/product-details/{id}', 'productDetails');
});