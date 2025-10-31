<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'description',
    ];

    public function gradeDetails()
    {
        return $this->hasMany(GradeDetail::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
