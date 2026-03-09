<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = Chapter::all();
        return view('chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chapters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:100|min:5',
            'order_number' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Chapter::create($validatedData);
        return redirect()->route('chapters.index')->with('success', 'Chaper created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('chapters.show', compact('chapter'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('chapters.edit', compact('chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:25|min:5',
            'order_number' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $chapter = Chapter::findOrFail($id);
        $chapter->update($validatedData);
        return redirect()->route('chapters.index')->with('success', 'Chapter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        return redirect()->route('chapters.index')->with('success', 'Chapter deleted successfully.');
    }
}
