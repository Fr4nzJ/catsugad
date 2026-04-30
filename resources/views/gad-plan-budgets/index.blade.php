@extends('layouts.layout')

@section('title', 'GAD Plans & Budgets - Gender and Development Services')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <!-- Page Title -->
    <div style="margin-bottom: 3rem;">
        <h1 style="color: #333; font-size: 2rem; margin-bottom: 0.5rem;">
            <i class="fas fa-coins" style="color: #8f1eae;"></i> GAD Plans & Budgets
        </h1>
        <p style="color: #666; font-size: 1rem;">Approved Gender and Development Plans and Budget allocations by college</p>
    </div>

    <!-- Filter Section -->
    <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 3rem;">
        <h5 style="color: #333; font-weight: 600; margin-bottom: 1.5rem;">
            <i class="fas fa-filter"></i> Filter Plans
        </h5>
        <form method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="color: #333; font-weight: 600; display: block; margin-bottom: 0.5rem;">College</label>
                <select name="college_id" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">All Colleges</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="background-color: #8f1eae; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>
    </div>

    @if($plans->count() > 0)
        <!-- Plans Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            @foreach($plans as $plan)
                <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    
                    <h3 style="color: #333; font-size: 1.25rem; margin-bottom: 1rem;">{{ $plan->title }}</h3>
                    
                    <div style="color: #666; font-size: 0.95rem; margin-bottom: 1rem;">
                        <p><strong>College:</strong> {{ $plan->college->name }}</p>
                        <p><strong>Program/Project:</strong> {{ $plan->program_project }}</p>
                        <p><strong>Budget:</strong> <span style="color: #2ecc71; font-weight: 600;">{{ $plan->getFormattedBudget() }}</span></p>
                        <p><strong>Timeline:</strong> {{ $plan->timeline ?? 'Not specified' }}</p>
                        @if($plan->target_beneficiaries)
                            <p><strong>Target Beneficiaries:</strong> {{ $plan->target_beneficiaries }}</p>
                        @endif
                    </div>

                    @if($plan->description)
                        <p style="color: #999; font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($plan->description, 100) }}</p>
                    @endif

                    <a href="{{ route('gad-plan-budgets.show', $plan) }}" style="display: inline-block; background-color: #8f1eae; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; transition: background-color 0.3s ease;">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($plans->hasPages())
            <div style="display: flex; justify-content: center; gap: 1rem; align-items: center; margin-top: 3rem;">
                {{ $plans->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div style="background-color: #f5f5f5; border-radius: 8px; padding: 3rem; text-align: center;">
            <p style="color: #999; font-size: 1.1rem;">No approved GAD Plans & Budgets available</p>
        </div>
    @endif
</div>
@endsection
