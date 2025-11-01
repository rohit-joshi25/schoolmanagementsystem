<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Section extends Model
{
    use HasFactory;

    protected $fillable = ['academic_class_id', 'name'];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
    public function timetableEntries() {
        return $this->hasMany(Timetable::class);
    }
    public function students()
    {
        return $this->hasMany(User::class, 'section_id')->where('role', 'student');
    }

    /**
     * Get the class that this section belongs to.
     */
    public function school_class()
    {
        return $this->belongsTo(AcademicClass::class, 'academic_class_id');
    }
    public function branch()
    {
        // This assumes your 'academic_classes' table has a 'branch_id' column
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get all sections for this class.
     */
    public function sections()
    {
        return $this->hasMany(Section::class, 'academic_class_id');
    }

}