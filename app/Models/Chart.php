<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\SafeJsonArray;

class Chart extends Model
{
    protected $fillable = [
        'name',
        'type',
        'labels',
        'data',
        'is_active',
        'order',
    ];

    protected $casts = [
        'labels' => SafeJsonArray::class,
        'data' => SafeJsonArray::class,
        'is_active' => 'boolean',
    ];
}

