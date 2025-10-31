<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_system_id',
        'grade_name',
        'mark_from',
        'mark_to',
        'comments',
    ];

    public function gradeSystem()
    {
        return $this->belongsTo(GradeSystem::class);
    }
}
