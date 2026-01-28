<?php

namespace App\Http\Controllers;

use App\Models\StudyLog;
use App\Models\Revision;
use App\Models\MockExam;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Estatísticas Gerais
        $totalMinutes = StudyLog::where(\'user_id\', $user->id)->sum(\'duration_minutes\');
        $totalHours = round($totalMinutes / 60, 1);
        
        $questionsCorrect = StudyLog::where(\'user_id\', $user->id)->sum(\'questions_correct\');
        $questionsTotal = StudyLog::where(\'user_id\', $user->id)->sum(\'questions_total\');
        $precision = $questionsTotal > 0 ? round(($questionsCorrect / $questionsTotal) * 100, 1) : 0;

        $pendingRevisionsCount = Revision::where(\'user_id\', $user->id)
            ->where(\'status\', \'pendente\')
            ->whereDate(\'scheduled_date\', \'<=\', $today)
            ->count();

        // Dados para o Gráfico de Horas (Últimos 7 dias)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $minutes = StudyLog::where(\'user_id\', $user->id)
                ->whereDate(\'studied_at\', $date)
                ->sum(\'duration_minutes\');
            
            $last7Days->push([
                \'day\' => $date->format(\'d/m\'),
                \'hours\' => round($minutes / 60, 1)
            ]);
        }

        // Atividades Recentes
        $recentLogs = StudyLog::where(\'user_id\', $user->id)
            ->with(\'topic.discipline\')
            ->orderBy(\'studied_at\', \'desc\')
            ->limit(5)
            ->get();

        // Próximas Revisões
        $upcomingRevisions = Revision::where(\'user_id\', $user->id)
            ->where(\'status\', \'pendente\')
            ->whereDate(\'scheduled_date\', \'>=\', $today)
            ->with(\'topic.discipline\')
            ->orderBy(\'scheduled_date\', \'asc\')
            ->limit(5)
            ->get();

        // Desempenho por Disciplina (Top 5)
        $disciplineStats = DB::table(\'study_logs\')
            ->join(\'topics\', \'study_logs.topic_id\', \'=\', \'topics.id\')
            ->join(\'disciplines\', \'topics.discipline_id\', \'=\', \'disciplines.id\')
            ->select(\'disciplines.name\', DB::raw(\'SUM(duration_minutes) as total_minutes\'))
            ->where(\'study_logs.user_id\', $user->id)
            ->groupBy(\'disciplines.id\', \'disciplines.name\')
            ->orderBy(\'total_minutes\', \'desc\')
            ->limit(5)
            ->get();

        return view(\'dashboard\', compact(
            \'totalHours\', 
            \'precision\', 
            \'pendingRevisionsCount\', 
            \'last7Days\', 
            \'recentLogs\', 
            \'upcomingRevisions\',
            \'disciplineStats\'
        ));
    }
}
