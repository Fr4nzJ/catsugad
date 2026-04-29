# Admin Activity Logging System - Documentation

**Implemented**: April 29, 2026  
**Version**: 1.0  
**Status**: ✅ Ready for Use

---

## 📋 Overview

A comprehensive **Admin Activity Logging System** that records all administrator actions on the CatSU GAD Admin Dashboard. This system provides complete audit trails for security, compliance, and accountability purposes.

---

## ✨ Features

### Activity Tracking
- ✅ **Login/Logout** - Track admin sign-in and sign-out times
- ✅ **Create** - Record creation of new items
- ✅ **Update** - Log modifications with before/after values
- ✅ **Delete** - Track deletion of items with full records
- ✅ **View** - Optional viewing of sensitive data
- ✅ **Date/Time** - Precise timestamp for each action
- ✅ **IP Tracking** - Record IP address of admin
- ✅ **User Agent** - Browser and device information

### Dashboard Features
- ✅ **Activity History Page** - View all admin activities
- ✅ **Filtering** - Filter by user, action, module, date range
- ✅ **Search** - Search by admin name
- ✅ **Pagination** - 50 entries per page
- ✅ **Detail View** - See complete activity details
- ✅ **Data Comparison** - View old vs new values
- ✅ **CSV Export** - Download logs for external analysis
- ✅ **Auto Cleanup** - Delete logs older than 90 days

---

## 🗄️ Database Schema

### `activity_logs` Table

```sql
CREATE TABLE activity_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NULLABLE,
    user_name VARCHAR(255) NULLABLE,
    user_email VARCHAR(255) NULLABLE,
    action VARCHAR(255) NOT NULL,           -- created, updated, deleted, viewed, logged_in, logged_out
    module VARCHAR(255) NOT NULL,           -- statistics, announcements, gad-submissions, etc.
    item_name VARCHAR(255) NULLABLE,        -- Name of affected item
    description TEXT NULLABLE,              -- What was done
    old_values LONGTEXT NULLABLE,          -- JSON of previous values
    new_values LONGTEXT NULLABLE,          -- JSON of new values
    ip_address VARCHAR(255) NULLABLE,
    user_agent VARCHAR(255) NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX user_id_index (user_id),
    INDEX action_index (action),
    INDEX module_index (module),
    INDEX created_at_index (created_at)
);
```

**Columns**:
- `user_id` - ID of authenticated user
- `user_name` - Name of admin
- `user_email` - Email of admin
- `action` - Type of action performed
- `module` - Dashboard module affected
- `item_name` - Name/ID of affected item
- `description` - Human-readable description
- `old_values` - Previous record values (JSON)
- `new_values` - New record values (JSON)
- `ip_address` - Source IP address
- `user_agent` - Browser/device info

---

## 📁 Files Created

### Models
- `app/Models/ActivityLog.php` - Activity log model with helper methods

### Controllers
- `app/Http/Controllers/Admin/ActivityLogController.php` - Activity log controller

### Helpers
- `app/Helpers/LogActivity.php` - Static logging helper

### Traits
- `app/Traits/LogsActivityTrait.php` - Reusable trait for controllers

### Views
- `resources/views/admin/activity-logs/index.blade.php` - Activity logs listing
- `resources/views/admin/activity-logs/show.blade.php` - Activity detail view

### Migrations
- `database/migrations/2026_04_29_000004_create_activity_logs_table.php`

### Routes
- Updated `routes/web.php` with activity log routes
- Updated `routes/web.php` with login/logout logging

### Config
- Updated `resources/views/layouts/admin.blade.php` with menu item

---

## 🚀 Setup Instructions

### 1. Run Migration

```bash
php artisan migrate
```

This creates the `activity_logs` table.

### 2. Verify Installation

Check that the migration completed successfully:
```bash
php artisan migrate:status
```

### 3. Access Activity Logs

Navigate to: **Admin Dashboard → Security & Logs → Activity History**

---

## 📖 Usage Guide

### Viewing Activity Logs

1. Click **"Activity History"** in the admin sidebar
2. See list of all admin activities (newest first)
3. Each row shows:
   - Date & Time
   - Admin account (name & email)
   - Action performed
   - Module affected
   - Item name
   - Description
   - IP address
   - View details button

### Filtering Activities

Use the filter form to search:

**By Admin Name**:
- Type admin name in "User Name" field
- Click "Filter"

**By Action**:
- Select action from dropdown (Created, Updated, Deleted, Viewed, Logged In, Logged Out)

**By Module**:
- Select module from dropdown

**By Date Range**:
- Set "From Date" and "To Date"
- Click "Filter"

**Reset Filters**:
- Click "Reset" button to clear all filters

### Viewing Details

Click the eye icon (<i class="fas fa-eye"></i>) in any row to see:
- Full date and time
- Admin name and email
- Action and module
- Item affected
- Complete description
- IP address and user agent
- **Old values** - Previous data (if updated/deleted)
- **New values** - Current data (if created/updated)

### Exporting Logs

1. (Optional) Apply filters for specific date range
2. Click **"Export CSV"** button
3. File downloads as `activity-logs-YYYY-MM-DD.csv`

**CSV Columns**:
- User Name
- Email
- Action
- Module
- Item Name
- Description
- IP Address
- Date/Time

### Cleaning Old Logs

To delete logs older than 90 days:

1. Click **"Clear Old Logs"** button
2. Confirm deletion dialog
3. Old logs are removed

---

## 🔌 Integration with Controllers

### Using the Logging Trait

In any admin controller:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\LogsActivityTrait;
use App\Models\Statistic;

class StatisticsController extends Controller
{
    use LogsActivityTrait;

    public function store(Request $request)
    {
        $validated = $request->validate([...]);
        $statistic = Statistic::create($validated);

        // Log the creation
        $this->logCreate($statistic, $statistic->label);

        return redirect()->route('admin.statistics.index')
                       ->with('success', 'Created!');
    }

    public function update(Request $request, Statistic $statistic)
    {
        $oldValues = $statistic->getAttributes();
        
        $validated = $request->validate([...]);
        $statistic->update($validated);

        // Log the update
        $this->logUpdate($statistic, $oldValues, $statistic->label);

        return redirect()->route('admin.statistics.index')
                       ->with('success', 'Updated!');
    }

    public function destroy(Statistic $statistic)
    {
        // Log the deletion
        $this->logDelete($statistic, $statistic->label);
        
        $statistic->delete();

        return redirect()->route('admin.statistics.index')
                       ->with('success', 'Deleted!');
    }
}
```

### Direct Logging

Using the `LogActivity` helper directly:

```php
use App\Helpers\LogActivity;

// Log any activity
LogActivity::log(
    'action',           // created, updated, deleted, viewed
    'module',           // statistics, announcements, etc.
    'item_name',        // Name of affected item
    'description',      // What was done
    $oldValues,         // Previous values (optional)
    $newValues          // New values (optional)
);

// Log login
LogActivity::logLogin('admin@example.com');

// Log logout
LogActivity::logLogout();
```

---

## 🏗️ Module Names

Supported modules automatically mapped:

```
Model Name              → Module Name
Statistic             → statistics
PageBanner            → banners
AccomplishmentReport  → accomplishment-reports
Chart                 → charts
Announcement          → announcements
OrganizationMember    → organization-members
Program               → programs
Document              → documents
GADSubmission         → gad-submissions
GADAgenda             → gad-agendas
GADGuideline          → gad-guidelines
```

---

## 🎨 Action Types

| Action | Icon | Color | Description |
|--------|------|-------|-------------|
| created | ➕ Plus | Green | New item created |
| updated | ✏️ Edit | Blue | Item modified |
| deleted | 🗑️ Trash | Red | Item removed |
| viewed | 👁️ Eye | Light | Item viewed |
| logged_in | ✔️ In | Green | Admin signed in |
| logged_out | ✖️ Out | Orange | Admin signed out |

---

## 📊 Data Retention Policy

- **Retention Period**: 90 days
- **Auto-cleanup**: Logs older than 90 days can be manually deleted
- **CSV Export**: Download logs before deletion if needed
- **Manual Cleanup**: Click "Clear Old Logs" button

---

## 🔒 Security Features

✅ **User Identification**
- Records admin name and email
- Tracks user ID when available

✅ **IP Tracking**
- Captures source IP address
- Useful for detecting unauthorized access

✅ **Device Tracking**
- Records user agent (browser/device)
- Helps identify unusual access patterns

✅ **Data Integrity**
- Stores old and new values for comparison
- Audit trail for compliance

✅ **Timezone Support**
- All timestamps in server timezone
- Timestamps are UTC

---

## 📱 Responsive Design

Activity logs page is fully responsive:
- ✅ Desktop (1200px+)
- ✅ Tablet (768px-1199px)
- ✅ Mobile (320px-767px)

On mobile, table becomes scrollable with key columns prioritized.

---

## 🧪 Testing

### Manual Testing Checklist

- [ ] Create a statistic and verify log entry
- [ ] Edit a statistic and verify old/new values
- [ ] Delete a statistic and verify deletion log
- [ ] Log out and verify logout activity
- [ ] Log in and verify login activity
- [ ] Filter by admin name
- [ ] Filter by action
- [ ] Filter by module
- [ ] Filter by date range
- [ ] View activity details
- [ ] Export logs to CSV
- [ ] Verify CSV file content

---

## 🐛 Troubleshooting

### Issue: Activity logs not showing

**Solution**: Ensure migration was run:
```bash
php artisan migrate
php artisan cache:clear
```

### Issue: Can't see login/logout entries

**Solution**: Check that `AuthController` was updated with logging.

### Issue: Old/new values showing as NULL

**Solution**: Ensure model is correctly named and trait is applied to controller.

### Issue: Export CSV not working

**Solution**: Check file permissions in `storage/` directory.

---

## 📈 Performance Considerations

- **Indexes**: Created on `user_id`, `action`, `module`, `created_at`
- **Pagination**: 50 entries per page to avoid slow loads
- **Auto-cleanup**: Delete old logs regularly to maintain performance
- **Query Optimization**: Indexed columns for faster filtering

---

## 🔄 Workflow

```
Admin Action
    ↓
Controller Method (store/update/destroy)
    ↓
Use LogsActivityTrait or LogActivity helper
    ↓
Activity recorded in activity_logs table
    ↓
Admin views in Activity History page
    ↓
Can filter, search, export, or view details
```

---

## 📞 Support

For issues or questions:
- Check database table exists: `SELECT * FROM activity_logs LIMIT 1;`
- Verify migration status: `php artisan migrate:status`
- Check error logs: `storage/logs/laravel.log`
- Review this documentation

---

## 📌 Implementation Checklist

- ✅ Migration created and run
- ✅ Model with helper methods created
- ✅ Controller created with index/filter/show/export actions
- ✅ Helper class for logging created
- ✅ Trait for CRUD logging created
- ✅ Views created (index, show)
- ✅ Routes configured
- ✅ Menu item added to admin layout
- ✅ Auth controller updated with logging
- ✅ Documentation complete

---

**Version**: 1.0  
**Last Updated**: April 29, 2026  
**Status**: ✅ Production Ready
