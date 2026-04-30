@extends('layouts.admin')

@section('title', 'GAD Coordinators - CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-users"></i> GAD Coordinators Management</h2>
    <a href="{{ route('admin.gad-coordinators.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Coordinator</span>
    </a>
</div>

@if (session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

@if ($coordinators->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>College</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coordinators as $coordinator)
                    <tr>
                        <td>
                            @if ($coordinator->photo)
                                <figure class="image is-32x32" style="margin: 0;">
                                    <img src="{{ $coordinator->getPhotoUrl() }}" alt="{{ $coordinator->name }}" style="border-radius: 4px;">
                                </figure>
                            @else
                                <span style="color: #ccc;">
                                    <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
                                </span>
                            @endif
                        </td>
                        <td><strong>{{ $coordinator->name }}</strong></td>
                        <td>
                            <span class="tag is-light">{{ $coordinator->college->name }}</span>
                        </td>
                        <td>
                            @if ($coordinator->email)
                                <a href="mailto:{{ $coordinator->email }}" style="color: #3273dc; text-decoration: none;">
                                    {{ $coordinator->email }}
                                </a>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($coordinator->contact_number)
                                <a href="tel:{{ $coordinator->contact_number }}" style="color: #3273dc; text-decoration: none;">
                                    {{ $coordinator->contact_number }}
                                </a>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.gad-coordinators.edit', $coordinator) }}" class="button is-small is-info is-light" title="Edit">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.gad-coordinators.destroy', $coordinator) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this coordinator?');">
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

    <div class="mt-5" style="margin-top: 2rem;">
        {{ $coordinators->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem; background: #fff; border-radius: 4px;">
        <p style="color: #999; font-size: 1.1rem;">
            No GAD Coordinators found. <a href="{{ route('admin.gad-coordinators.create') }}">Create one now</a>
        </p>
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
</style>
@endsection
