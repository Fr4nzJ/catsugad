# Sex-Disaggregated Staff Data Import Feature - Implementation Guide

## 🎯 Overview

This feature allows importing staff data from Excel files (.xlsx, .csv) and displays sex-disaggregated staff statistics on the Accomplishment Reports page.

**Update**: Now uses **native PHP** for parsing - no external dependencies needed!

---

## 📋 Installation Steps (QUICK)

### 1. Start MySQL Service
```
Open XAMPP Control Panel: C:\xampp\xampp-control.exe
Click "Start" next to MySQL
Click "Start" next to Apache
Wait 10 seconds
```

### 2. Run Migration
```bash
cd E:\xampp\htdocs\catsugad
php artisan migrate
```

### 3. Clear Caches (PowerShell)
```powershell
php artisan cache:clear; php artisan config:clear; php artisan route:clear
```

**That's it!** No package installation needed.

---

## 🚀 What Changed

**Old Approach**: Required `composer require maatwebsite/excel` (had extension conflicts)  
**New Approach**: ✅ Uses native PHP

### File Parsing Implementation
- **CSV**: Uses PHP `fgetcsv()` function
- **XLSX**: Uses `ZipArchive` + XML parsing (native PHP)

**Benefits**:
- ✅ No composer dependencies
- ✅ No missing PHP extensions
- ✅ Works on any PHP 8.0+ system
- ✅ Same functionality as before

---

## 📁 Generated Files

### Database
- **Migration**: `database/migrations/2026_05_05_create_staff_table.php`
  - Table: `staff`
  - Columns: id, name, position, office, gender, timestamps
  - Indexes: office, gender

### Models
- **Staff Model**: `app/Models/Staff.php`
  - Fillable: name, position, office, gender

### Import
- **StaffImport Class**: `app/Imports/StaffImport.php` ✨ UPDATED
  - Now uses native PHP file parsing
  - Maintains stateful parsing with `$currentOffice` tracking
  - Normalizes gender values (M/Male → Male, F/Female → Female, Other → Other)
  - Methods:
    - `import($filePath)` - Main entry point
    - `parseCsv($filePath)` - CSV parser
    - `parseXlsx($filePath)` - XLSX parser
    - `processRows($rows)` - Process all rows
    - `processRow($row)` - Process single row

### Controllers
- **StaffImportController**: `app/Http/Controllers/Admin/StaffImportController.php` ✨ UPDATED
  - `index()` - Display import form and current data
  - `import()` - Process file upload
  - Stores file temporarily, imports, then cleans up
  - `getTotalByGender()` - Query total staff by gender
  - `getByOfficeAndGender()` - Query staff grouped by office and gender

### Routes
- `GET /admin/staff/import` → `admin.staff.import` (display form)
- `POST /admin/staff/import` → `admin.staff.import.post` (process import)

### Views
- **Admin import view**: `resources/views/admin/staff/import.blade.php`
- **Staff data partial**: `resources/views/partials/staff-sex-disaggregated-data.blade.php`

---

## ⚡ Quick Start

### 1. Start Services
```
XAMPP Control Panel → Start MySQL → Start Apache
```

### 2. Run Migration
```bash
php artisan migrate
```

### 3. Clear Caches
```powershell
php artisan cache:clear; php artisan config:clear; php artisan route:clear
```

### 4. Start Server
```bash
php artisan serve
```

### 5. Test
```
http://localhost:8000/admin/staff/import
```

---

## 📊 PARSING LOGIC (CRITICAL)

Inside the import class:

```php
$currentOffice = null;

// If row[0] (No.) is empty:
// → Set $currentOffice = row[1] (Name column contains office name)
// → Skip saving

// If row[0] is numeric:
// → Create staff record using:
//   name = row[1]
//   position = row[2]
//   gender = normalized row[3]
//   office = $currentOffice

// Skip rows if:
// • No office is defined yet
// • Name is empty
```

---

## 📋 Excel File Format

### Headers (Row 1)
| No. | Name | Position | Gender |

### Data
- **Empty No.** → Office row (e.g., "College of Engineering")
- **Numeric No.** → Staff under most recent office

### Example
```
    | College of Engineering |          |
1   | Dr. Maria Garcia       | Dean     | Female
2   | Prof. Juan Santos      | Vice Dean| Male
    | Administration Office  |          |
3   | Mrs. Patricia Martinez | Registrar| F
```

---

## 👥 Gender Normalization

| Input | Output |
|-------|--------|
| M | Male |
| F | Female |
| Male | Male |
| Female | Female |
| (any other) | Other |

---

## 🗄️ DATABASE

**Table**: `staff`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| name | string | Staff name |
| position | string | Job position |
| office | string | Office/department name |
| gender | enum | Male, Female, Other |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Indexes**:
- office (for filtering)
- gender (for aggregation)

---

## 🎛️ CONTROLLER

### import() Method
```php
public function import(Request $request)
{
    // 1. Validate file (.xlsx/.csv, <5MB)
    // 2. Optionally truncate existing data
    // 3. Store file temporarily
    // 4. Call StaffImport->import()
    // 5. Clean up temp file
    // 6. Return success/error
}
```

### Query Methods
```php
getTotalByGender()        // Returns: ['Male' => int, 'Female' => int, 'Other' => int]
getByOfficeAndGender()    // Returns: ['Office' => [...]]
```

---

## 📺 SEX-DISAGGREGATION OUTPUT

### Admin Page (`/admin/staff/import`)

**Summary**:
- Male | Female | Other counts

**Table**:
- Office | Male | Female | Other | Total

### Public Page (`/accomplishment-report`)

**Summary**:
- Male | Female | Other (with percentages)

**Table**:
- Office | Male | Female | Other | Total

---

## 📄 FILES REFERENCE

| File | Purpose |
|------|---------|
| `STAFF_IMPORT_SETUP.md` | This file |
| `STAFF_IMPORT_EXCEL_FORMAT.md` | Excel template |
| `STAFF_IMPORT_TROUBLESHOOTING.md` | Common issues |
| `STAFF_IMPORT_QUICKSTART.md` | 2-minute setup |
| `STAFF_IMPORT_DEPLOYMENT_CHECKLIST.md` | Deployment |
| `app/Imports/StaffImport.php` | Import logic |
| `app/Http/Controllers/Admin/StaffImportController.php` | Controller |

---

## ✅ VERIFICATION

After setup:
- [ ] MySQL running (XAMPP)
- [ ] Migration ran successfully
- [ ] No errors in caches clear
- [ ] `/admin/staff/import` loads
- [ ] Test file uploads successfully
- [ ] Data appears on accomplishment report

---

## 🔧 TROUBLESHOOTING

### "MySQL connection refused"
→ Start MySQL in XAMPP Control Panel

### "Migration file not found"
→ Check: `database/migrations/2026_05_05_create_staff_table.php`

### "0 records imported"
→ Check Excel format: No. empty for offices, numeric for staff

### "File could not be opened"
→ Ensure file is .xlsx or .csv format and <5MB

---

## 📞 SUPPORT

See `STAFF_IMPORT_TROUBLESHOOTING.md` for detailed error solutions.

---

**Status**: ✅ PRODUCTION READY (No dependencies!)



---

## 📁 Generated Files

### Database
- **Migration**: `database/migrations/2026_05_05_create_staff_table.php`
  - Table: `staff`
  - Columns: id, name, position, office, gender, timestamps
  - Indexes: office, gender

### Models
- **Staff Model**: `app/Models/Staff.php`
  - Fillable: name, position, office, gender

### Import
- **StaffImport Class**: `app/Imports/StaffImport.php`
  - Implements stateful parsing with `$currentOffice` tracking
  - Normalizes gender values (M/Male → Male, F/Female → Female, Other → Other)
  - Implements ToModel, WithHeadingRow, SkipsEmptyRows

### Controllers
- **StaffImportController**: `app/Http/Controllers/Admin/StaffImportController.php`
  - `index()` - Display import form and current data
  - `import()` - Process file upload with truncate option
  - `getTotalByGender()` - Query total staff by gender
  - `getByOfficeAndGender()` - Query staff grouped by office and gender

### Routes
- `GET /admin/staff/import` → `admin.staff.import` (display form)
- `POST /admin/staff/import` → `admin.staff.import.post` (process import)

### Views
- **Admin Import View**: `resources/views/admin/staff/import.blade.php`
  - File upload form
  - Truncate option checkbox
  - Summary cards (Male, Female, Other)
  - Breakdown table by office and gender

- **Accomplishment Reports Partial**: `resources/views/partials/staff-sex-disaggregated-data.blade.php`
  - Staff summary section with gender distribution
  - Staff breakdown table by office

### Updates
- **Routes**: Added to `routes/web.php`
- **AccomplishmentReportController**: Added staff data queries
- **Accomplishment Report View**: Added staff data partial include
- **Admin Layout**: Added Staff Data Import link to sidebar

---

## 🗂️ Excel File Format

### Required Columns (Header Row 1)
| No. | Name | Position | Gender |
|-----|------|----------|--------|

### Data Format

**Office Rows** (No. is empty):
```
[empty] | College of Engineering | [empty] | [empty]
[empty] | Administration Office  | [empty] | [empty]
```

**Staff Rows** (No. is numeric, assigned to most recent office):
```
1 | John Doe      | Instructor      | M
2 | Jane Smith    | Assistant Dean  | F
3 | Bob Johnson   | Accountant      | Male
```

### Gender Normalization
- `M` or `Male` → `Male`
- `F` or `Female` → `Female`
- Any other value → `Other`

---

## 🔄 Parsing Logic (Core Implementation)

```php
private $currentOffice = null;

public function model(array $row)
{
    $no = trim((string)($row['no'] ?? $row['No.'] ?? ''));
    $name = trim((string)($row['name'] ?? $row['Name'] ?? ''));
    
    // If No. is empty → Office row
    if (empty($no)) {
        if (!empty($name)) {
            $this->currentOffice = $name;
        }
        return null;
    }
    
    // If No. is numeric → Staff row
    if (!empty($name) && $this->currentOffice !== null) {
        return new Staff([
            'name' => $name,
            'position' => $position,
            'office' => $this->currentOffice,
            'gender' => $this->normalizeGender($gender),
        ]);
    }
    
    return null;
}
```

**Key Point**: `$currentOffice` variable maintains state across rows, enabling proper office-to-staff assignment.

---

## 💻 Usage

### As Admin

1. Navigate to `/admin/staff/import`
2. Click "Choose File" and select .xlsx or .csv
3. Optionally check "Clear existing data before import"
4. Click "Import File"
5. View summary and breakdown

### On Accomplishment Reports Page

1. Navigate to `/accomplishment-report`
2. Scroll to "Sex-Disaggregated Staff Data" section
3. View:
   - Total staff by gender with percentages
   - Breakdown table by office and gender

---

## 📊 Data Queries

### Controller Methods

```php
// Get totals by gender
getTotalByGender() // Returns: ['Male' => int, 'Female' => int, 'Other' => int]

// Get office breakdown
getByOfficeAndGender() // Returns: ['Office Name' => [...]]
```

### View Variables (Accomplishment Report)

- `$staffTotalByGender` - Total counts by gender
- `$staffByOfficeAndGender` - Breakdown by office and gender

---

## 🎨 Display Sections

### Admin Import Page (`/admin/staff/import`)

**Upload Section**
- File input with .xlsx/.csv filter
- Truncate checkbox
- Import button

**Summary Section** (if data exists)
- Male count card (blue)
- Female count card (orange)
- Other count card (grey)
- Total staff count

**Breakdown Table** (if data exists)
- Office | Male | Female | Other | Total

---

### Accomplishment Reports Page (`/accomplishment-report`)

**Staff Summary Section** (gradient red background)
- Male staff card with percentage
- Female staff card with percentage
- Other staff card with percentage
- Total staff info box

**Staff by Office & Gender Table**
- Office | Male | Female | Other | Total

---

## 🚀 Next Steps

1. Install Laravel Excel: `composer require maatwebsite/excel`
2. Run migration: `php artisan migrate`
3. Test import on `/admin/staff/import`
4. Check display on `/accomplishment-report`

---

## 🔍 Troubleshooting

### "Class not found: Maatwebsite\Excel\Facades\Excel"
→ Run `composer require maatwebsite/excel`

### Import shows 0 records
→ Check Excel file format matches requirements (No., Name, Position, Gender columns)
→ Ensure offices are defined before staff rows

### Staff data not showing on accomplishment report
→ Ensure at least 1 staff record exists
→ Check AccomplishmentReportController is passing data

---

## 📝 Sample Excel File

Create an Excel file with:

```
No.  | Name                    | Position              | Gender
-----|-------------------------|------------------------|-------
     | College of Engineering  |                        |
1    | Dr. Maria Garcia        | Dean                   | F
2    | Prof. Juan Santos       | Vice Dean              | M
3    | Ms. Rosa Lopez          | Secretary              | F
     | College of Liberal Arts |                        |
4    | Dr. John Smith          | Dean                   | M
5    | Prof. Sarah Davis       | Department Chair       | F
6    | Mr. Carlos Rodriguez    | Faculty                | M
```

---

## ✅ Verification Checklist

- [ ] Migration created and run
- [ ] Staff model created
- [ ] StaffImport class created with stateful parsing
- [ ] StaffImportController created with all methods
- [ ] Routes added to routes/web.php
- [ ] Admin import view created
- [ ] Staff data partial created
- [ ] AccomplishmentReportController updated
- [ ] Accomplishment report view includes staff partial
- [ ] Admin sidebar includes staff import link
- [ ] Laravel Excel package installed
- [ ] Sample Excel file tested
- [ ] Data displays correctly on both admin and public pages

---

## 🔑 Key Implementation Insights

### Stateful Parsing
The import logic uses a private `$currentOffice` variable that persists across row iterations. This enables:
- Recognition of office vs. staff rows
- Automatic assignment of staff to offices
- Proper grouping without office column duplication

### Gender Normalization
Handles multiple input formats:
- Case-insensitive
- Abbreviations (M/F)
- Full names (Male/Female)
- Unknown values → Other

### Sex-Disaggregated Output
Two levels of data presentation:
1. **Admin**: Full control over import with truncate option
2. **Public**: Integrated into Accomplishment Reports page for context

---

## 📧 Support

For issues or questions, refer to:
- Laravel Excel Docs: https://docs.laravel-excel.com/
- Laravel Docs: https://laravel.com/docs
