<!-- Sex-Disaggregated Staff Data Visualization Section -->
<section style="background: linear-gradient(135deg, #FF6B6B 0%, #C92A2A 100%); border-radius: 12px; padding: 3rem; color: white; margin: 3rem 0; box-shadow: 0 8px 24px rgba(255, 107, 107, 0.4);">
    
    <!-- Section Header -->
    <div style="margin-bottom: 2.5rem;">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-users" style="font-size: 2.2rem;"></i>
            Sex-Disaggregated Staff Data
        </h2>
        <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 1.05rem;">
            University Staff Distribution by Gender
        </p>
    </div>

    <!-- A. UNIVERSITY SUMMARY BLOCK -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem; backdrop-filter: blur(10px);">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.4rem;">
            <i class="fas fa-chart-line"></i> Staff Summary
        </h3>

        <!-- Summary Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            @php
                $totalStaff = $staffTotalByGender['Male'] + $staffTotalByGender['Female'] + $staffTotalByGender['Other'];
                $malePercentage = $totalStaff > 0 ? round(($staffTotalByGender['Male'] / $totalStaff) * 100, 1) : 0;
                $femalePercentage = $totalStaff > 0 ? round(($staffTotalByGender['Female'] / $totalStaff) * 100, 1) : 0;
                $otherPercentage = $totalStaff > 0 ? round(($staffTotalByGender['Other'] / $totalStaff) * 100, 1) : 0;
            @endphp

            <div style="background: #4C6EF5; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Male Staff</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Male'] }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $malePercentage }}%</p>
            </div>

            <div style="background: #FF922B; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Female Staff</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Female'] }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $femalePercentage }}%</p>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Other</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Other'] }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $otherPercentage }}%</p>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Total Personnel</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $totalStaff }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">University</p>
            </div>
        </div>

        <!-- University Summary Text -->
        <div style="background: rgba(255, 255, 255, 0.08); border-left: 4px solid #FFD700; border-radius: 4px; padding: 1.5rem; margin-bottom: 1.5rem;">
            <p style="margin: 0; color: rgba(255, 255, 255, 0.95); font-size: 1.05rem; line-height: 1.6;">
                <i class="fas fa-quote-left" style="margin-right: 0.5rem; opacity: 0.6;"></i>
                The university has a total of <strong>{{ $totalStaff }}</strong> personnel across all offices and divisions, with {{ $malePercentage }}% male and {{ $femalePercentage }}% female staff members representing our institution.
            </p>
        </div>

        <!-- University Pie Chart -->
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem;">
            <canvas id="staffUniversitySummaryChart" style="max-height: 250px;"></canvas>
        </div>
    </div>

    <!-- B. VISUALIZATION TYPE SELECTOR -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 2.5rem;">
        <h4 style="margin-top: 0; margin-bottom: 1rem; color: white;">
            <i class="fas fa-sliders-h"></i> Visualization Type
        </h4>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="staff-chart-type-btn" data-type="table" style="background: #4C6EF5; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-table"></i> Table View
            </button>
        </div>
    </div>

    <!-- C. OFFICE-LEVEL BREAKDOWN -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 2rem; font-size: 1.4rem;">
            <i class="fas fa-building"></i> Office-Level Breakdown
        </h3>

        <!-- Office Chart Container -->
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <div id="staffOfficeChartContainer">
                <canvas id="staffOfficeChart" style="max-height: 400px; display: block; margin: 0 auto;"></canvas>
            </div>
            <div id="staffOfficeTableContainer" style="display: none; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <table style="width: 100%; border-collapse: collapse; color: white; table-layout: auto;">
                    <thead>
                        <tr style="background: rgba(255, 255, 255, 0.1); border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                            <th style="padding: 1rem; text-align: left;">Office</th>
                            <th style="padding: 1rem; text-align: center;">Male</th>
                            <th style="padding: 1rem; text-align: center;">Female</th>
                            <th style="padding: 1rem; text-align: center;">Other</th>
                            <th style="padding: 1rem; text-align: center;">Total</th>
                            <th style="padding: 1rem; text-align: center;">M %</th>
                            <th style="padding: 1rem; text-align: center;">F %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffByOfficeAndGender as $office => $counts)
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                                <td style="padding: 1rem; text-align: left;">{{ $office }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Male'] }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Female'] }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Other'] }}</td>
                                <td style="padding: 1rem; text-align: center; font-weight: bold; background: rgba(255, 255, 255, 0.05);">{{ $counts['Total'] }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ round(($counts['Male'] / $counts['Total']) * 100, 1) }}%</td>
                                <td style="padding: 1rem; text-align: center;">{{ round(($counts['Female'] / $counts['Total']) * 100, 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Office Summary Text -->
        <div style="background: rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 1.5rem;">
            <h5 style="margin-top: 0; margin-bottom: 1rem; color: white;">
                <i class="fas fa-info-circle"></i> Office Insights
            </h5>
            <div id="staffOfficeSummaryText" style="color: rgba(255, 255, 255, 0.95); line-height: 1.8; font-size: 0.95rem;">
                <p style="margin: 0;">The staff distribution across <strong>{{ count($staffByOfficeAndGender) }}</strong> offices shows varying gender composition based on organizational needs and roles.</p>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
// Staff Chart Data
const staffChartData = {
    labels: ['Male', 'Female', 'Other'],
    maleCount: {{ $staffTotalByGender['Male'] }},
    femaleCount: {{ $staffTotalByGender['Female'] }},
    otherCount: {{ $staffTotalByGender['Other'] }},
    officeData: @json($staffByOfficeAndGender),
};

let staffUniversityChart = null;
let staffOfficeChart = null;

// Initialize University Summary Chart (Pie)
function initStaffUniversityChart() {
    const ctx = document.getElementById('staffUniversitySummaryChart')?.getContext('2d');
    if (!ctx) return;

    staffUniversityChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female', 'Other'],
            datasets: [{
                data: [staffChartData.maleCount, staffChartData.femaleCount, staffChartData.otherCount],
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

// Initialize Office Chart (Bar)
function initStaffOfficeChart(chartType = 'bar') {
    const container = document.getElementById('staffOfficeChartContainer');
    const ctx = document.getElementById('staffOfficeChart')?.getContext('2d');
    if (!ctx) return;

    // Prepare office data
    const officeNames = Object.keys(staffChartData.officeData);
    const maleData = officeNames.map(office => staffChartData.officeData[office].Male);
    const femaleData = officeNames.map(office => staffChartData.officeData[office].Female);
    const otherData = officeNames.map(office => staffChartData.officeData[office].Other);

    if (staffOfficeChart) {
        staffOfficeChart.destroy();
    }

    let chartConfig = {
        type: chartType,
        data: {
            labels: officeNames,
            datasets: [
                {
                    label: 'Male',
                    data: maleData,
                    backgroundColor: '#4C6EF5',
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1,
                },
                {
                    label: 'Female',
                    data: femaleData,
                    backgroundColor: '#FF922B',
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1,
                },
                {
                    label: 'Other',
                    data: otherData,
                    backgroundColor: 'rgba(255, 255, 255, 0.3)',
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            indexAxis: chartType === 'bar' ? 'y' : undefined,
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white',
                        font: { size: 11 }
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
    };

    if (chartType === 'pie' || chartType === 'doughnut') {
        chartConfig.type = chartType;
        chartConfig.options.indexAxis = undefined;
    }

    staffOfficeChart = new Chart(ctx, chartConfig);
}

// Handle visualization type button clicks
document.querySelectorAll('.staff-chart-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const type = this.getAttribute('data-type');
        
        // Update button styles
        document.querySelectorAll('.staff-chart-type-btn').forEach(b => {
            b.style.background = 'rgba(255, 255, 255, 0.2)';
        });
        this.style.background = '#4C6EF5';

        // Toggle chart/table visibility
        const chartContainer = document.getElementById('staffOfficeChartContainer');
        const tableContainer = document.getElementById('staffOfficeTableContainer');

        if (type === 'table') {
            chartContainer.style.display = 'none';
            tableContainer.style.display = 'block';
        } else {
            chartContainer.style.display = 'block';
            tableContainer.style.display = 'none';
            initStaffOfficeChart(type);
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initStaffUniversityChart();
    // Show table view by default, hide chart
    document.getElementById('staffOfficeChartContainer').style.display = 'none';
    document.getElementById('staffOfficeTableContainer').style.display = 'block';
});
</script>
</script>
