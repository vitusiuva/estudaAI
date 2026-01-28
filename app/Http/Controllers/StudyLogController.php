<?php

namespace App\Http\Controllers;

use App\Models\StudyLog;
use App\Models\Topic;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudyLogController extends Controller
{
    public function index()
    {
        $logs = StudyLog::where(\'user_id\', Auth::id())
            ->with(\'topic.discipline\')
            ->orderBy(\'studied_at\', \'desc\')
            ->paginate(15);
            
        return view(\'study-logs.index\', compact(\'logs\'));
    }

    public function store(Request $request)
    {
        $request->validate([
            \'topic_id\' => \'required|exists:topics,id\',
            \'type\' => \'required|string\',
            \'duration_minutes\' => \'required|integer|min:1\',
            \'questions_correct\' => \'nullable|integer|min:0\',
            \'questions_total\' => \'nullable|integer|min:0\',
            \'pages_read\' => \'nullable|integer|min:0\',
            \'studied_at\' => \'nullable|date\',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        if ($topic->discipline->plan->user_id !== Auth::id()) abort(403);
        
        $studiedAt = $request->studied_at ? Carbon::parse($request->studied_at) : now();

        StudyLog::create([
            \'user_id\' => Auth::id(),
            \'topic_id\' => $request->topic_id,
            \'type\' => $request->type,
            \'duration_minutes\' => $request->duration_minutes,
            \'questions_correct\' => $request->questions_correct ?? 0,
            \'questions_total\' => $request->questions_total ?? 0,
            \'pages_read\' => $request->pages_read ?? 0,
            \'comments\' => $request->comments,
            \'studied_at\' => $studiedAt,
        ]);

        $topic->update([\'is_studied\' => true]);

        // Agendamento Automático de Revisões (1, 7, 15, 30, 60 dias)
        $intervals = [1, 7, 15, 30, 60];
        foreach ($intervals as $days) {
            Revision::updateOrCreate(
                [
                    \'user_id\' => Auth::id(),
                    \'topic_id\' => $topic->id,
                    \'interval_days\' => $days,
                    \'status\' => \'pendente\'
                ],
                [
                    \'scheduled_date\' => $studiedAt->copy()->addDays($days),
                ]
            );
        }

        return back()->with(\'success\', \'Estudo registrado e revisões (1, 7, 15, 30, 60 dias) agendadas!\');
    }
}
