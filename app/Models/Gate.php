<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
    ];

    protected $casts = [
        'type' => \App\Enums\GateType::class,
    ];

    public function cameras()
    {
        return $this->hasMany(Camera::class);
    }
}
