<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function createUpdateProfile(Request $request)
    {
        $userId = $request->header('userId');
        $request->merge(['user_id' => $userId]);

        try {
            CustomerProfile::updateOrCreate(['user_id' => $userId], $request->input());
            return ResponseHelper::success();

        } catch (Exception $e) {
            return ResponseHelper::failed();
        }
    }

    function profileDetails(Request $request)
    {
        $userId = $request->header('userId');
        $details = CustomerProfile::where('user_id', $userId)->with([
            'user' => function ($query) {
                $query->select("id", "email");
            }
        ])->first();

        return ResponseHelper::success(data: $details);
    }
}