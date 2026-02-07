<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'parking_session_id',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'status' => \App\Enums\PaymentStatus::class,
    ];

    public function parkingSession()
    {
        return $this->belongsTo(ParkingSession::class);
    }
}
