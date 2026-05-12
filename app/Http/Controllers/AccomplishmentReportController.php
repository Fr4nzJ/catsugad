<?php

namespace App\Http\Controllers;

use App\Models\AccomplishmentReport;
use App\Models\College;
use App\Models\Staff;
use App\Helpers\EnrollmentAggregator;
use App\Helpers\HierarchicalEnrollmentAggregator;
use Illuminate\Http\Request;

class AccomplishmentReportController extends Controller
{
    /**
     * Public index - show all accomplishment reports with coordinators and enrollment data
     */
    public function index(Request $request)
    {
        // Get all reports with filters
        $reports = AccomplishmentReport::query()
            ->when($request->college, fn($q) => $q->where('college', $request->college))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->orderBy('year', 'desc')
            ->paginate(15);

        // Get unique colleges from reports
        $collegeNames = AccomplishmentReport::distinct()
            ->pluck('college')
            ->filter()
            ->sort()
            ->values();

        // Load coordinators for each college
        $coordinators = College::with('gadCoordinator')
                              ->whereIn('name', $collegeNames)
                              ->get()
                              ->keyBy('name');

        // Get sex-disaggregated enrollment data - HIERARCHICAL
        $hierarchicalEnrollment = HierarchicalEnrollmentAggregator::getByHierarchy('2025-2026', 'Second Semester');
        $higherEducationInsights = HierarchicalEnrollmentAggregator::getHigherEducationInsights('2025-2026', 'Second Semester');
        $advancedEducationSummary = HierarchicalEnrollmentAggregator::getAdvancedEducationSummary('2025-2026', 'Second Semester');

        // Keep old data for backward compatibility with views
        $enrollmentData = EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');
        $enrollmentStats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');
        $enrollmentSummary = EnrollmentAggregator::getSexDisaggregatedSummary('2025-2026', 'Second Semester');
        $collegesWithPrograms = EnrollmentAggregator::getCollegesWithProgramsBreakdown('2025-2026', 'Second Semester');
        $enrollmentByCollege = $enrollmentData->keyBy('college_name');

        // Get staff sex-disaggregated data
        $staffTotalByGender = $this->getStaffTotalByGender();
        $staffByOfficeAndGender = $this->getStaffByOfficeAndGender();

        // Group reports by college for display
        $reportsByCollege = $reports->groupBy('college');

        return view('accomplishment-report', compact('reports', 'collegeNames', 'coordinators', 'reportsByCollege', 'enrollmentByCollege', 'enrollmentStats', 'enrollmentData', 'enrollmentSummary', 'collegesWithPrograms', 'staffTotalByGender', 'staffByOfficeAndGender', 'hierarchicalEnrollment', 'higherEducationInsights', 'advancedEducationSummary'));
    }

    /**
     * AJAX endpoint for getting college data in specified chart format
     */
    public function getCollegeChartData(Request $request)
    {
        $chartType = $request->get('chart_type', 'bar');
        $academicYear = $request->get('academic_year', '2025-2026');
        $semester = $request->get('semester', 'Second Semester');

        $collegeData = EnrollmentAggregator::getByCollege($academicYear, $semester);

        return response()->json([
            'chart_type' => $chartType,
            'labels' => $collegeData->pluck('college_name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Male Students',
                    'data' => $collegeData->pluck('male_count')->toArray(),
                    'backgroundColor' => '#5E72E4',
                    'borderColor' => '#5E72E4',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Female Students',
                    'data' => $collegeData->pluck('female_count')->toArray(),
                    'backgroundColor' => '#B8BED4',
                    'borderColor' => '#B8BED4',
                    'borderWidth' => 1,
                ]
            ],
            'raw_data' => $collegeData->toArray(),
        ]);
    }

    /**
     * AJAX endpoint for getting program-level data for a specific college
     */
    public function getCollegeProgramData($collegeId, Request $request)
    {
        $academicYear = $request->get('academic_year', '2025-2026');
        $semester = $request->get('semester', 'Second Semester');

        $collegeDetails = EnrollmentAggregator::getCollegeDetails($collegeId, $academicYear, $semester);

        if (empty($collegeDetails)) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $programs = collect($collegeDetails['programs'] ?? []);

        return response()->json([
            'college' => $collegeDetails['college'],
            'labels' => $programs->pluck('program_name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Male Students',
                    'data' => $programs->pluck('male_count')->toArray(),
                    'backgroundColor' => '#5E72E4',
                ],
                [
                    'label' => 'Female Students',
                    'data' => $programs->pluck('female_count')->toArray(),
                    'backgroundColor' => '#B8BED4',
                ]
            ],
            'programs' => $collegeDetails['programs'],
        ]);
    }

    /**
     * AJAX endpoint for getting university summary data
     */
    public function getUniversitySummaryData(Request $request)
    {
        $academicYear = $request->get('academic_year', '2025-2026');
        $semester = $request->get('semester', 'Second Semester');

        $summary = EnrollmentAggregator::getSexDisaggregatedSummary($academicYear, $semester);

        return response()->json([
            'stats' => $summary['stats'],
            'text_summary' => $summary['text_summary'],
            'chart_data' => [
                'labels' => ['Male', 'Female'],
                'datasets' => [
                    [
                        'data' => [
                            $summary['stats']['total_male'],
                            $summary['stats']['total_female']
                        ],
                        'backgroundColor' => ['#5E72E4', '#B8BED4'],
                        'borderColor' => ['#5E72E4', '#B8BED4'],
                        'borderWidth' => 2,
                    ]
                ]
            ]
        ]);
    }

    /**
     * Get total staff counts by gender
     */
    private function getStaffTotalByGender(): array
    {
        return [
            'Male' => Staff::where('gender', 'Male')->count(),
            'Female' => Staff::where('gender', 'Female')->count(),
            'Other' => Staff::where('gender', 'Other')->count(),
        ];
    }

    /**
     * Get staff counts grouped by office and gender
     */
    private function getStaffByOfficeAndGender(): array
    {
        // Get all staff grouped by office
        $staffByOffice = Staff::all()->groupBy('office');

        $result = [];

        foreach ($staffByOffice as $office => $staffList) {
            $result[$office] = [
                'Male' => $staffList->where('gender', 'Male')->count(),
                'Female' => $staffList->where('gender', 'Female')->count(),
                'Other' => $staffList->where('gender', 'Other')->count(),
            ];

            $result[$office]['Total'] = array_sum($result[$office]);
        }

        // Sort by office name
        ksort($result);

        return $result;
    }
}

