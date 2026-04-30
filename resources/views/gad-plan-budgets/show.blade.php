@extends('layouts.layout')

@section('title', $gadPlanBudget->title . ' - GAD Plans & Budgets')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Content -->
        <div>
            <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div>
                        <h1 style="color: #333; font-size: 2rem; margin-bottom: 0.5rem;">{{ $gadPlanBudget->title }}</h1>
                    </div>
                    <div>
                        <span style="background-color: {{ $gadPlanBudget->status == 'approved' ? '#2ecc71' : '#f39c12' }}; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                            {{ ucfirst($gadPlanBudget->status) }}
                        </span>
                    </div>
                </div>

                <div style="background-color: #f5f5f5; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                        <div>
                            <p style="color: #999; font-weight: 600; margin-bottom: 0.5rem;">College</p>
                            <p style="color: #333; font-size: 1.1rem;">{{ $gadPlanBudget->college->name }}</p>
                        </div>
                        <div>
                            <p style="color: #999; font-weight: 600; margin-bottom: 0.5rem;">Program/Project</p>
                            <p style="color: #333; font-size: 1.1rem;">{{ $gadPlanBudget->program_project }}</p>
                        </div>
                        <div>
                            <p style="color: #999; font-weight: 600; margin-bottom: 0.5rem;">Budget</p>
                            <p style="color: #2ecc71; font-size: 1.25rem; font-weight: 600;">{{ $gadPlanBudget->getFormattedBudget() }}</p>
                        </div>
                    </div>
                </div>

                <h2 style="color: #333; font-size: 1.5rem; margin-bottom: 1rem;">Description</h2>
                <p style="color: #666; line-height: 1.6; margin-bottom: 2rem;">{{ $gadPlanBudget->description ?? 'No description provided' }}</p>

                <hr style="border: none; border-top: 1px solid #ddd; margin: 2rem 0;">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <p style="color: #999; font-weight: 600; margin-bottom: 0.5rem;">Target Beneficiaries</p>
                        <p style="color: #333;">{{ $gadPlanBudget->target_beneficiaries ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <p style="color: #999; font-weight: 600; margin-bottom: 0.5rem;">Timeline</p>
                        <p style="color: #333;">{{ $gadPlanBudget->timeline ?? 'Not specified' }}</p>
                    </div>
                </div>

                <hr style="border: none; border-top: 1px solid #ddd; margin: 2rem 0;">

                <p style="color: #999; font-size: 0.9rem;">
                    Created on {{ $gadPlanBudget->created_at->format('F d, Y') }}
                    @if($gadPlanBudget->updated_at != $gadPlanBudget->created_at)
                        | Last updated {{ $gadPlanBudget->updated_at->format('F d, Y') }}
                    @endif
                </p>

                <div style="margin-top: 2rem;">
                    <a href="{{ route('gad-plan-budgets.index') }}" style="display: inline-block; background-color: #ddd; color: #333; padding: 0.7rem 1.5rem; border-radius: 4px; text-decoration: none; transition: background-color 0.3s ease;">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Quick Facts Card -->
            <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
                <h2 style="color: #333; font-size: 1.25rem; margin-bottom: 1.5rem;">Quick Facts</h2>
                
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem;">
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 0.5rem;">Total Budget</p>
                    <p style="font-size: 1.5rem; font-weight: 600;">{{ $gadPlanBudget->getFormattedBudget() }}</p>
                </div>

                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem;">
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 0.5rem;">Status</p>
                    <p style="font-size: 1.25rem; font-weight: 600;">{{ ucfirst($gadPlanBudget->status) }}</p>
                </div>

                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 8px; padding: 1.5rem;">
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 0.5rem;">College</p>
                    <p style="font-size: 1.25rem; font-weight: 600;">{{ $gadPlanBudget->college->abbreviation ?? $gadPlanBudget->college->name }}</p>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #333; font-size: 1.25rem; margin-bottom: 1.5rem;">Additional Info</h2>
                <p style="color: #666; font-size: 0.95rem;">
                    <strong>Created:</strong> {{ $gadPlanBudget->created_at->format('M d, Y') }}<br>
                    <strong>Updated:</strong> {{ $gadPlanBudget->updated_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
