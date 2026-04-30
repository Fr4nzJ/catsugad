@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="title">Sex-Disaggregated Data Dashboard</h1>

    <!-- Summary Cards -->
    <div class="columns is-multiline mb-5">
        <div class="column is-3-desktop is-6-tablet">
            <div class="box has-background-link-light">
                <p class="heading">Male Students</p>
                <p class="title has-text-link">{{ number_format($stats['male_students']) }}</p>
            </div>
        </div>
        <div class="column is-3-desktop is-6-tablet">
            <div class="box has-background-info-light">
                <p class="heading">Female Students</p>
                <p class="title has-text-info">{{ number_format($stats['female_students']) }}</p>
            </div>
        </div>
        <div class="column is-3-desktop is-6-tablet">
            <div class="box has-background-success-light">
                <p class="heading">Male Employees</p>
                <p class="title has-text-success">{{ number_format($stats['male_employees']) }}</p>
            </div>
        </div>
        <div class="column is-3-desktop is-6-tablet">
            <div class="box has-background-warning-light">
                <p class="heading">Female Employees</p>
                <p class="title has-text-warning">{{ number_format($stats['female_employees']) }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="box mb-5">
        <h2 class="subtitle">Filters</h2>
        <div class="columns is-multiline">
            <div class="column is-6-tablet is-3-desktop">
                <div class="field">
                    <label class="label">College</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="collegeFilter">
                                <option value="">All Colleges</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}">{{ $college->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-6-tablet is-3-desktop">
                <div class="field">
                    <label class="label">Program</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="programFilter">
                                <option value="">All Programs</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->program_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-12">
                <button id="applyFiltersBtn" class="button is-info">
                    <span class="icon"><i class="fas fa-filter"></i></span>
                    <span>Apply Filters</span>
                </button>
                <button id="clearFiltersBtn" class="button is-light">
                    <span class="icon"><i class="fas fa-times"></i></span>
                    <span>Clear Filters</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Students by College -->
    <div class="box mb-5">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h2 class="subtitle">Students by College</h2>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <div class="buttons has-addons">
                        <button class="button is-small toggle-chart-view" data-chart="collegeStudents" data-view="chart">
                            <span class="icon"><i class="fas fa-chart-bar"></i></span>
                            <span>Chart</span>
                        </button>
                        <button class="button is-small toggle-chart-view" data-chart="collegeStudents" data-view="table">
                            <span class="icon"><i class="fas fa-table"></i></span>
                            <span>Table</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container collegeStudents-chart">
            <canvas id="collegeStudentsChart"></canvas>
        </div>

        <div class="table-container collegeStudents-table" style="display: none;">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>College</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="collegeStudentsTableBody">
                    <tr>
                        <td colspan="4" class="has-text-centered">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Students by Program -->
    <div class="box mb-5">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h2 class="subtitle">Students by Program</h2>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <div class="buttons has-addons">
                        <button class="button is-small toggle-chart-view" data-chart="programStudents" data-view="chart">
                            <span class="icon"><i class="fas fa-chart-bar"></i></span>
                            <span>Chart</span>
                        </button>
                        <button class="button is-small toggle-chart-view" data-chart="programStudents" data-view="table">
                            <span class="icon"><i class="fas fa-table"></i></span>
                            <span>Table</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container programStudents-chart">
            <canvas id="programStudentsChart"></canvas>
        </div>

        <div class="table-container programStudents-table" style="display: none;">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="programStudentsTableBody">
                    <tr>
                        <td colspan="4" class="has-text-centered">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Employees -->
    <div class="box">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h2 class="subtitle">Employees Distribution</h2>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <div class="buttons has-addons">
                        <button class="button is-small toggle-chart-view" data-chart="employees" data-view="chart">
                            <span class="icon"><i class="fas fa-chart-pie"></i></span>
                            <span>Chart</span>
                        </button>
                        <button class="button is-small toggle-chart-view" data-chart="employees" data-view="table">
                            <span class="icon"><i class="fas fa-table"></i></span>
                            <span>Table</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container employees-chart">
            <canvas id="employeesChart"></canvas>
        </div>

        <div class="table-container employees-table" style="display: none;">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="employeesTableBody">
                    <tr>
                        <td colspan="4" class="has-text-centered">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .chart-container {
        position: relative;
        height: 400px;
        margin-bottom: 20px;
    }

    .table-container {
        overflow-x: auto;
    }

    .box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    let collegeStudentsChart = null;
    let programStudentsChart = null;
    let employeesChart = null;

    const MALE_COLOR = '#5E72E4';      // Muted blue
    const FEMALE_COLOR = '#B8BED4';    // Neutral gray

    document.addEventListener('DOMContentLoaded', function() {
        loadCharts();
        setupFilterHandlers();
        setupToggleHandlers();
    });

    function getFilterValues() {
        return {
            college_id: document.getElementById('collegeFilter').value,
            program_id: document.getElementById('programFilter').value,
        };
    }

    function loadCharts() {
        const filters = getFilterValues();
        
        // Load college students data
        fetch('{{ route("dashboard.students-by-college") }}?' + new URLSearchParams(filters))
            .then(r => r.json())
            .then(data => {
                renderCollegeStudentsChart(data);
                renderCollegeStudentsTable(data);
            });

        // Load program students data
        fetch('{{ route("dashboard.students-by-program") }}?' + new URLSearchParams(filters))
            .then(r => r.json())
            .then(data => {
                renderProgramStudentsChart(data);
                renderProgramStudentsTable(data);
            });

        // Load employee data
        fetch('{{ route("dashboard.employee-stats") }}?' + new URLSearchParams(filters))
            .then(r => r.json())
            .then(data => {
                renderEmployeesChart(data);
                renderEmployeesTable(data);
            });
    }

    function renderCollegeStudentsChart(data) {
        const ctx = document.getElementById('collegeStudentsChart').getContext('2d');
        
        if (collegeStudentsChart) {
            collegeStudentsChart.destroy();
        }

        collegeStudentsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Male',
                        data: data.males,
                        backgroundColor: MALE_COLOR,
                    },
                    {
                        label: 'Female',
                        data: data.females,
                        backgroundColor: FEMALE_COLOR,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }

    function renderCollegeStudentsTable(data) {
        const tbody = document.getElementById('collegeStudentsTableBody');
        tbody.innerHTML = '';

        if (data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="has-text-centered">No data available</td></tr>';
            return;
        }

        data.data.forEach((item, index) => {
            const total = data.males[index] + data.females[index];
            tbody.innerHTML += `
                <tr>
                    <td>${data.labels[index]}</td>
                    <td>${data.males[index]}</td>
                    <td>${data.females[index]}</td>
                    <td><strong>${total}</strong></td>
                </tr>
            `;
        });
    }

    function renderProgramStudentsChart(data) {
        const ctx = document.getElementById('programStudentsChart').getContext('2d');
        
        if (programStudentsChart) {
            programStudentsChart.destroy();
        }

        programStudentsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Male',
                        data: data.males,
                        backgroundColor: MALE_COLOR,
                    },
                    {
                        label: 'Female',
                        data: data.females,
                        backgroundColor: FEMALE_COLOR,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }

    function renderProgramStudentsTable(data) {
        const tbody = document.getElementById('programStudentsTableBody');
        tbody.innerHTML = '';

        if (data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="has-text-centered">No data available</td></tr>';
            return;
        }

        data.data.forEach((item, index) => {
            const total = data.males[index] + data.females[index];
            tbody.innerHTML += `
                <tr>
                    <td>${data.labels[index]}</td>
                    <td>${data.males[index]}</td>
                    <td>${data.females[index]}</td>
                    <td><strong>${total}</strong></td>
                </tr>
            `;
        });
    }

    function renderEmployeesChart(data) {
        const ctx = document.getElementById('employeesChart').getContext('2d');
        
        if (employeesChart) {
            employeesChart.destroy();
        }

        employeesChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: [MALE_COLOR, FEMALE_COLOR],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                }
            }
        });
    }

    function renderEmployeesTable(data) {
        const tbody = document.getElementById('employeesTableBody');
        tbody.innerHTML = '';

        if (data.breakdown.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="has-text-centered">No data available</td></tr>';
            return;
        }

        data.breakdown.forEach(item => {
            const total = item.male + item.female;
            tbody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.male}</td>
                    <td>${item.female}</td>
                    <td><strong>${total}</strong></td>
                </tr>
            `;
        });
    }

    function setupFilterHandlers() {
        document.getElementById('applyFiltersBtn').addEventListener('click', loadCharts);
        document.getElementById('clearFiltersBtn').addEventListener('click', () => {
            document.getElementById('collegeFilter').value = '';
            document.getElementById('programFilter').value = '';
            loadCharts();
        });
    }

    function setupToggleHandlers() {
        document.querySelectorAll('.toggle-chart-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const chart = this.dataset.chart;
                const view = this.dataset.view;
                const isChart = view === 'chart';

                // Update button states
                document.querySelectorAll(`[data-chart="${chart}"]`).forEach(b => {
                    b.classList.remove('is-info');
                });
                this.classList.add('is-info');

                // Toggle visibility
                document.querySelector(`.${chart}-chart`).style.display = isChart ? 'block' : 'none';
                document.querySelector(`.${chart}-table`).style.display = isChart ? 'none' : 'block';
            });
        });

        // Set initial button state
        document.querySelectorAll('.toggle-chart-view[data-view="chart"]').forEach(btn => {
            btn.classList.add('is-info');
        });
    }
</script>
@endsection
