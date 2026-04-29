@extends('layouts.admin')

@section('title', 'Manage GAD Agendas - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-alt"></i> Manage GAD Agendas</h2>
    <a href="{{ route('admin.gad-agendas.create') }}" class="button is-info">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Add Agenda</span>
    </a>
</div>

@if(session('success'))
    <div class="notification is-success">
        <button class="delete"></button>
        {{ session('success') }}
    </div>
@endif

@if ($agendas->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Organization</th>
                    <th>Year Range</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agendas as $agenda)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($agenda->agenda_title, 40) }}</strong>
                        </td>
                        <td>{{ $agenda->organization }}</td>
                        <td>{{ $agenda->start_year }} - {{ $agenda->end_year }}</td>
                        <td>
                            <span class="badge 
                                @if($agenda->status == 'Active') is-success
                                @else is-light
                                @endif
                            ">
                                {{ $agenda->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.gad-agendas.edit', $agenda) }}" class="button is-small is-info is-light">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <form method="POST" action="{{ route('admin.gad-agendas.destroy', $agenda) }}" onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
    
    <div class="pagination-container">
        {{ $agendas->links() }}
    </div>
@else
    <div class="notification is-info">
        <p><strong>No agendas yet.</strong> Click "Add Agenda" to create one.</p>
    </div>
@endif

<style>
    .pagination-container {
        margin-top: 2rem;
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
    .badge.is-light { background-color: #f5f5f5; color: #333; }
    .badge.is-success { background-color: #e8f5e9; color: #388e3c; }
</style>
@endsection
