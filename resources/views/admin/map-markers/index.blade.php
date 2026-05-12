@extends('layouts.admin')

@section('title', 'Manage Map Markers')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 4rem;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="margin: 0; color: #333; font-size: 2rem;">
                <i class="fas fa-map-pin"></i> Map Markers Management
            </h1>
            <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.95rem;">Manage location markers displayed on the contact page map</p>
        </div>
        <a href="{{ route('admin.map-markers.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #667eea; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 500;">
            <i class="fas fa-plus"></i> Add New Marker
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; color: #155724;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Markers Table -->
    @if($markers->count() > 0)
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Name</th>
                        <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Location</th>
                        <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Page</th>
                        <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600;">Status</th>
                        <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($markers as $marker)
                        <tr style="border-bottom: 1px solid #dee2e6; transition: background 0.2s;">
                            <td style="padding: 1rem; color: #333;">
                                <strong>{{ $marker->name }}</strong>
                            </td>
                            <td style="padding: 1rem; color: #666;">
                                <span style="background: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 3px; font-family: monospace; font-size: 0.85rem;">
                                    {{ $marker->latitude }}, {{ $marker->longitude }}
                                </span>
                            </td>
                            <td style="padding: 1rem; color: #666;">
                                <span style="background: #e7f3ff; color: #004085; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; font-weight: 500;">
                                    {{ $marker->page }}
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                @if($marker->is_active)
                                    <span style="background: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; font-weight: 500;">
                                        <i class="fas fa-check"></i> Active
                                    </span>
                                @else
                                    <span style="background: #f8d7da; color: #721c24; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; font-weight: 500;">
                                        <i class="fas fa-times"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('admin.map-markers.edit', $marker) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #667eea; color: white; border-radius: 4px; text-decoration: none; transition: background 0.2s;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.map-markers.destroy', $marker) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this marker?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background 0.2s;" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: white; padding: 3rem; border-radius: 8px; text-align: center; color: #666;">
            <i class="fas fa-map-pin" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
            <p style="margin: 0; font-size: 1.1rem;">No map markers found.</p>
            <p style="margin: 0.5rem 0 0 0; color: #999;">Click "Add New Marker" to create one.</p>
        </div>
    @endif
</div>

<style>
    table tr:hover {
        background: #f9f9f9;
    }
</style>
@endsection
