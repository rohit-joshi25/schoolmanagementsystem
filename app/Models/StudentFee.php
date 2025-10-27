<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'user_id',
        'fee_allocation_id',
        'amount',
        'amount_paid',
        'status',
        'due_date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feeAllocation()
    {
        return $this->belongsTo(FeeAllocation::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPaymentLog::class);
    }
}