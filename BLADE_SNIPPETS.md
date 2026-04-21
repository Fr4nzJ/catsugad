# Accomplishment Reports - Complete Blade Snippets

> **Copy-paste ready code for form fields and display components**

---

## 📝 CREATE/EDIT FORM - FULL STRUCTURE

### Complete Form HTML
```blade
<form method="POST" action="{{ $accomplishmentReport ? route('admin.accomplishment-reports.update', $accomplishmentReport) : route('admin.accomplishment-reports.store') }}" class="needs-validation">
    @csrf
    @if($accomplishmentReport)
        @method('PUT')
    @endif

    <!-- Validation Errors Display -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Title Field -->
    <div class="mb-3">
        <label for="title" class="form-label">
            <strong>Title <span class="text-danger">*</span></strong>
        </label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" 
               id="title" name="title" 
               value="{{ old('title', $accomplishmentReport->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Year Field -->
    <div class="mb-3">
        <label for="year" class="form-label">
            <strong>Year <span class="text-danger">*</span></strong>
        </label>
        <input type="number" class="form-control @error('year') is-invalid @enderror" 
               id="year" name="year" 
               value="{{ old('year', $accomplishmentReport->year ?? date('Y')) }}" 
               min="2000" max="9999" required>
        @error('year')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- College Select (Dynamic) -->
    <div class="mb-3">
        <label for="college" class="form-label">
            <strong>College <span class="text-danger">*</span></strong>
        </label>
        <select class="form-select @error('college') is-invalid @enderror" 
                id="college" name="college" required>
            <option value="">-- Select College --</option>
            @foreach($colleges as $value => $label)
                <option value="{{ $value }}" 
                    {{ old('college', $accomplishmentReport->college ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('college')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Gender Select -->
    <div class="mb-3">
        <label for="gender" class="form-label">
            <strong>Gender <span class="text-danger">*</span></strong>
        </label>
        <select class="form-select @error('gender') is-invalid @enderror" 
                id="gender" name="gender" required>
            <option value="">-- Select Gender --</option>
            @foreach($genders as $value => $label)
                <option value="{{ $value }}" 
                    {{ old('gender', $accomplishmentReport->gender ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('gender')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Participants Count -->
    <div class="mb-3">
        <label for="participants_count" class="form-label">
            <strong>Participants Count <span class="text-danger">*</span></strong>
        </label>
        <input type="number" class="form-control @error('participants_count') is-invalid @enderror" 
               id="participants_count" name="participants_count" 
               value="{{ old('participants_count', $accomplishmentReport->participants_count ?? 0) }}" 
               min="0" required>
        @error('participants_count')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Content Field -->
    <div class="mb-3">
        <label for="content" class="form-label">
            <strong>Content <span class="text-danger">*</span></strong>
        </label>
        <textarea class="form-control @error('content') is-invalid @enderror" 
                  id="content" name="content" rows="6" required>{{ old('content', $accomplishmentReport->content ?? '') }}</textarea>
        @error('content')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Buttons -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ $accomplishmentReport ? 'Update Report' : 'Create Report' }}
        </button>
        <a href="{{ route('admin.accomplishment-reports.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</form>
```

---

## 🔍 ADMIN INDEX TABLE

### Reports Table with Filters
```blade
<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.accomplishment-reports.index') }}" class="row g-3">
            <div class="col-md-5">
                <label for="college" class="form-label">College</label>
                <select class="form-select" id="college" name="college">
                    <option value="">-- All Colleges --</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
                            {{ $college }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">-- All Genders --</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Reports Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Year</th>
                    <th>College</th>
                    <th>Gender</th>
                    <th>Participants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>
                            <strong>{{ $report->title }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($report->content, 60) }}</small>
                        </td>
                        <td>{{ $report->year }}</td>
                        <td>{{ $report->college ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $report->gender === 'male' ? 'bg-primary' : 'bg-danger' }}">
                                {{ ucfirst($report->gender) }}
                            </span>
                        </td>
                        <td>{{ $report->participants_count }}</td>
                        <td>
                            <a href="{{ route('admin.accomplishment-reports.edit', $report) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.accomplishment-reports.destroy', $report) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No accomplishment reports found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="row mt-4">
    <div class="col-md-12">
        {{ $reports->links() }}
    </div>
</div>
```

---

## 📊 PUBLIC VIEW - FILTERED DISPLAY

### Reports Grid with Filters
```blade
<!-- Filters Section -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Filter Reports</h5>
        <form method="GET" action="{{ route('accomplishment-report') }}" class="row g-3">
            <div class="col-md-5">
                <label for="college" class="form-label">College</label>
                <select class="form-select" id="college" name="college">
                    <option value="">-- All Colleges --</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
                            {{ $college }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">-- All Genders --</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if(request('college') || request('gender'))
                    <a href="{{ route('accomplishment-report') }}" class="btn btn-secondary w-100 ms-2">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Reports Cards Grid -->
<div class="row mt-4">
    @forelse($reports as $report)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $report->title }}</h5>
                    <div class="mb-3">
                        <span class="badge bg-info">{{ $report->year }}</span>
                        <span class="badge bg-secondary">{{ $report->college }}</span>
                        <span class="badge {{ $report->gender === 'male' ? 'bg-primary' : 'bg-danger' }}">
                            {{ ucfirst($report->gender) }}
                        </span>
                        <span class="badge bg-success">{{ $report->participants_count }} Participants</span>
                    </div>
                    <p class="card-text">{{ Str::limit($report->content, 150) }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">
                        Created: {{ $report->created_at->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info">
                No accomplishment reports found matching your filters.
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($reports->hasPages())
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $reports->links() }}
        </div>
    </div>
@endif

<!-- Summary Statistics -->
@if($reports->count() > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                    <p class="mb-0">
                        <strong>Total Reports:</strong> {{ $reports->total() }} |
                        <strong>Total Participants:</strong> {{ $reports->sum('participants_count') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
```

---

## 👤 DISPLAYING GENDER WITH BADGE

### Gender Badge Component
```blade
<!-- Male Badge -->
<span class="badge bg-primary">
    {{ ucfirst($report->gender) }}
</span>

<!-- Female Badge -->
<span class="badge bg-danger">
    {{ ucfirst($report->gender) }}
</span>

<!-- Conditional -->
<span class="badge {{ $report->gender === 'male' ? 'bg-primary' : 'bg-danger' }}">
    {{ ucfirst($report->gender) }}
</span>

<!-- With Icon -->
<span class="badge {{ $report->gender === 'male' ? 'bg-primary' : 'bg-danger' }}">
    <i class="fas fa-{{ $report->gender === 'male' ? 'mars' : 'venus' }}"></i>
    {{ ucfirst($report->gender) }}
</span>
```

---

## 🎯 FILTER DROPDOWN ONLY

### College Filter Dropdown (minimal)
```blade
<select class="form-select" name="college">
    <option value="">-- All Colleges --</option>
    @foreach($colleges as $college)
        <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
            {{ $college }}
        </option>
    @endforeach
</select>
```

### Gender Filter Dropdown (minimal)
```blade
<select class="form-select" name="gender">
    <option value="">-- All Genders --</option>
    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
</select>
```

---

## 📋 FORM FIELD ONLY - REUSABLE

### College Select (reusable)
```blade
@props(['colleges', 'selected' => null, 'required' => true])

<select class="form-select @error('college') is-invalid @enderror" 
        id="college" name="college" {{ $required ? 'required' : '' }}>
    <option value="">-- Select College --</option>
    @foreach($colleges as $value => $label)
        <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
@error('college')
    <div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
```

### Gender Select (reusable)
```blade
@props(['selected' => null, 'required' => true])

<select class="form-select @error('gender') is-invalid @enderror" 
        id="gender" name="gender" {{ $required ? 'required' : '' }}>
    <option value="">-- Select Gender --</option>
    <option value="male" {{ $selected === 'male' ? 'selected' : '' }}>Male</option>
    <option value="female" {{ $selected === 'female' ? 'selected' : '' }}>Female</option>
</select>
@error('gender')
    <div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
```

### Participants Count Input (reusable)
```blade
@props(['value' => 0, 'required' => true])

<input type="number" class="form-control @error('participants_count') is-invalid @enderror" 
       id="participants_count" name="participants_count" 
       value="{{ $value }}" 
       min="0" {{ $required ? 'required' : '' }}>
@error('participants_count')
    <div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
```

---

## 🧩 SUMMARY STATISTICS COMPONENT

### Quick Stats Display
```blade
@if($reports->count() > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4>{{ $reports->total() }}</h4>
                            <p class="text-muted">Total Reports</p>
                        </div>
                        <div class="col-md-4">
                            <h4>{{ $reports->sum('participants_count') }}</h4>
                            <p class="text-muted">Total Participants</p>
                        </div>
                        <div class="col-md-4">
                            <h4>{{ $reports->count() }}</h4>
                            <p class="text-muted">This Page</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
```

---

## ✨ HELPER FUNCTIONS TO ADD (optional)

### Service Class Filter
```php
namespace App\Services;

use App\Models\AccomplishmentReport;

class AccomplishmentReportService
{
    public static function getFiltered($collegeFilter = null, $genderFilter = null, $perPage = 15)
    {
        return AccomplishmentReport::query()
            ->when($collegeFilter, fn($q) => $q->where('college', $collegeFilter))
            ->when($genderFilter, fn($q) => $q->where('gender', $genderFilter))
            ->orderBy('year', 'desc')
            ->paginate($perPage);
    }

    public static function getGenderLabel($gender)
    {
        return match($gender) {
            'male' => 'Male',
            'female' => 'Female',
            default => 'Unknown',
        };
    }

    public static function getGenderBadgeColor($gender)
    {
        return match($gender) {
            'male' => 'primary',
            'female' => 'danger',
            default => 'secondary',
        };
    }
}
```

---

Generated: April 15, 2026
For Laravel 12 with PHP 8.2+
