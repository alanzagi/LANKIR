<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'code',
        'qr_path',
        'issued_at',
        'expired_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function parkingSession()
    {
        return $this->hasOne(ParkingSession::class);
    }
}
