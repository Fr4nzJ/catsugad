# GAD Coordinators - Verification & Testing Guide

## Pre-Deployment Verification

### ✅ Code Quality Checks

**Database Layer:**
- [ ] Migration file exists: `database/migrations/2026_04_30_000001_*.php`
- [ ] Creates `colleges` table with unique name field
- [ ] Creates `gad_coordinators` table with foreign key
- [ ] Foreign key has cascade delete configured
- [ ] Indexes defined for performance

**Models:**
- [ ] `app/Models/College.php` exists with relationships
- [ ] `app/Models/GADCoordinator.php` exists with methods
- [ ] `College::gadCoordinator()` relationship defined
- [ ] `GADCoordinator::college()` relationship defined
- [ ] Helper methods implemented (findByName, getPhotoUrl, etc.)

**Controllers:**
- [ ] `app/Http/Controllers/Admin/GADCoordinatorController.php` exists
- [ ] All CRUD methods implemented (index, create, store, edit, update, destroy)
- [ ] LogsActivityTrait integrated
- [ ] Photo upload handling implemented
- [ ] Proper error handling and redirects

**Requests:**
- [ ] `app/Http/Requests/StoreGADCoordinatorRequest.php` exists
- [ ] All validation rules defined
- [ ] Custom error messages included
- [ ] Authorization method implemented

**Views:**
- [ ] Index view shows list with pagination
- [ ] Create view has all form fields
- [ ] Edit view pre-populates data and shows current photo
- [ ] All views use consistent styling

**Frontend:**
- [ ] `resources/views/accomplishment-report.blade.php` updated
- [ ] Shows college sections with coordinators inline
- [ ] Gender distribution displayed
- [ ] Coordinator info formatted correctly
- [ ] Fallback message for no coordinator
- [ ] Mobile responsive

**Routes:**
- [ ] Import added: `use App\Http\Controllers\Admin\GADCoordinatorController;`
- [ ] Resource routes added in admin middleware group
- [ ] All CRUD routes accessible
- [ ] Route names follow `admin.gad-coordinators.*` pattern

**Navigation:**
- [ ] Sidebar link added in admin layout
- [ ] Link points to correct route
- [ ] Icon set correctly (fas fa-user-tie)

---

## Setup Verification

### Step 1: Database Setup
```bash
# Run migration
php artisan migrate

# Expected output:
# - Migrating: 2026_04_30_000001_create_colleges_and_gad_coordinators_tables.php
# - Migrated: 2026_04_30_000001_create_colleges_and_gad_coordinators_tables.php
```

**Verify in database:**
```sql
DESCRIBE colleges;
-- Should show: id, name, abbreviation, created_at, updated_at

DESCRIBE gad_coordinators;
-- Should show: id, college_id, name, email, contact_number, photo, created_at, updated_at
```

### Step 2: Seed Colleges
```bash
php artisan db:seed --class=CollegeSeeder

# Expected output:
# Colleges seeded successfully!
```

**Verify:**
```sql
SELECT COUNT(*) FROM colleges;
-- Should show number of colleges (> 0)

SELECT name FROM colleges LIMIT 5;
-- Should show college names from accomplishment_reports
```

### Step 3: Test File Structure
```bash
# Check all files exist
ls app/Models/College.php
ls app/Models/GADCoordinator.php
ls app/Http/Controllers/Admin/GADCoordinatorController.php
ls app/Http/Requests/StoreGADCoordinatorRequest.php
ls resources/views/admin/gad-coordinators/index.blade.php
ls resources/views/admin/gad-coordinators/create.blade.php
ls resources/views/admin/gad-coordinators/edit.blade.php
ls database/seeders/CollegeSeeder.php
```

---

## Admin Panel Testing

### Test 1: Access Admin Panel
- [ ] Navigate to `/admin/login`
- [ ] Login with admin credentials
- [ ] Successfully logged in

### Test 2: Navigate to Coordinators
- [ ] Click "GAD Modules" in sidebar
- [ ] Click "GAD Coordinators"
- [ ] Successfully navigated to `/admin/gad-coordinators`
- [ ] Empty list message or existing coordinators shown

### Test 3: Create Coordinator
- [ ] Click "Add Coordinator" button
- [ ] Navigate to `/admin/gad-coordinators/create`
- [ ] See college dropdown populated
- [ ] Fill in form:
  - [ ] Select college
  - [ ] Enter name
  - [ ] Enter email (valid format)
  - [ ] Enter contact number
  - [ ] Upload photo (test with 1MB image)
- [ ] Click "Create Coordinator"
- [ ] Redirected to index with success message
- [ ] New coordinator appears in list
- [ ] Photo displayed as thumbnail

### Test 4: Edit Coordinator
- [ ] Click edit button on coordinator
- [ ] Navigate to `/admin/gad-coordinators/{id}/edit`
- [ ] Form pre-populated with current data
- [ ] Current photo preview shown
- [ ] Modify name and contact
- [ ] Upload new photo
- [ ] Click "Update Coordinator"
- [ ] Redirected with success message
- [ ] Changes reflected in list
- [ ] Old photo removed from storage

### Test 5: Duplicate Prevention
- [ ] Try to create second coordinator for same college
- [ ] Should see college as "disabled" in dropdown
- [ ] Should see "(Already assigned)" text
- [ ] Cannot select same college

### Test 6: Delete Coordinator
- [ ] Click delete button on coordinator
- [ ] See confirmation dialog
- [ ] Click "OK" to confirm
- [ ] Redirected with success message
- [ ] Coordinator removed from list
- [ ] Photo file deleted from storage

### Test 7: Activity Logging
- [ ] Navigate to `/admin/activity-logs`
- [ ] Create/edit/delete a coordinator
- [ ] See activities logged:
  - "Created GAD Coordinator: [Name] ([College])"
  - "Updated GAD Coordinator: [Name] ([College])"
  - "Deleted GAD Coordinator: [Name] ([College])"

---

## Frontend Testing

### Test 1: View Accomplishment Reports
- [ ] Navigate to `/accomplishment-report`
- [ ] Page loads successfully
- [ ] See filter section (college, gender)
- [ ] See summary statistics cards
- [ ] See college sections displayed

### Test 2: College Sections Display
- [ ] Each college has:
  - [ ] Gradient header with college name
  - [ ] Gender distribution box (Male/Female counts)
  - [ ] GAD Coordinator section
- [ ] Reports table for each college shown below

### Test 3: Coordinator Display
For each college WITH coordinator:
- [ ] Coordinator photo visible (circular avatar)
- [ ] Coordinator name displayed
- [ ] Email shown as clickable link (mailto:)
- [ ] Contact number shown as clickable link (tel:)
- [ ] Professional styling with border

For colleges WITHOUT coordinator:
- [ ] Gray box with "No coordinator assigned" message
- [ ] Fallback styling applied

### Test 4: Filter Functionality
- [ ] Filter by college: Only that college's reports + coordinator shown
- [ ] Filter by gender: Gender counts reflect filter
- [ ] Filter by both: Both filters work together
- [ ] Clear filters: All reports/colleges shown again
- [ ] Coordinator persists through filtering

### Test 5: Mobile Responsiveness
**On browser <= 768px:**
- [ ] Grid changes to single column
- [ ] Coordinator info stacks vertically
- [ ] Photo and text center-aligned
- [ ] Links still clickable
- [ ] Table becomes scrollable
- [ ] All text readable
- [ ] No horizontal scroll issues

**Test on actual devices:**
- [ ] iPhone SE (375px)
- [ ] iPhone 12 (390px)
- [ ] iPad (768px)
- [ ] Android phone (360px)

### Test 6: Link Testing
- [ ] Email link: Click → opens mail client with address pre-filled
- [ ] Phone link: Click → calls number on mobile device
- [ ] Back links: Navigate correctly

---

## Edge Cases & Validation

### Test 1: Form Validation
- [ ] Submit with blank college: Error shown
- [ ] Submit with blank name: Error shown
- [ ] Submit with invalid email: Error shown
- [ ] Submit with contact > 20 chars: Error shown
- [ ] Submit with photo > 2MB: Error shown
- [ ] Submit with non-image file: Error shown

### Test 2: Photo Upload
- [ ] Upload JPEG: Works
- [ ] Upload PNG: Works
- [ ] Upload GIF: Works
- [ ] Upload WebP: Works
- [ ] Upload PDF: Rejected with error
- [ ] Upload 0KB file: Rejected
- [ ] Upload 5MB file: Rejected (exceeds 2MB)

### Test 3: Database Constraints
- [ ] Delete college: Coordinator also deleted (cascade)
- [ ] Manually set duplicate college_id: Violates unique constraint

### Test 4: Photo Deletion
- [ ] Delete coordinator: Photo file removed from storage
- [ ] Update coordinator photo: Old photo file removed
- [ ] Check storage/app/public/gad-coordinators/: Old files not present

---

## Performance Testing

### Test 1: Query Count
- [ ] Run debugbar on admin list page
- [ ] Should use eager loading (max 2 queries: colleges + coordinators)
- [ ] No N+1 queries

### Test 2: Page Load Time
- [ ] Admin list: < 500ms
- [ ] Accomplishment report: < 1000ms
- [ ] Admin create form: < 200ms

### Test 3: Image Optimization
- [ ] Uploaded 2MB JPEG: Stored successfully
- [ ] Thumbnail displays: < 100KB total page size
- [ ] Avatar loads quickly

---

## Security Testing

### Test 1: Authorization
- [ ] Unauthenticated user → redirected to login
- [ ] Non-admin user → blocked from admin routes
- [ ] Admin user → full access

### Test 2: Input Injection
- [ ] Name: `<script>alert('xss')</script>` → Escaped in display
- [ ] Email: `test@example.com'; DROP TABLE colleges; --` → Rejected
- [ ] Contact: `+63<script>` → Rejected

### Test 3: File Upload Security
- [ ] Upload file with dangerous extension (.php): Rejected
- [ ] Upload file with fake image extension (.jpg.php): Rejected
- [ ] Verify MIME type is actually image

### Test 4: SQL Injection
- [ ] College selection uses parameterized queries (safe)
- [ ] Filter uses parameterized queries (safe)

---

## Browser Compatibility

Test on:
- [ ] Chrome 90+
- [ ] Firefox 88+
- [ ] Safari 14+
- [ ] Edge 90+
- [ ] Chrome Mobile
- [ ] Safari Mobile

**Functionality to test:**
- [ ] All buttons clickable
- [ ] Forms submit correctly
- [ ] Modals/dialogs work
- [ ] Styling renders correctly
- [ ] Images load
- [ ] Links work

---

## API/Integration Testing

### Test 1: Model Relationships
```php
# In tinker:
$college = College::first();
$college->gadCoordinator;  // Returns coordinator or null

$coordinator = GADCoordinator::first();
$coordinator->college;      // Returns college
```

### Test 2: Helpers
```php
# In tinker:
College::findByName('College of Arts');
College::findOrCreateByName('New College');
$coordinator->getPhotoUrl();
$coordinator->getFormattedContactNumber();
```

### Test 3: Scope Filtering
```php
# In tinker:
# No special scopes for coordinators, but verify queries work:
GADCoordinator::with('college')->get();
College::with('gadCoordinator')->get();
```

---

## Documentation Verification

- [ ] `GAD_COORDINATORS_IMPLEMENTATION.md` exists and complete
- [ ] `GAD_COORDINATORS_QUICK_SETUP.md` exists and easy to follow
- [ ] `GAD_COORDINATORS_SUMMARY.md` exists and accurate
- [ ] All files documented in docs
- [ ] Setup instructions clear
- [ ] Troubleshooting section helpful

---

## Final Checklist

### Before Deployment
- [ ] All tests passing
- [ ] Code review completed
- [ ] Database backup created
- [ ] Migration tested on staging
- [ ] Documentation reviewed
- [ ] Activity logging verified
- [ ] No breaking changes confirmed
- [ ] Performance acceptable
- [ ] Security issues resolved
- [ ] Mobile tested on real device

### Deployment
- [ ] Backup created
- [ ] Migration run successfully
- [ ] Seeder run successfully
- [ ] Storage link exists
- [ ] Admin can create coordinators
- [ ] Frontend displays coordinators
- [ ] Activity logs record actions
- [ ] Photo uploads working
- [ ] Filters working
- [ ] Mobile responsive

### Post-Deployment
- [ ] Production system tested
- [ ] No error logs
- [ ] Photo uploads working
- [ ] Activity logs populated
- [ ] Coordinators displaying on reports page
- [ ] Performance acceptable
- [ ] No broken links
- [ ] Team trained on new feature

---

## Sign-Off

- **Feature:** GAD Coordinators
- **Status:** Ready for production
- **Tested by:** [Your Name]
- **Date:** [Current Date]
- **Issues:** None

---

**All checks passed? Ready to deploy!** ✅
