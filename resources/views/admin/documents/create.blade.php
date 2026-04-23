@extends('layouts.admin')

@section('title', 'Upload Document - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-file-pdf"></i> Upload Document</h2>
</div>

<div class="box">
    @if ($errors->any())
        <div class="notification is-danger">
            <button class="delete"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label class="label">Document Title</label>
            <div class="control has-icons-left">
                <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="Document title" value="{{ old('title') }}" required>
                <span class="icon is-left">
                    <i class="fas fa-heading"></i>
                </span>
            </div>
            @error('title')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Description (Optional)</label>
            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" name="description" placeholder="Document description" rows="4">{{ old('description') }}</textarea>
            </div>
            @error('description')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Category</label>
            <div class="control has-icons-left">
                <div class="select @error('category') is-danger @enderror">
                    <select name="category" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="icon is-left">
                    <i class="fas fa-layer-group"></i>
                </span>
            </div>
            @error('category')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Year (Optional)</label>
            <div class="control has-icons-left">
                <input class="input @error('year') is-danger @enderror" type="number" name="year" placeholder="Year" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
                <span class="icon is-left">
                    <i class="fas fa-calendar"></i>
                </span>
            </div>
            @error('year')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Document File</label>
            <div class="control">
                <input class="input @error('file') is-danger @enderror" type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
            </div>
            <p class="help">Accepted formats: PDF, DOC, DOCX, XLS, XLSX. Max size: 10MB</p>
            @error('file')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" type="submit">
                    <span class="icon"><i class="fas fa-upload"></i></span>
                    <span>Upload Document</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.documents.index') }}" class="button is-light">Cancel</a>
            </div>
        </div>
    </form>
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-header h2 {
        margin: 0;
    }
</style>
@endsection
