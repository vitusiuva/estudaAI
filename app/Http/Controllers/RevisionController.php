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
        $user = Auth::user();
        
        $revisions = Revision::whereHas(\'topic.discipline.plan\', function($query) use ($user) {
            $query->where(\'user_id\', $user->id);
        })
        ->with(\'topic.discipline\')
        ->orderBy(\'scheduled_date\', \'asc\')
        ->get();

        return view(\'revisions.index\', compact(\'revisions\'));
    }

    public function update(Request $request, Revision $revision)
    {
        if ($revision->topic->discipline->plan->user_id !== Auth::id()) abort(403);
        
        $revision->update([\'status\' => \'concluida\']);
        
        // Se for a primeira revisão (24h), marca o tópico como revisado 1x
        if ($revision->topic->revisions()->where(\'status\', \'concluida\')->count() == 1) {
            $revision->topic->update([\'is_revised_1x\' => true]);
        } else {
            $revision->topic->update([\'is_revised_2x\' => true]);
        }

        return back()->with(\'success\', \'Revisão concluída!\');
    }
}
