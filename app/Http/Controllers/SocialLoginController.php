<?php

namespace App\Http\Controllers;
use App\Actions\User\Login;
use App\Http\Requests\api\auth\SocialLoginRequest;
use Exception;

class SocialLoginController extends Controller
{
    public function login(SocialLoginRequest $request)
    {
        try {
            $user_info = Login::run($request->get('access_token'), $request->get('provider'));
            return response()->json([
                'status' => true,
                'data' => $user_info
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
