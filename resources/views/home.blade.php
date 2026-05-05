@extends('layouts.layout')
@section('title', 'Gender and Development Services - Home')
@section('content')
    <style>
        .gad-impact-section {
            background-color: #f9f9f9;
            padding: 4rem 1rem;
        }
        .gad-impact-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .gad-impact-header h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .gad-impact-header p {
            font-size: 1rem;
            color: #666;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .kpi-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .kpi-card.blue {
            border-top: 4px solid #3498db;
        }
        .kpi-card.green {
            border-top: 4px solid #2ecc71;
        }
        .kpi-card.orange {
            border-top: 4px solid #e67e22;
        }
        .kpi-card.red {
            border-top: 4px solid #e74c3c;
        }
        .kpi-icon {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 1rem;
        }
        .kpi-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .kpi-label {
            font-size: 1rem;
            color: #666;
            margin-top: 0.5rem;
        }
        .chart-container {
            position: relative;
            width: 100%;
            height: 400px;
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .hero-button-programs,
        .hero-button-contact {
            background: rgba(63, 124, 255, 0.7);
            color: #fff;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-size: 1.25rem;
            border: 2px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
            margin-right: 1rem;
        }
        .hero-button-programs:hover,
        .hero-button-contact:hover {
            background: rgba(235, 23, 217, 0.7);
            transform: scale(1.05);
            color: #fff;
        }
        .hero-content {
            text-align: center;
            padding: 4rem 1rem;
            background-color: #f5f5f5;
        }
        .hero-content h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .hero-content .subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 2rem;
        }
        .main-banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
            display: block;
            margin: 2rem auto;
        }
        .icon-text .icon {
            margin-right: 5px;
        }
    </style>
    <div class="hero-content">
        <h1>Empowering Communities Through Gender Equality</h1>
        <p class="subtitle">Building Inclusive Communities for Sustainable Development</p>
        <div class="buttons is-centered mt-6">
            <a class="hero-button-programs" href="{{ route('programs-services') }}">
                <span class="icon"><i class="fas fa-chart-bar"></i></span>
                <span>Our Programs</span>
            </a>
            <a class="hero-button-contact" href="{{ route('contact') }}">
                <span class="icon"><i class="fas fa-paper-plane"></i></span>
                <span>Get Involved</span>
            </a>
        </div>
    </div>
    <div class="main-banner">
        @if ($banner)
            <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->name }}">
        @else
            <img src="{{ asset('images/sliders/4ft x 11ft Streamer.png') }}" alt="Main Banner">
        @endif
    </div>
    <div class="gad-impact-section">
        <div class="gad-impact-header">
            <h2>Key GAD Impact Statistics</h2>
            <p>Measurable outcomes from our 2024 initiatives</p>
        </div>

        <div class="kpi-grid">
            @forelse($statistics as $stat)
                <div class="kpi-card {{ $stat->color ?? 'blue' }}">
                    @if($stat->icon)
                        <div class="kpi-icon"><i class="{{ $stat->icon }}"></i></div>
                    @endif
                    <div class="kpi-number">{{ $stat->value }}</div>
                    <div class="kpi-label">{{ $stat->label }}</div>
                    @if($stat->description)
                        <p style="color: #999; font-size: 0.85rem; margin-top: 0.5rem;">{{ $stat->description }}</p>
                    @endif
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">
                    <p style="color: #999;">Key performance indicators will be available soon.</p>
                </div>
            @endforelse
        </div>

        <div class="columns mt-6 is-multiline">
            @if($growthChart->count() > 0)
                <div class="column is-full-mobile is-6-tablet is-6-desktop">
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; color: #2c3e50; font-weight: 600;">
                            Annual Participation Growth
                        </h3>
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            @endif
            @if($distributionChart->count() > 0)
                <div class="column is-full-mobile is-6-tablet is-6-desktop">
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; color: #2c3e50; font-weight: 600;">
                            Program Distribution by Category
                        </h3>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

    <script>
        @if($growthChart->count() > 0)

            @php
                $growthFirst = $growthChart->first();
            @endphp

            const growthCtx = document.getElementById('growthChart').getContext('2d');

            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: @json($growthFirst->labels),
                    datasets: [{
                        label: '{{ $growthFirst->name ?? "Participation Growth" }}',
                        data: @json($growthFirst->data),
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

        @endif

        @if($distributionChart->count() > 0)

            @php
                $distributionFirst = $distributionChart->first();
            @endphp

            const categoryCtx = document.getElementById('categoryChart').getContext('2d');

            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($distributionFirst->labels),
                    datasets: [{
                        data: @json($distributionFirst->data),
                        backgroundColor: [
                            '#667eea',
                            '#764ba2',
                            '#f093fb',
                            '#4facfe',
                            '#00f2fe',
                            '#43e97b',
                            '#fa709a',
                            '#fee140',
                            '#30b0fe',
                            '#a8edea'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

        @endif
    </script>

    <!-- NEW: Latest Announcements Section -->
    <div style="background-color: #fff; padding: 4rem 1rem; margin: 2rem 0;">
        <div class="container">
            <h2 style="font-size: 2rem; color: #333; margin-bottom: 0.5rem; text-align: center;">
                <i class="fas fa-bullhorn" style="color: #e67e22; margin-right: 0.5rem;"></i>Latest News & Announcements
            </h2>
            <p style="text-align: center; color: #666; margin-bottom: 3rem;">Stay updated with our latest announcements and news</p>

            @if($latestAnnouncements->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($latestAnnouncements as $announcement)
                        <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            @if($announcement->image_path)
                                <img src="{{ asset($announcement->image_path) }}" alt="{{ $announcement->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            <div style="padding: 1.5rem;">
                                <p style="color: #999; font-size: 0.85rem; margin: 0 0 0.5rem 0;">
                                    <i class="fas fa-calendar"></i> {{ $announcement->published_at?->format('M d, Y') ?? 'Not published' }}
                                </p>
                                <h4 style="color: #333; margin: 0.5rem 0; font-size: 1.1rem; font-weight: 600;">{{ $announcement->title }}</h4>
                                <p style="color: #666; margin: 0.5rem 0 1rem 0; font-size: 0.95rem;">{{ $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 100) }}</p>
                                <a href="{{ route('announcements.show', $announcement->slug) }}" style="color: #667eea; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('announcements.index') }}" style="background: linear-gradient(to right, #667eea, #764ba2); color: white; padding: 0.75rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block;">
                        View All Announcements <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                    </a>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; background: #f9f9f9; border-radius: 8px;">
                    <i class="fas fa-newspaper" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #999;">No announcements yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- NEW: Latest Programs & Services Section -->
    <div style="background-color: #f9f9f9; padding: 4rem 1rem; margin: 2rem 0;">
        <div class="container">
            <h2 style="font-size: 2rem; color: #333; margin-bottom: 0.5rem; text-align: center;">
                <i class="fas fa-briefcase" style="color: #3498db; margin-right: 0.5rem;"></i>Our Programs & Services
            </h2>
            <p style="text-align: center; color: #666; margin-bottom: 3rem;">Explore our key initiatives and programs</p>

            @if($latestPrograms->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($latestPrograms as $program)
                        <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;">
                            @if($program->image_path)
                                <img src="{{ asset($program->image_path) }}" alt="{{ $program->program_name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                            @endif
                            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                                @if($program->category)
                                    <span style="background: #3498db; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; display: inline-block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; width: fit-content;">{{ $program->category }}</span>
                                @endif
                                <h4 style="color: #333; margin: 0.5rem 0; font-size: 1.1rem; font-weight: 600;">{{ $program->program_name }}</h4>
                                <p style="color: #666; margin: 0.5rem 0 1rem 0; font-size: 0.95rem; flex-grow: 1;">{{ Str::limit($program->description, 120) }}</p>
                                @if($program->target_beneficiaries)
                                    <p style="color: #999; font-size: 0.85rem; margin: 0.5rem 0;"><i class="fas fa-users"></i> {{ $program->target_beneficiaries }}</p>
                                @endif
                                <a href="{{ route('programs-services') }}" style="color: #3498db; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                                    Learn More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('programs-services') }}" style="background: linear-gradient(to right, #3498db, #2980b9); color: white; padding: 0.75rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block;">
                        View All Programs <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                    </a>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; background: #fff; border-radius: 8px;">
                    <i class="fas fa-briefcase" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #999;">No programs available yet. Stay tuned!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- NEW: Latest Accomplishment Reports Section -->
    <div style="background-color: #fff; padding: 4rem 1rem; margin: 2rem 0;">
        <div class="container">
            <h2 style="font-size: 2rem; color: #333; margin-bottom: 0.5rem; text-align: center;">
                <i class="fas fa-trophy" style="color: #f39c12; margin-right: 0.5rem;"></i>Latest Accomplishments
            </h2>
            <p style="text-align: center; color: #666; margin-bottom: 3rem;">Celebrating our impact and achievements</p>

            @if($latestAccomplishments->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($latestAccomplishments as $report)
                        <div style="background: #fff; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #f39c12; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                                <span style="background: #f39c12; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $report->year ?? date('Y') }}</span>
                                @if($report->gender)
                                    <span style="background: {{ $report->gender == 'male' ? '#3498db' : '#e74c3c' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        {{ ucfirst($report->gender) }}
                                    </span>
                                @endif
                            </div>
                            <h4 style="color: #333; margin: 0.5rem 0; font-size: 1.1rem; font-weight: 600;">{{ $report->title }}</h4>
                            @if($report->college)
                                <p style="color: #666; font-size: 0.9rem; margin: 0.5rem 0;"><i class="fas fa-university"></i> {{ $report->college }}</p>
                            @endif
                            <p style="color: #666; margin: 1rem 0; font-size: 0.95rem;">{{ Str::limit(strip_tags($report->content), 120) }}</p>
                            @if($report->participants_count)
                                <p style="color: #999; font-size: 0.85rem; margin: 0.5rem 0;"><i class="fas fa-users"></i> {{ $report->participants_count }} participants</p>
                            @endif
                            <a href="{{ route('accomplishment-report') }}" style="color: #f39c12; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                                View Report <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('accomplishment-report') }}" style="background: linear-gradient(to right, #f39c12, #e67e22); color: white; padding: 0.75rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block;">
                        View All Accomplishments <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                    </a>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; background: #f9f9f9; border-radius: 8px;">
                    <i class="fas fa-trophy" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #999;">No accomplishment reports yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>

    @include('components.latest-announcements')
@endsection