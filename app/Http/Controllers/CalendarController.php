<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Planner;

class CalendarController extends Controller
{
    /**
     * Display the user's calendar.
     */
    public function index(Request $request): View
    {
        return view('calendar.index', [
            'user' => $request->user(),
        ]);
    }

    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Create a new Note
        Planner::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status, // Corrected field
            'user_id' => Auth::id(),
        ]);

        // Set a success message
        return redirect()->route('calendar.index')->with('success', 'Task created successfully.');
    }

}
