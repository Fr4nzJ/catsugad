# Admin Activity Logging - Command Reference

Quick reference for all commands and code snippets.

---

## 🚀 Setup Commands

### Run Migration
```bash
php artisan migrate
```

### Verify Migration
```bash
php artisan migrate:status
```

### Clear Cache (if needed)
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 🧪 Testing Commands

### Check Migration Table
```bash
php artisan tinker
>>> DB::table('activity_logs')->get();
```

### Count Log Entries
```bash
php artisan tinker
>>> App\Models\ActivityLog::count();
```

### Get Latest Logs
```bash
php artisan tinker
>>> App\Models\ActivityLog::latest()->take(10)->get();
```

### Get Logs by User
```bash
php artisan tinker
>>> App\Models\ActivityLog::where('user_name', 'John Doe')->get();
```

### Check Routes
```bash
php artisan route:list | grep activity-logs
```

---

## 📝 Logging Code Snippets

### Log Any Activity
```php
use App\Helpers\LogActivity;

LogActivity::log(
    'created',                          // action
    'statistics',                       // module
    'Gender Distribution',              // itemName
    'Created new statistic',            // description
    null,                               // oldValues
    json_encode($model->getAttributes()) // newValues
);
```

### Log Login
```php
use App\Helpers\LogActivity;

LogActivity::logLogin('admin@example.com');
```

### Log Logout
```php
use App\Helpers\LogActivity;

LogActivity::logLogout();
```

---

## 🎯 Controller Integration Snippets

### Use the Trait
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Traits\LogsActivityTrait;

class StatisticsController extends Controller
{
    use LogsActivityTrait;
```

### Log Create
```php
public function store(Request $request)
{
    $statistic = Statistic::create($validated);
    $this->logCreate($statistic, $statistic->label);
    return redirect()->route('admin.statistics.index');
}
```

### Log Update
```php
public function update(Request $request, Statistic $statistic)
{
    $oldValues = $statistic->getAttributes();
    $statistic->update($validated);
    $this->logUpdate($statistic, $oldValues, $statistic->label);
    return redirect()->route('admin.statistics.index');
}
```

### Log Delete
```php
public function destroy(Statistic $statistic)
{
    $this->logDelete($statistic, $statistic->label);
    $statistic->delete();
    return redirect()->route('admin.statistics.index');
}
```

---

## 🔍 Query Reference

### Get All Logs (Recent First)
```php
$logs = ActivityLog::latest()->paginate(50);
```

### Filter by User
```php
$logs = ActivityLog::where('user_name', 'John Doe')->get();
```

### Filter by Action
```php
$logs = ActivityLog::where('action', 'created')->get();
```

### Filter by Module
```php
$logs = ActivityLog::where('module', 'statistics')->get();
```

### Filter by Date Range
```php
$logs = ActivityLog::whereBetween('created_at', [
    '2024-01-01',
    '2024-01-31'
])->get();
```

### Combine Filters
```php
$logs = ActivityLog::where('user_name', 'John Doe')
    ->where('action', 'created')
    ->where('module', 'statistics')
    ->latest()
    ->get();
```

### Count by Action
```php
$counts = ActivityLog::groupBy('action')->count();
```

### Get Logs Older Than 90 Days
```php
$old_logs = ActivityLog::where('created_at', '<', now()->subDays(90))->get();
```

### Delete Logs Older Than 90 Days
```php
ActivityLog::where('created_at', '<', now()->subDays(90))->delete();
```

---

## 📊 Blade Template Snippets

### Display Activity List
```blade
@foreach($logs as $log)
    <tr>
        <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
        <td>{{ $log->user_name }}</td>
        <td>
            <span class="tag {{ $log->getActionBadgeColor() }}">
                {{ ucfirst($log->action) }}
            </span>
        </td>
        <td>{{ ucfirst($log->module) }}</td>
        <td>{{ $log->item_name }}</td>
    </tr>
@endforeach
```

### Display Activity Details
```blade
<h2>{{ $activityLog->item_name }}</h2>
<p>Action: {{ $activityLog->action }}</p>
<p>User: {{ $activityLog->user_name }}</p>
<p>Date: {{ $activityLog->created_at->format('F d, Y H:i:s') }}</p>

@if($activityLog->old_values)
    <h3>Previous Values</h3>
    <pre>{{ json_encode(json_decode($activityLog->old_values), JSON_PRETTY_PRINT) }}</pre>
@endif

@if($activityLog->new_values)
    <h3>New Values</h3>
    <pre>{{ json_encode(json_decode($activityLog->new_values), JSON_PRETTY_PRINT) }}</pre>
@endif
```

### Filter Form
```blade
<form method="GET" action="{{ route('admin.activity-logs.filter') }}">
    <input type="text" name="user_name" placeholder="Admin name">
    <select name="action">
        <option value="">-- All Actions --</option>
        <option value="created">Created</option>
        <option value="updated">Updated</option>
        <option value="deleted">Deleted</option>
    </select>
    <input type="date" name="date_from">
    <input type="date" name="date_to">
    <button type="submit">Filter</button>
</form>
```

---

## 🛠️ Helper Class Usage

### Access LogActivity Helper
```php
use App\Helpers\LogActivity;

// Static method calls
LogActivity::log($action, $module, $itemName, $description, $oldValues, $newValues);
LogActivity::logLogin('email@example.com');
LogActivity::logLogout();
```

### Available Methods
```php
LogActivity::log($action, $module, $itemName, $description, $oldValues, $newValues);
LogActivity::logLogin($email);
LogActivity::logLogout();
```

---

## 📱 Route Reference

| Method | Route | Name | Purpose |
|--------|-------|------|---------|
| GET | `/admin/activity-logs` | `admin.activity-logs.index` | View all logs |
| GET | `/admin/activity-logs/filter` | `admin.activity-logs.filter` | Filter logs |
| GET | `/admin/activity-logs/{id}` | `admin.activity-logs.show` | View detail |
| POST | `/admin/activity-logs/export` | `admin.activity-logs.export` | Export CSV |
| POST | `/admin/activity-logs/clear` | `admin.activity-logs.clear` | Clear old logs |

---

## 🔗 URL Reference

| Action | URL |
|--------|-----|
| View logs | `/admin/activity-logs` |
| View detail | `/admin/activity-logs/1` |
| Filter | `/admin/activity-logs/filter?user_name=John&action=created` |

---

## 🎨 HTML/Blade Links

### Link to Activity Logs
```blade
<a href="{{ route('admin.activity-logs.index') }}">Activity Logs</a>
```

### Link to Activity Detail
```blade
<a href="{{ route('admin.activity-logs.show', $log->id) }}">View</a>
```

### Button for Export
```blade
<form method="POST" action="{{ route('admin.activity-logs.export') }}">
    @csrf
    <button type="submit">Export CSV</button>
</form>
```

### Button for Clear
```blade
<form method="POST" action="{{ route('admin.activity-logs.clear') }}">
    @csrf
    <button type="submit" onclick="return confirm('Clear old logs?')">
        Clear Old Logs
    </button>
</form>
```

---

## 🧹 Maintenance Commands

### Delete Old Logs (Manual)
```bash
php artisan tinker
>>> App\Models\ActivityLog::where('created_at', '<', now()->subDays(90))->delete();
```

### Export All Logs
```bash
php artisan tinker
>>> App\Models\ActivityLog::all()->download('activity-logs.csv');
```

### Reset Activity Logs (Use with Caution!)
```bash
php artisan tinker
>>> DB::table('activity_logs')->truncate();
```

---

## 🔐 Security Commands

### Find Suspicious Activity
```bash
php artisan tinker
>>> App\Models\ActivityLog::where('action', 'deleted')->get();
```

### List All Admin Access
```bash
php artisan tinker
>>> App\Models\ActivityLog::where('action', 'logged_in')->get();
```

### Export by User
```bash
php artisan tinker
>>> App\Models\ActivityLog::where('user_name', 'John Doe')->get();
```

---

## 📊 CSV Export Snippet

### Export Method in Controller
```php
public function export(Request $request)
{
    $query = ActivityLog::query();

    if ($request->user_name) {
        $query->where('user_name', 'like', '%' . $request->user_name . '%');
    }
    if ($request->action) {
        $query->where('action', $request->action);
    }
    if ($request->module) {
        $query->where('module', $request->module);
    }
    if ($request->date_from) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->date_to) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $logs = $query->latest()->get();

    $headers = [
        'User Name',
        'Email',
        'Action',
        'Module',
        'Item',
        'Description',
        'IP Address',
        'Date',
    ];

    $data = $logs->map(function($log) {
        return [
            $log->user_name,
            $log->user_email,
            $log->action,
            $log->module,
            $log->item_name,
            $log->description,
            $log->ip_address,
            $log->created_at,
        ];
    });

    return response()->streamDownload(function() use ($headers, $data) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $headers);
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }, 'activity-logs-' . date('Y-m-d') . '.csv');
}
```

---

## 🧪 Testing with Tinker

```bash
# Start Tinker
php artisan tinker

# Test 1: Create activity
>>> App\Models\ActivityLog::create([
    'user_name' => 'Test Admin',
    'user_email' => 'test@example.com',
    'action' => 'created',
    'module' => 'statistics',
    'item_name' => 'Test Item',
    'description' => 'Testing activity logging',
    'ip_address' => '127.0.0.1'
]);

# Test 2: Get all logs
>>> App\Models\ActivityLog::all();

# Test 3: Count logs
>>> App\Models\ActivityLog::count();

# Test 4: Get latest 5
>>> App\Models\ActivityLog::latest()->take(5)->get();

# Test 5: Delete test data
>>> App\Models\ActivityLog::where('item_name', 'Test Item')->delete();

# Exit
>>> exit
```

---

## 📦 All Available Helpers

### In LogActivity.php
```php
LogActivity::log(
    string $action,
    string $module,
    string $itemName,
    string $description,
    ?array $oldValues = null,
    ?array $newValues = null
): void

LogActivity::logLogin(string $email): void

LogActivity::logLogout(): void
```

### In LogsActivityTrait.php
```php
$this->logCreate(Model $model, string $itemName): void

$this->logUpdate(Model $model, array $oldValues, string $itemName): void

$this->logDelete(Model $model, string $itemName): void

$this->logView(Model $model, string $itemName = ''): void

$this->getModuleName(string $modelName): string
```

---

## 🎯 Common Tasks

### Task 1: Get logs from last 7 days
```php
$logs = ActivityLog::where('created_at', '>=', now()->subDays(7))->get();
```

### Task 2: Find all deletes by user
```php
$logs = ActivityLog::where('user_name', 'John')
    ->where('action', 'deleted')
    ->get();
```

### Task 3: Count creates per module
```php
$counts = ActivityLog::where('action', 'created')
    ->groupBy('module')
    ->selectRaw('module, count(*) as total')
    ->get();
```

### Task 4: Find unusual times
```php
$logs = ActivityLog::where('created_at', 'like', '% 02:%')
    ->orWhere('created_at', 'like', '% 03:%')
    ->get();
```

### Task 5: Export with filters
```php
// See ACTIVITY_LOGGING_SYSTEM.md → export() method
```

---

**Last Updated**: April 29, 2026  
**Version**: 1.0
