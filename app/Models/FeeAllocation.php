<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'academic_class_id',
        'fee_type_id',
        'amount',
        'due_date',
    ];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}