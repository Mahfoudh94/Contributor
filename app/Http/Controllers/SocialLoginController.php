<?php

namespace App\Http\Controllers;

use App\Actions\User\auth\github\HandleGithubCallBack;
use App\Actions\User\auth\github\RedirectToGithub;
use App\Models\User;
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
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function assignInstallId(Request $request)
    {
        $installId = $request->query('installation_id');

        \Auth::user()->githubAccount()
            ->update(['installation_id' => $installId]);

        return response(<<<END
                <script>window.close()</script>
                END
            )->header('content-type', 'text/html');
    }
}
