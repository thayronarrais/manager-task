<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::where('user_id', auth()->id())->get();

        return Inertia::render('Dashboard', [
            'boards' => $boards,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
        ]);

        return redirect()->route('boards.index');
    }


    public function show($slug)
    {
        $board = Board::where('slug', $slug)->where('user_id', auth()->id())->firstOrFail();
        // dd($board);
        return Inertia::render('Boards/Index', [
            'board' => $board,
        ]);
    }
}
