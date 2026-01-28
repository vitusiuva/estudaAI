<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('user_id', Auth::id())->with('plan')->get();
        $plans = Plan::where('user_id', Auth::id())->get();
        
        return view('schedules.index', compact('schedules', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'day_of_week' => 'required|integer|between:0,6', // 0=Sunday, 6=Saturday
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        if ($plan->user_id !== Auth::id()) abort(403);

        Schedule::create([
            'user_id' => Auth::id(),
            'plan_id' => $request->plan_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Horário de estudo agendado!');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->user_id !== Auth::id()) abort(403);
        $schedule->delete();
        return back()->with('success', 'Horário removido!');
    }
}
