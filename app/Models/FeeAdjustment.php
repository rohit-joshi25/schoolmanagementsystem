<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'type',
        'amount',
        'is_percentage',
    ];
}