@extends('layouts.admin')

@section('title', 'Edit Accomplishment Report - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-edit"></i> Edit Accomplishment Report</h2>
    <a href="{{ route('admin.accomplishment-reports.index') }}" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Back</span>
    </a>
</div>

@if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
        <strong>Please fix the following errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.accomplishment-reports.update', $accomplishmentReport) }}">
    @csrf
    @method('PUT')

    <div class="field">
        <label class="label">Title *</label>
        <div class="control">
            <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="e.g., GAD Seminar 2024" value="{{ old('title', $accomplishmentReport->title) }}" required>
        </div>
        @error('title')
            <p class="error-text">{{ $message }}</p>
        @enderror
    </div>

    <div class="columns">
        <div class="column is-6">
            <div class="field">
                <label class="label">Year *</label>
                <div class="control">
                    <input class="input @error('year') is-danger @enderror" type="number" name="year" placeholder="2024" value="{{ old('year', $accomplishmentReport->year) }}" min="2000" max="9999" required>
                </div>
                @error('year')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="column is-6">
            <div class="field">
                <label class="label">College *</label>
                <div class="control">
                    <div class="select is-fullwidth @error('college') is-danger @enderror">
                        <select name="college" required>
                            <option value="">-- Select College --</option>
                            @foreach($colleges as $value => $label)
                                <option value="{{ $value }}" {{ old('college', $accomplishmentReport->college) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('college')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column is-6">
            <div class="field">
                <label class="label">Gender *</label>
                <div class="control">
                    <div class="select is-fullwidth @error('gender') is-danger @enderror">
                        <select name="gender" required>
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ old('gender', $accomplishmentReport->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $accomplishmentReport->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
                @error('gender')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="column is-6">
            <div class="field">
                <label class="label">Participants Count *</label>
                <div class="control">
                    <input class="input @error('participants_count') is-danger @enderror" type="number" name="participants_count" placeholder="0" value="{{ old('participants_count', $accomplishmentReport->participants_count) }}" min="0" required>
                </div>
                @error('participants_count')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Content/Description *</label>
        <div class="control">
            <textarea class="textarea @error('content') is-danger @enderror" name="content" placeholder="Describe the accomplishment..." rows="6" required>{{ old('content', $accomplishmentReport->content) }}</textarea>
        </div>
        @error('content')
            <p class="error-text">{{ $message }}</p>
        @enderror
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button type="submit" class="button is-primary">
                <span class="icon"><i class="fas fa-save"></i></span>
                <span>Update Report</span>
            </button>
        </div>
        <div class="control">
            <a href="{{ route('admin.accomplishment-reports.index') }}" class="button is-light">
                <span>Cancel</span>
            </a>
        </div>
    </div>
</form>
@endsection
    </div>
</body>
</html>
