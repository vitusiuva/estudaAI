<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'type',
        'duration_minutes',
        'questions_correct',
        'questions_total',
        'pages_read',
        'comments',
        'studied_at',
    ];

    protected $casts = [
        'studied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
