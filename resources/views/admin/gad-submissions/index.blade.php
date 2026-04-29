@extends('layouts.admin')

@section('title', 'Manage GAD Submissions - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-file-alt"></i> Manage GAD Submissions</h2>
    <a href="{{ route('admin.gad-submissions.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Submission</span>
    </a>
</div>

@if(session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

@if ($submissions->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>LGU Name</th>
                    <th>Fiscal Year</th>
                    <th>Status</th>
                    <th>Document</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($submission->title, 40) }}</strong>
                        </td>
                        <td>{{ $submission->lgu_name }}</td>
                        <td>{{ $submission->fiscal_year }}</td>
                        <td>
                            <span class="badge 
                                @if($submission->status == 'Draft') is-light
                                @elseif($submission->status == 'Submitted') is-info
                                @elseif($submission->status == 'Under Review') is-warning
                                @elseif($submission->status == 'Approved') is-success
                                @elseif($submission->status == 'Rejected') is-danger
                                @endif
                            ">
                                {{ $submission->status }}
                            </span>
                        </td>
                        <td>
                            @if ($submission->document_path)
                                <a href="{{ asset($submission->document_path) }}" target="_blank" class="button is-small is-light">
                                    <span class="icon"><i class="fas fa-download"></i></span>
                                </a>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.gad-submissions.edit', $submission) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.gad-submissions.destroy', $submission) }}" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-small is-danger is-light">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        {{ $submissions->links() }}
    </div>
@else
    <div class="notification is-info">
        <p><strong>No submissions yet.</strong> Click "Add Submission" to create one.</p>
    </div>
@endif

<style>
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge.is-light { background-color: #f5f5f5; color: #333; }
    .badge.is-info { background-color: #e3f2fd; color: #1976d2; }
    .badge.is-warning { background-color: #fff3e0; color: #f57c00; }
    .badge.is-success { background-color: #e8f5e9; color: #388e3c; }
    .badge.is-danger { background-color: #ffebee; color: #d32f2f; }
</style>
@endsection
