@extends('layouts.layout')

@section('title', $aboutSection->title . ' - About')

@section('content')
<div style="margin-top: 65px; padding: 2rem;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8">
                <!-- About Section Header -->
                <div style="margin-bottom: 2rem;">
                    <h1 class="title is-1" style="color: #8f1eae;">
                        <i class="{{ $aboutSection->icon }}" style="margin-right: 0.5rem;"></i>
                        {{ $aboutSection->title }}
                    </h1>
                    <div class="divider" style="background-color: #8f1eae; height: 3px; margin: 1rem 0;"></div>
                </div>

                <!-- About Section Content -->
                <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                    {!! nl2br(e($aboutSection->content)) !!}
                </div>

                <!-- Navigation Links -->
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd;">
                    <div class="columns is-multiline">
                        @forelse($aboutSections as $section)
                            <div class="column is-full-mobile is-half-tablet is-one-third-desktop">
                                <a href="{{ route($section->route) }}" 
                                   class="box has-background-light" 
                                   style="text-decoration: none; transition: all 0.3s ease; display: block; height: 100%;"
                                   onmouseover="this.style.backgroundColor='#f3e5f5'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'"
                                   onmouseout="this.style.backgroundColor='#f5f5f5'; this.style.boxShadow=''">
                                    <p style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <i class="{{ $section->icon }}" style="color: #8f1eae; font-size: 1.3rem;"></i>
                                        <strong style="color: #333;">{{ $section->title }}</strong>
                                    </p>
                                    <small style="color: #666;">{{ Str::limit($section->content, 80) }}</small>
                                </a>
                            </div>
                        @empty
                            <div class="column is-full">
                                <p class="notification is-info">No other sections available.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Back Button -->
                <div style="margin-top: 2rem;">
                    <a href="{{ route('about') }}" class="button" style="background-color: #8f1eae; color: white; border: none;">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Back to About</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
