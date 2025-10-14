<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * This array tells Laravel which fields are safe to be filled
     * when using the Invoice::create() method.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'plan_id',
        'school_subscription_id',
        'amount',
        'due_date',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
