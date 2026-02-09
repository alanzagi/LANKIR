<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate_number',
        'type',
        'driver_name',
    ];

    /**
     * 1 kendaraan bisa punya banyak transaksi parkir
     */
    public function parkingTransactions()
    {
        return $this->hasMany(ParkingTransaction::class);
    }

    /**
     * Helper: cek apakah kendaraan sedang parkir
     */
    public function activeParking()
    {
        return $this->hasOne(ParkingTransaction::class)
            ->where('status', 'parked');
    }
}
