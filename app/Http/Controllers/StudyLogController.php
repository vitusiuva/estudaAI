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
        $logs = StudyLog::where('user_id', Auth::id())
            ->with('topic.discipline')
            ->orderBy('studied_at', 'desc')
            ->paginate(15);
            
        return view('study-logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'type' => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        
        StudyLog::create([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'type' => $request->type,
            'duration_minutes' => $request->duration_minutes,
            'questions_correct' => $request->questions_correct ?? 0,
            'questions_total' => $request->questions_total ?? 0,
            'comments' => $request->comments,
            'studied_at' => now(),
        ]);

        $topic->update(['is_studied' => true]);

        Revision::create([
            'topic_id' => $topic->id,
            'scheduled_date' => Carbon::today()->addDay(),
            'status' => 'pendente'
        ]);

        Revision::create([
            'topic_id' => $topic->id,
            'scheduled_date' => Carbon::today()->addDays(7),
            'status' => 'pendente'
        ]);

        return back()->with('success', 'Estudo registrado e revisões agendadas!');
    }
}
