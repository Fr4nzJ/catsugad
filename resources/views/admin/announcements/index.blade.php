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
                    <th>Status</th>
                    <th>Published At</th>
                    <th>Image</th>
                    <th>Excerpt</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td><strong>{{ $announcement->title }}</strong></td>
                        <td>
                            @if ($announcement->status === 'published' && $announcement->isPublished())
                                <span class="tag is-success">
                                    <i class="fas fa-check-circle"></i> Published
                                </span>
                            @elseif ($announcement->status === 'draft')
                                <span class="tag is-warning">
                                    <i class="fas fa-file"></i> Draft
                                </span>
                            @else
                                <span class="tag is-light">
                                    <i class="fas fa-clock"></i> Scheduled
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($announcement->published_at)
                                <small>{{ $announcement->published_at->format('M d, Y H:i') }}</small>
                            @else
                                <small style="color: #ccc;">-</small>
                            @endif
                        </td>
                        <td>
                            @if ($announcement->image_path)
                                <span class="tag is-info">
                                    <i class="fas fa-image"></i> Image
                                </span>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ Str::limit($announcement->excerpt ?? $announcement->content, 40) }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="button is-small is-info is-light" title="Edit">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-small is-danger is-light" title="Delete">
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
