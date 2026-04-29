@extends('layouts.admin')

@section('title', 'Create GAD Submission - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-file-alt"></i> Create GAD Submission</h2>
    <a href="{{ route('admin.gad-submissions.index') }}" class="button is-light">
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

<form method="POST" action="{{ route('admin.gad-submissions.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="field">
        <label class="label">Title <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="Submission Title" value="{{ old('title') }}" required>
        </div>
        @error('title')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">LGU Name <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('lgu_name') is-danger @enderror" type="text" name="lgu_name" placeholder="LGU Name" value="{{ old('lgu_name') }}" required>
        </div>
        @error('lgu_name')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Fiscal Year <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('fiscal_year') is-danger @enderror" type="number" name="fiscal_year" placeholder="2026" value="{{ old('fiscal_year', date('Y')) }}" min="2000" max="2100" required>
        </div>
        @error('fiscal_year')
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
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
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

    <div class="field">
        <label class="label">Remarks</label>
        <div class="control">
            <textarea class="textarea @error('remarks') is-danger @enderror" name="remarks" placeholder="Optional remarks or notes" rows="4">{{ old('remarks') }}</textarea>
        </div>
        @error('remarks')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Attach Document (PDF/DOCX)</label>
        <div class="control">
            <div class="file is-boxed">
                <label class="file-label">
                    <input class="file-input" type="file" name="document" accept=".pdf,.doc,.docx">
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choose a file…
                        </span>
                    </span>
                </label>
            </div>
        </div>
        @error('document')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
        <p class="help">Max file size: 10MB (PDF, DOC, DOCX)</p>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-info" type="submit">
                <span class="icon"><i class="fas fa-save"></i></span>
                <span>Create Submission</span>
            </button>
        </div>
        <div class="control">
            <a href="{{ route('admin.gad-submissions.index') }}" class="button is-light">
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
