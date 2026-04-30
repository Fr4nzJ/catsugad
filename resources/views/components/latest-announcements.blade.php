@php
    $announcements = \App\Models\Announcement::published()
                                            ->latest()
                                            ->limit(5)
                                            ->get();
@endphp

@if ($announcements->count() > 0)
<section style="background-color: #f8f9ff; padding: 3rem 1rem; margin: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="font-size: 2rem; margin: 0 0 0.5rem 0; color: #333;">
                <i class="fas fa-bullhorn"></i> Latest News & Announcements
            </h2>
            <p style="color: #666; margin: 0;">Stay informed with our latest updates and announcements</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            @foreach ($announcements as $announcement)
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; height: 100%; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                    @if ($announcement->image_path)
                        <div style="width: 100%; height: 180px; overflow: hidden; background-color: #f0f0f0;">
                            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endif
                    
                    <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <p style="margin: 0 0 0.75rem 0; color: #999; font-size: 0.85rem;">
                            <i class="fas fa-calendar-alt"></i> {{ $announcement->published_at->format('M d, Y') }}
                        </p>
                        
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.15rem; color: #333; line-height: 1.4;">
                            {{ Str::limit($announcement->title, 50) }}
                        </h3>
                        
                        <p style="margin: 0 0 1.5rem 0; color: #666; font-size: 0.95rem; line-height: 1.5; flex-grow: 1;">
                            {{ $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 100) }}
                        </p>
                        
                        <a href="{{ route('announcements.show', $announcement->slug) }}" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: color 0.3s;">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('announcements.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 2.5rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block; font-weight: 600; transition: opacity 0.3s;">
                View All Announcements <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<style>
    a:hover {
        opacity: 0.85 !important;
    }

    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem !important;
        }
    }
</style>
