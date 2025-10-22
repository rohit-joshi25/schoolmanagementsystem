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
}
