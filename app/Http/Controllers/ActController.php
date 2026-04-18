<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ActController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acts = Act::with('chapter')->orderBy('order_number')->paginate(10);
        return view('acts.index', compact('acts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chapters = Chapter::orderBy('order_number')->get();
        return view('acts.create', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:255',
            'order_number' => 'required|integer|min:1',
        ]);

        Act::create($validated);

        return redirect()->route('acts.index')
                        ->with('success', 'Act berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Act $act)
    {
        return view('acts.show', compact('act'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Act $act)
    {
        $chapters = Chapter::orderBy('order_number')->get();
        return view('acts.edit', compact('act', 'chapters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Act $act)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:255',
            'order_number' => 'required|integer|min:1',
        ]);

        $act->update($validated);

        return redirect()->route('acts.show', $act)
                        ->with('success', 'Act berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Act $act)
    {
        $act->delete();

        return redirect()->route('acts.index')
                        ->with('success', 'Act berhasil dihapus.');
    }
}
