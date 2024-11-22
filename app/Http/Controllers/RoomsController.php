<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetRepositories;
use App\Actions\Rooms\DeleteRoom;
use App\Actions\Rooms\GetPaginatedRooms;
use App\Actions\Rooms\StoreRoom;
use App\Actions\Rooms\UpdateRoom;
use App\Http\Requests\Rooms\StoreRoomRequest;
use App\Http\Requests\Rooms\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoomsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth', only: ['create', 'store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Homepage', [
            'rooms' => GetPaginatedRooms::run(),
            'GITHUB_REDIRECT_URL' => config('services.github.install_url')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $repo_name = $request->query('repo', '');
        return Inertia::render('Rooms/Create', [
            'repositories' => fn() => GetRepositories::run(),
            'branches' => fn() => GetRepoBranches::run($repo_name),
        ]);
    }

    /**
     * Store new Room.
     */
    public function store(StoreRoomRequest $request)
    {
        $room = StoreRoom::run($request->validated(), $request->header('X-Timezone'));
        return Redirect::route('rooms.show', [
            'id' => $room->id
        ])->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Room not found.');
        }
        $room->load('tasks');
        return Inertia::render('Rooms/Show', [
            'room' => $room
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Room not found.');
        }

        return Inertia::render('', [
            'room' => $room
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Room not found.');
        }
        UpdateRoom::run($room, $request->validated());
        return Redirect::back()->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Room not found.');
        }
        DeleteRoom::run($room);
        return Redirect::route('Homepage')->with([
            'success' => 'deleted successfully'
        ]);
    }
}
