<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This is the "whitelist" for mass assignment.
     */
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone',
        'address',
        'status',
    ];

    /**
     * Get the school that owns the branch.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
