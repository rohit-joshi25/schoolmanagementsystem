<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'grade_system_id',
        'name',
        'start_date',
        'end_date',
        'is_published',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function gradeSystem()
    {
        return $this->belongsTo(GradeSystem::class);
    }
    public function marks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
