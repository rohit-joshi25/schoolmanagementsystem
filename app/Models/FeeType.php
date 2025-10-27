<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'fee_group_id',
        'name',
        'fee_code',
        'description',
    ];

    public function feeGroup()
    {
        return $this->belongsTo(FeeGroup::class);
    }
}