@extends('layouts.admin')

@section('title', 'Create Announcement - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-bullhorn"></i> Create Announcement</h2>
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

    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label class="label">Title <span style="color: #f14668;">*</span></label>
            <div class="control has-icons-left">
                <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="Announcement title" value="{{ old('title') }}" required>
                <span class="icon is-left">
                    <i class="fas fa-heading"></i>
                </span>
            </div>
            @error('title')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Excerpt (Optional)</label>
            <div class="control">
                <textarea class="textarea @error('excerpt') is-danger @enderror" name="excerpt" placeholder="Brief summary (will be auto-generated if empty)" rows="2" maxlength="500">{{ old('excerpt') }}</textarea>
            </div>
            <p class="help">Max 500 characters. Will be auto-generated from content if left empty.</p>
            @error('excerpt')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Content <span style="color: #f14668;">*</span></label>
            <div class="control">
                <textarea class="textarea @error('content') is-danger @enderror" name="content" placeholder="Announcement content" rows="10" required>{{ old('content') }}</textarea>
            </div>
            @error('content')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Image (Optional)</label>
            <div class="control">
                <input class="input @error('image') is-danger @enderror" type="file" name="image" accept="image/*">
            </div>
            <p class="help">Max size: 5MB. Accepted formats: JPEG, PNG, JPG, GIF, WebP</p>
            @error('image')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Status <span style="color: #f14668;">*</span></label>
            <div class="control">
                <div class="select">
                    <select name="status" required onchange="togglePublishedAt()">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Unpublished)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
            @error('status')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field" id="publishedAtField">
            <label class="label">Published Date & Time <span id="publishedAtRequired" style="color: #f14668;">*</span></label>
            <div class="control has-icons-left">
                <input class="input @error('published_at') is-danger @enderror" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
                <span class="icon is-left">
                    <i class="fas fa-calendar-alt"></i>
                </span>
            </div>
            <p class="help">Required only when status is "Published"</p>
            @error('published_at')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" type="submit">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Create Announcement</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.announcements.index') }}" class="button is-light">Cancel</a>
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

<script>
function togglePublishedAt() {
    const status = document.querySelector('select[name="status"]').value;
    const publishedAtField = document.getElementById('publishedAtField');
    const publishedAtInput = document.querySelector('input[name="published_at"]');
    const publishedAtRequired = document.getElementById('publishedAtRequired');
    
    if (status === 'published') {
        publishedAtInput.required = true;
        publishedAtRequired.style.display = 'inline';
    } else {
        publishedAtInput.required = false;
        publishedAtRequired.style.display = 'none';
        publishedAtInput.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', togglePublishedAt);
</script>
@endsection
