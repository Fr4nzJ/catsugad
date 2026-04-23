@extends('layouts.layout')

@section('title', 'Reports & Documents - Gender and Development Services')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; text-align: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <h1 style="margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-file-pdf"></i> Reports & Documents
        </h1>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">Access important documents and reports</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; margin-bottom: 4rem;">
    <!-- Filter Section -->
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <form method="GET" action="{{ route('documents.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Filter by Category</label>
                <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Filter by Year</label>
                <select name="year" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">All Years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('documents.index') }}" style="background: #e0e0e0; color: #333; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 4px; display: inline-block; font-weight: 600;">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Documents List -->
    @if ($documents->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 3rem;">
            @foreach ($documents as $document)
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div style="flex-shrink: 0; width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-file-pdf"></i>
                    </div>

                    <div style="flex-grow: 1;">
                        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: #333;">{{ $document->title }}</h3>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                            <span class="tag" style="display: inline-block; background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.85rem;">
                                {{ $document->category }}
                            </span>
                            @if ($document->year)
                                <span style="display: inline-block; background: #f0f0f0; color: #666; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.85rem;">
                                    <i class="fas fa-calendar"></i> {{ $document->year }}
                                </span>
                            @endif
                            <span style="display: inline-block; background: #f0f0f0; color: #666; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.85rem;">
                                <i class="fas fa-download"></i> {{ $document->download_count }}
                            </span>
                        </div>
                        @if ($document->description)
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">{{ Str::limit($document->description, 100) }}</p>
                        @endif
                    </div>

                    <div style="flex-shrink: 0;">
                        <a href="{{ route('documents.download', $document) }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; display: inline-block; font-weight: 600; transition: transform 0.2s ease;">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: center;">
            {{ $documents->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 8px;">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #999; font-size: 1.1rem;">No documents found matching your filters.</p>
            <a href="{{ route('documents.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Clear filters</a>
        </div>
    @endif
</div>

<style>
    div[style*="display: flex"][style*="align-items: center"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    a[style*="background: linear-gradient"]:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem !important;
        }

        div[style*="display: flex"][style*="flex-wrap"] {
            flex-direction: column !important;
        }

        div[style*="display: flex"][style*="align-items: center"] {
            flex-direction: column !important;
            text-align: center;
        }

        div[style*="flex-grow: 1"] {
            width: 100% !important;
        }
    }
</style>
@endsection
