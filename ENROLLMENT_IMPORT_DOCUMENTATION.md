# Enrollment Data Import System - Documentation

## Overview

This system provides a structured approach to store and manage sex-disaggregated student enrollment data. It supports dashboard visualization and maintains clean, normalized database structure.

---

## Database Architecture

### Tables

#### `colleges`
- **id** (Primary Key)
- **name** (varchar 255)
- **abbreviation** (varchar 10)
- **timestamps**

#### `programs`
- **id** (Primary Key)
- **college_id** (Foreign Key → colleges.id)
- **program_name** (varchar 255)
- **description** (text)
- **target_beneficiaries** (text, nullable)
- **category** (varchar 255)
- **image_path** (varchar 255, nullable)
- **timestamps**

#### `enrollments`
- **id** (Primary Key)
- **college_id** (Foreign Key → colleges.id, CASCADE)
- **program_id** (Foreign Key → programs.id, nullable, SET NULL)
- **academic_year** (string, e.g., "2025-2026")
- **semester** (string, e.g., "Second Semester")
- **male_count** (integer, default 0)
- **female_count** (integer, default 0)
- **total_count** (integer, default 0)
- **timestamps**

**Unique Constraint**: (college_id, program_id, academic_year, semester)

**Indexes**: college_id, program_id, (academic_year, semester)

---

## Models

### College Model
```php
class College extends Model {
    // Relationships
    public function enrollments() {}
    public function programs() {}
}
```

### Program Model
```php
class Program extends Model {
    // Relationships
    public function college() {}
    public function enrollments() {}
}
```

### Enrollment Model
```php
class Enrollment extends Model {
    // Relationships
    public function college() {}
    public function program() {}
    
    // Scopes
    public function scopeByCollege($query, $collegeId)
    public function scopeByProgram($query, $programId)
    public function scopeByAcademicYear($query, $academicYear)
    public function scopeBySemester($query, $semester)
    public function scopeCollegeLevelOnly($query)
    public function scopeProgramLevelOnly($query)
    
    // Methods
    public function getMalePercentage()
    public function getFemalePercentage()
    public static function aggregateByCollege($academicYear, $semester)
    public static function aggregateByProgram($academicYear, $semester)
}
```

---

## Data Insertion

### Using the Seeder

Run the provided seeder to insert college-level enrollment data:

```bash
php artisan db:seed --class=EnrollmentSeeder
```

This creates:
- 12 colleges (if they don't already exist)
- 12 college-level enrollment records for Academic Year 2025-2026, Second Semester

**Data Inserted:**
1. Advanced Education: M=166, F=295
2. College of Law: M=26, F=26
3. College of Science: M=330, F=775
4. College of Humanities and Social Sciences: M=233, F=363
5. College of Education: M=351, F=895
6. College of Business and Accountancy: M=494, F=1512
7. College of Agriculture and Fisheries: M=560, F=519
8. College of Engineering and Architecture: M=775, F=558
9. College of Information and Communications Technology: M=974, F=733
10. College of Health Sciences: M=261, F=1197
11. College of Industrial Technology: M=2151, F=707
12. Panganiban Campus: M=305, F=354

### Manual Entry

```php
use App\Models\College;
use App\Models\Enrollment;

$college = College::where('name', 'College of Science')->first();

Enrollment::create([
    'college_id' => $college->id,
    'program_id' => null,
    'academic_year' => '2025-2026',
    'semester' => 'Second Semester',
    'male_count' => 330,
    'female_count' => 775,
    'total_count' => 1105,
]);
```

---

## Dashboard Integration

### Using the EnrollmentAggregator Helper

#### Get Enrollments by College

```php
use App\Helpers\EnrollmentAggregator;

$collegeData = EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');

// Returns:
// [
//   {
//     'college_id' => 1,
//     'college_name' => 'College of Business and Accountancy',
//     'male_count' => 494,
//     'female_count' => 1512,
//     'total_count' => 2006,
//     'male_percentage' => 24.58,
//     'female_percentage' => 75.32,
//   },
//   ...
// ]
```

#### Get University-Wide Statistics

```php
$stats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');

// Returns:
// [
//   'total_male' => 7120,
//   'total_female' => 8909,
//   'total_students' => 16029,
//   'male_percentage' => 44.41,
//   'female_percentage' => 55.59,
//   'colleges_count' => 12,
// ]
```

#### Get College Details with Programs

```php
$collegeDetails = EnrollmentAggregator::getCollegeDetails(
    collegeId: 3,
    academicYear: '2025-2026',
    semester: 'Second Semester'
);

// Returns college-level data + program-level data if available
```

#### Get Enrollment Trends

```php
$trends = EnrollmentAggregator::getTrends(
    collegeId: 3,
    semester: 'Second Semester'
);

// Returns enrollment data across multiple academic years
```

---

## Query Examples

### Basic Queries

#### Get all enrollments for a specific college
```php
$enrollments = Enrollment::byCollege(3)->get();
```

#### Get college-level data only
```php
$collegeData = Enrollment::collegeLevelOnly()->get();
```

#### Get program-level data only
```php
$programData = Enrollment::programLevelOnly()->get();
```

#### Get enrollments for a specific academic year
```php
$enrollments = Enrollment::byAcademicYear('2025-2026')->get();
```

#### Get enrollments for a specific semester
```php
$enrollments = Enrollment::bySemester('Second Semester')->get();
```

### Advanced Queries

#### Total males by college (2025-2026, Second Semester)
```php
$malesByCollege = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->collegeLevelOnly()
    ->selectRaw('college_id, SUM(male_count) as total_males')
    ->groupBy('college_id')
    ->with('college')
    ->get();
```

#### Total females by college
```php
$femalesByCollege = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->collegeLevelOnly()
    ->selectRaw('college_id, SUM(female_count) as total_females')
    ->groupBy('college_id')
    ->with('college')
    ->get();
```

#### Gender ratio by college
```php
$genderRatio = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->collegeLevelOnly()
    ->selectRaw('
        college_id,
        SUM(male_count) as males,
        SUM(female_count) as females,
        SUM(total_count) as total,
        ROUND((SUM(male_count) / SUM(total_count)) * 100, 2) as male_pct,
        ROUND((SUM(female_count) / SUM(total_count)) * 100, 2) as female_pct
    ')
    ->groupBy('college_id')
    ->with('college')
    ->orderBy('total', 'desc')
    ->get();
```

#### Top 5 colleges by enrollment
```php
$topColleges = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->collegeLevelOnly()
    ->with('college')
    ->orderBy('total_count', 'desc')
    ->limit(5)
    ->get();
```

#### Colleges with more female than male students
```php
$moreFemaleThanMale = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->collegeLevelOnly()
    ->whereRaw('female_count > male_count')
    ->with('college')
    ->orderBy('female_count', 'desc')
    ->get();
```

#### Average class size by college
```php
$avgClassSize = Enrollment::byAcademicYear('2025-2026')
    ->bySemester('Second Semester')
    ->programLevelOnly()
    ->selectRaw('college_id, AVG(total_count) as avg_class_size')
    ->groupBy('college_id')
    ->with('college')
    ->get();
```

---

## Dashboard Controller Implementation

```php
namespace App\Http\Controllers;

use App\Helpers\EnrollmentAggregator;

class EnrollmentDashboardController extends Controller
{
    public function index()
    {
        $collegeData = EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');
        $stats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');

        return view('enrollment.dashboard', [
            'collegeData' => $collegeData,
            'stats' => $stats,
        ]);
    }

    public function getCollegeDetail($collegeId)
    {
        $details = EnrollmentAggregator::getCollegeDetails(
            $collegeId,
            '2025-2026',
            'Second Semester'
        );

        return response()->json($details);
    }
}
```

---

## Duplicate Prevention

The system prevents duplicate enrollments using a unique constraint:

```sql
UNIQUE KEY unique_enrollment (college_id, program_id, academic_year, semester)
```

The seeder checks for existing records before inserting:

```php
$existingEnrollment = Enrollment::where('college_id', $college->id)
    ->where('academic_year', $academicYear)
    ->where('semester', $semester)
    ->whereNull('program_id')
    ->first();

if (!$existingEnrollment) {
    // Insert new record
}
```

---

## Future Enhancements

1. **CSV/Excel Import**
   - Create a bulk import feature for multiple semesters
   - Support file uploads with validation

2. **Program-Level Data**
   - Use the existing program relationships
   - Link program-specific enrollment data

3. **Historical Trends**
   - Track enrollment changes across semesters
   - Generate trend reports

4. **API Endpoints**
   - RESTful API for enrollment data retrieval
   - Support filtering and pagination

5. **Export Functionality**
   - Export to CSV, Excel, PDF
   - Use `EnrollmentAggregator::exportToArray()`

---

## Files Created/Modified

### New Files
- `database/migrations/2026_05_01_000000_add_college_id_to_programs_table.php`
- `database/migrations/2026_05_01_000001_create_enrollments_table.php`
- `app/Models/Enrollment.php`
- `database/seeders/EnrollmentSeeder.php`
- `app/Helpers/EnrollmentAggregator.php`

### Modified Files
- `app/Models/College.php` - Added enrollments() and programs() relationships
- `app/Models/Program.php` - Added college_id fillable, college() relationship, enrollments() relationship

---

## Verification

To verify data was inserted correctly:

```bash
# Check colleges
php artisan tinker
>>> use App\Models\College;
>>> College::count(); // Should be 12

# Check enrollments
>>> use App\Models\Enrollment;
>>> Enrollment::count(); // Should be 12
>>> Enrollment::sum('total_count'); // Should be 16029

# Check university stats
>>> use App\Helpers\EnrollmentAggregator;
>>> EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');
```

---

## Notes

- All data is college-level (program_id is NULL)
- Academic Year: 2025-2026
- Semester: Second Semester
- Total Students: 16,029 (Male: 7,120, Female: 8,909)
- Supports future program-level data entry
- Database is fully normalized and scalable
