<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryFine extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'user_id',
        'book_issue_id',
        'days_overdue',
        'fine_rate',
        'total_amount',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookIssue()
    {
        return $this->belongsTo(BookIssue::class);
    }
}
