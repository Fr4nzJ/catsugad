<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
