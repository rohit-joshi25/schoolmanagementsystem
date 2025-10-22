<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'academic_class_id',
        'section_id',
        'user_id',
        'attendance_date',
        'status',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}