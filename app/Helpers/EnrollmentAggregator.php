<?php

namespace App\Helpers;

use App\Models\College;
use App\Models\Enrollment;
use Illuminate\Support\Collection;

class EnrollmentAggregator
{
    /**
     * Get aggregated enrollment data by college
     * Useful for dashboard visualization
     */
    public static function getByCollege(string $academicYear, string $semester): Collection
    {
        return Enrollment::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->collegeLevelOnly()
            ->with('college')
            ->orderBy('total_count', 'desc')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'college_id' => $enrollment->college_id,
                    'college_name' => $enrollment->college->name,
                    'male_count' => $enrollment->male_count,
                    'female_count' => $enrollment->female_count,
                    'total_count' => $enrollment->total_count,
                    'male_percentage' => $enrollment->getMalePercentage(),
                    'female_percentage' => $enrollment->getFemalePercentage(),
                ];
            });
    }

    /**
     * Get aggregated enrollment data by program
     * Useful for detailed dashboard analysis
     */
    public static function getByProgram(string $academicYear, string $semester): Collection
    {
        return Enrollment::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->programLevelOnly()
            ->with(['college', 'program'])
            ->orderBy('total_count', 'desc')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'program_id' => $enrollment->program_id,
                    'program_name' => $enrollment->program->program_name ?? 'N/A',
                    'college_id' => $enrollment->college_id,
                    'college_name' => $enrollment->college->name,
                    'male_count' => $enrollment->male_count,
                    'female_count' => $enrollment->female_count,
                    'total_count' => $enrollment->total_count,
                    'male_percentage' => $enrollment->getMalePercentage(),
                    'female_percentage' => $enrollment->getFemalePercentage(),
                ];
            });
    }

    /**
     * Get overall university-wide statistics
     */
    public static function getUniversityStats(string $academicYear, string $semester): array
    {
        $enrollments = Enrollment::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->collegeLevelOnly()
            ->get();

        $totalMale = $enrollments->sum('male_count');
        $totalFemale = $enrollments->sum('female_count');
        $totalStudents = $enrollments->sum('total_count');

        return [
            'total_male' => $totalMale,
            'total_female' => $totalFemale,
            'total_students' => $totalStudents,
            'male_percentage' => $totalStudents > 0 ? round(($totalMale / $totalStudents) * 100, 2) : 0,
            'female_percentage' => $totalStudents > 0 ? round(($totalFemale / $totalStudents) * 100, 2) : 0,
            'colleges_count' => $enrollments->count(),
        ];
    }

    /**
     * Get enrollment data for a specific college
     */
    public static function getCollegeDetails(int $collegeId, string $academicYear, string $semester): array
    {
        $collegeEnrollment = Enrollment::where('college_id', $collegeId)
            ->byAcademicYear($academicYear)
            ->bySemester($semester)
            ->whereNull('program_id')
            ->with('college')
            ->first();

        if (!$collegeEnrollment) {
            return [];
        }

        $programEnrollments = Enrollment::where('college_id', $collegeId)
            ->byAcademicYear($academicYear)
            ->bySemester($semester)
            ->programLevelOnly()
            ->with('program')
            ->orderBy('total_count', 'desc')
            ->get();

        return [
            'college' => [
                'id' => $collegeEnrollment->college->id,
                'name' => $collegeEnrollment->college->name,
                'male_count' => $collegeEnrollment->male_count,
                'female_count' => $collegeEnrollment->female_count,
                'total_count' => $collegeEnrollment->total_count,
                'male_percentage' => $collegeEnrollment->getMalePercentage(),
                'female_percentage' => $collegeEnrollment->getFemalePercentage(),
            ],
            'programs' => $programEnrollments->map(function ($enrollment) {
                return [
                    'program_id' => $enrollment->program_id,
                    'program_name' => $enrollment->program->program_name ?? 'N/A',
                    'male_count' => $enrollment->male_count,
                    'female_count' => $enrollment->female_count,
                    'total_count' => $enrollment->total_count,
                    'male_percentage' => $enrollment->getMalePercentage(),
                    'female_percentage' => $enrollment->getFemalePercentage(),
                ];
            }),
        ];
    }

    /**
     * Get enrollment trends across multiple academic years
     */
    public static function getTrends(int $collegeId, string $semester = null): Collection
    {
        $query = Enrollment::where('college_id', $collegeId)
            ->collegeLevelOnly()
            ->orderBy('academic_year', 'asc');

        if ($semester) {
            $query->where('semester', $semester);
        }

        return $query->get()
            ->map(function ($enrollment) {
                return [
                    'academic_year' => $enrollment->academic_year,
                    'semester' => $enrollment->semester,
                    'male_count' => $enrollment->male_count,
                    'female_count' => $enrollment->female_count,
                    'total_count' => $enrollment->total_count,
                ];
            });
    }

    /**
     * Export enrollment data to array format
     */
    public static function exportToArray(string $academicYear, string $semester): array
    {
        $enrollments = Enrollment::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->collegeLevelOnly()
            ->with('college')
            ->orderBy('total_count', 'desc')
            ->get();

        return $enrollments->map(function ($enrollment) {
            return [
                'College' => $enrollment->college->name,
                'Male' => $enrollment->male_count,
                'Female' => $enrollment->female_count,
                'Total' => $enrollment->total_count,
                'Male %' => $enrollment->getMalePercentage(),
                'Female %' => $enrollment->getFemalePercentage(),
                'Academic Year' => $enrollment->academic_year,
                'Semester' => $enrollment->semester,
            ];
        })->toArray();
    }

    /**
     * Get comprehensive college with program-level breakdown
     * Useful for detailed sex-disaggregated analytics
     */
    public static function getCollegesWithProgramsBreakdown(string $academicYear, string $semester): array
    {
        $colleges = Enrollment::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->collegeLevelOnly()
            ->with('college')
            ->orderBy('total_count', 'desc')
            ->get();

        return $colleges->map(function ($collegeEnrollment) use ($academicYear, $semester) {
            $collegeId = $collegeEnrollment->college_id;
            
            // Get programs for this college
            $programs = Enrollment::where('college_id', $collegeId)
                ->byAcademicYear($academicYear)
                ->bySemester($semester)
                ->programLevelOnly()
                ->with('program')
                ->orderBy('total_count', 'desc')
                ->get()
                ->map(function ($enrollment) {
                    return [
                        'program_id' => $enrollment->program_id,
                        'program_name' => $enrollment->program->program_name ?? 'Program ' . $enrollment->program_id,
                        'male_count' => $enrollment->male_count,
                        'female_count' => $enrollment->female_count,
                        'total_count' => $enrollment->total_count,
                        'male_percentage' => $enrollment->getMalePercentage(),
                        'female_percentage' => $enrollment->getFemalePercentage(),
                        'text_summary' => self::generateProgramSummary($enrollment),
                    ];
                });

            return [
                'college_id' => $collegeId,
                'college_name' => $collegeEnrollment->college->name,
                'male_count' => $collegeEnrollment->male_count,
                'female_count' => $collegeEnrollment->female_count,
                'total_count' => $collegeEnrollment->total_count,
                'male_percentage' => $collegeEnrollment->getMalePercentage(),
                'female_percentage' => $collegeEnrollment->getFemalePercentage(),
                'text_summary' => self::generateCollegeSummary($collegeEnrollment),
                'programs' => $programs,
                'has_programs' => $programs->count() > 0,
            ];
        })->toArray();
    }

    /**
     * Generate text summary for a college
     */
    private static function generateCollegeSummary($enrollment): string
    {
        $college = $enrollment->college->name;
        $male = $enrollment->male_count;
        $female = $enrollment->female_count;
        $total = $enrollment->total_count;
        $malePercent = $enrollment->getMalePercentage();
        $femalePercent = $enrollment->getFemalePercentage();

        return "{$college} has {$male} male ({$malePercent}%) and {$female} female ({$femalePercent}%) participants, totaling {$total} students.";
    }

    /**
     * Generate text summary for a program
     */
    private static function generateProgramSummary($enrollment): string
    {
        $program = $enrollment->program->program_name ?? 'Program';
        $male = $enrollment->male_count;
        $female = $enrollment->female_count;
        $total = $enrollment->total_count;
        $malePercent = $enrollment->getMalePercentage();
        $femalePercent = $enrollment->getFemalePercentage();

        return "{$program} recorded {$male} male ({$malePercent}%) and {$female} female ({$femalePercent}%) participants, totaling {$total}.";
    }

    /**
     * Get enhanced university summary with text interpretation
     */
    public static function getSexDisaggregatedSummary(string $academicYear, string $semester): array
    {
        $stats = self::getUniversityStats($academicYear, $semester);
        
        return [
            'stats' => $stats,
            'text_summary' => "Across all {$stats['colleges_count']} colleges, the university has {$stats['total_male']} male ({$stats['male_percentage']}%) and {$stats['total_female']} female ({$stats['female_percentage']}%) population, totaling {$stats['total_students']} students.",
        ];
    }
}
