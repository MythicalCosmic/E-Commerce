<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    protected $table = 'payments';

    use SoftDeletes;

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
