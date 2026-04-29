@extends('layouts.admin')

@section('title', 'Activity Details - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-search"></i> Activity Details</h2>
    <a href="{{ route('admin.activity-logs.index') }}" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Back to Logs</span>
    </a>
</div>

<div class="columns">
    <div class="column is-8">
        <div class="box">
            <div class="field">
                <label class="label">Date & Time</label>
                <p class="control">
                    <strong>{{ $activityLog->created_at->format('F d, Y \a\t H:i:s') }}</strong>
                </p>
            </div>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Admin Name</label>
                        <p class="control">
                            <strong>{{ $activityLog->user_name ?? 'N/A' }}</strong>
                        </p>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Admin Email</label>
                        <p class="control">
                            <code>{{ $activityLog->user_email ?? 'N/A' }}</code>
                        </p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Action</label>
                        <p class="control">
                            <span class="tag {{ $activityLog->getActionBadgeColor() }}">
                                <span class="icon is-small"><i class="fas {{ $activityLog->getActionIcon() }}"></i></span>
                                <span>{{ ucfirst($activityLog->action) }}</span>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Module</label>
                        <p class="control">
                            <span class="badge is-light">
                                {{ ucfirst(str_replace('-', ' ', $activityLog->module)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Item Name</label>
                <p class="control">
                    <strong>{{ $activityLog->item_name ?? 'N/A' }}</strong>
                </p>
            </div>

            <div class="field">
                <label class="label">Description</label>
                <p class="control">
                    {{ $activityLog->description ?? 'N/A' }}
                </p>
            </div>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">IP Address</label>
                        <p class="control">
                            <code>{{ $activityLog->ip_address ?? 'N/A' }}</code>
                        </p>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">User Agent</label>
                        <p class="control">
                            <small>{{ Str::limit($activityLog->user_agent, 60) }}</small>
                        </p>
                    </div>
                </div>
            </div>

            @if ($activityLog->old_values || $activityLog->new_values)
                <hr>

                @if ($activityLog->old_values)
                    <div class="field">
                        <label class="label">Previous Values</label>
                        <div class="content">
                            <pre style="background: #f5f5f5; padding: 1rem; border-radius: 4px; overflow-x: auto;"><code>{{ json_encode(json_decode($activityLog->old_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                        </div>
                    </div>
                @endif

                @if ($activityLog->new_values)
                    <div class="field">
                        <label class="label">New Values</label>
                        <div class="content">
                            <pre style="background: #f5f5f5; padding: 1rem; border-radius: 4px; overflow-x: auto;"><code>{{ json_encode(json_decode($activityLog->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="column is-4">
        <div class="box" style="background: #f5f5f5;">
            <p class="heading">Quick Info</p>
            <table class="table is-narrow is-fullwidth">
                <tr>
                    <td><strong>Status</strong></td>
                    <td>
                        <span class="tag is-success">Recorded</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Days Ago</strong></td>
                    <td>{{ $activityLog->created_at->diffInDays(now()) }} days</td>
                </tr>
                <tr>
                    <td><strong>User ID</strong></td>
                    <td><code>{{ $activityLog->user_id ?? '-' }}</code></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<style>
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
    code {
        background: #f5f5f5;
        padding: 0.2rem 0.4rem;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
</style>
@endsection
