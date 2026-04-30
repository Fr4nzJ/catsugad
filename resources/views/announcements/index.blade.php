@extends('layouts.layout')

@section('title', 'News & Announcements - Gender and Development Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <h1 style="margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-bullhorn"></i> News & Announcements
        </h1>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">Stay updated with the latest news from our office</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    @if ($announcements->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            @foreach ($announcements as $announcement)
                <div class="card" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; height: 100%; display: flex; flex-direction: column; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                    @if ($announcement->image_path)
                        <div style="width: 100%; height: 200px; overflow: hidden; background-color: #f0f0f0;">
                            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endif
                    
                    <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <p style="margin: 0 0 0.5rem 0; color: #667eea; font-size: 0.9rem; font-weight: 600;">
                            <i class="fas fa-calendar-alt"></i> {{ $announcement->published_at->format('F d, Y') }}
                        </p>
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.3rem; color: #333;">{{ $announcement->title }}</h3>
                        <p style="margin: 0 0 1.5rem 0; color: #666; font-size: 0.95rem; line-height: 1.6; flex-grow: 1;">
                            {{ $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 150) }}
                        </p>
                        <a href="{{ route('announcements.show', $announcement->slug) }}" style="display: inline-block; color: #667eea; text-decoration: none; font-weight: 600; transition: color 0.3s ease;">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: center; margin-top: 3rem;">
            {{ $announcements->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #999; font-size: 1.1rem;">No announcements available at this time.</p>
        </div>
    @endif

</div>

<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    a:hover {
        color: #764ba2 !important;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
