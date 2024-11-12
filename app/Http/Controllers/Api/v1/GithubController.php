<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetRepoPullRequests;
use App\Actions\Github\GetReps;
use App\Http\Controllers\Controller;
use App\Http\Requests\RepoPRRequest;
use Exception;

class GithubController extends Controller
{
    public function showProjects()
    {
        try {
            return GetReps::run();
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this user'
            ], 400);
        }

    }

    public function showBranches(string $repo)
    {
        try {
            return GetRepoBranches::run($repo);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this repo'
            ], 400);
        }
    }

    public function showPullRequests(string $repo, RepoPRRequest $request ,string $branch = null)
    {
        try {
            return GetRepoPullRequests::run($repo, $request->input('owner_id'),$branch);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this repo'
            ], 400);
        }
    }
}

