<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Act;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::with('act')->latest()->paginate(10);
        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $acts = Act::orderBy('order_number')->get();
        return view('lessons.create', compact('acts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'act_id' => 'required|exists:acts,id',
            'content' => 'required|string|min:10',
        ]);

        Lesson::create($validated);

        return redirect()->route('lessons.index')
                        ->with('success', 'Lesson berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $acts = Act::orderBy('order_number')->get();
        return view('lessons.edit', compact('lesson', 'acts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'act_id' => 'required|exists:acts,id',
            'content' => 'required|string|min:10',
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.show', $lesson)
                        ->with('success', 'Lesson berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lessons.index')
                        ->with('success', 'Lesson berhasil dihapus.');
    }
}
