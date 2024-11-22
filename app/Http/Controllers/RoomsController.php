<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetReps;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Redirect;

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
        $rooms = Room::with(['tasks:id,room_id,status', 'manager:id,name'])
            ->orderByDesc('start_at')
            ->orderByDesc('updated_at')
            ->paginate(10);
        return Inertia::render('Homepage', [
            'rooms' => $rooms,
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
            'repositories' => fn () => GetReps::run(),
            'branches' => fn () => $repo_name ? GetRepoBranches::run($repo_name) : [] ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'repository' => 'required',
            'branch' => 'required',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'start_at' => 'sometimes|date|after:now'
        ]);
        $room = Room::create([
            'title' => $request->string('title'),
            'description' => $request->string('description'),
            'manager_id' => $request->user()->id,
            'start_at' => $request->date('start_at',
                tz: $request->header('X-Timezone')
            ),
        ])->repository()->create([
            'repository' => $request->input('repository'),
            'branch' => $request->input('branch'),
            'owner' => request()->user()->githubAccount->account_name
        ]);
        return Redirect::route('rooms.show', ['id' => $room->id])
            ->with('success', 'Room created successfully.');
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
        Room::find($id)->fill(
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
        Room::find($id)->delete();
        return Redirect::route('Homepage')
            ->with([
                'success' => 'deleted successfully'
            ]);
    }
}
