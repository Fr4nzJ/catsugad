@extends('layouts.layout')

@section('title', 'Programs & Services - Gender and Development Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <h1 style="margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-project-diagram"></i> Programs & Services
        </h1>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">Discover our initiatives and services</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    <!-- Search and Filter Section -->
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <form method="GET" action="{{ route('programs.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Search Programs</label>
                <input type="text" name="search" placeholder="Enter program name or keywords..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Filter by Category</label>
                <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('programs.index') }}" style="background: #e0e0e0; color: #333; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 4px; display: inline-block; font-weight: 600;">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Programs Grid -->
    @if ($programs->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            @foreach ($programs as $program)
                <div class="program-card" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; height: 100%;">
                    @if ($program->image_path)
                        <div style="width: 100%; height: 200px; overflow: hidden; background-color: #f0f0f0;">
                            <img src="{{ asset('storage/' . $program->image_path) }}" alt="{{ $program->program_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    @endif

                    <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <span class="tag" style="display: inline-block; background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.85rem; margin-bottom: 0.75rem; width: fit-content;">{{ $program->category }}</span>
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.2rem; color: #333;">{{ $program->program_name }}</h3>
                        <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.95rem; line-height: 1.6; flex-grow: 1;">
                            {{ Str::limit($program->description, 100) }}
                        </p>
                        <a href="{{ route('programs.show', $program) }}" style="display: inline-block; color: #667eea; text-decoration: none; font-weight: 600; transition: color 0.3s ease;">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: center; margin-top: 3rem;">
            {{ $programs->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 8px;">
            <i class="fas fa-search" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #999; font-size: 1.1rem;">No programs found matching your search criteria.</p>
            <a href="{{ route('programs.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Clear filters</a>
        </div>
    @endif
</div>

<style>
    .program-card:hover {
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

        div[style*="display: flex"][style*="flex-wrap"] {
            flex-direction: column !important;
        }

        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
