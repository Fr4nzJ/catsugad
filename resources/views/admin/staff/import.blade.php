@extends('layouts.admin')

@section('title', 'Staff Import - Sex-Disaggregated Data')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<div class="container">
    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <h1 class="title">Staff Import (Sex-Disaggregated Data)</h1>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if($errors->any())
        <div class="notification is-danger">
            <button class="delete"></button>
            <strong>Error!</strong>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="notification is-success">
            <button class="delete"></button>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="notification is-danger">
            <button class="delete"></button>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Upload Section --}}
    <div class="box">
        <h2 class="subtitle is-5">
            <i class="fas fa-file-upload"></i> Import Excel File
        </h2>

        <form action="{{ route('admin.staff.import.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label class="label">Select File (.xlsx or .csv)</label>
                <div class="control has-icons-left">
                    <input class="input" type="file" name="file" accept=".xlsx,.csv" required>
                    <span class="icon is-left">
                        <i class="fas fa-file"></i>
                    </span>
                </div>
                <p class="help">Maximum file size: 5 MB</p>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" name="truncate" value="1">
                        <strong>Clear existing data before import</strong>
                    </label>
                </div>
                <p class="help is-warning">Checking this will delete all current staff records before importing.</p>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-info" type="submit">
                        <span class="icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span>Import File</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="box is-light mt-5">
            <h3 class="subtitle is-6">Excel File Format</h3>
            <p><strong>Columns:</strong> No. | Name | Position | Gender</p>
            <p class="mt-2"><strong>Rules:</strong></p>
            <ul class="ml-4">
                <li>• <strong>Empty "No."</strong> = Office name (e.g., "College of Engineering")</li>
                <li>• <strong>Numeric "No."</strong> = Staff record under the most recent office</li>
                <li>• Gender: M/Male → Male | F/Female → Female | Other → Other</li>
            </ul>
        </div>
    </div>

    {{-- Summary Section with Charts --}}
    @if($totalByGender['Male'] > 0 || $totalByGender['Female'] > 0 || $totalByGender['Other'] > 0)
        <!-- Enhanced Summary Section -->
        <section style="background: linear-gradient(135deg, #FF6B6B 0%, #C92A2A 100%); border-radius: 12px; padding: 3rem; color: white; margin: 3rem 0; box-shadow: 0 8px 24px rgba(255, 107, 107, 0.4);">
            
            <!-- Section Header -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-users" style="font-size: 2.2rem;"></i>
                    Staff Summary
                </h2>
                <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 1.05rem;">
                    Current Staff Distribution by Gender
                </p>
            </div>

            <!-- Summary Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                @php
                    $totalStaff = $totalByGender['Male'] + $totalByGender['Female'] + $totalByGender['Other'];
                    $malePercentage = $totalStaff > 0 ? round(($totalByGender['Male'] / $totalStaff) * 100, 1) : 0;
                    $femalePercentage = $totalStaff > 0 ? round(($totalByGender['Female'] / $totalStaff) * 100, 1) : 0;
                    $otherPercentage = $totalStaff > 0 ? round(($totalByGender['Other'] / $totalStaff) * 100, 1) : 0;
                @endphp
                
                <div style="background: #4C6EF5; border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Male Staff</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $totalByGender['Male'] }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $malePercentage }}%</p>
                </div>

                <div style="background: #FF922B; border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Female Staff</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $totalByGender['Female'] }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $femalePercentage }}%</p>
                </div>

                <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Other</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $totalByGender['Other'] }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $otherPercentage }}%</p>
                </div>
            </div>

            <!-- Total Staff -->
            <div style="background: rgba(255, 255, 255, 0.08); border-left: 4px solid #FFD700; border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem;">
                <p style="margin: 0; color: rgba(255, 255, 255, 0.95); font-size: 1.05rem; line-height: 1.6;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                    <strong>Total University Staff:</strong> {{ $totalStaff }} personnel
                </p>
            </div>

            <!-- Charts Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <!-- Pie Chart -->
                <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 1.5rem; backdrop-filter: blur(10px);">
                    <h3 style="color: white; margin-top: 0; margin-bottom: 1rem;">Distribution</h3>
                    <canvas id="genderPieChart" style="max-height: 250px;"></canvas>
                </div>

                <!-- Bar Chart -->
                <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 1.5rem; backdrop-filter: blur(10px);">
                    <h3 style="color: white; margin-top: 0; margin-bottom: 1rem;">Gender Breakdown</h3>
                    <canvas id="genderBarChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </section>

        {{-- Breakdown by Office --}}
        @if(count($byOfficeAndGender) > 0)
            <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; backdrop-filter: blur(10px); overflow-x: auto; margin-top: 3rem;">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.4rem; color: #333;">
                    <i class="fas fa-building"></i> Staff by Office & Gender
                </h3>

                <div class="table-container">
                    <table class="table is-striped is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>Office</th>
                                <th class="has-text-centered">Male</th>
                                <th class="has-text-centered">Female</th>
                                <th class="has-text-centered">Other</th>
                                <th class="has-text-centered">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byOfficeAndGender as $office => $counts)
                                <tr>
                                    <td><strong>{{ $office }}</strong></td>
                                    <td class="has-text-centered">{{ $counts['Male'] }}</td>
                                    <td class="has-text-centered">{{ $counts['Female'] }}</td>
                                    <td class="has-text-centered">{{ $counts['Other'] }}</td>
                                    <td class="has-text-centered has-background-light"><strong>{{ $counts['Total'] }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
</div>

<script>
    // Pie Chart
    const pieCtx = document.getElementById('genderPieChart')?.getContext('2d');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female', 'Other'],
                datasets: [{
                    data: [{{ $totalByGender['Male'] }}, {{ $totalByGender['Female'] }}, {{ $totalByGender['Other'] }}],
                    backgroundColor: ['#4C6EF5', '#FF922B', 'rgba(255, 255, 255, 0.3)'],
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: { size: 12 },
                            padding: 15
                        }
                    }
                }
            }
        });
    }

    // Bar Chart
    const barCtx = document.getElementById('genderBarChart')?.getContext('2d');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Male', 'Female', 'Other'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $totalByGender['Male'] }}, {{ $totalByGender['Female'] }}, {{ $totalByGender['Other'] }}],
                    backgroundColor: ['#4C6EF5', '#FF922B', 'rgba(255, 255, 255, 0.3)'],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: { size: 12 }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'white' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    },
                    y: {
                        ticks: { color: 'white' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    }
                }
            }
        });
    }
</script>

<style>
    .table-container {
        border-radius: 8px;
        overflow: hidden;
    }
</style>

@endsection
