<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helper;

class BrandController extends Controller
{
    function brandList(): JsonResponse
    {
        $brands = Brand::all();
        return ResponseHelper::success(data: $brands);
    }
}