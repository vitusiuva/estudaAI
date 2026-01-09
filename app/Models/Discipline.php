<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'total_topics',
        'completed_topics',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
