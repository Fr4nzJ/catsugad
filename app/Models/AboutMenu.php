<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMenu extends Model
{
    protected $table = 'about_menus';

    protected $fillable = [
        'title',
        'route',
        'icon',
        'content',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
