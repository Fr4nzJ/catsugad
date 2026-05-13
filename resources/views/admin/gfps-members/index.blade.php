@extends('layouts.admin')

@section('title', 'GFPS Members - Admin')

@section('content')
<div class="container mt-5">
    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <h1 class="title">GFPS Member Directory</h1>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <a href="{{ route('admin.gfps-members.create') }}" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Add Member</span>
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="notification is-success is-light">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    <!-- Import Section -->
    <div class="box" style="margin-bottom: 2rem;">
        <h2 class="subtitle">Import from Excel/CSV</h2>
        <form action="{{ route('admin.gfps-members.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="file" name="file" accept=".xlsx,.xls,.csv" required>
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                        <span class="icon"><i class="fas fa-upload"></i></span>
                        <span>Import</span>
                    </button>
                </div>
            </div>
            @error('file')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </form>
    </div>

    <!-- Members by Section -->
    @forelse($grouped as $section => $sectionMembers)
        <div class="box" style="margin-bottom: 2rem;">
            <h2 class="subtitle is-4" style="color: #2E75B6; font-weight: bold;">
                <i class="fas fa-sitemap"></i> {{ $section }}
            </h2>

            <div class="table-container">
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Order</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th>Name / Status</th>
                            <th>Designation</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sectionMembers as $member)
                            <tr>
                                <td><strong>{{ $member->sort_order }}</strong></td>
                                <td>{{ $member->gfps_position }}</td>
                                <td><span class="tag">{{ $member->gfps_role }}</span></td>
                                <td>
                                    @if($member->is_vacant)
                                        <span style="color: #999; font-style: italic;">— Vacant —</span>
                                    @else
                                        <strong>{{ $member->name }}</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($member->designation)
                                        <small>{{ $member->designation }}</small>
                                    @else
                                        <span style="color: #999;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="{{ route('admin.gfps-members.edit', $member) }}" class="button is-info">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                        </a>
                                        <form action="{{ route('admin.gfps-members.destroy', $member) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button is-danger">
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
        </div>
    @empty
        <div class="box">
            <p class="has-text-centered has-text-grey">No GFPS members found. <a href="{{ route('admin.gfps-members.create') }}">Create one now</a></p>
        </div>
    @endforelse
</div>

<script>
    // Close notification
    document.querySelectorAll('.notification .delete').forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });
</script>
@endsection
