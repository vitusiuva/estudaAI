<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use App\Models\MockExamResult;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockExamController extends Controller
{
    public function index()
    {
        $mockExams = MockExam::where(\'user_id\', Auth::id())->with(\'results.discipline\')->orderBy(\'date\', \'desc\')->get();
        $disciplines = Discipline::whereHas(\'plan\', function($q) {
            $q->where(\'user_id\', Auth::id());
        })->get();
        
        return view(\'mock-exams.index\', compact(\'mockExams\', \'disciplines\'));
    }

    public function store(Request $request)
    {
        $request->validate([
            \'title\' => \'required|string|max:255\',
            \'date\' => \'required|date\',
            \'exam_type\' => \'nullable|string\',
            \'exam_board\' => \'nullable|string\',
        ]);

        $mockExam = MockExam::create([
            \'user_id\' => Auth::id(),
            \'title\' => $request->title,
            \'date\' => $request->date,
            \'exam_type\' => $request->exam_type,
            \'exam_board\' => $request->exam_board,
        ]);

        return redirect()->route(\'mock-exams.show\', $mockExam)->with(\'success\', \'Simulado criado! Agora adicione os resultados por disciplina.\');
    }

    public function show(MockExam $mockExam)
    {
        if ($mockExam->user_id !== Auth::id()) abort(403);
        
        $mockExam->load(\'results.discipline\');
        $disciplines = Discipline::whereHas(\'plan\', function($q) {
            $q->where(\'user_id\', Auth::id());
        })->get();

        return view(\'mock-exams.show\', compact(\'mockExam\', \'disciplines\'));
    }

    public function addResult(Request $request, MockExam $mockExam)
    {
        if ($mockExam->user_id !== Auth::id()) abort(403);

        $request->validate([
            \'discipline_id\' => \'required|exists:disciplines,id\',
            \'weight\' => \'required|integer|min:1\',
            \'total_questions\' => \'required|integer|min:1\',
            \'correct_answers\' => \'required|integer|min:0|max:\'.$request->total_questions,
            \'wrong_answers\' => \'required|integer|min:0|max:\'.$request->total_questions,
        ]);

        MockExamResult::create([
            \'mock_exam_id\' => $mockExam->id,
            \'discipline_id\' => $request->discipline_id,
            \'weight\' => $request->weight,
            \'total_questions\' => $request->total_questions,
            \'correct_answers\' => $request->correct_answers,
            \'wrong_answers\' => $request->wrong_answers,
        ]);

        $this->updateTotalScore($mockExam);

        return back()->with(\'success\', \'Resultado da disciplina adicionado!\');
    }

    private function updateTotalScore(MockExam $mockExam)
    {
        $total = $mockExam->results->sum(function($result) {
            return ($result->correct_answers * $result->weight);
        });
        $mockExam->update([\'total_score\' => $total]);
    }

    public function destroy(MockExam $mockExam)
    {
        if ($mockExam->user_id !== Auth::id()) abort(403);
        $mockExam->delete();
        return redirect()->route(\'mock-exams.index\')->with(\'success\', \'Simulado removido!\');
    }
}
