@extends('layouts.admin')

@section('title', 'Manage Programs - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-project-diagram"></i> Manage Programs</h2>
    <a href="{{ route('admin.programs.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Program</span>
    </a>
</div>

@if ($programs->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Program Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr>
                        <td><strong>{{ $program->program_name }}</strong></td>
                        <td>
                            <span class="tag is-primary">{{ $program->category }}</span>
                        </td>
                        <td>{{ Str::limit($program->description, 50) }}</td>
                        <td>
                            @if ($program->image_path)
                                <span class="tag is-info">
                                    <i class="fas fa-image"></i> Image
                                </span>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.programs.edit', $program) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Are you sure?')">
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

    <div class="mt-5">
        {{ $programs->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No programs found. <a href="{{ route('admin.programs.create') }}">Create one now</a></p>
    </div>
@endif

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-header h2 {
        margin: 0;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .action-buttons form {
        margin: 0;
    }
    .mt-5 {
        margin-top: 2rem;
    }
</style>
@endsection
