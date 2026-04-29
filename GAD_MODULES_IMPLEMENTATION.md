# GAD Modules Implementation Guide - 2026 Updates

## Overview
This document provides a complete guide to the three new GAD (Gender and Development) modules integrated into the CatSU GAD system, implementing the latest 2026 PCW and DILG updates.

---

## Module 1: LGU-Based GAD Processing (2026 UPDATE A)

### Purpose
Simulate decentralized GAD workflow where Local Government Units (LGUs) manage and review GAD plans locally.

### Database Table
**Table**: `gad_submissions`
```sql
- id (Primary Key)
- title (string)
- lgu_name (string)
- fiscal_year (integer)
- status (enum: Draft, Submitted, Under Review, Approved, Rejected)
- remarks (text, nullable)
- document_path (string, nullable)
- document_original_name (string, nullable)
- created_at, updated_at (timestamps)
```

### Model
**File**: `app/Models/GADSubmission.php`
- Manages GAD submission records
- Fillable fields: title, lgu_name, fiscal_year, status, remarks, document_path, document_original_name

### Controller
**File**: `app/Http/Controllers/Admin/GADSubmissionController.php`
- Resource controller with CRUD operations
- Supports file uploads (PDF, DOCX)
- File storage: `storage/gad-submissions/`
- Max file size: 10MB

### Routes
```
GET    /admin/gad-submissions              - List all submissions
GET    /admin/gad-submissions/create       - Show create form
POST   /admin/gad-submissions              - Store submission
GET    /admin/gad-submissions/{id}/edit    - Show edit form
PUT    /admin/gad-submissions/{id}         - Update submission
DELETE /admin/gad-submissions/{id}         - Delete submission
```

### Views
- **index.blade.php**: Lists all submissions with pagination, filters, and action buttons
- **create.blade.php**: Form to create new submission
- **edit.blade.php**: Form to edit existing submission

### Features
✓ Create GAD submissions with LGU assignment  
✓ Track submission status through workflow (Draft → Submitted → Under Review → Approved/Rejected)  
✓ Attach supporting documents (PDF/DOCX)  
✓ Add remarks and feedback  
✓ Paginated listing with status badges  
✓ Full CRUD functionality  

---

## Module 2: GAD Agenda Management (2026-2031) (UPDATE B)

### Purpose
Manage long-term GAD strategic plans per organization or LGU for the period 2026-2031.

### Database Table
**Table**: `gad_agendas`
```sql
- id (Primary Key)
- agenda_title (string)
- organization (string)
- start_year (integer, default: 2026)
- end_year (integer, default: 2031)
- objectives (text)
- strategies (text)
- status (enum: Active, Inactive)
- created_at, updated_at (timestamps)
```

### Model
**File**: `app/Models/GADAgenda.php`
- Manages GAD agenda records
- Fillable fields: agenda_title, organization, start_year, end_year, objectives, strategies, status
- Type casting for year fields

### Controller
**File**: `app/Http/Controllers/Admin/GADAgendaController.php`
- Resource controller with CRUD operations
- Validates year ranges (end_year >= start_year)
- Default years: 2026-2031

### Routes
```
GET    /admin/gad-agendas              - List all agendas
GET    /admin/gad-agendas/create       - Show create form
POST   /admin/gad-agendas              - Store agenda
GET    /admin/gad-agendas/{id}/edit    - Show edit form
PUT    /admin/gad-agendas/{id}         - Update agenda
DELETE /admin/gad-agendas/{id}         - Delete agenda
```

### Views
- **index.blade.php**: Lists all agendas with pagination and status indicators
- **create.blade.php**: Form to create new agenda (with default year range)
- **edit.blade.php**: Form to edit existing agenda

### Features
✓ Create strategic plans for 2026-2031 period  
✓ Define objectives and implementation strategies  
✓ Link agenda to organizations/LGUs  
✓ Toggle agenda status (Active/Inactive)  
✓ Validate year ranges  
✓ Full CRUD with paginated listings  

---

## Module 3: GAD Guidelines & Memorandum (UPDATE C)

### Purpose
Store and publish updated GAD policies, circulars, and guidelines from PCW and DILG.

### Database Table
**Table**: `gad_guidelines`
```sql
- id (Primary Key)
- title (string)
- description (text)
- category (string: Memorandum, Circular, Event Guide, Policy, Other)
- release_date (date)
- file_path (string, nullable)
- file_original_name (string, nullable)
- release_year (integer)
- created_at, updated_at (timestamps)
```

### Model
**File**: `app/Models/GADGuideline.php`
- Manages GAD guideline records
- Fillable fields: title, description, category, release_date, file_path, file_original_name, release_year
- Type casting for date and year fields

### Controller
**File**: `app/Http/Controllers/Admin/GADGuidelineController.php`
- Resource controller with CRUD operations
- Supports file uploads (PDF, DOCX)
- File storage: `storage/gad-guidelines/`
- Max file size: 10MB
- Categories: Memorandum, Circular, Event Guide, Policy, Other

### Routes
```
GET    /admin/gad-guidelines              - List all guidelines
GET    /admin/gad-guidelines/create       - Show create form
POST   /admin/gad-guidelines              - Store guideline
GET    /admin/gad-guidelines/{id}/edit    - Show edit form
PUT    /admin/gad-guidelines/{id}         - Update guideline
DELETE /admin/gad-guidelines/{id}         - Delete guideline
```

### Views
- **index.blade.php**: Lists all guidelines with category badges and download links
- **create.blade.php**: Form to create new guideline with date and file upload
- **edit.blade.php**: Form to edit existing guideline

### Features
✓ Store PCW and DILG guidelines, memoranda, and circulars  
✓ Categorize by type (Memorandum, Circular, Event Guide, Policy, Other)  
✓ Track release dates and years  
✓ Attach downloadable documents  
✓ Search and filter capabilities  
✓ Full CRUD operations  

---

## File Structure

### Database Migrations
```
database/migrations/
├── 2026_04_29_000001_create_gad_submissions_table.php
├── 2026_04_29_000002_create_gad_agendas_table.php
└── 2026_04_29_000003_create_gad_guidelines_table.php
```

### Models
```
app/Models/
├── GADSubmission.php
├── GADAgenda.php
└── GADGuideline.php
```

### Controllers
```
app/Http/Controllers/Admin/
├── GADSubmissionController.php
├── GADAgendaController.php
└── GADGuidelineController.php
```

### Views
```
resources/views/admin/
├── gad-submissions/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── gad-agendas/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── gad-guidelines/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

### Routes
- Updated: `routes/web.php`
  - Added resource routes for all three modules
  - Protected with `admin` middleware
  - Grouped under `/admin` prefix

---

## Admin Dashboard Integration

### Sidebar Menu
A new **"GAD Modules"** section has been added to the admin sidebar with three menu items:
- **GAD Submissions** - Manage LGU submissions
- **GAD Agendas** - Manage strategic plans
- **GAD Guidelines** - Manage policies and guidelines

### Navigation
Each module has full navigation:
- Main menu links in admin sidebar
- "Back" buttons on detail pages
- Breadcrumb-like navigation
- Clear CRUD action buttons

---

## Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```
This will create three new tables:
- `gad_submissions`
- `gad_agendas`
- `gad_guidelines`

### 2. File Storage Configuration
Ensure your `storage/app/public` directory exists and is linked:
```bash
php artisan storage:link
```

Create directories for uploads:
```bash
mkdir -p storage/app/public/gad-submissions
mkdir -p storage/app/public/gad-guidelines
```

### 3. Access Admin Dashboard
Navigate to: `/admin/dashboard`
- Use existing admin credentials
- Verify new "GAD Modules" section appears in sidebar

### 4. Start Using Modules
- Click on any GAD module in the sidebar
- Use "Add" button to create new records
- Use Edit/Delete buttons to manage records

---

## Security & Validation

### File Upload Validation
- **Allowed types**: PDF, DOC, DOCX
- **Max size**: 10MB per file
- **Storage**: Public storage with unique filenames using timestamps

### Input Validation
All forms include server-side validation:
- Required field checks
- Type validation (integers, dates, enums)
- Year range validation (end_year >= start_year)
- File type and size validation

### Access Control
All admin routes protected by:
- Authentication middleware (`auth`)
- Admin role middleware (existing `admin` middleware)

---

## UI/UX Features

### Responsive Design
- Mobile-friendly tables with horizontal scroll on small screens
- Responsive forms with column layout
- Touch-friendly buttons and links

### User Feedback
- Success messages after CRUD operations
- Error notifications with field-specific messages
- Confirmation dialogs before deletion
- Loading states and disabled buttons

### Visual Design
- Consistent with existing Bulma CSS framework
- Color-coded status badges
- Font Awesome icons for quick identification
- Organized table layouts with pagination

### Accessibility
- Proper label associations in forms
- Alt text for icons
- Semantic HTML structure
- Clear error messages

---

## Testing Checklist

- [ ] Migrations run successfully
- [ ] All three models are accessible
- [ ] Admin sidebar shows new GAD Modules menu
- [ ] Can create GAD Submission with document
- [ ] Can edit GAD Submission status
- [ ] Can delete GAD Submission with confirmation
- [ ] Can create GAD Agenda with year range
- [ ] Can edit GAD Agenda
- [ ] Can delete GAD Agenda with confirmation
- [ ] Can create GAD Guideline with file
- [ ] Can edit GAD Guideline
- [ ] Can delete GAD Guideline with confirmation
- [ ] Pagination works on all index pages
- [ ] File uploads work correctly
- [ ] Validation messages display properly
- [ ] Authentication/admin middleware prevents unauthorized access

---

## Future Enhancement Opportunities

### Optional Advanced Features
1. **Dashboard Analytics**
   - Number of submissions per LGU
   - Approval rate tracking
   - Submission timeline charts

2. **Workflow Automation**
   - Auto-status transitions
   - Email notifications on status changes
   - Approval queue management

3. **Reporting**
   - Export to Excel/PDF
   - Monthly submission reports
   - LGU performance metrics

4. **Integration**
   - Link submissions to accomplishment reports
   - Connect agendas to programs
   - Cross-reference guidelines with policies

5. **Audit Trail**
   - Track all changes with timestamps
   - User activity logging
   - Change reason documentation

---

## Support & Maintenance

### Common Tasks
- **Backup database**: `php artisan backup:run`
- **Clear cache**: `php artisan cache:clear`
- **Monitor uploads**: Check `storage/app/public/` periodically

### Troubleshooting
- **File uploads not working**: Verify `storage:link` is configured
- **Routes not found**: Ensure routes are cached: `php artisan route:clear`
- **Permission errors**: Check `storage/` directory permissions

---

## Notes
- All new features are modular and isolated
- No existing functionality has been modified
- Follows existing project patterns and conventions
- Compatible with Laravel 12 and Bulma CSS framework
- Timestamps automatically managed by Eloquent

---

**Implementation Date**: April 29, 2026  
**Version**: 1.0  
**Status**: Ready for deployment
