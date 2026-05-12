@extends('layouts.layout')

@section('title', 'Accomplishment Reports - Gender and Development Services')

@section('content')
<div class="container" style="margin-top: 100px; padding: 2rem;">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Page Title -->
            <div style="margin-bottom: 3rem;">
                <h1 style="color: #333; font-size: 2rem; margin-bottom: 0.5rem;">
                    <i class="fas fa-chart-bar" style="color: #8f1eae;"></i> Accomplishment Reports
                </h1>
                <p style="color: #666; font-size: 1rem;">Gender and Development accomplishments segregated by college and gender</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Filter and Results Section -->
            <div style="background-color: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 3rem;">
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: flex-start;">
            <!-- Filter Section -->
            <div>
                <h5 style="color: #333; font-weight: 600; margin-bottom: 1.5rem;">
                    <i class="fas fa-filter"></i> Filter Reports
                </h5>
                <form method="GET" action="{{ route('accomplishment-report') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                    <div style="flex: 1; min-width: 250px;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 0.5rem;">College</label>
                        <select name="college" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                            <option value="">-- All Colleges --</option>
                            @foreach($collegeNames as $college)
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

            <!-- Summary Statistics Cards (Results) -->
            @if($reports->count() > 0)
                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem; min-width: 350px;">
                    <div style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center; color: white;">
                        <h6 style="color: rgba(255,255,255,0.9); font-size: 0.85rem; margin-bottom: 0.5rem;">Total Reports</h6>
                        <h3 style="color: white; font-size: 2rem; margin: 0;">{{ $reports->total() }}</h3>
                    </div>

                    <div style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center; color: white;">
                        <h6 style="color: rgba(255,255,255,0.9); font-size: 0.85rem; margin-bottom: 0.5rem;">Total Participants</h6>
                        <h3 style="color: white; font-size: 2rem; margin: 0;">{{ $reports->sum('participants_count') }}</h3>
                    </div>

                    <div style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center; color: white;">
                        <h6 style="color: rgba(255,255,255,0.9); font-size: 0.85rem; margin-bottom: 0.5rem;">Showing</h6>
                        <h3 style="color: white; font-size: 2rem; margin: 0;">{{ $reports->count() }}</h3>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <!-- Include Enhanced Sex-Disaggregated Data Visualization Section -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            @include('partials.sex-disaggregated-data-visualization')
        </div>
    </div>

    <!-- Include Enhanced Staff Sex-Disaggregated Data Visualization Section -->
    @if(isset($staffTotalByGender) && ($staffTotalByGender['Male'] > 0 || $staffTotalByGender['Female'] > 0))
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                @include('partials.staff-sex-disaggregated-data-visualization')
            </div>
        </div>
    @endif

    <!-- Reports by College Section -->
    @if($reports->count() > 0)
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9" style="margin-bottom: 3rem;">
            @foreach($collegeNames as $collegeName)
                @if($reportsByCollege->has($collegeName))
                    @php
                        $collegeReports = $reportsByCollege[$collegeName];
                        $maleCount = $collegeReports->where('gender', 'male')->count();
                        $femaleCount = $collegeReports->where('gender', 'female')->count();
                        $coordinator = $coordinators[$collegeName] ?? null;
                    @endphp
                    
                    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; overflow: hidden;">
                        <!-- College Header -->
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem;">
                            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.4rem;">
                                <i class="fas fa-university"></i> {{ $collegeName }}
                            </h3>
                        </div>

                        <!-- College Stats and Coordinator -->
                        <div style="padding: 1.5rem; border-bottom: 1px solid #eee;">
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                                <!-- Enrollment Statistics -->
                                @if($enrollmentByCollege->has($collegeName))
                                    @php $enrollment = $enrollmentByCollege[$collegeName]; @endphp
                                    <div>
                                        <h5 style="color: #333; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">
                                            <i class="fas fa-graduation-cap"></i> Student Enrollment
                                        </h5>
                                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                                            <div style="flex: 1; padding: 1rem; background: #e3f2fd; border-radius: 6px; text-align: center;">
                                                <p style="margin: 0; color: #1976d2; font-weight: 600; font-size: 0.9rem;">Male</p>
                                                <p style="margin: 0.5rem 0 0 0; color: #1976d2; font-size: 1.8rem; font-weight: bold;">{{ number_format($enrollment['male_count']) }}</p>
                                                <p style="margin: 0.25rem 0 0 0; color: #1976d2; font-size: 0.85rem;">{{ round($enrollment['male_percentage'], 1) }}%</p>
                                            </div>
                                            <div style="flex: 1; padding: 1rem; background: #fce4ec; border-radius: 6px; text-align: center;">
                                                <p style="margin: 0; color: #c2185b; font-weight: 600; font-size: 0.9rem;">Female</p>
                                                <p style="margin: 0.5rem 0 0 0; color: #c2185b; font-size: 1.8rem; font-weight: bold;">{{ number_format($enrollment['female_count']) }}</p>
                                                <p style="margin: 0.25rem 0 0 0; color: #c2185b; font-size: 0.85rem;">{{ round($enrollment['female_percentage'], 1) }}%</p>
                                            </div>
                                        </div>
                                        <div style="padding: 0.75rem; background: #f5f5f5; border-radius: 4px; text-align: center;">
                                            <p style="margin: 0; color: #666; font-weight: 600; font-size: 0.9rem;">Total: <span style="font-size: 1.1rem;">{{ number_format($enrollment['total_count']) }}</span></p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Gender Statistics -->
                                <div>
                                    <h5 style="color: #333; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">
                                        <i class="fas fa-chart-pie"></i> Report Distribution
                                    </h5>
                                    <div style="display: flex; gap: 1rem;">
                                        <div style="flex: 1; padding: 1rem; background: #e3f2fd; border-radius: 6px; text-align: center;">
                                            <p style="margin: 0; color: #1976d2; font-weight: 600; font-size: 0.9rem;">Male</p>
                                            <p style="margin: 0.5rem 0 0 0; color: #1976d2; font-size: 1.8rem; font-weight: bold;">{{ $maleCount }}</p>
                                        </div>
                                        <div style="flex: 1; padding: 1rem; background: #fce4ec; border-radius: 6px; text-align: center;">
                                            <p style="margin: 0; color: #c2185b; font-weight: 600; font-size: 0.9rem;">Female</p>
                                            <p style="margin: 0.5rem 0 0 0; color: #c2185b; font-size: 1.8rem; font-weight: bold;">{{ $femaleCount }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- GAD Coordinator -->
                                <div>
                                    <h5 style="color: #333; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">
                                        <i class="fas fa-user-tie"></i> GAD Coordinator
                                    </h5>
                                    @if($coordinator && $coordinator->gadCoordinator)
                                        @php $coord = $coordinator->gadCoordinator; @endphp
                                        <div style="background: #f8f9ff; padding: 1rem; border-radius: 6px; border-left: 4px solid #667eea;">
                                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                                @if($coord->photo)
                                                    <img src="{{ $coord->getPhotoUrl() }}" alt="{{ $coord->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                                @else
                                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                        <i class="fas fa-user" style="color: #999; font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                                <div style="flex-grow: 1; min-width: 0;">
                                                    <p style="margin: 0 0 0.25rem 0; color: #333; font-weight: 600;">{{ $coord->name }}</p>
                                                    @if($coord->email)
                                                        <p style="margin: 0 0 0.25rem 0; color: #667eea; font-size: 0.9rem;">
                                                            <a href="mailto:{{ $coord->email }}" style="color: #667eea; text-decoration: none;">
                                                                <i class="fas fa-envelope"></i> {{ $coord->email }}
                                                            </a>
                                                        </p>
                                                    @endif
                                                    @if($coord->contact_number)
                                                        <p style="margin: 0; color: #667eea; font-size: 0.9rem;">
                                                            <a href="tel:{{ $coord->contact_number }}" style="color: #667eea; text-decoration: none;">
                                                                <i class="fas fa-phone"></i> {{ $coord->contact_number }}
                                                            </a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div style="background: #f5f5f5; padding: 1rem; border-radius: 6px; border-left: 4px solid #ccc; text-align: center;">
                                            <p style="margin: 0; color: #999; font-size: 0.95rem;">
                                                <i class="fas fa-info-circle"></i> No coordinator assigned
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Reports for this College -->
                        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                                <thead>
                                    <tr style="background-color: #f9f9f9; border-bottom: 1px solid #eee;">
                                        <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600; width: 100px;">Gender</th>
                                        <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600; width: auto; min-width: 400px;">Title</th>
                                        <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600; width: 80px;">Year</th>
                                        <th style="padding: 1rem; text-align: center; color: #333; font-weight: 600; width: 120px;">Participants</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collegeReports as $report)
                                        <tr style="border-bottom: 1px solid #eee; transition: background-color 0.3s ease;">
                                            <td style="padding: 1rem; vertical-align: top;">
                                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; {{ $report->gender === 'male' ? 'background-color: #e3f2fd; color: #1976d2;' : 'background-color: #fce4ec; color: #c2185b;' }}">
                                                    {{ ucfirst($report->gender) }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem; color: #333; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">
                                                <strong>{{ $report->title }}</strong><br>
                                                <small style="color: #999; display: block; margin-top: 0.25rem;">{{ Str::limit($report->content, 100) }}</small>
                                            </td>
                                            <td style="padding: 1rem; text-align: center; color: #333; vertical-align: top; white-space: nowrap;">{{ $report->year }}</td>
                                            <td style="padding: 1rem; text-align: center; vertical-align: top;">
                                                <span style="background-color: #f0f0f0; padding: 0.5rem 1rem; border-radius: 4px; color: #333; font-weight: 600; display: inline-block;">
                                                    {{ $report->participants_count }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div style="padding: 1.5rem; text-align: center; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        {{ $reports->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div style="background: #fff; padding: 2rem; text-align: center; color: #999; border-radius: 8px;">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                    No accomplishment reports found matching your filters.
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    table tbody tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 1024px) {
        div[style*="display: grid; grid-template-columns: 1fr auto"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="min-width: 350px"] {
            min-width: 100% !important;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem !important;
        }

        h1 {
            font-size: 1.5rem !important;
        }

        h3 {
            font-size: 1.1rem !important;
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

        div[style*="display: flex; align-items: flex-start"] {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
</style>
@endsection
