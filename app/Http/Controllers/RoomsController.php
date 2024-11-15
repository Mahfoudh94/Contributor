<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('tasks:id,room_id,status')
            ->paginate(10);
        return Inertia::render('Homepage', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Rooms/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'start_at' => 'sometimes|date|after:now'
        ]);
        Room::create([
            'title' => $request->string('title'),
            'description' => $request->string('description'),
            'manager_id' => $request->user()->id,
            'start_at' => $request->date('start_at',
                tz: $request->header('X-Timezone')
            ),
        ]);
        return \Redirect::back()->with('success', 'Room created successfully.');
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
        return \Redirect::back()->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Room::find($id)->delete();
        return \Redirect::route('Homepage')
            ->with([
                'success' => 'deleted successfully'
            ]);
    }
}
