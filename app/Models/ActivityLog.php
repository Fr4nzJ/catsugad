<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'action',
        'module',
        'item_name',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user associated with this activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get action badge color
     */
    public function getActionBadgeColor()
    {
        return match($this->action) {
            'created' => 'is-success',
            'updated' => 'is-info',
            'deleted' => 'is-danger',
            'viewed' => 'is-light',
            'logged_in' => 'is-success',
            'logged_out' => 'is-warning',
            default => 'is-light',
        };
    }

    /**
     * Get action icon
     */
    public function getActionIcon()
    {
        return match($this->action) {
            'created' => 'fa-plus',
            'updated' => 'fa-edit',
            'deleted' => 'fa-trash',
            'viewed' => 'fa-eye',
            'logged_in' => 'fa-sign-in-alt',
            'logged_out' => 'fa-sign-out-alt',
            default => 'fa-info-circle',
        };
    }
}
