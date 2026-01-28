<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RevisionController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $revisionsToday = Revision::where('user_id', Auth::id())
            ->where('status', 'pendente')
            ->whereDate('scheduled_date', $today)
            ->with('topic.discipline')
            ->get();

        $revisionsOverdue = Revision::where('user_id', Auth::id())
            ->where('status', 'pendente')
            ->whereDate('scheduled_date', '<', $today)
            ->with('topic.discipline')
            ->get();

        $revisionsCompleted = Revision::where('user_id', Auth::id())
            ->where('status', 'concluida')
            ->with('topic.discipline')
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();

        return view('revisions.index', compact('revisionsToday', 'revisionsOverdue', 'revisionsCompleted'));
    }

    public function update(Request $request, Revision $revision)
    {
        if ($revision->user_id !== Auth::id()) abort(403);
        
        $revision->update(['status' => 'concluida']);
        
        // Atualizar contagem de revisões no tópico
        $completedCount = Revision::where('topic_id', $revision->topic_id)
            ->where('status', 'concluida')
            ->count();

        if ($completedCount >= 1) {
            $revision->topic->update(['is_revised_1x' => true]);
        }
        if ($completedCount >= 2) {
            $revision->topic->update(['is_revised_2x' => true]);
        }

        return back()->with('success', 'Revisão concluída!');
    }
}
