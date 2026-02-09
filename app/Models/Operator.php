<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
        'name',
        'balance',
    ];

    /**
     * Operator bisa menerima banyak pembayaran
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
