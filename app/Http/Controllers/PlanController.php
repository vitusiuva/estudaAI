<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('user_id', Auth::id())->withCount('disciplines')->get();
        return view('plans.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_exam' => 'nullable|string|max:255',
            'exam_date' => 'nullable|date',
        ]);

        Plan::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'target_exam' => $request->target_exam,
            'exam_date' => $request->exam_date,
        ]);

        return redirect()->route('plans.index')->with('success', 'Plano criado com sucesso!');
    }

    public function show(Plan $plan)
    {
        if ($plan->user_id !== Auth::id()) abort(403);
        
        $plan->load('disciplines.topics');
        return view('plans.show', compact('plan'));
    }

    public function destroy(Plan $plan)
    {
        if ($plan->user_id !== Auth::id()) abort(403);
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plano excluído!');
    }
}
