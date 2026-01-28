<?php

namespace App\Http\Controllers;

use App\Models\StudyCycle;
use App\Models\CycleDiscipline;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyCycleController extends Controller
{
    public function index()
    {
        $cycles = StudyCycle::where(\'user_id\', Auth::id())->with(\'cycleDisciplines.discipline\')->get();
        $disciplines = Discipline::whereHas(\'plan\', function($q) {
            $q->where(\'user_id\', Auth::id());
        })->get();
        
        return view(\'cycles.index\', compact(\'cycles\', \'disciplines\'));
    }

    public function store(Request $request)
    {
        $request->validate([
            \'name\' => \'required|string|max:255\',
        ]);

        StudyCycle::create([
            \'user_id\' => Auth::id(),
            \'name\' => $request->name,
            \'is_active\' => false,
        ]);

        return back()->with(\'success\', \'Ciclo criado com sucesso!\');
    }

    public function addDiscipline(Request $request, StudyCycle $cycle)
    {
        if ($cycle->user_id !== Auth::id()) abort(403);

        $request->validate([
            \'discipline_id\' => \'required|exists:disciplines,id\',
            \'target_duration_minutes\' => \'required|integer|min:1\',
        ]);

        $order = $cycle->cycleDisciplines()->count() + 1;

        CycleDiscipline::create([
            \'study_cycle_id\' => $cycle->id,
            \'discipline_id\' => $request->discipline_id,
            \'target_duration_minutes\' => $request->target_duration_minutes,
            \'order\' => $order,
        ]);

        return back()->with(\'success\', \'Disciplina adicionada ao ciclo!\');
    }

    public function toggleActive(StudyCycle $cycle)
    {
        if ($cycle->user_id !== Auth::id()) abort(403);

        // Desativar outros ciclos
        StudyCycle::where(\'user_id\', Auth::id())->update([\'is_active\' => false]);
        
        $cycle->update([\'is_active\' => !$cycle->is_active]);

        return back()->with(\'success\', \'Status do ciclo atualizado!\');
    }

    public function destroy(StudyCycle $cycle)
    {
        if ($cycle->user_id !== Auth::id()) abort(403);
        $cycle->delete();
        return back()->with(\'success\', \'Ciclo removido!\');
    }
}
