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

<!-- Include Enhanced Sex-Disaggregated Data Visualization Section -->
@if($enrollmentStats)
    @include('partials.sex-disaggregated-data-visualization')
@endif

<!-- Include Enhanced Sex-Disaggregated Staff Data Visualization -->
@if(isset($staffTotalByGender) && ($staffTotalByGender['Male'] > 0 || $staffTotalByGender['Female'] > 0 || $staffTotalByGender['Other'] > 0))
    @include('partials.staff-sex-disaggregated-data-visualization')
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
