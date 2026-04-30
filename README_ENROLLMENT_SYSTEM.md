# Student Enrollment Data Import System

## 🎯 Overview

A comprehensive Laravel system for managing and visualizing sex-disaggregated student enrollment data. The system supports college-level and program-level data with built-in dashboard aggregation capabilities.

## ✨ Features

- ✅ **Sex-Disaggregated Data**: Track male and female enrollment separately
- ✅ **College & Program Support**: Both college-level and program-level enrollments
- ✅ **Duplicate Prevention**: Unique constraints prevent data duplication
- ✅ **Dashboard Ready**: Pre-built aggregation methods for visualization
- ✅ **Percentage Calculations**: Automatic gender percentage calculations
- ✅ **Scalable Design**: Normalized database structure for future growth
- ✅ **Export Capabilities**: Export to JSON, CSV, or array format
- ✅ **Verification Tools**: Built-in commands for data integrity checks
- ✅ **Comprehensive Documentation**: Complete guide with examples

## 📦 What's Included

### Database
- `colleges` table (12 records seeded)
- `programs` table (enhanced with college_id)
- `enrollments` table (college & program-level support)

### Models
- `College` model with relationships
- `Program` model with relationships
- `Enrollment` model with scopes and aggregation methods

### Seeders
- `EnrollmentSeeder` - Inserts 12 colleges with enrollment data

### Helpers
- `EnrollmentAggregator` - Dashboard data aggregation

### Controllers
- `EnrollmentDashboardController` - Example controller implementation

### Commands
- `enrollment:verify` - Verify data integrity

### Views
- `enrollment/dashboard.blade.php` - Example dashboard template

## 🚀 Quick Start

### 1. Install & Migrate

```bash
# Run migrations
php artisan migrate

# Seed enrollment data
php artisan db:seed --class=EnrollmentSeeder

# Verify data
php artisan enrollment:verify
```

### 2. Basic Usage

```php
use App\Helpers\EnrollmentAggregator;

// Get college-level data
$collegeData = EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');

// Get university statistics
$stats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');

// Get college details with programs
$details = EnrollmentAggregator::getCollegeDetails(1, '2025-2026', 'Second Semester');
```

### 3. Dashboard Display

```php
// In your controller
$collegeData = EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');
$stats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');

return view('enrollment.dashboard', compact('collegeData', 'stats'));
```

## 📊 Data Included

### 12 Colleges with 2025-2026 Second Semester Data

| College | Male | Female | Total |
|---------|------|--------|-------|
| College of Industrial Technology | 2,151 | 707 | 2,858 |
| College of Business and Accountancy | 494 | 1,512 | 2,006 |
| College of Information and Communications Technology | 974 | 733 | 1,707 |
| College of Health Sciences | 261 | 1,197 | 1,458 |
| College of Engineering and Architecture | 775 | 558 | 1,333 |
| College of Education | 351 | 895 | 1,246 |
| College of Science | 330 | 775 | 1,105 |
| College of Agriculture and Fisheries | 560 | 519 | 1,079 |
| Panganiban Campus | 305 | 354 | 659 |
| College of Humanities and Social Sciences | 233 | 363 | 596 |
| Advanced Education | 166 | 295 | 461 |
| College of Law | 26 | 26 | 52 |

**Total**: 14,560 students (6,626 Male / 7,934 Female)

## 🏗️ Database Schema

### Enrollments Table

```sql
CREATE TABLE enrollments (
    id BIGINT PRIMARY KEY,
    college_id BIGINT NOT NULL,
    program_id BIGINT NULL,
    academic_year VARCHAR(255),
    semester VARCHAR(255),
    male_count INT DEFAULT 0,
    female_count INT DEFAULT 0,
    total_count INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (college_id) REFERENCES colleges(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE SET NULL,
    UNIQUE KEY unique_enrollment (college_id, program_id, academic_year, semester),
    INDEX idx_college_id (college_id),
    INDEX idx_program_id (program_id),
    INDEX idx_academic_year_semester (academic_year, semester)
);
```

## 🔍 Query Examples

### College-Level Queries

```php
// Get all college-level enrollments
Enrollment::collegeLevelOnly()->get();

// Get college-level by academic year
Enrollment::byAcademicYear('2025-2026')->collegeLevelOnly()->get();

// Get top 5 colleges by enrollment
Enrollment::collegeLevelOnly()
    ->orderBy('total_count', 'desc')
    ->limit(5)
    ->with('college')
    ->get();
```

### Gender Analysis

```php
// Get gender statistics
Enrollment::collegeLevelOnly()
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
    ->get();

// Colleges with more female than male students
Enrollment::collegeLevelOnly()
    ->whereRaw('female_count > male_count')
    ->orderBy('female_count', 'desc')
    ->get();
```

### Trends Analysis

```php
// Get enrollment trends
Enrollment::where('college_id', 3)
    ->whereBetween('academic_year', ['2023-2024', '2025-2026'])
    ->orderBy('academic_year')
    ->get();
```

## 📋 API Endpoints (Example)

```php
// Dashboard index
GET /enrollment/dashboard

// Get college details
GET /enrollment/college/{id}

// Get chart data (AJAX)
GET /enrollment/chart-data?type=college&academic_year=2025-2026&semester=Second%20Semester

// Export data
GET /enrollment/export?format=csv&academic_year=2025-2026&semester=Second%20Semester

// Get trends
GET /enrollment/trends/{collegeId}
```

## 🛠️ Configuration

### Add Routes (Optional)

```php
// routes/web.php
Route::prefix('enrollment')->group(function () {
    Route::get('/', [EnrollmentDashboardController::class, 'index'])->name('enrollment.dashboard');
    Route::get('/college/{id}', [EnrollmentDashboardController::class, 'getCollegeDetails'])->name('enrollment.college-detail');
    Route::get('/chart-data', [EnrollmentDashboardController::class, 'getChartData'])->name('enrollment.chart-data');
    Route::get('/export', [EnrollmentDashboardController::class, 'export'])->name('enrollment.export');
    Route::get('/trends/{id}', [EnrollmentDashboardController::class, 'getTrends'])->name('enrollment.trends');
});
```

## 📚 Documentation Files

- `ENROLLMENT_IMPORT_DOCUMENTATION.md` - Complete system documentation
- `ENROLLMENT_SYSTEM_SUMMARY.md` - Implementation summary
- Example controller: `EnrollmentDashboardController.php`
- Example view: `resources/views/enrollment/dashboard.blade.php`

## 🧪 Verification

```bash
# Verify data integrity
php artisan enrollment:verify

# Sample output:
# Total Enrollments: 12
# Total Students: 14,560
# Total Males: 6,626 (45.51%)
# Total Females: 7,934 (54.49%)
```

## 🔄 Future Enhancements

1. **Bulk Import** - CSV/Excel upload for multiple semesters
2. **Program-Level Data** - Link program-specific enrollments
3. **API** - RESTful API for external integrations
4. **Notifications** - Alerts for anomalies
5. **Reports** - PDF generation for reports
6. **Comparison** - Year-over-year analysis
7. **Charts** - Interactive visualizations
8. **Filters** - Advanced filtering capabilities

## ✅ Verification Checklist

- [x] Colleges table created with 12 records
- [x] Enrollments table created with unique constraints
- [x] Enrollment data inserted (14,560 students)
- [x] Models with relationships created
- [x] Scopes and helper methods implemented
- [x] EnrollmentAggregator helper created
- [x] Seeder created and verified
- [x] Verification command created
- [x] Documentation completed
- [x] Example controller provided
- [x] Example views provided
- [x] No data duplication issues
- [x] Database integrity verified

## 📞 Support

For help or questions:
1. Check `ENROLLMENT_IMPORT_DOCUMENTATION.md`
2. Review example queries in this README
3. Run `php artisan enrollment:verify`
4. Review `EnrollmentAggregator` helper methods
5. Check `EnrollmentDashboardController` example

## 📄 License

This system is part of the CatSU GAD Application.

---

**Status**: ✅ Production Ready
**Last Updated**: April 30, 2026
**Total Records**: 12 colleges, 12 enrollments, 14,560 students
