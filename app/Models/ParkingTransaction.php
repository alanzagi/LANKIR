<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class ParkingTransaction extends Model
{
    const STATUS_PARKED = 'parked';
    const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'vehicle_id',
        'entered_at',
        'exited_at',
        'fee',
        'status',
    ];

    protected $casts = [
        'entered_at' => 'datetime',
        'exited_at'  => 'datetime',
    ];

    /**
     * Setiap transaksi parkir milik satu kendaraan
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Satu transaksi punya satu pembayaran
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Helper: hitung durasi parkir (menit)
     */
    public function durationInMinutes(): int
    {
        $end = $this->exited_at ?? now();
        return $this->entered_at->diffInMinutes($end);
    }
}
