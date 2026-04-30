@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="title">Add GAD Plan & Budget</h1>

    <form action="{{ route('admin.gad-plan-budgets.store') }}" method="POST" class="box">
        @csrf

        <div class="columns is-multiline">
            <div class="column is-6">
                <div class="field">
                    <label class="label">Title <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input type="text" name="title" class="input @error('title') is-danger @enderror" 
                               value="{{ old('title') }}" required>
                    </div>
                    @error('title')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">College <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select is-fullwidth @error('college_id') is-danger @enderror">
                            <select name="college_id" required>
                                <option value="">Select a college</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('college_id')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Program/Project <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input type="text" name="program_project" class="input @error('program_project') is-danger @enderror" 
                               value="{{ old('program_project') }}" required>
                    </div>
                    @error('program_project')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Budget Amount <span class="has-text-danger">*</span></label>
                    <div class="control has-icons-left">
                        <input type="number" name="budget_amount" class="input @error('budget_amount') is-danger @enderror" 
                               value="{{ old('budget_amount') }}" step="0.01" min="0" required>
                        <span class="icon is-left">₱</span>
                    </div>
                    @error('budget_amount')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-full">
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea name="description" class="textarea @error('description') is-danger @enderror" 
                                  rows="4">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Target Beneficiaries</label>
                    <div class="control">
                        <input type="text" name="target_beneficiaries" class="input @error('target_beneficiaries') is-danger @enderror" 
                               value="{{ old('target_beneficiaries') }}">
                    </div>
                    @error('target_beneficiaries')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Timeline</label>
                    <div class="control">
                        <input type="text" name="timeline" class="input @error('timeline') is-danger @enderror" 
                               placeholder="e.g., Q1 2026 - Q4 2026" value="{{ old('timeline') }}">
                    </div>
                    @error('timeline')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Status <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select is-fullwidth @error('status') is-danger @enderror">
                            <select name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    @error('status')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field is-grouped mt-5">
            <div class="control">
                <button type="submit" class="button is-primary">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Create Plan & Budget</span>
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.gad-plan-budgets.index') }}" class="button is-light">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
