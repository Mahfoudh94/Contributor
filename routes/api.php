<?php

use App\Http\Controllers\Api\v1\GithubController;
use App\Http\Controllers\Api\v1\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/auth/github', [SocialLoginController::class, 'redirectToGithub']);
    Route::get('/auth/github/callback', [SocialLoginController::class, 'handleGithubCallback']);

    // Define the API prefix for GitHub routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('github')->group(function () {
            Route::middleware('github.read')->group(function () {

                // Retrieve Projects (for displaying in a view)
                Route::get('/projects', [GithubController::class, 'showProjects']);

                // Retrieve Branches from a Selected Repository (for displaying branches in a view)
                Route::get('/{repo}/branches', [GithubController::class, 'showBranches']);

                // Retrieve Pull Requests (for displaying pull requests in a view)
                Route::get('/{repo}/pulls', [GithubController::class, 'showPullRequests']);

                // Retrieve Pull Requests with filter the user and his original branch(for displaying pull requests in a view)
                Route::get('/{repo}/{branch}/pulls', [GithubController::class, 'showPullRequests']);

                // Check if a Fork Already Exists (display fork status in a view)
                Route::get('/{repo}/fork/check', [GithubController::class, 'showForkStatus']);

                // Retrieve Commits from a Specific Pull Request (for displaying commits of a PR)
                Route::get('/{repo}/pull-requests/{pr_id}/commits', [GithubController::class, 'showCommits']);
            });

            // Show form to create a branch
            Route::get('/{repo}/branches/create', [GithubController::class, 'showCreateBranchForm']);

            // Create a Branch Based on the Selected Branch
            Route::post('/{repo}/branches', [GithubController::class, 'createBranch']);

            // Initiate a Fork (display fork status in a view)
            Route::post('/{repo}/fork', [GithubController::class, 'createFork']);


        });
    });
});
