@extends('layouts.layout')

@section('title', $announcement->title . ' - News & Announcements')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <a href="{{ route('announcements.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; margin-bottom: 1rem; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Back to Announcements
        </a>
        <h1 style="margin: 1rem 0 0 0; font-size: 2.5rem;">{{ $announcement->title }}</h1>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.95;">
            <i class="fas fa-calendar-alt"></i> Published on {{ $announcement->published_at->format('F d, Y \a\t h:i A') }}
        </p>
    </div>
</div>

<div style="max-width: 800px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    @if ($announcement->image_path)
        <div style="margin-bottom: 2rem; border-radius: 8px; overflow: hidden;">
            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}" style="width: 100%; height: auto; display: block;">
        </div>
    @endif

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.8; color: #333; font-size: 1rem;">
        {!! nl2br(e($announcement->content)) !!}
    </div>

    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd; text-align: center;">
        <a href="{{ route('announcements.index') }}" class="button is-info" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer;">
            <i class="fas fa-arrow-left"></i> Back to Announcements
        </a>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        div[style*="padding: 2rem"] {
            padding: 1.5rem !important;
        }
    }
</style>
@endsection
