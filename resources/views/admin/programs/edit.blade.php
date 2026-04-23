@extends('layouts.admin')

@section('title', 'Edit Program - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-project-diagram"></i> Edit Program</h2>
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

    <form action="{{ route('admin.programs.update', $program) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Program Name</label>
            <div class="control has-icons-left">
                <input class="input @error('program_name') is-danger @enderror" type="text" name="program_name" placeholder="Program name" value="{{ old('program_name', $program->program_name) }}" required>
                <span class="icon is-left">
                    <i class="fas fa-heading"></i>
                </span>
            </div>
            @error('program_name')
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
                            <option value="{{ $category }}" {{ old('category', $program->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
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
            <label class="label">Description</label>
            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" name="description" placeholder="Program description" rows="8" required>{{ old('description', $program->description) }}</textarea>
            </div>
            @error('description')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Target Beneficiaries (Optional)</label>
            <div class="control">
                <textarea class="textarea @error('target_beneficiaries') is-danger @enderror" name="target_beneficiaries" placeholder="Who will benefit from this program?" rows="4">{{ old('target_beneficiaries', $program->target_beneficiaries) }}</textarea>
            </div>
            @error('target_beneficiaries')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Image (Optional)</label>
            @if ($program->image_path)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('storage/' . $program->image_path) }}" alt="Current image" style="max-width: 200px; border-radius: 4px;">
                    <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #666;">Current image</p>
                </div>
            @endif
            <div class="control">
                <input class="input @error('image') is-danger @enderror" type="file" name="image" accept="image/*">
            </div>
            <p class="help">Leave blank to keep current image. Max size: 2MB. Accepted formats: JPEG, PNG, JPG, GIF</p>
            @error('image')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" type="submit">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Update Program</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.programs.index') }}" class="button is-light">Cancel</a>
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
