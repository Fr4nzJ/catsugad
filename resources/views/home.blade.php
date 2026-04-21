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
@endsection