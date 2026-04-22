@extends('layouts.admin')

@section('title', 'Manage Statistics - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-chart-pie"></i> Manage Statistics</h2>
    <a href="{{ route('admin.statistics.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Statistic</span>
    </a>
</div>

                    @if ($statistics->count() > 0)
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable">
                                <thead>
                                    <tr>
                                        <th>Value</th>
                                        <th>Label</th>
                                        <th>Color</th>
                                        <th>Icon</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($statistics as $statistic)
                                        <tr>
                                            <td><strong>{{ $statistic->value }}</strong></td>
                                            <td>{{ $statistic->label }}</td>
                                            <td>
                                                <span class="badge {{ $statistic->color }}">{{ ucfirst($statistic->color) }}</span>
                                            </td>
                                            <td>
                                                @if ($statistic->icon)
                                                    <i class="{{ $statistic->icon }}"></i>
                                                @else
                                                    <span style="color: #ccc;">-</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($statistic->description, 50) }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.statistics.edit', $statistic) }}" class="button is-small is-info is-light">
                                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.statistics.destroy', $statistic) }}" onsubmit="return confirm('Are you sure?')">
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
                            {{ $statistics->links() }}
                        </div>
@else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #999; font-size: 1.1rem;">No statistics found. <a href="{{ route('admin.statistics.create') }}">Create one now</a></p>
    </div>
@endif
@endsection
