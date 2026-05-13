@extends('layouts.admin')

@section('title', 'Edit GFPS Member - Admin')

@section('content')
<div class="container mt-5">
    <div class="columns is-centered">
        <div class="column is-8">
            <div class="box">
                <h1 class="title">Edit GFPS Member</h1>

                <form action="{{ route('admin.gfps-members.update', $gfpsMember) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Section *</label>
                                <div class="control">
                                    <div class="select">
                                        <select name="section" required>
                                            <option value="">Select section</option>
                                            @foreach($sections as $value => $label)
                                                <option value="{{ $value }}" {{ old('section', $gfpsMember->section) === $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('section')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Sort Order *</label>
                                <div class="control">
                                    <input class="input @error('sort_order') is-danger @enderror" 
                                           type="number" name="sort_order" value="{{ old('sort_order', $gfpsMember->sort_order) }}" required>
                                </div>
                                @error('sort_order')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">GFPS Position *</label>
                        <div class="control">
                            <input class="input @error('gfps_position') is-danger @enderror" 
                                   type="text" name="gfps_position" placeholder="e.g., SUC President" 
                                   value="{{ old('gfps_position', $gfpsMember->gfps_position) }}" required>
                        </div>
                        @error('gfps_position')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">GFPS Role *</label>
                                <div class="control">
                                    <div class="select">
                                        <select name="gfps_role" required>
                                            <option value="">Select role</option>
                                            @foreach($roles as $value => $label)
                                                <option value="{{ $value }}" {{ old('gfps_role', $gfpsMember->gfps_role) === $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('gfps_role')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Name (optional)</label>
                                <div class="control">
                                    <input class="input @error('name') is-danger @enderror" 
                                           type="text" name="name" placeholder="Leave blank if vacant"
                                           value="{{ old('name', $gfpsMember->name) }}" id="memberName">
                                </div>
                                <p class="help">Leave blank to mark as vacant</p>
                                @error('name')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- AI Suggest Button for Vacant Positions -->
                    @if($gfpsMember->is_vacant)
                        <div class="field">
                            <div class="control">
                                <button type="button" class="button is-light" id="suggestBtn" onclick="suggestName()">
                                    <span class="icon"><i class="fas fa-wand-magic-sparkles"></i></span>
                                    <span>✨ Suggest with AI</span>
                                </button>
                            </div>
                            <p class="help">Let Claude suggest qualifications for this vacant position</p>
                        </div>
                    @endif

                    <div class="field">
                        <label class="label">Designation (optional)</label>
                        <div class="control">
                            <input class="input @error('designation') is-danger @enderror" 
                                   type="text" name="designation" placeholder="e.g., Associate Professor III"
                                   value="{{ old('designation', $gfpsMember->designation) }}">
                        </div>
                        @error('designation')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">Remarks (optional)</label>
                        <div class="control">
                            <textarea class="textarea @error('remarks') is-danger @enderror" 
                                      name="remarks" placeholder="Any additional notes">{{ old('remarks', $gfpsMember->remarks) }}</textarea>
                        </div>
                        @error('remarks')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="is_vacant" value="1" {{ old('is_vacant', $gfpsMember->is_vacant) ? 'checked' : '' }} id="vacantCheck">
                                Mark as Vacant Position
                            </label>
                        </div>
                    </div>

                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-success">
                                <span class="icon"><i class="fas fa-save"></i></span>
                                <span>Update Member</span>
                            </button>
                        </div>
                        <div class="control">
                            <a href="{{ route('admin.gfps-members.index') }}" class="button is-light">
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function suggestName() {
    const btn = document.getElementById('suggestBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="icon"><i class="fas fa-spinner fa-spin"></i></span><span>Generating...</span>';

    fetch('{{ route("admin.gfps-members.suggest", $gfpsMember) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const nameField = document.getElementById('memberName');
        nameField.value = data.suggestion;
        
        // Show success notification
        const notification = document.createElement('div');
        notification.className = 'notification is-success is-light';
        notification.innerHTML = '<button class="delete"></button><p>AI suggestion added to Name field!</p>';
        document.querySelector('form').parentElement.insertBefore(notification, document.querySelector('form'));
        
        notification.querySelector('.delete').onclick = function() {
            notification.remove();
        };
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating suggestion: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}
</script>
@endsection
