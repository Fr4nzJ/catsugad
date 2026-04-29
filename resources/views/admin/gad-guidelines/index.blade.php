@extends('layouts.admin')

@section('title', 'Manage GAD Guidelines - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-book"></i> Manage GAD Guidelines</h2>
    <a href="{{ route('admin.gad-guidelines.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Guideline</span>
    </a>
</div>

@if(session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

@if ($guidelines->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Release Date</th>
                    <th>Year</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guidelines as $guideline)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($guideline->title, 40) }}</strong>
                        </td>
                        <td>
                            <span class="badge is-light">{{ $guideline->category }}</span>
                        </td>
                        <td>{{ $guideline->release_date->format('M d, Y') }}</td>
                        <td>{{ $guideline->release_year }}</td>
                        <td>
                            @if ($guideline->file_path)
                                <a href="{{ asset($guideline->file_path) }}" target="_blank" class="button is-small is-light">
                                    <span class="icon"><i class="fas fa-download"></i></span>
                                </a>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.gad-guidelines.edit', $guideline) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.gad-guidelines.destroy', $guideline) }}" onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
        {{ $guidelines->links() }}
    </div>
@else
    <div class="notification is-info">
        <p><strong>No guidelines yet.</strong> Click "Add Guideline" to create one.</p>
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
</style>
@endsection
