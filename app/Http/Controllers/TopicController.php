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
            'parent_id' => 'nullable|exists:topics,id',
        ]);

        $discipline = Discipline::findOrFail($request->discipline_id);
        if ($discipline->plan->user_id !== Auth::id()) abort(403);

        Topic::create($request->all());

        return back()->with('success', 'Tópico adicionado!');
    }

    public function toggleComplete(Topic $topic)
    {
        if ($topic->discipline->plan->user_id !== Auth::id()) abort(403);
        
        $topic->update([
            'is_completed' => !$topic->is_completed
        ]);

        return back()->with('success', 'Status do tópico atualizado!');
    }

    public function destroy(Topic $topic)
    {
        if ($topic->discipline->plan->user_id !== Auth::id()) abort(403);
        $topic->delete();
        return back()->with('success', 'Tópico removido!');
    }
}
