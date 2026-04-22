@extends('layouts.admin')

@section('title', 'Manage Charts - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-chart-line"></i> Manage Charts</h2>
    <a href="{{ route('admin.charts.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Chart</span>
    </a>
</div>

                    @if ($charts->count() > 0)
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($charts as $chart)
                                        <tr>
                                            <td>{{ $chart->name }}</td>
                                            <td>
                                                <span class="tag {{ $chart->type === 'growth' ? 'is-info' : 'is-warning' }}">
                                                    {{ ucfirst($chart->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($chart->is_active)
                                                    <span class="tag is-success">Active</span>
                                                @else
                                                    <span class="tag is-light">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $chart->order }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.charts.edit', $chart) }}" class="button is-small is-info">Edit</a>
                                                    <form action="{{ route('admin.charts.destroy', $chart) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button is-small is-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $charts->links() }}
                        </div>
@else
    <div class="notification is-info">
        <p>No charts found. <a href="{{ route('admin.charts.create') }}">Create one</a></p>
    </div>
@endif
@endsection
