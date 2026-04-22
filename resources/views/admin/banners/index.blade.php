@extends('layouts.admin')

@section('title', 'Manage Page Banners - GAD CatSU Admin')

@section('extra-styles')
<style>
    .banner-preview {
        width: 150px;
        height: 100px;
        border-radius: 4px;
        object-fit: cover;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="fas fa-images"></i> Manage Page Banners</h2>
    <a href="{{ route('admin.banners.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Banner</span>
    </a>
</div>

                    @if ($banners->count() > 0)
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Page</th>
                                        <th>Preview</th>
                                        <th>Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td><strong>{{ $banner->name }}</strong></td>
                                            <td>
                                                <span class="badge">{{ ucfirst($banner->page) }}</span>
                                            </td>
                                            <td>
                                                <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->name }}" class="banner-preview">
                                            </td>
                                            <td>
                                                @if ($banner->is_active)
                                                    <span class="tag is-success is-light">Active</span>
                                                @else
                                                    <span class="tag is-danger is-light">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="button is-small is-info is-light">
                                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Are you sure?')">
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
                            {{ $banners->links() }}
                        </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No banners found. <a href="{{ route('admin.banners.create') }}">Create one now</a></p>
    </div>
@endif
@endsection
