<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GfpsMember extends Model
{
    protected $fillable = [
        'section',
        'sort_order',
        'gfps_position',
        'gfps_role',
        'name',
        'designation',
        'remarks',
        'is_vacant',
    ];

    protected $casts = [
        'is_vacant' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: Get vacant positions
     */
    public function scopeVacant($query)
    {
        return $query->where('is_vacant', true);
    }

    /**
     * Scope: Get members by section
     */
    public function scopeInSection($query, $section)
    {
        return $query->where('section', $section)->orderBy('sort_order');
    }

    /**
     * Helper: Get display name (shows "— Vacant —" if no name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?? '— Vacant —';
    }

    /**
     * Get list of available sections
     */
    public static function getSections()
    {
        return [
            'Top Level' => 'Top Level',
            'Members Level' => 'Members Level',
            'Technical Working Group' => 'Technical Working Group',
            'Deans / Campus Level' => 'Deans / Campus Level',
            'Directors / Other Members' => 'Directors / Other Members',
        ];
    }

    /**
     * Get list of available roles
     */
    public static function getRoles()
    {
        return [
            'Head of Agency' => 'Head of Agency',
            'Chair' => 'Chair',
            'Member' => 'Member',
            'Focal Person' => 'Focal Person',
        ];
    }
}
