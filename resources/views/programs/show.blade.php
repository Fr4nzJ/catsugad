@extends('layouts.layout')

@section('title', $program->program_name . ' - Programs & Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <a href="{{ route('programs.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; margin-bottom: 1rem; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Back to Programs
        </a>
        <h1 style="margin: 1rem 0 0 0; font-size: 2.5rem;">{{ $program->program_name }}</h1>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.95;">
            <span style="display: inline-block; background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 4px; margin-top: 0.5rem;">{{ $program->category }}</span>
        </p>
    </div>
</div>

<div style="max-width: 1000px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <!-- Main Content -->
        <div>
            @if ($program->image_path)
                <div style="margin-bottom: 2rem; border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $program->image_path) }}" alt="{{ $program->program_name }}" style="width: 100%; height: auto; display: block;">
                </div>
            @endif

            <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; color: #333;">Program Description</h2>
                <div style="line-height: 1.8; color: #555; font-size: 1rem;">
                    {!! nl2br(e($program->description)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
                    <i class="fas fa-info-circle"></i> Quick Info
                </h3>

                <div style="margin: 1.5rem 0 0 0;">
                    <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #667eea; font-size: 0.9rem;">Category</p>
                    <p style="margin: 0 0 1.5rem 0; color: #333;">{{ $program->category }}</p>

                    @if ($program->target_beneficiaries)
                        <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #667eea; font-size: 0.9rem;">Target Beneficiaries</p>
                        <p style="margin: 0 0 1.5rem 0; color: #333; line-height: 1.6;">
                            {!! nl2br(e($program->target_beneficiaries)) !!}
                        </p>
                    @endif

                    <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #667eea; font-size: 0.9rem;">Created</p>
                    <p style="margin: 0; color: #999; font-size: 0.9rem;">{{ $program->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding: 2rem 0;">
        <a href="{{ route('programs.index') }}" class="button" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Programs
        </a>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }

        div[style*="position: sticky"] {
            position: static !important;
        }
    }
</style>
@endsection
