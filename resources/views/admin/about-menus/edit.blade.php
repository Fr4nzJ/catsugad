@extends('layouts.admin')

@section('content')
<div class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title">
                        <i class="fas fa-edit"></i> Edit About Menu Item
                    </h1>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="{{ route('admin.about-menus.index') }}" class="button is-light">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Back</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="box">
            <form action="{{ route('admin.about-menus.update', $aboutMenu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label">Title <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input class="input @error('title') is-danger @enderror" type="text" name="title" placeholder="e.g., Mission, Vision and Goal" value="{{ old('title', $aboutMenu->title) }}" required>
                    </div>
                    @error('title')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Route <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input class="input @error('route') is-danger @enderror" type="text" name="route" placeholder="e.g., about.mission-vision" value="{{ old('route', $aboutMenu->route) }}" required>
                    </div>
                    @error('route')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Icon (Font Awesome)</label>
                    <div class="control">
                        <input class="input @error('icon') is-danger @enderror" type="text" name="icon" placeholder="e.g., fas fa-bullseye" value="{{ old('icon', $aboutMenu->icon) }}">
                    </div>
                    @error('icon')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Content</label>
                    <div class="control">
                        <textarea class="textarea @error('content') is-danger @enderror" name="content" placeholder="Enter the content for this menu section" rows="6">{{ old('content', $aboutMenu->content) }}</textarea>
                    </div>
                    @error('content')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Order</label>
                    <div class="control">
                        <input class="input @error('order') is-danger @enderror" type="number" name="order" placeholder="Display order" value="{{ old('order', $aboutMenu->order) }}">
                    </div>
                    @error('order')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $aboutMenu->is_active) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-warning" type="submit">
                            <span class="icon"><i class="fas fa-save"></i></span>
                            <span>Update</span>
                        </button>
                    </div>
                    <div class="control">
                        <a href="{{ route('admin.about-menus.index') }}" class="button is-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
