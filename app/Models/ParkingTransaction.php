<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class ParkingTransaction extends Model
{
    const STATUS_PARKED = 'parked';
    const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'plate_number',
        'vehicle_type_id',
        'check_in_at',
        'check_out_at',
        'duration_minutes',
        'total_fee',
        'status',
        'void_reason',
        'voided_by',
        'voided_at',
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

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
