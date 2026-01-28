<?php

namespace App\Http\Controllers;

use App\Models\StudyLog;
use App\Models\Revision;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $today = Carbon::today();

        // 1. Estatísticas Gerais
        $totalMinutes = StudyLog::where('user_id', $user->id)->sum('duration_minutes');
        $totalHours = round($totalMinutes / 60, 1);

        // 2. Estatísticas de Desempenho (Acertos/Erros)
        
        $totalQuestions = StudyLog::where('user_id', $user->id)->sum('questions_total');
        $totalCorrect = StudyLog::where('user_id', $user->id)->sum('questions_correct');
        $precision = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 1) : 0;

        // 3. Horas Estudadas por Dia (Últimos 7 dias)
        $studyLogs = StudyLog::where('user_id', $user->id)
            ->where('created_at', '>=', $today->copy()->subDays(6))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(duration_minutes) as minutes')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $studyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $logForDate = $studyLogs->firstWhere('date', $date);
            $minutes = $logForDate ? $logForDate->minutes : 0;
            $studyData[] = [
                'day' => $today->copy()->subDays($i)->format('D'),
                'minutes' => $minutes,
                'hours' => round($minutes / 60, 1)
            ];
        }

        // 4. Revisões Pendentes
        $pendingRevisions = Revision::where('user_id', $user->id)
            ->where('scheduled_date', '<=', $today)
            ->whereNull('completed_at')
            ->with('topic.discipline')
            ->orderBy('scheduled_date', 'asc')
            ->get();

        // 5. Tópicos em Progresso
        $topicsInProgress = Topic::whereHas('discipline.plan', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'in_progress')
        ->with('discipline')
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard', [
            'totalHours' => $totalHours,
            'precision' => $precision,
            'pendingRevisionsCount' => $pendingRevisions->count(),
            'studyData' => $studyData,
            'pendingRevisions' => $pendingRevisions,
            'topicsInProgress' => $topicsInProgress,
        ]);
    }
}
