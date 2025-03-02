<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'stripe_payment_id',
        'amount',
        'status'
    ];

    public  function order(): BelongsTo
    {
        return  $this->belongsTo(Order::class);
    }
}
