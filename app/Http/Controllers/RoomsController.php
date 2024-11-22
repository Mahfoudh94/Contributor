<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetRepositories;
use App\Actions\Rooms\GetPaginatedRooms;
use App\Actions\Rooms\StoreRoom;
use App\Http\Requests\Rooms\StoreRoomRequest;
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
            'branches' => fn() => $repo_name ? GetRepoBranches::run($repo_name) : [],
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
        return Inertia::render('Rooms/Show', [
            'room' => Room::with('tasks')
                ->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('', [
            'room' => Room::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Task not found.');
        }
        $room->fill(
            array_filter([
                'title' => $request->string('title'),
                'description' => $request->string('description'),
                'start_at' => $request->date('start_at')
            ])
        );
        return Redirect::back()->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return Redirect::back()->with('error', 'Task not found.');
        }

        $room->delete();
        return Redirect::route('Homepage')->with([
                'success' => 'deleted successfully'
            ]);
    }
}
