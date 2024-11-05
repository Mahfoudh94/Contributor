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
            Login::run($request->get('access_token'), $request->get('provider'));
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
