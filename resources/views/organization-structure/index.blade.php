@extends('layouts.layout')

@section('title', 'Organizational Structure - Gender and Development Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <h1 style="margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-sitemap"></i> Organizational Structure
        </h1>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">Meet our dedicated team members</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    @foreach ($groupedMembers as $roleGroup => $members)
        <div style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.8rem; color: #667eea; margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 2px solid #667eea;">
                {{ $roleGroup }}
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @foreach ($members as $member)
                    <div class="member-card" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        @if ($member->image_path)
                            <div style="width: 100%; height: 250px; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; opacity: 0.3;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif

                        <div style="padding: 1.5rem;">
                            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.2rem; color: #333;">{{ $member->name }}</h3>
                            <p style="margin: 0 0 1rem 0; color: #667eea; font-weight: 600; font-size: 0.95rem;">{{ $member->position }}</p>
                            
                            @if ($member->bio)
                                <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.5;">{{ $member->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    @if ($groupedMembers->isEmpty())
        <div style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-users" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #999; font-size: 1.1rem;">No organization members available.</p>
        </div>
    @endif
</div>

<style>
    .member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        h2 {
            font-size: 1.4rem !important;
        }

        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
