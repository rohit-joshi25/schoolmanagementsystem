<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'type',
    ];
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher');
    }
    public function timetableEntries() {
        return $this->hasMany(Timetable::class);
    }
    public function syllabi()
    {
        return $this->hasMany(Syllabus::class);
    }
}