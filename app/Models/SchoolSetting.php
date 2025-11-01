<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'key',
        'value',
    ];

    // Automatically encrypt the value when saving
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Crypt::encryptString($value);
    }

    // Automatically decrypt the value when retrieving
    public function getValueAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return $value; // Return original value if decryption fails
        }
    }
}