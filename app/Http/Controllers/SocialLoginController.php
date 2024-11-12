<?php

namespace App\Http\Controllers;

use App\Actions\User\auth\github\HandleGithubCallBack;
use App\Actions\User\auth\github\RedirectToGithub;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Exception;

class SocialLoginController extends Controller
{
    public function redirectToGithub(): RedirectResponse
    {
        return RedirectToGithub::run();
    }

    public function handleGithubCallback()
    {
        try {
            HandleGithubCallBack::run();
            return redirect()->back();
        } catch (Exception) {
            abort(404);
        }
    }
}
