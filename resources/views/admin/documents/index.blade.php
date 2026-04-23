@extends('layouts.admin')

@section('title', 'Manage Documents - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-file-pdf"></i> Manage Documents</h2>
    <a href="{{ route('admin.documents.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Upload Document</span>
    </a>
</div>

@if ($documents->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Year</th>
                    <th>File Type</th>
                    <th>Downloads</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                    <tr>
                        <td><strong>{{ $document->title }}</strong></td>
                        <td>
                            <span class="tag is-primary">{{ Str::limit($document->category, 20) }}</span>
                        </td>
                        <td>{{ $document->year ?? '-' }}</td>
                        <td>
                            <span class="tag is-info">{{ strtoupper($document->file_type) }}</span>
                        </td>
                        <td>
                            <span style="background: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $document->download_count }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.documents.edit', $document) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" onsubmit="return confirm('Are you sure?')">
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
        {{ $documents->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No documents found. <a href="{{ route('admin.documents.create') }}">Upload one now</a></p>
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
