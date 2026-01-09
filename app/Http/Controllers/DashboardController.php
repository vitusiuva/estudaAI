<?php

namespace App\Http\Controllers;

use App\Models\StudyLog;
use App\Models\Plan;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalStudyTime = StudyLog::where('user_id', $user->id)->sum('duration_minutes');
        $totalQuestions = StudyLog::where('user_id', $user->id)->sum('questions_total');
        $correctQuestions = StudyLog::where('user_id', $user->id)->sum('questions_correct');
        
        $accuracy = $totalQuestions > 0 ? round(($correctQuestions / $totalQuestions) * 100, 2) : 0;

        $plans = Plan::where('user_id', $user->id)->withCount('disciplines')->get();

        $pendingRevisions = Revision::whereHas('topic.discipline.plan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pendente')
          ->whereDate('scheduled_date', '<=', Carbon::today())
          ->with('topic.discipline')
          ->get();

        $recentLogs = StudyLog::where('user_id', $user->id)
            ->with('topic.discipline')
            ->orderBy('studied_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudyTime', 
            'totalQuestions', 
            'accuracy', 
            'plans', 
            'pendingRevisions', 
            'recentLogs'
        ));
    }
}
