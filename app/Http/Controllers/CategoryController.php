<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function categoryList(): JsonResponse
    {
        $categories = Category::all();
        return ResponseHelper::success(data: $categories);
    }
}