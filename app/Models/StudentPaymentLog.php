<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'user_id',
        'student_fee_id',
        'amount',
        'payment_method',
        'notes',
        'payment_date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }
}