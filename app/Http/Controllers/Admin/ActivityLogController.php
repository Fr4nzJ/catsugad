<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(50);
        $actions = ['created', 'updated', 'deleted', 'viewed', 'logged_in', 'logged_out'];
        $modules = ActivityLog::distinct('module')->pluck('module')->sort();

        return view('admin.activity-logs.index', compact('logs', 'actions', 'modules'));
    }

    public function filter(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->filled('user_name')) {
            $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        $actions = ['created', 'updated', 'deleted', 'viewed', 'logged_in', 'logged_out'];
        $modules = ActivityLog::distinct('module')->pluck('module')->sort();

        return view('admin.activity-logs.index', compact('logs', 'actions', 'modules'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function export(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $csv = "User Name,Email,Action,Module,Item Name,Description,IP Address,Date/Time\n";

        foreach ($logs as $log) {
            $csv .= "\"{$log->user_name}\",\"{$log->user_email}\",\"{$log->action}\",\"{$log->module}\",";
            $csv .= "\"{$log->item_name}\",\"{$log->description}\",\"{$log->ip_address}\",\"{$log->created_at}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-logs-' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function clearOldLogs()
    {
        // Delete logs older than 90 days
        ActivityLog::where('created_at', '<', now()->subDays(90))->delete();

        return redirect()->route('admin.activity-logs.index')
                       ->with('success', 'Logs older than 90 days have been deleted.');
    }
}
