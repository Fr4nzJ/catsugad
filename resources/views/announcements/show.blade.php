@extends('layouts.layout')

@section('title', $announcement->title . ' - News & Announcements')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <a href="{{ route('announcements.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; margin-bottom: 1rem; display: inline-block; transition: color 0.3s;">
            <i class="fas fa-arrow-left"></i> Back to Announcements
        </a>
        <h1 style="margin: 1rem 0 0 0; font-size: 2.5rem;">{{ $announcement->title }}</h1>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.95;">
            <i class="fas fa-calendar-alt"></i> Published on {{ $announcement->published_at->format('F d, Y \a\t h:i A') }}
        </p>
    </div>
</div>

<div style="max-width: 900px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    @if ($announcement->image_path)
        <div style="margin-bottom: 2rem; border-radius: 8px; overflow: hidden;">
            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}" style="width: 100%; height: auto; display: block; max-height: 500px; object-fit: cover;">
        </div>
    @endif

    <article style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.8; color: #333; font-size: 1.05rem;">
        @if ($announcement->excerpt)
            <p style="font-style: italic; font-size: 1.1rem; color: #667eea; margin-bottom: 1.5rem; padding: 1rem; background-color: #f8f9ff; border-left: 4px solid #667eea; border-radius: 4px;">
                {{ $announcement->excerpt }}
            </p>
        @endif
        
        <div style="color: #444; word-wrap: break-word;">
            {!! nl2br(e($announcement->content)) !!}
        </div>
    </article>

    @if ($relatedAnnouncements->count() > 0)
        <div style="margin-top: 4rem; padding-top: 3rem; border-top: 2px solid #e0e0e0;">
            <h3 style="font-size: 1.5rem; margin-bottom: 2rem; color: #333;">
                <i class="fas fa-newspaper"></i> Related Announcements
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                @foreach ($relatedAnnouncements as $related)
                    <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.1)'">
                        @if ($related->image_path)
                            <div style="width: 100%; height: 150px; overflow: hidden; background-color: #f0f0f0;">
                                <img src="{{ asset('storage/' . $related->image_path) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                        
                        <div style="padding: 1.25rem; background: white;">
                            <p style="margin: 0 0 0.5rem 0; color: #999; font-size: 0.85rem;">
                                <i class="fas fa-calendar-alt"></i> {{ $related->published_at->format('M d, Y') }}
                            </p>
                            <h4 style="margin: 0 0 0.75rem 0; font-size: 1.05rem; color: #333;">{{ $related->title }}</h4>
                            <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.9rem; line-height: 1.5;">
                                {{ Str::limit($related->excerpt ?? strip_tags($related->content), 80) }}
                            </p>
                            <a href="{{ route('announcements.show', $related->slug) }}" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd; text-align: center;">
        <a href="{{ route('announcements.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer; transition: opacity 0.3s;">
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

        div[style*="max-width: 900px"] {
            padding: 0 0.5rem !important;
        }
    }

    a:hover {
        opacity: 0.85 !important;
    }
</style>
@endsection
