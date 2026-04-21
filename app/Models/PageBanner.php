<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'page',
        'description',
        'is_active',
    ];
}