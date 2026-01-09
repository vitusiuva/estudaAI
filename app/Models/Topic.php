<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_id',
        'name',
        'is_studied',
        'is_revised_1x',
        'is_revised_2x',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function studyLogs()
    {
        return $this->hasMany(StudyLog::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
}
