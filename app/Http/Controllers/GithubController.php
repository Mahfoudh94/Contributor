<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetCommitsFromPullRequest;
use App\Actions\Github\GetReps;
use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetRepoPullRequests;
use App\Http\Requests\GetCommitsRequest;
use App\Http\Requests\RepoPRRequest;
use Mockery\Exception;

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

    public function showCommits(string $repo, string $pr_id,GetCommitsRequest $request){
        try {
            return GetCommitsFromPullRequest::run($request->input('owner_id'),$repo,$pr_id);
        }catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this repo'
            ], 400);
        }
    }
}

