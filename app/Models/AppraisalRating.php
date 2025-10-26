<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_appraisal_id',
        'performance_category_id',
        'rating',
        'comments',
    ];

    public function appraisal()
    {
        return $this->belongsTo(TeacherAppraisal::class);
    }

    public function category()
    {
        return $this->belongsTo(PerformanceCategory::class, 'performance_category_id');
    }
}