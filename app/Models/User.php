<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name', // Use full_name
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'school_id',
        'branch_id',
        'academic_class_id', // Foreign key
        'section_id',        // Foreign key
        'guardian_name',
        'guardian_relation',
        'guardian_phone',
        'guardian_email',
        'admission_no',
        'roll_number',
        'gender',
        'date_of_birth',
        'category',
        'religion',
        'caste',
        'mobile_number',
        'admission_date',
        'student_photo_path',
        'blood_group',
        'house',
        'height',
        'weight',
        'measurement_date',
        'medical_history',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the school that the user belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the branch that the user belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The subjects that the user (teacher) teaches.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    /**
     * The attendance records for the user (student).
     */
    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'user_id');
    }

    /**
     * Get the academic class that the user (student) belongs to.
     * THIS IS THE FIX.
     */
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    /**
     * Get the section that the user (student) belongs to.
     * THIS FIXES THE NEXT ERROR.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function leaveRequests() // As a student
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }
    public function teacherAttendances()
    {
        return $this->hasMany(TeacherAttendance::class, 'user_id');
    }
}