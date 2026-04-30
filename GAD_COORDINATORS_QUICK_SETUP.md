# GAD Coordinators - Quick Setup Guide

## 3-Minute Setup

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Seed Colleges (from existing data)
```bash
php artisan db:seed --class=CollegeSeeder
```

### 3. Access Admin
- Login to admin panel
- Go to "GAD Modules" → "GAD Coordinators"  
- Click "Add Coordinator"
- Select college, fill in details, upload photo
- Click "Create Coordinator"

### 4. View on Frontend
- Navigate to `/accomplishment-report`
- Colleges now display with coordinators inline

---

## What You Get

### Admin Features
✅ Add/Edit/Delete coordinators  
✅ One coordinator per college (enforced)  
✅ Photo upload (circular avatar)  
✅ Email & phone contact links  
✅ Activity logging for audits  

### Frontend Display
✅ Colleges organized in collapsible sections  
✅ Gender statistics (Male/Female counts)  
✅ Coordinator info with photo inline  
✅ Mobile responsive  
✅ Fallback message if no coordinator  

---

## Files Added

| File | Purpose |
|------|---------|
| `app/Models/College.php` | College model with coordinator relationship |
| `app/Models/GADCoordinator.php` | Coordinator model |
| `app/Http/Controllers/Admin/GADCoordinatorController.php` | Admin CRUD |
| `app/Http/Requests/StoreGADCoordinatorRequest.php` | Form validation |
| `resources/views/admin/gad-coordinators/index.blade.php` | List view |
| `resources/views/admin/gad-coordinators/create.blade.php` | Add form |
| `resources/views/admin/gad-coordinators/edit.blade.php` | Edit form |
| `database/migrations/2026_04_30_000001_*.php` | Database tables |
| `database/seeders/CollegeSeeder.php` | Populate colleges |

## Files Updated

| File | Changes |
|------|---------|
| `routes/web.php` | Added coordinator routes & import |
| `app/Http/Controllers/AccomplishmentReportController.php` | Group by college, load coordinators |
| `resources/views/accomplishment-report.blade.php` | Display colleges with coordinators inline |
| `resources/views/layouts/admin.blade.php` | Added sidebar link |

---

## Validation Rules

- **College**: Required, must exist, unique (one per college)
- **Name**: Required, max 255 chars
- **Email**: Optional, valid email format
- **Contact**: Optional, max 20 chars
- **Photo**: Optional, image file, max 2MB

---

## Troubleshooting

**Colleges not appearing?**
```bash
# Verify colleges were seeded
php artisan tinker
>>> App\Models\College::count()
```

**Photos not showing?**
```bash
php artisan storage:link
```

**Already a coordinator for this college?**
- Each college can have only ONE coordinator
- Delete existing to assign new

---

## Mobile View

- Responsive grid (1-3 columns)
- Coordinator info stacks vertically
- Touch-friendly buttons
- Scrollable tables

---

## Next Steps

1. Create first coordinator in admin panel
2. View on `/accomplishment-report` page
3. Try filters to see coordinator persist per college
4. Check activity logs for audit trail

---

**Need Help?** See `GAD_COORDINATORS_IMPLEMENTATION.md` for detailed docs.
