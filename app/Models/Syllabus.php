<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    // Use 'syllabi' as the table name explicitly if needed, though Laravel usually guesses correctly
    // protected $table = 'syllabi'; 

    protected $fillable = [
        'school_id',
        'subject_id',
        // 'academic_class_id', // Add if you included this in the migration
        'title',
        'description',
        'file_path',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Optional: Add relationship if you linked to academic_classes
    // public function academicClass()
    // {
    //     return $this->belongsTo(AcademicClass::class);
    // }
}