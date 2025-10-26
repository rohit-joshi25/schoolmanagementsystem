<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAppraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'teacher_id',
        'appraiser_id',
        'appraisal_date',
        'overall_comments',
    ];

    /**
     * Get the teacher who was reviewed.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the admin who did the review.
     */
    public function appraiser()
    {
        return $this->belongsTo(User::class, 'appraiser_id');
    }

    /**
     * Get all the individual ratings for this appraisal.
     */
    public function ratings()
    {
        return $this->hasMany(AppraisalRating::class);
    }
}