<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Policy;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    function policyByType(Request $request)
    {
        $policy = Policy::where('type', $request->type)->first();
        return ResponseHelper::success(data: $policy);
    }
}