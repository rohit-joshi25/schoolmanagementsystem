<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicClass extends Model
{
    use HasFactory;
    
    // Make sure your table name is correct, e.g., 'academic_classes'
    // protected $table = 'academic_classes'; 

    protected $fillable = ['school_id', 'branch_id', 'name', 'status'];


    /**
     * Get the branch that this class belongs to.
     * * THIS IS THE MISSING LINK.
     */
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

    /**
     * Get all students in this class.
     */
    public function students()
    {
        return $this->hasMany(User::class, 'academic_class_id')->where('role', 'student');
    }
}
