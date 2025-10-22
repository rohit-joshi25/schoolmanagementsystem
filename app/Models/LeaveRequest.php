<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'section_id',
        'start_date',
        'end_date',
        'reason',
        'attachment_path',
        'status',
        'action_by_user_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'action_by_user_id');
    }
}