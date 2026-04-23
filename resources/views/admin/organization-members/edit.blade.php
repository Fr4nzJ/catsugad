@extends('layouts.admin')

@section('title', 'Edit Organization Member - GAD CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-sitemap"></i> Edit Organization Member</h2>
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

    <form action="{{ route('admin.organization-members.update', $organizationMember) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Name</label>
            <div class="control has-icons-left">
                <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="Member name" value="{{ old('name', $organizationMember->name) }}" required>
                <span class="icon is-left">
                    <i class="fas fa-user"></i>
                </span>
            </div>
            @error('name')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Position</label>
            <div class="control has-icons-left">
                <input class="input @error('position') is-danger @enderror" type="text" name="position" placeholder="Job position" value="{{ old('position', $organizationMember->position) }}" required>
                <span class="icon is-left">
                    <i class="fas fa-briefcase"></i>
                </span>
            </div>
            @error('position')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Role Group</label>
            <div class="control has-icons-left">
                <div class="select @error('role_group') is-danger @enderror">
                    <select name="role_group" required>
                        <option value="">Select a role group</option>
                        @foreach ($roleGroups as $group)
                            <option value="{{ $group }}" {{ old('role_group', $organizationMember->role_group) === $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="icon is-left">
                    <i class="fas fa-layer-group"></i>
                </span>
            </div>
            @error('role_group')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Bio (Optional)</label>
            <div class="control">
                <textarea class="textarea @error('bio') is-danger @enderror" name="bio" placeholder="Brief biography" rows="4">{{ old('bio', $organizationMember->bio) }}</textarea>
            </div>
            @error('bio')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Sort Order</label>
            <div class="control has-icons-left">
                <input class="input @error('sort_order') is-danger @enderror" type="number" name="sort_order" placeholder="0" value="{{ old('sort_order', $organizationMember->sort_order) }}" min="0">
                <span class="icon is-left">
                    <i class="fas fa-sort-numeric-up"></i>
                </span>
            </div>
            <p class="help">Lower numbers appear first</p>
            @error('sort_order')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Image (Optional)</label>
            @if ($organizationMember->image_path)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('storage/' . $organizationMember->image_path) }}" alt="Current image" style="max-width: 150px; border-radius: 4px;">
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
                    <span>Update Member</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.organization-members.index') }}" class="button is-light">Cancel</a>
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
