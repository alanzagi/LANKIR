<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'parking_transaction_id',
        'operator_id',
        'amount',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function parkingTransaction()
    {
        return $this->belongsTo(ParkingTransaction::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}
