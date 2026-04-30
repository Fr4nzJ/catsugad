<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccomplishmentReport;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccomplishmentReportController extends Controller
{
    use LogsActivityTrait;

    /**
     * Display admin listing of accomplishment reports with enrollment data
     */
    public function index(Request $request)
    {
        $reports = AccomplishmentReport::query()
            ->when($request->college, fn($q) => $q->where('college', $request->college))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->orderBy('year', 'desc')
            ->paginate(10);

        $colleges = AccomplishmentReport::distinct()
            ->pluck('college')
            ->filter()
            ->sort()
            ->values();

        // Get sex-disaggregated enrollment data
        $enrollmentData = \App\Helpers\EnrollmentAggregator::getByCollege('2025-2026', 'Second Semester');
        $enrollmentStats = \App\Helpers\EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');
        $enrollmentByCollege = $enrollmentData->keyBy('college_name');

        return view('admin.accomplishment-reports.index', compact('reports', 'colleges', 'enrollmentByCollege', 'enrollmentStats', 'enrollmentData'));
    }

    /**
     * Show form for creating a new accomplishment report
     */
    public function create()
    {
        $colleges = $this->getColleges();
        $genders = $this->getGenders();

        return view('admin.accomplishment-reports.create', compact('colleges', 'genders'));
    }

    /**
     * Store a newly created accomplishment report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'year' => 'required|integer|min:2000|max:9999',
            'college' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'participants_count' => 'required|integer|min:0',
        ]);

        $report = AccomplishmentReport::create($validated);
        $this->logCreate($report, $report->title);

        return redirect()->route('admin.accomplishment-reports.index')
            ->with('success', 'Accomplishment report created successfully');
    }

    /**
     * Show form for editing an accomplishment report
     */
    public function edit(AccomplishmentReport $accomplishmentReport)
    {
        $colleges = $this->getColleges();
        $genders = $this->getGenders();

        return view('admin.accomplishment-reports.edit', compact('accomplishmentReport', 'colleges', 'genders'));
    }

    /**
     * Update the specified accomplishment report
     */
    public function update(Request $request, AccomplishmentReport $accomplishmentReport)
    {
        $oldValues = $accomplishmentReport->getAttributes();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'year' => 'required|integer|min:2000|max:9999',
            'college' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'participants_count' => 'required|integer|min:0',
        ]);

        $accomplishmentReport->update($validated);
        $this->logUpdate($accomplishmentReport, $oldValues, $accomplishmentReport->title);

        return redirect()->route('admin.accomplishment-reports.index')
            ->with('success', 'Accomplishment report updated successfully');
    }

    /**
     * Delete the specified accomplishment report
     */
    public function destroy(AccomplishmentReport $accomplishmentReport)
    {
        $this->logDelete($accomplishmentReport, $accomplishmentReport->title);
        $accomplishmentReport->delete();

        return redirect()->route('admin.accomplishment-reports.index')
            ->with('success', 'Accomplishment report deleted successfully');
    }

    /**
     * Get list of colleges - expandable for future dynamic sources
     */
    private function getColleges()
    {
        // Can be extended to fetch from a dedicated Colleges table in the future
        return [
            'College of Agriculture and Fisheries' => 'College of Agriculture and Fisheries',
            'College of Arts and Sciences' => 'College of Arts and Sciences',
            'College of Business and Accountancy' => 'College of Business and Accountancy',
            'College of Education' => 'College of Education',
            'College of Engineering' => 'College of Engineering',
            'College of Health Sciences' => 'College of Health Sciences',
            'College of Information and Communications Technology' => 'College of Information and Communications Technology',
            'College of Industrial Technology' => 'College of Industrial Technology',
            'College of Law' => 'College of Law',
            'University College of Education Integrated Laboratory School' => 'University College of Education Integrated Laboratory School',
        ];
    }

    /**
     * Get list of genders
     */
    private function getGenders()
    {
        return [
            'male' => 'Male',
            'female' => 'Female',
        ];
    }
}
