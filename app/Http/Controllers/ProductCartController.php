<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductWish;
use Exception;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class ProductCartController extends Controller
{
    function createUpdateProductCart(Request $request)
    {
        $userId = $request->header('userId');
        $productId = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');
        $quantity = $request->input('quantity');

        $productDetails = Product::where('id', $productId)->first();

        $unitPrice = 0;

        if ($productDetails->discount === 1) {
            $unitPrice = $productDetails->discount_price;

        } else {
            $unitPrice = $productDetails->price;
        }

        try {
            ProductCart::updateOrCreate(
                ["user_id" => $userId, "product_id" => $request->product_id],
                [
                    "user_id" => $userId,
                    "product_id" => $productId,
                    "size" => $size,
                    "color" => $color,
                    "quantity" => $quantity,
                    "price" => $unitPrice * $quantity
                ]
            );
            return ResponseHelper::success();

        } catch (Exception $e) {
            return ResponseHelper::failed();
        }
    }
    
    function removeProductCart(Request $request)
    {
        $userId = $request->header('userId');

        try {
            ProductCart::where(["user_id" => $userId, "product_id" => $request->id])->delete();
            return ResponseHelper::success('product removed successfully');

        } catch (Exception $e) {
            return ResponseHelper::failed('removing product is failed');
        }
    }

    function productCartList(Request $request)
    {
        $userId = $request->header('userId');

        $products = ProductCart::where('user_id', $userId)->with('product')->get();
        return ResponseHelper::success(data: $products);
    }
}