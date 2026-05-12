@extends('layouts.layout')

@section('title', 'About - Gender and Development Services')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <h1 style="color: #333; font-size: 2.5rem; margin-bottom: 2rem; text-align: center;">
                <i class="fas fa-info-circle" style="color: #667eea; margin-right: 0.5rem;"></i> About Us
            </h1>
            <p style="color: #666; font-size: 1.1rem; text-align: center; margin-bottom: 3rem;">
                Gender and Development Services at Catanduanes State University
            </p>

            @forelse($aboutSections as $section)
                <div style="background: white; border-radius: 8px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-left: 4px solid #667eea;">
                    <h2 style="color: #333; font-size: 1.8rem; margin-bottom: 1rem;">
                        <i class="fas fa-chevron-right" style="color: #667eea; margin-right: 0.5rem;"></i> {{ $section->title }}
                    </h2>
                    <div style="color: #666; font-size: 1.05rem; line-height: 1.8;">
                        {!! nl2br(e($section->content)) !!}
                    </div>
                </div>
            @empty
                <div style="background: #fff; padding: 2rem; text-align: center; color: #999; border-radius: 8px;">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                    <p>No content available at this moment. Please check back later.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
