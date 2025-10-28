<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'status',
        'logo_path',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    // ** ADD THESE NEW METHODS **
    public function subscriptions()
    {
        return $this->hasMany(SchoolSubscription::class);
    }

    public function currentSubscription()
    {
        // Get the latest active subscription for this school
        return $this->hasOne(SchoolSubscription::class)->where('status', 'active')->latest('id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function classes()
    {
        return $this->hasMany(AcademicClass::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function certificateTemplates()
    {
        return $this->hasMany(CertificateTemplate::class);
    }
    public function salaryGrades()
    {
        return $this->hasMany(SalaryGrade::class);
    }
    public function performanceCategories()
    {
        return $this->hasMany(PerformanceCategory::class);
    }

    public function teacherAppraisals()
    {
        return $this->hasMany(TeacherAppraisal::class);
    }
    public function feeGroups()
    {
        return $this->hasMany(FeeGroup::class);
    }
    public function feeTypes()
    {
        return $this->hasMany(FeeType::class);
    }
    public function feeAllocations()
    {
        return $this->hasMany(FeeAllocation::class);
    }
    public function feeAdjustments()
    {
        return $this->hasMany(FeeAdjustment::class);
    }
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
    public function incomeExpenseCategories()
    {
        return $this->hasMany(IncomeExpenseCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
