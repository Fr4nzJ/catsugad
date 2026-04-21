# Testing & API Reference Guide

---

## 🧪 UNIT TESTING

### Test Admin CRUD
```php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AccomplishmentReport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccomplishmentReportAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_accomplishment_report()
    {
        $response = $this->post(route('admin.accomplishment-reports.store'), [
            'title' => 'GAD Seminar 2024',
            'content' => 'Conducted awareness seminar',
            'year' => 2024,
            'college' => 'College of Computer Studies',
            'gender' => 'female',
            'participants_count' => 150,
        ]);

        $response->assertRedirect(route('admin.accomplishment-reports.index'));
        $this->assertDatabaseHas('accomplishment_reports', [
            'title' => 'GAD Seminar 2024',
            'gender' => 'female',
            'participants_count' => 150,
        ]);
    }

    /** @test */
    public function admin_can_update_accomplishment_report()
    {
        $report = AccomplishmentReport::factory()->create();

        $response = $this->put(
            route('admin.accomplishment-reports.update', $report),
            [
                'title' => 'Updated Title',
                'content' => 'Updated content',
                'year' => 2024,
                'college' => 'College of Business Administration',
                'gender' => 'male',
                'participants_count' => 100,
            ]
        );

        $response->assertRedirect(route('admin.accomplishment-reports.index'));
        $report->refresh();
        $this->assertEquals('Updated Title', $report->title);
        $this->assertEquals('male', $report->gender);
        $this->assertEquals(100, $report->participants_count);
    }

    /** @test */
    public function admin_can_delete_accomplishment_report()
    {
        $report = AccomplishmentReport::factory()->create();

        $response = $this->delete(route('admin.accomplishment-reports.destroy', $report));

        $response->assertRedirect(route('admin.accomplishment-reports.index'));
        $this->assertDatabaseMissing('accomplishment_reports', ['id' => $report->id]);
    }

    /** @test */
    public function validation_fails_for_invalid_gender()
    {
        $response = $this->post(route('admin.accomplishment-reports.store'), [
            'title' => 'Test',
            'content' => 'Test content',
            'year' => 2024,
            'college' => 'Test College',
            'gender' => 'invalid', // Invalid gender
            'participants_count' => 100,
        ]);

        $response->assertSessionHasErrors(['gender']);
    }

    /** @test */
    public function validation_fails_for_negative_participants()
    {
        $response = $this->post(route('admin.accomplishment-reports.store'), [
            'title' => 'Test',
            'content' => 'Test content',
            'year' => 2024,
            'college' => 'Test College',
            'gender' => 'male',
            'participants_count' => -5, // Negative
        ]);

        $response->assertSessionHasErrors(['participants_count']);
    }

    /** @test */
    public function filtering_by_college_works()
    {
        AccomplishmentReport::factory()->create(['college' => 'CCS', 'gender' => 'male']);
        AccomplishmentReport::factory()->create(['college' => 'CBA', 'gender' => 'female']);

        $response = $this->get(route('admin.accomplishment-reports.index', ['college' => 'CCS']));

        $response->assertSee('CCS');
    }

    /** @test */
    public function filtering_by_gender_works()
    {
        AccomplishmentReport::factory()->create(['college' => 'CCS', 'gender' => 'male']);
        AccomplishmentReport::factory()->create(['college' => 'CCS', 'gender' => 'female']);

        $response = $this->get(route('admin.accomplishment-reports.index', ['gender' => 'male']));

        $response->assertSee('Male');
    }
}
```

### Run Tests
```bash
# Run all accomplishment report tests
php artisan test --filter=AccomplishmentReportAdminTest

# Run specific test
php artisan test --filter=admin_can_create_accomplishment_report

# Run with coverage
php artisan test --coverage app/Http/Controllers/Admin/AccomplishmentReportController.php
```

---

## 🧪 MANUAL TESTING CHECKLIST

### Step 1: Database Preparation
```bash
# Run migration
php artisan migrate

# Verify table structure
php artisan tinker
>>> Schema::getColumns('accomplishment_reports')
```

### Step 2: Admin Create
```
1. Navigate to: http://localhost/admin/accomplishment-reports/create
2. Fill in all fields:
   - Title: "GAD Orientation 2024"
   - Year: 2024
   - College: "College of Computer Studies"
   - Gender: "Female"
   - Participants: 45
   - Content: "Conducted orientation on GAD..."
3. Click "Create Report"
4. Verify redirect and success message
5. Check database: php artisan tinker → App\Models\AccomplishmentReport::latest()->first()
```

### Step 3: Admin List & Filter
```
1. Navigate to: http://localhost/admin/accomplishment-reports
2. Create multiple reports with different colleges/genders
3. Test college filter:
   - Select a college dropdown
   - Click Filter
   - Verify only matching reports show
4. Test gender filter:
   - Select male/female
   - Click Filter
   - Verify only matching gender shows
5. Test combined filters (college + gender)
6. Test pagination (if > 10 reports)
```

### Step 4: Admin Edit
```
1. From listing, click Edit button on a report
2. Verify form is pre-filled with existing data
3. Change values:
   - Update title
   - Change college
   - Change gender
   - Update participants count
4. Click "Update Report"
5. Verify redirect and success message
6. Refresh and verify changes persisted
```

### Step 5: Admin Delete
```
1. From listing, click Delete button
2. Confirm deletion in prompt
3. Verify redirect and success message
4. Check report no longer in list
5. Verify deleted from database
```

### Step 6: Validation Testing
```
1. Navigate to create form
2. Try submitting empty form → All fields required
3. Try gender = "other" → Error message
4. Try participants = -5 → Error message
5. Try year = 1999 → Error (min 2000)
6. Verify old values preserved on error
```

### Step 7: Public View
```
1. Navigate to: http://localhost/accomplishment-report
2. Verify all created reports display
3. Test college filter dropdown → Filters results
4. Test gender filter dropdown → Filters results
5. Test combined filtering → Works correctly
6. Verify participant counts display
7. Check summary statistics at bottom
8. Verify pagination if > 15 reports
```

### Step 8: Chart Data
```bash
# In tinker (or via API if route added)
php artisan tinker
>>> $data = App\Http\Controllers\Admin\ChartController->getGenderCollegeAggregation()
>>> json_encode($data) // Verify structure
```

---

## 📡 API EXAMPLES

### Create Report (Admin)
```http
POST /admin/accomplishment-reports HTTP/1.1
Host: localhost
Content-Type: application/x-www-form-urlencoded

title=GAD+Seminar&content=Conducted+seminar&year=2024&college=CCS&gender=female&participants_count=150
```

### Update Report (Admin)
```http
PUT /admin/accomplishment-reports/1 HTTP/1.1
Host: localhost
Content-Type: application/x-www-form-urlencoded

_method=PUT&title=Updated&content=Updated&year=2024&college=CBA&gender=male&participants_count=100
```

### Delete Report (Admin)
```http
DELETE /admin/accomplishment-reports/1 HTTP/1.1
Host: localhost

_method=DELETE&_token=csrf_token
```

### List with Filters
```http
GET /admin/accomplishment-reports?college=CCS&gender=female HTTP/1.1
```

### Public View with Filters
```http
GET /accomplishment-report?college=CCS&gender=male HTTP/1.1
```

---

## 🔍 DEBUGGING TIPS

### Check Gender Values in Database
```bash
php artisan tinker
>>> DB::table('accomplishment_reports')->select('id', 'gender', 'participants_count')->get()
>>> DB::table('accomplishment_reports')->where('gender', 'male')->count()
>>> DB::table('accomplishment_reports')->sum('participants_count')
```

### Check Filtered Query
```bash
php artisan tinker
>>> $q = App\Models\AccomplishmentReport::where('gender', 'female');
>>> dd($q->toSql(), $q->getBindings())
```

### Check Form Values Preserved
```blade
<!-- In form after error -->
<select name="gender">
    @foreach($genders as $value => $label)
        <option value="{{ $value }}" {{ old('gender') === $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
```

### Verify Validation Rules
```bash
php artisan tinker
>>> $rules = [
    'gender' => 'required|in:male,female',
    'participants_count' => 'required|integer|min:0',
];
>>> Validator::make(['gender' => 'invalid'], $rules)->fails()  // true
>>> Validator::make(['gender' => 'male'], $rules)->passes()    // true if others ok
```

---

## 📊 DATA AGGREGATION TESTING

### Test Chart Data Generation
```bash
php artisan tinker

# Create sample data
>>> App\Models\AccomplishmentReport::create([
    'title' => 'Test 1',
    'content' => 'Test',
    'year' => 2024,
    'college' => 'CCS',
    'gender' => 'male',
    'participants_count' => 100
])

>>> App\Models\AccomplishmentReport::create([
    'title' => 'Test 2',
    'content' => 'Test',
    'year' => 2024,
    'college' => 'CCS',
    'gender' => 'female',
    'participants_count' => 150
])

# Test aggregation
>>> $result = DB::table('accomplishment_reports')
    ->select('college', 'gender', DB::raw('SUM(participants_count) as total'))
    ->groupBy('college', 'gender')
    ->get()

>>> dd($result)
# Expected output:
# {college: "CCS", gender: "male", total: 100}
# {college: "CCS", gender: "female", total: 150}
```

### Test Chart Controller Method
```bash
php artisan tinker
>>> $controller = new App\Http\Controllers\Admin\ChartController();
>>> $data = $controller->getGenderCollegeAggregation();
>>> dd($data);
# Expected: JSON response or array
```

---

## 🐛 COMMON ISSUES & SOLUTIONS

### Issue: Gender not filtering correctly
**Solution:** Check that gender values are lowercase in database
```bash
php artisan tinker
>>> DB::table('accomplishment_reports')->where('gender', 'male')->count()
```

### Issue: Dropdown not showing selected value in edit form
**Solution:** Ensure old() helper is used and value matches exactly
```blade
<option value="male" {{ old('gender', $report->gender) === 'male' ? 'selected' : '' }}>
```

### Issue: Participants count shows as string instead of int
**Solution:** Verify $casts in model includes participants_count
```php
protected $casts = [
    'participants_count' => 'integer',
];
```

### Issue: Chart data returns empty
**Solution:** Verify records have college and gender (both not null)
```bash
php artisan tinker
>>> App\Models\AccomplishmentReport::whereNull('college')->count()
>>> App\Models\AccomplishmentReport::whereNull('gender')->count()
```

---

## ✅ FINAL VERIFICATION CHECKLIST

- [ ] Migration runs successfully
- [ ] New columns visible in database
- [ ] Admin can create report with all fields
- [ ] Form validation works (try invalid values)
- [ ] College dropdown populates dynamically
- [ ] Gender shows as lowercase in DB (male/female)
- [ ] Edit form preserves selected values
- [ ] Delete functions without errors
- [ ] College filter works on admin side
- [ ] Gender filter works on admin side
- [ ] Public view displays reports
- [ ] Public filters work correctly
- [ ] Summary statistics calculate correctly
- [ ] Chart aggregation returns expected JSON
- [ ] No hardcoded values anywhere
- [ ] Pagination works (if > records per page)
- [ ] Validation error messages display
- [ ] Success messages appear on create/update/delete

---

Generated: April 15, 2026
Laravel 12 • PHP 8.2+
