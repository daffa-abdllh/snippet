<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource (Landing page to type new note).
     */
    public function index()
    {
        return view('notes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'title' => 'nullable|string|max:255',
        ]);

        // Generate unique 6-character random slug
        do {
            $slug = Str::lower(Str::random(6));
        } while (Note::where('slug', $slug)->exists());

        $note = Note::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title') ?: 'Tanpa Judul',
            'content' => $request->input('content'),
            'slug' => $slug,
        ]);

        if (auth()->check()) {
            return redirect()->route('dashboard')->with('status', 'note-created');
        }

        return redirect()->route('notes.show', $note->slug)->with('status', 'note-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $note = Note::where('slug', $slug)->firstOrFail();

        return view('notes.show', compact('note'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);

        // Pastikan catatan milik user yang login
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();

        return redirect()->route('dashboard')->with('status', 'note-deleted');
    }
}
