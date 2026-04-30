<!-- Example Dashboard View (resources/views/enrollment/dashboard.blade.php) -->

<div class="enrollment-dashboard" style="padding: 2rem;">

    <!-- Header -->
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 0.5rem;">
            <i class="fas fa-chart-bar"></i> Student Enrollment Dashboard
        </h1>
        <p style="color: #666; font-size: 1.1rem;">
            Academic Year: <strong>{{ $academicYear }}</strong> | Semester: <strong>{{ $semester }}</strong>
        </p>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        
        <!-- Total Students Card -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Students</div>
            <div style="font-size: 2.5rem; font-weight: bold;">{{ number_format($stats['total_students']) }}</div>
            <div style="font-size: 0.85rem; margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 0.5rem;">
                <span style="display: inline-block; margin-right: 1rem;">M: {{ number_format($stats['total_male']) }}</span>
                <span style="display: inline-block;">F: {{ number_format($stats['total_female']) }}</span>
            </div>
        </div>

        <!-- Male Card -->
        <div style="background: linear-gradient(135deg, #5E72E4 0%, #4c68d4 100%); color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Male Students</div>
            <div style="font-size: 2.5rem; font-weight: bold;">{{ number_format($stats['total_male']) }}</div>
            <div style="font-size: 0.85rem; margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 0.5rem;">
                {{ $stats['male_percentage'] }}% of total
            </div>
        </div>

        <!-- Female Card -->
        <div style="background: linear-gradient(135deg, #B8BED4 0%, #a8aac4 100%); color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Female Students</div>
            <div style="font-size: 2.5rem; font-weight: bold;">{{ number_format($stats['total_female']) }}</div>
            <div style="font-size: 0.85rem; margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 0.5rem;">
                {{ $stats['female_percentage'] }}% of total
            </div>
        </div>

        <!-- Colleges Card -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Colleges</div>
            <div style="font-size: 2.5rem; font-weight: bold;">{{ $stats['colleges_count'] }}</div>
            <div style="font-size: 0.85rem; margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 0.5rem;">
                Colleges with data
            </div>
        </div>

    </div>

    <!-- Colleges Table -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 2rem; border-bottom: 1px solid #e0e0e0;">
            <h2 style="font-size: 1.5rem; color: #333; margin: 0;">Enrollment by College</h2>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">College</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Male</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Female</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Total</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Male %</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Female %</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collegeData as $enrollment)
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                            <td style="padding: 1rem; color: #333;">{{ $enrollment['college_name'] }}</td>
                            <td style="padding: 1rem; text-align: center; color: #5E72E4; font-weight: 600;">
                                {{ number_format($enrollment['male_count']) }}
                            </td>
                            <td style="padding: 1rem; text-align: center; color: #B8BED4; font-weight: 600;">
                                {{ number_format($enrollment['female_count']) }}
                            </td>
                            <td style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">
                                {{ number_format($enrollment['total_count']) }}
                            </td>
                            <td style="padding: 1rem; text-align: center; color: #666;">
                                {{ $enrollment['male_percentage'] }}%
                            </td>
                            <td style="padding: 1rem; text-align: center; color: #666;">
                                {{ $enrollment['female_percentage'] }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999;">
                                No enrollment data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Container -->
    <div style="margin-top: 3rem; background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.5rem; color: #333; margin-bottom: 2rem;">Enrollment Distribution</h2>
        <canvas id="enrollmentChart" style="height: 300px;"></canvas>
    </div>

</div>

<!-- Chart.js Script (if using charts) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const collegeNames = {!! json_encode($collegeData->pluck('college_name')) !!};
        const maleData = {!! json_encode($collegeData->pluck('male_count')) !!};
        const femaleData = {!! json_encode($collegeData->pluck('female_count')) !!};

        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: collegeNames,
                datasets: [
                    {
                        label: 'Male Students',
                        data: maleData,
                        backgroundColor: '#5E72E4',
                    },
                    {
                        label: 'Female Students',
                        data: femaleData,
                        backgroundColor: '#B8BED4',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
