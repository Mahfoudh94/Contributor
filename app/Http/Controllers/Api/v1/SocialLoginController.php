<?php

namespace App\Http\Controllers\Api\v1;
use App\Actions\User\Login;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\auth\SocialLoginRequest;
use App\Models\User;
use Exception;

class SocialLoginController extends Controller
{
    public function login(SocialLoginRequest $request)
    {
        try {
            /** @var User $user */
            $user = Login::run($request->get('access_token'), $request->get('provider'));
            return response()->json([
                'status' => true,
                'data' => $user->createToken('API Token')->plainTextToken
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}