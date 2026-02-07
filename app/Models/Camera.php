<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = [
        'gate_id',
        'type',
        'endpoint_key',
    ];

    public function gate()
    {
        return $this->belongsTo(Gate::class);
    }
}
