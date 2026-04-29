<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    /**
     * Log an activity
     */
    public static function log(
        string $action,
        string $module,
        string $itemName = null,
        string $description = null,
        $oldValues = null,
        $newValues = null
    ) {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'action' => $action,
            'module' => $module,
            'item_name' => $itemName,
            'description' => $description,
            'old_values' => is_array($oldValues) ? json_encode($oldValues) : $oldValues,
            'new_values' => is_array($newValues) ? json_encode($newValues) : $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log login activity
     */
    public static function logLogin(string $email)
    {
        ActivityLog::create([
            'user_email' => $email,
            'action' => 'logged_in',
            'module' => 'auth',
            'description' => 'User logged in to admin dashboard',
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log logout activity
     */
    public static function logLogout()
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'action' => 'logged_out',
            'module' => 'auth',
            'description' => 'User logged out from admin dashboard',
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
