@extends('layouts.admin')

@section('title', 'Manage Accomplishment Reports - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-trophy"></i> Accomplishment Reports</h2>
    <a href="{{ route('admin.accomplishment-reports.create') }}" class="button is-primary">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>New Report</span>
    </a>
</div>

@if($message = Session::get('success'))
    <div class="notification is-success is-light">
        <button class="delete"></button>
        <i class="fas fa-check-circle"></i> {{ $message }}
    </div>
@endif

<!-- Sex-Disaggregated Enrollment Data Section -->
@if($enrollmentStats)
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 2rem; color: white; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
        <h4 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.3rem;">
            <i class="fas fa-venus-mars"></i> Sex-Disaggregated Student Enrollment Data (2025-2026)
        </h4>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
            <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center; backdrop-filter: blur(10px);">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Total Students</p>
                <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_students']) }}</h3>
            </div>

            <div style="background: #5E72E4; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Male Students</p>
                <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_male']) }}</h3>
                <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;">{{ round($enrollmentStats['male_percentage'], 2) }}%</p>
            </div>

            <div style="background: #B8BED4; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(0, 0, 0, 0.7); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Female Students</p>
                <h3 style="color: #333; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_female']) }}</h3>
                <p style="margin: 0.5rem 0 0 0; color: rgba(0, 0, 0, 0.6); font-size: 0.85rem;">{{ round($enrollmentStats['female_percentage'], 2) }}%</p>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center; backdrop-filter: blur(10px);">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Colleges</p>
                <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ $enrollmentStats['colleges_count'] }}</h3>
            </div>
        </div>
    </div>
@endif

<!-- Filter Section -->
<div style="background-color: #f9f9f9; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
    <h5 style="color: #333; font-weight: 600; margin-bottom: 1rem;"><i class="fas fa-filter"></i> Filter by</h5>
    <form method="GET" action="{{ route('admin.accomplishment-reports.index') }}" class="columns">
        <div class="column is-5">
            <div class="field">
                <label class="label">College</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="college">
                            <option value="">-- All Colleges --</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
                                    {{ $college }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="column is-5">
            <div class="field">
                <label class="label">Gender</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="gender">
                            <option value="">-- All Genders --</option>
                            <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="column is-2 is-flex is-align-items-flex-end">
            <button type="submit" class="button is-info is-fullwidth">
                <span class="icon"><i class="fas fa-search"></i></span>
                <span>Filter</span>
            </button>
        </div>
    </form>
</div>

<!-- Reports Table -->
<div class="table-container">
    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr style="background-color: #f5f5f5;">
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
                        <strong>{{ $report->title }}</strong><br>
                        <small style="color: #999;">{{ Str::limit($report->content, 50) }}</small>
                    </td>
                    <td>{{ $report->year }}</td>
                    <td>{{ $report->college ?? 'N/A' }}</td>
                    <td>
                        <span class="tag {{ $report->gender === 'male' ? 'is-info' : 'is-danger' }}">
                            {{ ucfirst($report->gender) }}
                        </span>
                    </td>
                    <td>{{ $report->participants_count }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.accomplishment-reports.edit', $report) }}" class="button is-small is-warning" title="Edit">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                            </a>
                            <form method="POST" action="{{ route('admin.accomplishment-reports.destroy', $report) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button is-small is-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #999; padding: 2rem;">
                        <i class="fas fa-inbox"></i> No accomplishment reports found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($reports->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $reports->links('pagination::simple-bootstrap-4') }}
    </div>
@endif
@endsection
</html>
