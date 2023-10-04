<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function productsByCategory(Request $request): JsonResponse
    {
        $products = Product::where('category_id', $request->id)->with('category', 'brand')->get();
        return ResponseHelper::success(data: $products);
    }

    function productsByBrand(Request $request): JsonResponse
    {
        $products = Product::where('brand_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::success(data: $products);
    }

    function productsByRemark(Request $request): JsonResponse
    {
        $products = Product::where('remark', $request->remark)->with('brand', 'category')->get();
        return ResponseHelper::success(data: $products);
    }

    function productSliderList(Request $request): JsonResponse
    {
        $products = ProductSlider::all();
        return ResponseHelper::success(data: $products);
    }
    function productDetails(Request $request): JsonResponse
    {
        $details = ProductDetail::where('product_id', $request->id)->with('product', 'product.category', 'product.brand')->first();
        return ResponseHelper::success(data: $details);
    }

    function reviewsByProduct(Request $request): JsonResponse
    {
        $reviews = ProductReview::where('product_id', $request->id)->with([
            'customerProfile' => function ($query) {
                $query->select('id', 'cus_name');
            }
        ])->get();

        return ResponseHelper::success(data: $reviews);
    }

    function createUpdateReview(Request $request): JsonResponse
    {
        $userId = $request->header('userId');
        $profile = CustomerProfile::where('user_id', $userId)->first();

        if ($profile) {
            $request->merge(['customer_id' => $profile->id]);

            try {
                ProductReview::updateOrCreate(['customer_id' => $profile->id], $request->input());
                return  ResponseHelper::success();

            } catch (Exception $e) {
                return ResponseHelper::failed();
            }

        } else {
            return ResponseHelper::failed('user profile doesn\'t exist');
        }
    }

}