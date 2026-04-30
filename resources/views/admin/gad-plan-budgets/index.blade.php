@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="level mb-5">
        <div class="level-left">
            <div class="level-item">
                <h1 class="title">GAD Plan & Budget</h1>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <a href="{{ route('admin.gad-plan-budgets.create') }}" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Add Plan & Budget</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="notification is-success">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="box mb-5">
        <form method="GET" class="columns is-multiline">
            <div class="column is-6-tablet is-4-desktop">
                <div class="field">
                    <label class="label">Filter by College</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="college_id">
                                <option value="">All Colleges</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-6-tablet is-4-desktop">
                <div class="field">
                    <label class="label">Filter by Status</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="status">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-12-tablet is-4-desktop">
                <div class="field">
                    <label class="label">&nbsp;</label>
                    <div class="control">
                        <button type="submit" class="button is-info is-fullwidth">
                            <span class="icon"><i class="fas fa-search"></i></span>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>College</th>
                    <th>Program/Project</th>
                    <th>Budget</th>
                    <th>Timeline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td><strong>{{ $plan->title }}</strong></td>
                        <td>{{ $plan->college->name }}</td>
                        <td>{{ $plan->program_project }}</td>
                        <td>{{ $plan->getFormattedBudget() }}</td>
                        <td>{{ $plan->timeline }}</td>
                        <td>
                            <span class="tag is-{{ $plan->getStatusColor() }}">
                                {{ ucfirst($plan->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="buttons are-small">
                                <a href="{{ route('admin.gad-plan-budgets.edit', $plan) }}" class="button is-info is-small">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form action="{{ route('admin.gad-plan-budgets.destroy', $plan) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-small" onclick="return confirm('Are you sure?')">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="has-text-centered has-text-grey">No GAD Plans & Budgets found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $plans->appends(request()->query())->links() }}
    </div>
</div>
@endsection
