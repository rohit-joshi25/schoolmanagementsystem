<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'income_expense_category_id',
        'type',
        'title',
        'amount',
        'transaction_date',
        'description',
        'file_path',
    ];

    public function category()
    {
        return $this->belongsTo(IncomeExpenseCategory::class, 'income_expense_category_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
