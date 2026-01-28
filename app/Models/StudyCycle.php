<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyCycle extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'name\', \'is_active\', \'total_duration_minutes\'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cycleDisciplines()
    {
        return $this->hasMany(CycleDiscipline::class);
    }
}
