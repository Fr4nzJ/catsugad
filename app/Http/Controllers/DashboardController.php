<?php

namespace App\Http\Controllers;

use App\Models\StudentStatistic;
use App\Models\EmployeeStatistic;
use App\Models\College;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard
     */
    public function index(Request $request)
    {
        $colleges = College::orderBy('name')->get();
        $programs = Program::orderBy('program_name')->get();

        // Get summary statistics
        $totalMaleStudents = StudentStatistic::sum('male_count');
        $totalFemaleStudents = StudentStatistic::sum('female_count');
        $totalMaleEmployees = EmployeeStatistic::sum('male_count');
        $totalFemaleEmployees = EmployeeStatistic::sum('female_count');

        $stats = [
            'male_students' => $totalMaleStudents,
            'female_students' => $totalFemaleStudents,
            'total_students' => $totalMaleStudents + $totalFemaleStudents,
            'male_employees' => $totalMaleEmployees,
            'female_employees' => $totalFemaleEmployees,
            'total_employees' => $totalMaleEmployees + $totalFemaleEmployees,
        ];

        return view('dashboard.index', compact('colleges', 'programs', 'stats'));
    }

    /**
     * Get students by college (AJAX endpoint)
     */
    public function getStudentsByCollege(Request $request): JsonResponse
    {
        $collegeId = $request->input('college_id');
        $programId = $request->input('program_id');

        $query = StudentStatistic::query();

        if ($collegeId) {
            $query->where('college_id', $collegeId);
        }

        if ($programId) {
            $query->where('program_id', $programId);
        }

        $data = $query->with(['college', 'program'])->get();

        return response()->json([
            'labels' => $data->map(fn($item) => $item->college?->name ?? 'Unknown')->toArray(),
            'males' => $data->pluck('male_count')->toArray(),
            'females' => $data->pluck('female_count')->toArray(),
            'data' => $data,
        ]);
    }

    /**
     * Get students by program (AJAX endpoint)
     */
    public function getStudentsByProgram(Request $request): JsonResponse
    {
        $collegeId = $request->input('college_id');
        $programId = $request->input('program_id');

        $query = StudentStatistic::query();

        if ($collegeId) {
            $query->where('college_id', $collegeId);
        }

        if ($programId) {
            $query->where('program_id', $programId);
        }

        $data = $query->with('program')->get();

        return response()->json([
            'labels' => $data->map(fn($item) => $item->program?->program_name ?? 'Unknown')->toArray(),
            'males' => $data->pluck('male_count')->toArray(),
            'females' => $data->pluck('female_count')->toArray(),
            'data' => $data,
        ]);
    }

    /**
     * Get employee statistics (AJAX endpoint)
     */
    public function getEmployeeStats(Request $request): JsonResponse
    {
        $collegeId = $request->input('college_id');

        $query = EmployeeStatistic::query();

        if ($collegeId) {
            $query->where('college_id', $collegeId);
        }

        $data = $query->with('college')->get();

        $maleTotal = $data->sum('male_count');
        $femaleTotal = $data->sum('female_count');

        return response()->json([
            'labels' => ['Male', 'Female'],
            'data' => [$maleTotal, $femaleTotal],
            'breakdown' => $data->map(fn($item) => [
                'name' => $item->college?->name ?? $item->department ?? 'Unknown',
                'male' => $item->male_count,
                'female' => $item->female_count,
            ])->toArray(),
        ]);
    }

    /**
     * Get programs filtered by college (AJAX endpoint)
     */
    public function getProgramsByCollege(Request $request): JsonResponse
    {
        $collegeId = $request->input('college_id');

        $programs = Program::query()
            ->whereHas('studentStatistics', function($q) use ($collegeId) {
                $q->where('college_id', $collegeId);
            })
            ->orderBy('program_name')
            ->get(['id', 'program_name']);

        return response()->json([
            'programs' => $programs,
        ]);
    }
}
