@extends('layouts.admin')

@section('title', 'Edit GAD Guideline - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-book"></i> Edit GAD Guideline</h2>
    <a href="{{ route('admin.gad-guidelines.index') }}" class="button is-light">
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

<form method="POST" action="{{ route('admin.gad-guidelines.update', $gadGuideline) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="field">
        <label class="label">Title <span style="color: red;">*</span></label>
        <div class="control">
            <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="Guideline Title" value="{{ old('title', $gadGuideline->title) }}" required>
        </div>
        @error('title')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Category <span style="color: red;">*</span></label>
        <div class="control">
            <div class="select @error('category') is-danger @enderror">
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $gadGuideline->category) == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('category')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="columns">
        <div class="column is-half">
            <div class="field">
                <label class="label">Release Date <span style="color: red;">*</span></label>
                <div class="control">
                    <input class="input @error('release_date') is-danger @enderror" type="date" name="release_date" value="{{ old('release_date', $gadGuideline->release_date->format('Y-m-d')) }}" required>
                </div>
                @error('release_date')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Release Year <span style="color: red;">*</span></label>
                <div class="control">
                    <input class="input @error('release_year') is-danger @enderror" type="number" name="release_year" placeholder="2026" value="{{ old('release_year', $gadGuideline->release_year) }}" min="2000" max="2100" required>
                </div>
                @error('release_year')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Description <span style="color: red;">*</span></label>
        <div class="control">
            <textarea class="textarea @error('description') is-danger @enderror" name="description" placeholder="Guideline description" rows="4" required>{{ old('description', $gadGuideline->description) }}</textarea>
        </div>
        @error('description')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Current File</label>
        <div class="control">
            @if ($gadGuideline->file_path)
                <p>
                    <a href="{{ asset($gadGuideline->file_path) }}" target="_blank" class="button is-small is-info is-light">
                        <span class="icon"><i class="fas fa-file"></i></span>
                        <span>{{ $gadGuideline->file_original_name }}</span>
                    </a>
                </p>
            @else
                <p><em>No file attached</em></p>
            @endif
        </div>
    </div>

    <div class="field">
        <label class="label">Replace File (PDF/DOCX)</label>
        <div class="control">
            <div class="file is-boxed">
                <label class="file-label">
                    <input class="file-input" type="file" name="file" accept=".pdf,.doc,.docx">
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
        @error('file')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
        <p class="help">Max file size: 10MB (PDF, DOC, DOCX) - Leave empty to keep current file</p>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-info" type="submit">
                <span class="icon"><i class="fas fa-save"></i></span>
                <span>Update Guideline</span>
            </button>
        </div>
        <div class="control">
            <a href="{{ route('admin.gad-guidelines.index') }}" class="button is-light">
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
