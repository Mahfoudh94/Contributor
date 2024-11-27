<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(?string $username = null): Response
    {
        $user = null;
        if ($username == null)
            $user = Auth::user();
        else
            if (Str::startsWith($username, '@'))
                $user = User::where('username', $username)->first();
            else
                $user = User::where('id', $username)->first();

        if (!$user) abort(404);

        $isMe = $user->id == Auth::id();
        $ownRooms = Room::where('owner_id', $user->id)->get();
        $rooms = Room::where('owner_id', '<>', $user->id)
            ->whereDoesntHave('users', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->get();
        return Inertia::render('Profile/Show', [
            'isMe' => $isMe,
            'profile' => $user,
            'ownRooms' => $ownRooms,
            'rooms' => $rooms
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
