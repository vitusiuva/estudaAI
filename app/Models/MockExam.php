<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExam extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'title\', \'exam_type\', \'exam_board\', \'date\', \'duration_minutes\', \'total_score\'];

    protected $casts = [
        \'date\' => \'date\',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(MockExamResult::class);
    }
}
