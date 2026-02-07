<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name',
        'vehicle_type',
        'pricing_type',
        'first_hour_price',
        'next_hour_price',
        'flat_price',
        'grace_period_minutes',
        'is_active',
    ];

    protected $casts = [
        'first_hour_price'     => 'integer',
        'next_hour_price'      => 'integer',
        'flat_price'           => 'integer',
        'grace_period_minutes' => 'integer',
        'is_active'            => 'boolean',
    ];

    public function parkingSessions()
    {
        return $this->hasMany(ParkingSession::class);
    }
}
