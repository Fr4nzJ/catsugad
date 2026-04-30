<?php

namespace App\Http\Controllers;

use App\Helpers\EnrollmentAggregator;
use Illuminate\Http\Request;

/**
 * Example Controller for Enrollment Dashboard
 * This demonstrates how to use the EnrollmentAggregator in a real controller
 */
class EnrollmentDashboardController extends Controller
{
    /**
     * Display enrollment dashboard
     */
    public function index(Request $request)
    {
        $academicYear = $request->input('academic_year', '2025-2026');
        $semester = $request->input('semester', 'Second Semester');

        // Get aggregated data
        $collegeData = EnrollmentAggregator::getByCollege($academicYear, $semester);
        $stats = EnrollmentAggregator::getUniversityStats($academicYear, $semester);
        $programData = EnrollmentAggregator::getByProgram($academicYear, $semester);

        return view('enrollment.dashboard', [
            'collegeData' => $collegeData,
            'stats' => $stats,
            'programData' => $programData,
            'academicYear' => $academicYear,
            'semester' => $semester,
        ]);
    }

    /**
     * Get college details with programs
     */
    public function getCollegeDetails(int $collegeId, Request $request)
    {
        $academicYear = $request->input('academic_year', '2025-2026');
        $semester = $request->input('semester', 'Second Semester');

        $details = EnrollmentAggregator::getCollegeDetails(
            $collegeId,
            $academicYear,
            $semester
        );

        if (empty($details)) {
            abort(404, 'College enrollment data not found');
        }

        return view('enrollment.college-detail', [
            'college' => $details['college'],
            'programs' => $details['programs'],
        ]);
    }

    /**
     * Get enrollment trends (AJAX)
     */
    public function getTrends(int $collegeId, Request $request)
    {
        $semester = $request->input('semester');

        $trends = EnrollmentAggregator::getTrends($collegeId, $semester);

        return response()->json($trends);
    }

    /**
     * Export enrollment data
     */
    public function export(Request $request)
    {
        $academicYear = $request->input('academic_year', '2025-2026');
        $semester = $request->input('semester', 'Second Semester');
        $format = $request->input('format', 'json');

        $data = EnrollmentAggregator::exportToArray($academicYear, $semester);

        if ($format === 'csv') {
            return $this->exportToCsv($data, $academicYear, $semester);
        }

        return response()->json($data);
    }

    /**
     * Export to CSV
     */
    private function exportToCsv(array $data, string $academicYear, string $semester)
    {
        $filename = "enrollment-{$academicYear}-{$semester}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // Write headers
            fputcsv($file, ['College', 'Male', 'Female', 'Total', 'Male %', 'Female %', 'Academic Year', 'Semester']);
            
            // Write data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get AJAX data for charts
     */
    public function getChartData(Request $request)
    {
        $academicYear = $request->input('academic_year', '2025-2026');
        $semester = $request->input('semester', 'Second Semester');
        $type = $request->input('type', 'college'); // 'college' or 'program'

        $data = $type === 'college'
            ? EnrollmentAggregator::getByCollege($academicYear, $semester)
            : EnrollmentAggregator::getByProgram($academicYear, $semester);

        return response()->json([
            'labels' => $data->pluck('college_name')->toArray(),
            'male' => $data->pluck('male_count')->toArray(),
            'female' => $data->pluck('female_count')->toArray(),
            'total' => $data->pluck('total_count')->toArray(),
        ]);
    }
}
