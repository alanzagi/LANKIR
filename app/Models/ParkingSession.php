<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSession extends Model
{
    protected $fillable = [
        'ticket_id',
        'tariff_id',
        'vehicle_type',
        'time_in',
        'time_out',
        'status',
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'status' => \App\Enums\ParkingStatus::class,
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
