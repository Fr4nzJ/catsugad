@extends('layouts.admin')

@section('title', 'Edit GAD Coordinator - CatSU Admin')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-edit"></i> Edit GAD Coordinator</h2>
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

    <form action="{{ route('admin.gad-coordinators.update', $gadCoordinator) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">College <span style="color: #f14668;">*</span></label>
            <div class="control has-icons-left">
                <div class="select">
                    <select name="college_id" required>
                        <option value="">-- Select College --</option>
                        @foreach ($colleges as $college)
                            <option value="{{ $college->id }}" {{ old('college_id', $gadCoordinator->college_id) == $college->id ? 'selected' : ($assignedColleges && in_array($college->id, $assignedColleges) ? '' : '') }} {{ $assignedColleges && in_array($college->id, $assignedColleges) ? 'disabled' : '' }}>
                                {{ $college->name }}
                                @if ($assignedColleges && in_array($college->id, $assignedColleges))
                                    (Already assigned)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <span class="icon is-left">
                    <i class="fas fa-building"></i>
                </span>
            </div>
            @error('college_id')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Name <span style="color: #f14668;">*</span></label>
            <div class="control has-icons-left">
                <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="Coordinator name" value="{{ old('name', $gadCoordinator->name) }}" required>
                <span class="icon is-left">
                    <i class="fas fa-user"></i>
                </span>
            </div>
            @error('name')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Email (Optional)</label>
            <div class="control has-icons-left">
                <input class="input @error('email') is-danger @enderror" type="email" name="email" placeholder="coordinator@example.com" value="{{ old('email', $gadCoordinator->email) }}">
                <span class="icon is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
            @error('email')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Contact Number (Optional)</label>
            <div class="control has-icons-left">
                <input class="input @error('contact_number') is-danger @enderror" type="tel" name="contact_number" placeholder="+63 9XX XXX XXXX" value="{{ old('contact_number', $gadCoordinator->contact_number) }}">
                <span class="icon is-left">
                    <i class="fas fa-phone"></i>
                </span>
            </div>
            @error('contact_number')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Photo (Optional)</label>
            @if ($gadCoordinator->photo)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ $gadCoordinator->getPhotoUrl() }}" alt="{{ $gadCoordinator->name }}" style="max-width: 150px; border-radius: 4px;">
                    <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #666;">Current photo</p>
                </div>
            @endif
            <div class="control">
                <input class="input @error('photo') is-danger @enderror" type="file" name="photo" accept="image/*">
            </div>
            <p class="help">Leave blank to keep current photo. Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WebP</p>
            @error('photo')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" type="submit">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Update Coordinator</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.gad-coordinators.index') }}" class="button is-light">Cancel</a>
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
