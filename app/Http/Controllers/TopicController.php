<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'discipline_id' => 'required|exists:disciplines,id',
            'name' => 'required|string|max:255',
        ]);

        $discipline = Discipline::findOrFail($request->discipline_id);
        if ($discipline->plan->user_id !== Auth::id()) abort(403);

        Topic::create($request->all());

        return back()->with('success', 'Tópico adicionado!');
    }

    public function destroy(Topic $topic)
    {
        if ($topic->discipline->plan->user_id !== Auth::id()) abort(403);
        $topic->delete();
        return back()->with('success', 'Tópico removido!');
    }
}
