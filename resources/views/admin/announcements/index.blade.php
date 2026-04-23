@extends('layouts.admin')

@section('title', 'Manage Announcements - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-bullhorn"></i> Manage Announcements</h2>
    <a href="{{ route('admin.announcements.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Announcement</span>
    </a>
</div>

@if ($announcements->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Published At</th>
                    <th>Image</th>
                    <th>Content Preview</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td><strong>{{ $announcement->title }}</strong></td>
                        <td>{{ $announcement->published_at?->format('M d, Y') ?? 'Not published' }}</td>
                        <td>
                            @if ($announcement->image_path)
                                <span class="tag is-info">
                                    <i class="fas fa-image"></i> Image
                                </span>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($announcement->content, 50) }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Are you sure?')">
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
        {{ $announcements->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No announcements found. <a href="{{ route('admin.announcements.create') }}">Create one now</a></p>
    </div>
@endif
@endsection

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
