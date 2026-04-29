@extends('layouts.admin')

@section('title', 'Admin Activity Logs - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-history"></i> Admin Activity History</h2>
    <div class="page-header-buttons">
        <form method="POST" action="{{ route('admin.activity-logs.export') }}" style="display:inline;">
            @csrf
            <button type="submit" class="button is-light">
                <span class="icon"><i class="fas fa-download"></i></span>
                <span>Export CSV</span>
            </button>
        </form>
        <form method="POST" action="{{ route('admin.activity-logs.clear') }}" onsubmit="return confirm('Delete logs older than 90 days? This cannot be undone.');" style="display:inline;">
            @csrf
            <button type="submit" class="button is-warning is-light">
                <span class="icon"><i class="fas fa-trash"></i></span>
                <span>Clear Old Logs</span>
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

<!-- Filter Form -->
<div class="box" style="margin-bottom: 2rem;">
    <p class="heading">Filter Activities</p>
    <form method="GET" action="{{ route('admin.activity-logs.filter') }}" class="filter-form">
        <div class="columns is-multiline">
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">User Name</label>
                    <div class="control">
                        <input class="input is-small" type="text" name="user_name" placeholder="Search by admin name" value="{{ request('user_name') }}">
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">Action</label>
                    <div class="control">
                        <div class="select is-fullwidth is-small">
                            <select name="action">
                                <option value="">-- All Actions --</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">Module</label>
                    <div class="control">
                        <div class="select is-fullwidth is-small">
                            <select name="module">
                                <option value="">-- All Modules --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('-', ' ', $module)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">&nbsp;</label>
                    <div class="control">
                        <button type="submit" class="button is-info is-small is-fullwidth">
                            <span class="icon"><i class="fas fa-search"></i></span>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">From Date</label>
                    <div class="control">
                        <input class="input is-small" type="date" name="date_from" value="{{ request('date_from') }}">
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">To Date</label>
                    <div class="control">
                        <input class="input is-small" type="date" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label is-small">&nbsp;</label>
                    <div class="control">
                        <a href="{{ route('admin.activity-logs.index') }}" class="button is-light is-small is-fullwidth">
                            <span class="icon"><i class="fas fa-times"></i></span>
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Activity Logs Table -->
@if ($logs->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable is-narrow">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Admin Account</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>
                            <small>
                                <strong>{{ $log->created_at->format('M d, Y') }}</strong><br>
                                {{ $log->created_at->format('H:i:s') }}
                            </small>
                        </td>
                        <td>
                            <small>
                                <strong>{{ $log->user_name ?? 'N/A' }}</strong><br>
                                <code>{{ $log->user_email ?? 'N/A' }}</code>
                            </small>
                        </td>
                        <td>
                            <span class="tag {{ $log->getActionBadgeColor() }}">
                                <span class="icon is-small"><i class="fas {{ $log->getActionIcon() }}"></i></span>
                                <span>{{ ucfirst($log->action) }}</span>
                            </span>
                        </td>
                        <td>
                            <span class="badge is-light">
                                {{ ucfirst(str_replace('-', ' ', $log->module)) }}
                            </span>
                        </td>
                        <td>
                            <small><strong>{{ $log->item_name ?? '-' }}</strong></small>
                        </td>
                        <td>
                            <small>{{ Str::limit($log->description, 40) }}</small>
                        </td>
                        <td>
                            <small><code>{{ $log->ip_address ?? 'N/A' }}</code></small>
                        </td>
                        <td>
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="button is-small is-info is-light">
                                <span class="icon"><i class="fas fa-eye"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top: 2rem;">
        {{ $logs->links() }}
    </div>
@else
    <div class="notification is-info">
        <p><strong>No activity logs found.</strong></p>
    </div>
@endif

<style>
    .filter-form {
        padding: 1rem;
    }
    .pagination-container {
        display: flex;
        justify-content: center;
    }
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge.is-light {
        background-color: #f5f5f5;
        color: #333;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endsection
