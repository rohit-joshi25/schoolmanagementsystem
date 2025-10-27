<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicClass extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'branch_id', 'name'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function feeAllocations()
    {
        return $this->hasMany(FeeAllocation::class);
    }
}