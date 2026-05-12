<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PageBanner extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'page',
        'description',
        'is_active',
    ];

    /**
     * Get the image URL for use in templates
     */
    public function getImageUrl()
    {
        if (!$this->image_path) {
            return null;
        }

        // Extract filename from path
        $filename = basename($this->image_path);
        
        // Return URL via the banner.serve route
        return route('banner.serve', $filename);
    }
}