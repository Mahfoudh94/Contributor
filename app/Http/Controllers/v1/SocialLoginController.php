<?php

namespace App\Http\Controllers\v1;
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
            response()->json([
                'status' => true,
                'data' => $user->createToken('API Token')->plainTextToken
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
        return 'Naaaaaaaaah, it won\t return, yet the IDE complains about it';
    }
}
