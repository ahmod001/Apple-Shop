<?php

namespace App\Http\Controllers;

use App\Models\ProductWish;
use Exception;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class ProductWishController extends Controller
{
    function createUpdateProductWish(Request $request)
    {
        $userId = $request->header('userId');

        try {
            ProductWish::updateOrCreate(
                ["user_id" => $userId, "product_id" => $request->id],
                ["user_id" => $userId, "product_id" => $request->id]
            );
            return ResponseHelper::success();

        } catch (Exception $e) {
            return ResponseHelper::failed();
        }
    }
    
    function removeProductWish(Request $request)
    {
        $userId = $request->header('userId');

        try {
            ProductWish::where(["user_id" => $userId, "product_id" => $request->id])->delete();
            return ResponseHelper::success('product removed successfully');

        } catch (Exception $e) {
            return ResponseHelper::failed('removing product is failed');
        }
    }

    function productWishList(Request $request)
    {
        $userId = $request->header('userId');

        $products = ProductWish::where('user_id', $userId)->with('product')->get();
        return ResponseHelper::success(data: $products);
    }
}