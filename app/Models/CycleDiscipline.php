<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleDiscipline extends Model
{
    use HasFactory;

    protected $fillable = [\'study_cycle_id\', \'discipline_id\', \'order\', \'target_duration_minutes\'];

    public function studyCycle()
    {
        return $this->belongsTo(StudyCycle::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
