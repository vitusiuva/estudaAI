<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamResult extends Model
{
    use HasFactory;

    protected $fillable = [\'mock_exam_id\', \'discipline_id\', \'weight\', \'total_questions\', \'correct_answers\', \'wrong_answers\'];

    public function mockExam()
    {
        return $this->belongsTo(MockExam::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
