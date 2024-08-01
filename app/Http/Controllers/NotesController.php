<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Note;
use Carbon\Carbon;

class NotesController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all notes for the authenticated user
        $notes = Note::where('user_id', Auth::id())->get();

        // Categorize notes
        $groupedNotes = [
            'Today' => [],
            'Yesterday' => [],
            'Previous 7 days' => [],
            'Previous 30 days' => [],
        ];

        foreach ($notes as $note) {
            $created_at = Carbon::parse($note->created_at);

            if ($created_at->isToday()) {
                $groupedNotes['Today'][] = $note;
            } elseif ($created_at->isYesterday()) {
                $groupedNotes['Yesterday'][] = $note;
            } elseif ($created_at->between(Carbon::now()->subDays(7), Carbon::now())) {
                $groupedNotes['Previous 7 days'][] = $note;
            } elseif ($created_at->between(Carbon::now()->subDays(30), Carbon::now())) {
                $groupedNotes['Previous 30 days'][] = $note;
            }
        }

        // Determine selected note based on request
        $selectedNote = null;
        if ($request->has('note_id')) {
            $selectedNote = Note::find($request->input('note_id'));
        }

        // Return the view with the notes and selected note
        return view('notes.index', [
            'groupedNotes' => $groupedNotes,
            'selectedNote' => $selectedNote,
        ]);
    }
    
    public function show(Request $request)
    {
        $note = Note::find($request->input('note_id'));

        if ($note) {
            return response()->json([
                'title' => $note->title,
                'content' => $note->content,
            ]);
        } else {
            return response()->json([
                'error' => 'Note not found',
            ], 404);
        }
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);
        $message="successfully add!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        return redirect()->route('notes.index')->with(['success', 'Note created successfully.']);
    }
    
    public function edit($id)
    {
        $note = Note::findOrFail($id); // Fetch the note by ID
        return view('notes.edit', compact('note')); // Return the edit view with note data
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with(['success' => 'Note renamed successfully.']);
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $note->delete();

        return response()->json(['success' => 'Note deleted successfully.']);
    }
}
