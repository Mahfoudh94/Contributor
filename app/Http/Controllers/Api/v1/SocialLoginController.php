<?php

namespace App\Http\Controllers\Api\v1;
use App\Actions\User\auth\github\HandleGithubCallBack;
use App\Http\Controllers\Controller;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGithub()
    {
        $redirectUrl = config('services.github.redirect_api');
        return response()->json([
            'url' => Socialite::driver('github')
                ->redirectUrl($redirectUrl)
                ->stateless()
                ->scopes(['repo'])
                ->redirect()
                ->getTargetUrl()
        ]);
    }
    public function handleGithubCallback()
    {
        try {
            $user = HandleGithubCallBack::run();
            return response()->json([
                'status' => true,
                'data' => $user->createToken('API Token')->plainTextToken,
            ]);
        } catch (Exception) {
            return response()->json([],400);
        }
    }
}
