<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{


    public static function success(string $message = 'Request successful', int $code = 200, $data = []): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public static function failed(string $message = 'Request failed', int $code = 400, array $data = []): JsonResponse
    {
        return response()->json([
            "status" => "failed",
            "message" => $message,
            "data" => $data
        ], $code);
    }
}