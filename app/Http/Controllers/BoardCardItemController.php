<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardCardItem;
use Illuminate\Http\Request;

class BoardCardItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $board = Board::find($request->board_id);
        $boardCardItem = BoardCardItem::create([
            'name' => $request->name,
            'card_id' => $request->card_id,
        ]);

        return redirect()->route('boards.show', $board->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $board = Board::find($request->board_id);
        $boardCardItem = BoardCardItem::find($id);
        $boardCardItem->update($request->all());
        return redirect()->route('boards.show', $board->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $boardCardItem = BoardCardItem::find($id);
        $boardCardItem->delete();
        return redirect()->back();
    }
}
