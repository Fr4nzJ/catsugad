<!-- Sex-Disaggregated Data Visualization Section -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 3rem; color: white; margin: 3rem 0; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);">
    
    <!-- Section Header -->
    <div style="margin-bottom: 2.5rem;">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-venus-mars" style="font-size: 2.2rem;"></i>
            Sex-Disaggregated Data Overview
        </h2>
        <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 1.05rem;">
            2025-2026 Academic Year | Second Semester
        </p>
    </div>

    <!-- A. UNIVERSITY SUMMARY BLOCK -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem; backdrop-filter: blur(10px);">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.4rem;">
            <i class="fas fa-chart-line"></i> University Summary
        </h3>

        <!-- Summary Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: #5E72E4; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Male Students</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ number_format($enrollmentSummary['stats']['total_male']) }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $enrollmentSummary['stats']['male_percentage'] }}%</p>
            </div>

            <div style="background: #B8BED4; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(0, 0, 0, 0.7); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Female Students</p>
                <h3 style="color: #333; font-size: 2.5rem; margin: 0;">{{ number_format($enrollmentSummary['stats']['total_female']) }}</h3>
                <p style="color: rgba(0, 0, 0, 0.6); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $enrollmentSummary['stats']['female_percentage'] }}%</p>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Total Population</p>
                <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ number_format($enrollmentSummary['stats']['total_students']) }}</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">{{ $enrollmentSummary['stats']['colleges_count'] }} colleges</p>
            </div>
        </div>

        <!-- University Summary Text -->
        <div style="background: rgba(255, 255, 255, 0.08); border-left: 4px solid #FFD700; border-radius: 4px; padding: 1.5rem; margin-bottom: 1.5rem;">
            <p style="margin: 0; color: rgba(255, 255, 255, 0.95); font-size: 1.05rem; line-height: 1.6;">
                <i class="fas fa-quote-left" style="margin-right: 0.5rem; opacity: 0.6;"></i>
                {{ $enrollmentSummary['text_summary'] }}
            </p>
        </div>

        <!-- University Pie Chart -->
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem;">
            <canvas id="universitySummaryChart" style="max-height: 250px;"></canvas>
        </div>
    </div>

    <!-- B. VISUALIZATION TYPE SELECTOR -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 2.5rem;">
        <h4 style="margin-top: 0 margin-bottom: 1rem; color: white;">
            <i class="fas fa-sliders-h"></i> Visualization Type
        </h4>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="chart-type-btn" data-type="bar" style="background: #5E72E4; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-chart-bar"></i> Bar Chart
            </button>
            <button class="chart-type-btn" data-type="line" style="background: rgba(255, 255, 255, 0.2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-chart-line"></i> Line Graph
            </button>
            <button class="chart-type-btn" data-type="pie" style="background: rgba(255, 255, 255, 0.2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-chart-pie"></i> Pie Chart
            </button>
            <button class="chart-type-btn" data-type="doughnut" style="background: rgba(255, 255, 255, 0.2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-ring"></i> Doughnut
            </button>
            <button class="chart-type-btn" data-type="table" style="background: rgba(255, 255, 255, 0.2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-table"></i> Table View
            </button>
        </div>
    </div>

    <!-- C. HIERARCHICAL DATA DISPLAY: CAMPUS → CATEGORY → COLLEGE -->
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 2rem; font-size: 1.4rem;">
            <i class="fas fa-sitemap"></i> Enrollment by Campus & Category
        </h3>

        @forelse($hierarchicalEnrollment as $campus)
            <!-- CAMPUS SECTION -->
            <div style="background: rgba(255, 255, 255, 0.08); border-left: 4px solid #FFD700; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
                <h4 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-map-marker-alt"></i> {{ $campus['campus'] }}
                    <span style="font-size: 0.9rem; background: rgba(255, 255, 255, 0.2); padding: 0.3rem 0.8rem; border-radius: 20px;">
                        {{ number_format($campus['total_students']) }} students
                    </span>
                </h4>

                <!-- CATEGORY SUBSECTIONS -->
                @forelse($campus['categories'] as $category)
                    <div style="background: rgba(255, 255, 255, 0.05); border-radius: 6px; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <h5 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #FFD700;">
                            <i class="fas fa-folder"></i> {{ $category['name'] }}
                        </h5>

                        @if($category['category'] === 'higher_education')
                            <!-- COLLEGES (only shown for Higher Education) -->
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; margin-bottom: 1rem;">
                                    <thead style="background: rgba(255, 255, 255, 0.1); border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                                        <tr>
                                            <th style="padding: 0.8rem; text-align: left;">College</th>
                                            <th style="padding: 0.8rem; text-align: center;">Male</th>
                                            <th style="padding: 0.8rem; text-align: center;">Female</th>
                                            <th style="padding: 0.8rem; text-align: center;">Total</th>
                                            <th style="padding: 0.8rem; text-align: center;">M %</th>
                                            <th style="padding: 0.8rem; text-align: center;">F %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($category['colleges'] as $college)
                                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); @if($loop->odd) background: rgba(255, 255, 255, 0.02); @endif">
                                                <td style="padding: 0.8rem;">{{ $college['name'] }}</td>
                                                <td style="padding: 0.8rem; text-align: center;">{{ number_format($college['male']) }}</td>
                                                <td style="padding: 0.8rem; text-align: center;">{{ number_format($college['female']) }}</td>
                                                <td style="padding: 0.8rem; text-align: center; font-weight: 600;">{{ number_format($college['total']) }}</td>
                                                <td style="padding: 0.8rem; text-align: center;">{{ $college['male_percentage'] }}%</td>
                                                <td style="padding: 0.8rem; text-align: center;">{{ $college['female_percentage'] }}%</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" style="padding: 1rem; text-align: center; color: rgba(255, 255, 255, 0.6);">No colleges found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Category Summary Stats -->
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Total Male</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_male']) }}</h5>
                                </div>
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Total Female</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_female']) }}</h5>
                                </div>
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Category Total</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_students']) }}</h5>
                                </div>
                            </div>
                        @else
                            <!-- ADVANCED EDUCATION (summary only, not broken down by colleges) -->
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; padding: 1rem; background: rgba(255, 255, 255, 0.08); border-radius: 4px;">
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Male</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_male']) }}</h5>
                                </div>
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Female</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_female']) }}</h5>
                                </div>
                                <div style="text-align: center;">
                                    <p style="color: rgba(255, 255, 255, 0.7); margin: 0 0 0.5rem 0; font-size: 0.9rem;">Total</p>
                                    <h5 style="margin: 0; color: white; font-size: 1.3rem;">{{ number_format($category['total_students']) }}</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <p style="color: rgba(255, 255, 255, 0.6); margin: 0;">No categories found for this campus.</p>
                @endforelse
            </div>
        @empty
            <p style="color: rgba(255, 255, 255, 0.6);">No hierarchical enrollment data available.</p>
        @endforelse
    </div>

    <!-- D. INSIGHTS SECTION (Higher Education Only) -->
    @if($higherEducationInsights)
        <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem;">
            <h3 style="margin-top: 0; margin-bottom: 2rem; font-size: 1.4rem;">
                <i class="fas fa-lightbulb"></i> Higher Education Insights
            </h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <!-- Highest Enrollment -->
                @if($higherEducationInsights['highest_enrollment'])
                    <div style="background: rgba(94, 114, 228, 0.2); border-left: 4px solid #5E72E4; border-radius: 8px; padding: 1.5rem;">
                        <h5 style="margin-top: 0; margin-bottom: 1rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-arrow-up"></i> Highest Enrollment
                        </h5>
                        <p style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 600; color: white;">
                            {{ $higherEducationInsights['highest_enrollment']['name'] }}
                        </p>
                        <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 0.95rem;">
                            <strong>{{ number_format($higherEducationInsights['highest_enrollment']['total']) }}</strong> students
                        </p>
                    </div>
                @endif

                <!-- Lowest Enrollment -->
                @if($higherEducationInsights['lowest_enrollment'])
                    <div style="background: rgba(184, 190, 212, 0.2); border-left: 4px solid #B8BED4; border-radius: 8px; padding: 1.5rem;">
                        <h5 style="margin-top: 0; margin-bottom: 1rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-arrow-down"></i> Lowest Enrollment
                        </h5>
                        <p style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 600; color: white;">
                            {{ $higherEducationInsights['lowest_enrollment']['name'] }}
                        </p>
                        <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 0.95rem;">
                            <strong>{{ number_format($higherEducationInsights['lowest_enrollment']['total']) }}</strong> students
                        </p>
                    </div>
                @endif

                <!-- Summary Stats -->
                <div style="background: rgba(255, 215, 0, 0.15); border-left: 4px solid #FFD700; border-radius: 8px; padding: 1.5rem;">
                    <h5 style="margin-top: 0; margin-bottom: 1rem; color: #FFD700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-chart-bar"></i> Category Summary
                    </h5>
                    <p style="margin: 0.5rem 0; color: rgba(255, 255, 255, 0.8); font-size: 0.95rem;">
                        <strong>{{ $higherEducationInsights['college_count'] }}</strong> Colleges
                    </p>
                    <p style="margin: 0.5rem 0; color: rgba(255, 255, 255, 0.8); font-size: 0.95rem;">
                        <strong>{{ number_format($higherEducationInsights['total_students']) }}</strong> Total Students
                    </p>
                    <p style="margin: 0.5rem 0; color: rgba(255, 255, 255, 0.8); font-size: 0.95rem;">
                        Male: <strong>{{ $higherEducationInsights['male_percentage'] }}%</strong> | Female: <strong>{{ $higherEducationInsights['female_percentage'] }}%</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- E. COLLEGE-LEVEL BREAKDOWN (LEGACY)
    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 2rem; font-size: 1.4rem;">
            <i class="fas fa-university"></i> College-Level Breakdown
        </h3>

        <!-- College Chart Container -->
        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <div id="collegeChartContainer">
                <canvas id="collegeChart" style="max-height: 400px;"></canvas>
            </div>
            <div id="collegeTableContainer" style="display: none; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; color: white;">
                    <thead>
                        <tr style="background: rgba(255, 255, 255, 0.1); border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                            <th style="padding: 1rem; text-align: left;">College</th>
                            <th style="padding: 1rem; text-align: center;">Male</th>
                            <th style="padding: 1rem; text-align: center;">Female</th>
                            <th style="padding: 1rem; text-align: center;">Total</th>
                            <th style="padding: 1rem; text-align: center;">M %</th>
                            <th style="padding: 1rem; text-align: center;">F %</th>
                        </tr>
                    </thead>
                    <tbody id="collegeTableBody">
                        <!-- Populated by AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- College Summary Text -->
        <div style="background: rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <h5 style="margin-top: 0; margin-bottom: 1rem; color: white;">
                <i class="fas fa-info-circle"></i> College Insights
            </h5>
            <div id="collegeSummaryText" style="color: rgba(255, 255, 255, 0.95); line-height: 1.8; font-size: 0.95rem;">
                <!-- Populated by JavaScript -->
            </div>
        </div>

        <!-- D. COLLEGE EXPANDABLE SECTIONS WITH PROGRAM-LEVEL DATA -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($collegesWithPrograms as $college)
                <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; border-left: 4px solid #5E72E4; overflow: hidden;">
                    <!-- College Header (Expandable) -->
                    <div class="college-expandable-header" data-college-id="{{ $college['college_id'] }}" style="padding: 1.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background 0.3s;">
                        <div>
                            <h5 style="margin: 0 0 0.5rem 0; color: white; font-size: 1.1rem;">
                                {{ $college['college_name'] }}
                            </h5>
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 0.9rem;">
                                <span style="margin-right: 1.5rem;">
                                    <i class="fas fa-mars"></i> {{ number_format($college['male_count']) }} ({{ $college['male_percentage'] }}%)
                                </span>
                                <span>
                                    <i class="fas fa-venus"></i> {{ number_format($college['female_count']) }} ({{ $college['female_percentage'] }}%)
                                </span>
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <p style="margin: 0 0 0.5rem 0; color: rgba(255, 255, 255, 0.9); font-size: 1.3rem; font-weight: bold;">
                                {{ number_format($college['total_count']) }}
                            </p>
                            <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.7); font-size: 1.2rem; transition: transform 0.3s;"></i>
                        </div>
                    </div>

                    <!-- College Content (Summary) -->
                    <div style="padding: 1.5rem; background: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(255, 255, 255, 0.1);">
                        <p style="margin: 0 0 1rem 0; color: rgba(255, 255, 255, 0.95); line-height: 1.6; font-style: italic;">
                            {{ $college['text_summary'] }}
                        </p>

                        @if($college['has_programs'])
                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                                <h6 style="margin: 0 0 1rem 0; color: white;">
                                    <i class="fas fa-graduation-cap"></i> Programs in this College
                                </h6>

                                <div class="college-programs-list" style="display: none; max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                                    @foreach($college['programs'] as $program)
                                        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 6px; padding: 1rem; margin-bottom: 0.75rem; border-left: 3px solid #B8BED4;">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <div style="flex-grow: 1;">
                                                    <p style="margin: 0 0 0.25rem 0; color: white; font-weight: 600;">{{ $program['program_name'] }}</p>
                                                    <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;">{{ $program['text_summary'] }}</p>
                                                </div>
                                                <div style="text-align: right; margin-left: 1rem;">
                                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; font-size: 0.9rem;">
                                                        <div style="background: rgba(94, 114, 228, 0.2); padding: 0.5rem; border-radius: 4px; text-align: center;">
                                                            <p style="margin: 0; color: #5E72E4; font-weight: 600;">{{ $program['male_count'] }}</p>
                                                            <small style="color: rgba(94, 114, 228, 0.8);">M</small>
                                                        </div>
                                                        <div style="background: rgba(184, 190, 212, 0.3); padding: 0.5rem; border-radius: 4px; text-align: center;">
                                                            <p style="margin: 0; color: #B8BED4; font-weight: 600;">{{ $program['female_count'] }}</p>
                                                            <small style="color: rgba(184, 190, 212, 0.9);">F</small>
                                                        </div>
                                                        <div style="background: rgba(255, 255, 255, 0.1); padding: 0.5rem; border-radius: 4px; text-align: center;">
                                                            <p style="margin: 0; color: white; font-weight: 600;">{{ $program['total_count'] }}</p>
                                                            <small style="color: rgba(255, 255, 255, 0.7);">T</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="toggle-programs-btn" data-college-id="{{ $college['college_id'] }}" style="background: rgba(94, 114, 228, 0.3); border: 1px solid #5E72E4; color: #5E72E4; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 600; margin-top: 1rem;">
                                    <i class="fas fa-chevron-right"></i> Show Programs ({{ count($college['programs']) }})
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentChartType = 'bar';
    let collegeChart = null;
    let universitySummaryChart = null;

    // Initialize charts
    initializeUniversitySummaryChart();
    initializeCollegeChart();

    // Visualization type selector
    document.querySelectorAll('.chart-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentChartType = this.dataset.type;
            
            // Update button styles
            document.querySelectorAll('.chart-type-btn').forEach(b => {
                b.style.background = 'rgba(255, 255, 255, 0.2)';
            });
            this.style.background = '#5E72E4';

            // Update display
            if (currentChartType === 'table') {
                document.getElementById('collegeChartContainer').style.display = 'none';
                document.getElementById('collegeTableContainer').style.display = 'block';
            } else {
                document.getElementById('collegeChartContainer').style.display = 'block';
                document.getElementById('collegeTableContainer').style.display = 'none';
                updateCollegeChart(currentChartType);
            }
        });
    });

    // Program expandable toggle
    document.querySelectorAll('.college-expandable-header').forEach(header => {
        header.addEventListener('click', function() {
            const collegeId = this.dataset.collegeId;
            const programsList = this.parentElement.querySelector('.college-programs-list');
            const toggleBtn = this.parentElement.querySelector('.toggle-programs-btn');
            const chevron = this.querySelector('i.fa-chevron-down');

            if (programsList && programsList.style.display === 'none') {
                programsList.style.display = 'block';
                programsList.style.maxHeight = programsList.scrollHeight + 'px';
                chevron.style.transform = 'rotate(180deg)';
                toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Programs';
            } else if (programsList) {
                programsList.style.maxHeight = '0';
                programsList.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
                toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i> Show Programs';
            }
        });
    });

    // Program toggle button
    document.querySelectorAll('.toggle-programs-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            this.parentElement.parentElement.querySelector('.college-programs-list').click();
        });
    });

    function initializeUniversitySummaryChart() {
        const ctx = document.getElementById('universitySummaryChart').getContext('2d');
        universitySummaryChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{ $enrollmentSummary['stats']['total_male'] }}, {{ $enrollmentSummary['stats']['total_female'] }}],
                    backgroundColor: ['#5E72E4', '#B8BED4'],
                    borderColor: '#667eea',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: { color: 'rgba(255, 255, 255, 0.9)', font: { size: 12, weight: 'bold' } }
                    }
                }
            }
        });
    }

    function initializeCollegeChart() {
        const ctx = document.getElementById('collegeChart').getContext('2d');
        const collegeData = {!! json_encode($enrollmentData->toArray()) !!};
        
        const labels = collegeData.map(d => d['college_name']);
        const maleData = collegeData.map(d => d['male_count']);
        const femaleData = collegeData.map(d => d['female_count']);

        collegeChart = new Chart(ctx, {
            type: currentChartType,
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Male Students',
                        data: maleData,
                        backgroundColor: '#5E72E4',
                        borderColor: '#5E72E4',
                        borderWidth: 1,
                    },
                    {
                        label: 'Female Students',
                        data: femaleData,
                        backgroundColor: '#B8BED4',
                        borderColor: '#B8BED4',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: { color: 'rgba(255, 255, 255, 0.9)', font: { size: 11 } }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(255, 255, 255, 0.7)', font: { size: 10 } },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: 'rgba(255, 255, 255, 0.7)', font: { size: 10 } },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    }
                }
            }
        });

        // Populate college summary text
        populateCollegeSummaryText(collegeData);

        // Populate table
        populateCollegeTable(collegeData);
    }

    function updateCollegeChart(type) {
        collegeChart.destroy();
        collegeChart.config.type = type;
        collegeChart = new Chart(document.getElementById('collegeChart').getContext('2d'), collegeChart.config);
    }

    function populateCollegeSummaryText(collegeData) {
        const topCollege = collegeData[0];
        const bottomCollege = collegeData[collegeData.length - 1];
        const summary = `
            <strong>Highest Enrollment:</strong> ${topCollege.college_name} with ${topCollege.total_count.toLocaleString()} students (${topCollege.male_percentage}% male, ${topCollege.female_percentage}% female).<br>
            <strong>Lowest Enrollment:</strong> ${bottomCollege.college_name} with ${bottomCollege.total_count.toLocaleString()} students (${bottomCollege.male_percentage}% male, ${bottomCollege.female_percentage}% female).<br>
            <strong>Gender Distribution Insights:</strong> The data shows varying gender distributions across colleges, with some specialized programs showing distinct gender patterns.
        `;
        document.getElementById('collegeSummaryText').innerHTML = summary;
    }

    function populateCollegeTable(collegeData) {
        const tbody = document.getElementById('collegeTableBody');
        tbody.innerHTML = collegeData.map(d => `
            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); hover: { background: rgba(255, 255, 255, 0.05); }">
                <td style="padding: 1rem; text-align: left; color: white;">${d.college_name}</td>
                <td style="padding: 1rem; text-align: center; color: #5E72E4; font-weight: 600;">${d.male_count.toLocaleString()}</td>
                <td style="padding: 1rem; text-align: center; color: #B8BED4; font-weight: 600;">${d.female_count.toLocaleString()}</td>
                <td style="padding: 1rem; text-align: center; color: white; font-weight: 600;">${d.total_count.toLocaleString()}</td>
                <td style="padding: 1rem; text-align: center; color: rgba(94, 114, 228, 0.9);">${d.male_percentage}%</td>
                <td style="padding: 1rem; text-align: center; color: rgba(184, 190, 212, 0.9);">${d.female_percentage}%</td>
            </tr>
        `).join('');
    }
});
</script>
