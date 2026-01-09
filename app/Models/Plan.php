<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'target_exam',
        'exam_date',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }
}
