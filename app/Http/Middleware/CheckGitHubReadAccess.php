<?php

namespace App\Http\Middleware;

use App\Actions\Github\RefreshGithubToken;
use App\Actions\Github\ValidateGithubToken;
use Closure;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGitHubReadAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws GuzzleException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->githubAccount?->github_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $githubAccount = $user->githubAccount;
        $githubToken = $githubAccount->github_token;

        // Check and refresh token if necessary
        if (!ValidateGithubToken::run($githubToken)) {
            $githubToken = RefreshGithubToken::run($githubAccount);
            if (!$githubToken) {
                return response()->json(['error' => 'Could not refresh GitHub token'], 401);
            }
            // Update the token in the database
            $githubAccount->github_token = $githubToken;
            $githubAccount->save();
        }

        // Attach the valid token to the request for use in controllers
        $request->attributes->set('github_token', $githubToken);

        return $next($request);
    }
}
