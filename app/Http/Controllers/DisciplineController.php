<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplineController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'name' => 'required|string|max:255',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        if ($plan->user_id !== Auth::id()) abort(403);

        Discipline::create($request->all());

        return back()->with('success', 'Disciplina adicionada!');
    }

    public function show(Discipline $discipline)
    {
        if ($discipline->plan->user_id !== Auth::id()) abort(403);
        
        $discipline->load('topics');
        return view('disciplines.show', compact('discipline'));
    }

    public function destroy(Discipline $discipline)
    {
        if ($discipline->plan->user_id !== Auth::id()) abort(403);
        $discipline->delete();
        return back()->with('success', 'Disciplina removida!');
    }
}
