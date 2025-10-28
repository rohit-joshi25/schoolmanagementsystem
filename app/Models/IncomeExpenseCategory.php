<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'type',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
