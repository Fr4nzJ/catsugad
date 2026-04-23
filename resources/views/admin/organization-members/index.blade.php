@extends('layouts.admin')

@section('title', 'Manage Organization Members - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-sitemap"></i> Manage Organization Members</h2>
    <a href="{{ route('admin.organization-members.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Member</span>
    </a>
</div>

@if ($members->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Role Group</th>
                    <th>Sort Order</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td><strong>{{ $member->name }}</strong></td>
                        <td>{{ $member->position }}</td>
                        <td>
                            <span class="tag is-primary">{{ $member->role_group }}</span>
                        </td>
                        <td>{{ $member->sort_order }}</td>
                        <td>
                            @if ($member->image_path)
                                <span class="tag is-info">
                                    <i class="fas fa-image"></i> Image
                                </span>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.organization-members.edit', $member) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.organization-members.destroy', $member) }}" onsubmit="return confirm('Are you sure?')">
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
        {{ $members->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No members found. <a href="{{ route('admin.organization-members.create') }}">Add one now</a></p>
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
