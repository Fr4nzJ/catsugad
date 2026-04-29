@extends('layouts.admin')

@section('title', 'Edit GAD Agenda - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-alt"></i> Edit GAD Agenda</h2>
    <a href="{{ route('admin.gad-agendas.index') }}" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Back</span>
    </a>
</div>

@if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
        <strong>Validation Errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.gad-agendas.update', $gadAgenda) }}">
    @csrf
    @method('PUT')
    
    <div class="field">
        <label class="label">Agenda Title <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('agenda_title') is-danger @enderror" type="text" name="agenda_title" placeholder="GAD Agenda Title" value="{{ old('agenda_title', $gadAgenda->agenda_title) }}" required>
        </div>
        @error('agenda_title')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Organization/LGU <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('organization') is-danger @enderror" type="text" name="organization" placeholder="Organization or LGU Name" value="{{ old('organization', $gadAgenda->organization) }}" required>
        </div>
        @error('organization')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="columns">
        <div class="column is-half">
            <div class="field">
                <label class="label">Start Year <span style="color: red;">*</span></label>
                <div class="control">
                    <input class="input @error('start_year') is-danger @enderror" type="number" name="start_year" placeholder="2026" value="{{ old('start_year', $gadAgenda->start_year) }}" min="2000" max="2100" required>
                </div>
                @error('start_year')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">End Year <span style="color: red;">*</span></label>
                <div class="control">
                    <input class="input @error('end_year') is-danger @enderror" type="number" name="end_year" placeholder="2031" value="{{ old('end_year', $gadAgenda->end_year) }}" min="2000" max="2100" required>
                </div>
                @error('end_year')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Objectives <span style="color: red;">*</span></label>
        <div class="control">
            <textarea class="textarea @error('objectives') is-danger @enderror" name="objectives" placeholder="Define GAD objectives" rows="4" required>{{ old('objectives', $gadAgenda->objectives) }}</textarea>
        </div>
        @error('objectives')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Strategies <span style="color: red;">*</span></label>
        <div class="control">
            <textarea class="textarea @error('strategies') is-danger @enderror" name="strategies" placeholder="Define implementation strategies" rows="4" required>{{ old('strategies', $gadAgenda->strategies) }}</textarea>
        </div>
        @error('strategies')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Status <span style="color: red;">*</span></label>
        <div class="control">
            <div class="select @error('status') is-danger @enderror">
                <select name="status" required>
                    <option value="">-- Select Status --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status', $gadAgenda->status) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('status')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-info" type="submit">
                <span class="icon"><i class="fas fa-save"></i></span>
                <span>Update Agenda</span>
            </button>
        </div>
        <div class="control">
            <a href="{{ route('admin.gad-agendas.index') }}" class="button is-light">
                <span>Cancel</span>
            </a>
        </div>
    </div>
</form>

<style>
    .field {
        margin-bottom: 1.5rem;
    }
    .control {
        margin-top: 0.5rem;
    }
</style>
@endsection
