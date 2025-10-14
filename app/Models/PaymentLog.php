<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_gateway',
        'transaction_id',
        'status',
        'notes',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
