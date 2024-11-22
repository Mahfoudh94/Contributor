<?php

namespace App\Http\Controllers;

use App\Actions\Badges\AssignBadge;
use App\Actions\Badges\StoreBadge;
use App\Http\Requests\Badges\StoreBadgeRequest;
use App\Http\Requests\Badges\AssignBadgeRequest;
use App\Models\Badge;

class BadgeController extends Controller
{
    // List all badges
    public function index()
    {
        return response()->json(Badge::all());
    }

    // Create a new badge
    public function store(StoreBadgeRequest $request)
    {
        $badge = StoreBadge::run($request->validated());

        return response()->json(['message' => 'Badge created successfully!', 'badge' => $badge]);
    }

    // Assign a badge to a user
    public function assignToUser(AssignBadgeRequest $request)
    {
        $validatedData = $request->validated();
        AssignBadge::run($validatedData['user_id'], $validatedData['badge_id']);

        return response()->json(['message' => 'Badge assigned successfully!']);
    }
}
