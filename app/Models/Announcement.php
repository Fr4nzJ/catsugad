<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Automatically generate slug from title
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->title);
            }
            
            // Auto-generate excerpt if not provided
            if (!$model->excerpt && $model->content) {
                $model->excerpt = Str::limit(strip_tags($model->content), 150);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->title);
            }
            
            // Update excerpt if content changed
            if ($model->isDirty('content') && !$model->isDirty('excerpt')) {
                $model->excerpt = Str::limit(strip_tags($model->content), 150);
            }
        });
    }

    /**
     * Scope: Get only published announcements
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope: Get only drafts
     */
    public function scopeDrafts($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Latest first
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Get the route key for model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Check if announcement is published
     */
    public function isPublished()
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }
}
