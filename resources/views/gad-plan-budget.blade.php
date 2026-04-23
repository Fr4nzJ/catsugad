@extends('layouts.layout')

@section('title', 'GAD Plan and Budget - Gender and Development Services')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <h1>GAD Plan and Budget</h1>
    <p>Browse and download GAD Plan and Budget documents and certificates.</p>

    @if($documents->count() > 0)
        <div style="margin-top: 2rem;">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Document Title</th>
                        <th>Year</th>
                        <th>Downloads</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->year ?? 'N/A' }}</td>
                            <td><span class="tag is-info">{{ $document->download_count }}</span></td>
                            <td>
                                <a href="{{ route('documents.download', $document) }}" class="button is-small is-info" download>
                                    <span class="icon"><i class="fas fa-download"></i></span>
                                    <span>Download</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 2rem;">
                {{ $documents->links() }}
            </div>
        </div>
    @else
        <div class="notification is-info" style="margin-top: 2rem;">
            <p>No GAD Plan and Budget documents are currently available.</p>
        </div>
    @endif
</div>

<style>
    .table {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table thead {
        background-color: #667eea;
        color: white;
    }

    .table thead th {
        color: white;
        font-weight: 600;
        border-bottom: 2px solid #5a67d8;
    }

    .button.is-info {
        background-color: #667eea;
        color: white;
    }

    .button.is-info:hover {
        background-color: #5a67d8;
    }

    .tag.is-info {
        background-color: #e3f2fd;
        color: #1976d2;
    }
</style>
@endsection
