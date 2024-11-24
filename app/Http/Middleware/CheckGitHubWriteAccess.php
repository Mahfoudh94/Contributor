<?php

namespace App\Http\Middleware;

use App\Actions\Github\GetGithubPrivateToken;
use App\Actions\Github\GetOrCreateGithubInstallationId;
use App\Actions\User\auth\github\RedirectToGithubInstall;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGitHubWriteAccess
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws GuzzleException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }

        $githubAccount = $user->githubAccount;

        // Check if the user has an installation_id
        if (!$githubAccount || !$githubAccount->installation_id) {
            $installationId = GetOrCreateGithubInstallationId::run($githubAccount);

            if (!$installationId) {
                // Redirect the user to install the GitHub App if not installed
                return RedirectToGithubInstall::run();
            }
            // Save the retrieved installation_id to the user's account
            $githubAccount->installation_id = $installationId;
            $githubAccount->save();
        }

        // Retrieve a new installation token based on the installation_id
        $privateToken = GetGithubPrivateToken::run($githubAccount->installation_id);
        if (!$privateToken) {
            return response()->json(['error' => 'Could not obtain GitHub installation token'], 400);
        }

        // Attach the valid token to the request for use in controllers
        $request->attributes->set('github_private_token', $privateToken);

        return $next($request);
    }
}
