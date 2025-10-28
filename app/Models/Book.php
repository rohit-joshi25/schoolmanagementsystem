<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'branch_id',
        'title',
        'author',
        'publisher',
        'isbn',
        'book_code',
        'quantity',
        'available_quantity',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}
