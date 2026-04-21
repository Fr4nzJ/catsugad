@extends('layouts.layout')

@section('title', 'Accomplishment Reports - Gender and Development Services')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <!-- Page Title -->
    <div style="margin-bottom: 3rem;">
        <h1 style="color: #333; font-size: 2rem; margin-bottom: 0.5rem;">
            <i class="fas fa-chart-bar" style="color: #8f1eae;"></i> Accomplishment Reports
        </h1>
        <p style="color: #666; font-size: 1rem;">Gender and Development accomplishments segregated by college and gender</p>
    </div>

    <!-- Filter Section -->
    <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 3rem;">
        <h5 style="color: #333; font-weight: 600; margin-bottom: 1.5rem;">
            <i class="fas fa-filter"></i> Filter Reports
        </h5>
        <form method="GET" action="{{ route('accomplishment-report') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; color: #333; font-weight: 600; margin-bottom: 0.5rem;">College</label>
                <select name="college" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">-- All Colleges --</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college }}" {{ request('college') === $college ? 'selected' : '' }}>
                            {{ $college }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; color: #333; font-weight: 600; margin-bottom: 0.5rem;">Gender</label>
                <select name="gender" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">-- All Genders --</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 200px; display: flex; gap: 0.5rem;">
                <button type="submit" style="flex: 1; background: linear-gradient(to right, #ff0191, rgb(0, 64, 255)); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Filter
                </button>
                @if(request('college') || request('gender'))
                    <a href="{{ route('accomplishment-report') }}" style="flex: 1; background-color: #f5f5f5; color: #333; border: 1px solid #ddd; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 600; text-decoration: none; text-align: center;">
                        <i class="fas fa-refresh"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary Statistics Cards -->
    @if($reports->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; border-top: 4px solid #3498db;">
                <h6 style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Reports</h6>
                <h3 style="color: #333; font-size: 2.5rem; margin: 0;">{{ $reports->total() }}</h3>
            </div>

            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; border-top: 4px solid #3498db;">
                <h6 style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Participants</h6>
                <h3 style="color: #333; font-size: 2.5rem; margin: 0;">{{ $reports->sum('participants_count') }}</h3>
            </div>

            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; border-top: 4px solid #2ecc71;">
                <h6 style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Showing</h6>
                <h3 style="color: #333; font-size: 2.5rem; margin: 0;">{{ $reports->count() }}</h3>
            </div>
        </div>
    @endif

    <!-- Reports Table -->
    <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #eee;">
            <h5 style="color: #333; margin: 0;">
                <i class="fas fa-list"></i> Detailed Report
            </h5>
        </div>

        @if($reports->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f9f9f9; border-bottom: 2px solid #eee;">
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">College</th>
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Gender</th>
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Title</th>
                            <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600;">Year</th>
                            <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600;">Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr style="border-bottom: 1px solid #eee; transition: background-color 0.3s ease;">
                                <td style="padding: 1rem; color: #333;">{{ $report->college }}</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; {{ $report->gender === 'male' ? 'background-color: #e3f2fd; color: #1976d2;' : 'background-color: #fce4ec; color: #c2185b;' }}">
                                        {{ ucfirst($report->gender) }}
                                    </span>
                                </td>
                                <td style="padding: 1rem; color: #333;">
                                    <strong>{{ $report->title }}</strong><br>
                                    <small style="color: #999;">{{ Str::limit($report->content, 60) }}</small>
                                </td>
                                <td style="padding: 1rem; text-align: center; color: #333;">{{ $report->year }}</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span style="background-color: #f0f0f0; padding: 0.5rem 1rem; border-radius: 4px; color: #333; font-weight: 600;">
                                        {{ $report->participants_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
                <div style="padding: 1.5rem; text-align: center; border-top: 1px solid #eee;">
                    {{ $reports->links('pagination::simple-bootstrap-4') }}
                </div>
            @endif
        @else
            <div style="padding: 2rem; text-align: center; color: #999;">
                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                No accomplishment reports found matching your filters.
            </div>
        @endif
    </div>
</div>

<style>
    tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem !important;
        }

        h1 {
            font-size: 1.5rem !important;
        }

        div[style*="grid"] {
            grid-template-columns: 1fr !important;
        }

        table {
            font-size: 0.9rem;
        }

        td, th {
            padding: 0.75rem !important;
        }
    }
</style>
@endsection
