<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'user_id',
        'attendance_date',
        'status',
        'notes',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}