<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapMarker extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'description',
        'page',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'is_active' => 'boolean',
    ];
}
