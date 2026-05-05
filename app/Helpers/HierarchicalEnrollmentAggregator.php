<?php

namespace App\Helpers;

use App\Models\College;
use App\Models\Enrollment;
use Illuminate\Support\Collection;

class HierarchicalEnrollmentAggregator
{
    /**
     * Get enrollments organized by Campus → Category → College hierarchy
     *
     * @param string $academicYear
     * @param string $semester
     * @return array Hierarchical structure
     */
    public static function getByHierarchy(string $academicYear, string $semester): array
    {
        $enrollments = Enrollment::with('college')
            ->where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->whereNull('program_id')
            ->get();

        $hierarchy = [];

        foreach ($enrollments as $enrollment) {
            $campus = $enrollment->college->campus ?? 'Main Campus';
            $category = $enrollment->college->category ?? 'higher_education';
            $categoryLabel = $category === 'advanced_education' ? 'Advanced Education' : 'Higher Education';

            // Initialize campus if not exists
            if (!isset($hierarchy[$campus])) {
                $hierarchy[$campus] = [
                    'campus' => $campus,
                    'categories' => [],
                    'total_male' => 0,
                    'total_female' => 0,
                    'total_students' => 0,
                ];
            }

            // Initialize category if not exists
            if (!isset($hierarchy[$campus]['categories'][$category])) {
                $hierarchy[$campus]['categories'][$category] = [
                    'name' => $categoryLabel,
                    'category' => $category,
                    'colleges' => [],
                    'total_male' => 0,
                    'total_female' => 0,
                    'total_students' => 0,
                ];
            }

            // Add college data
            $collegeData = [
                'id' => $enrollment->college->id,
                'name' => $enrollment->college->name,
                'male' => $enrollment->male_count,
                'female' => $enrollment->female_count,
                'total' => $enrollment->total_count,
                'male_percentage' => $enrollment->total_count > 0 ? round(($enrollment->male_count / $enrollment->total_count) * 100, 2) : 0,
                'female_percentage' => $enrollment->total_count > 0 ? round(($enrollment->female_count / $enrollment->total_count) * 100, 2) : 0,
            ];

            $hierarchy[$campus]['categories'][$category]['colleges'][] = $collegeData;

            // Update category totals
            $hierarchy[$campus]['categories'][$category]['total_male'] += $enrollment->male_count;
            $hierarchy[$campus]['categories'][$category]['total_female'] += $enrollment->female_count;
            $hierarchy[$campus]['categories'][$category]['total_students'] += $enrollment->total_count;

            // Update campus totals
            $hierarchy[$campus]['total_male'] += $enrollment->male_count;
            $hierarchy[$campus]['total_female'] += $enrollment->female_count;
            $hierarchy[$campus]['total_students'] += $enrollment->total_count;
        }

        // Calculate percentages and clean up array keys
        foreach ($hierarchy as &$campus) {
            $campus['male_percentage'] = $campus['total_students'] > 0 ? round(($campus['total_male'] / $campus['total_students']) * 100, 2) : 0;
            $campus['female_percentage'] = $campus['total_students'] > 0 ? round(($campus['total_female'] / $campus['total_students']) * 100, 2) : 0;

            // Re-index categories array
            $campus['categories'] = array_values($campus['categories']);

            foreach ($campus['categories'] as &$category) {
                $category['male_percentage'] = $category['total_students'] > 0 ? round(($category['total_male'] / $category['total_students']) * 100, 2) : 0;
                $category['female_percentage'] = $category['total_students'] > 0 ? round(($category['total_female'] / $category['total_students']) * 100, 2) : 0;

                // Sort colleges by name within category
                usort($category['colleges'], function ($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
            }
        }

        // Re-index campus array
        return array_values($hierarchy);
    }

    /**
     * Get insights for Higher Education category only
     *
     * @param string $academicYear
     * @param string $semester
     * @return array Insights with highest/lowest colleges
     */
    public static function getHigherEducationInsights(string $academicYear, string $semester): array
    {
        $hierarchy = self::getByHierarchy($academicYear, $semester);

        $allColleges = [];
        $totalMale = 0;
        $totalFemale = 0;
        $totalStudents = 0;

        // Collect only Higher Education colleges
        foreach ($hierarchy as $campus) {
            foreach ($campus['categories'] as $category) {
                if ($category['category'] === 'higher_education') {
                    $allColleges = array_merge($allColleges, $category['colleges']);
                    $totalMale += $category['total_male'];
                    $totalFemale += $category['total_female'];
                    $totalStudents += $category['total_students'];
                }
            }
        }

        // Sort by enrollment
        usort($allColleges, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        $highest = $allColleges[0] ?? null;
        $lowest = end($allColleges) ?: null;

        $malePercentage = $totalStudents > 0 ? round(($totalMale / $totalStudents) * 100, 2) : 0;
        $femalePercentage = $totalStudents > 0 ? round(($totalFemale / $totalStudents) * 100, 2) : 0;

        return [
            'highest_enrollment' => $highest,
            'lowest_enrollment' => $lowest,
            'total_male' => $totalMale,
            'total_female' => $totalFemale,
            'total_students' => $totalStudents,
            'male_percentage' => $malePercentage,
            'female_percentage' => $femalePercentage,
            'college_count' => count($allColleges),
        ];
    }

    /**
     * Get Advanced Education summary (separate from colleges)
     *
     * @param string $academicYear
     * @param string $semester
     * @return array|null Advanced education data or null if not exists
     */
    public static function getAdvancedEducationSummary(string $academicYear, string $semester): ?array
    {
        $hierarchy = self::getByHierarchy($academicYear, $semester);

        foreach ($hierarchy as $campus) {
            foreach ($campus['categories'] as $category) {
                if ($category['category'] === 'advanced_education') {
                    return [
                        'total_male' => $category['total_male'],
                        'total_female' => $category['total_female'],
                        'total_students' => $category['total_students'],
                        'male_percentage' => $category['male_percentage'],
                        'female_percentage' => $category['female_percentage'],
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Get list of all campuses
     *
     * @return Collection
     */
    public static function getCampuses(): Collection
    {
        return College::distinct()
            ->pluck('campus')
            ->sort()
            ->values();
    }

    /**
     * Get enrollments for specific campus
     *
     * @param string $campus
     * @param string $academicYear
     * @param string $semester
     * @return array
     */
    public static function getByCampus(string $campus, string $academicYear, string $semester): array
    {
        $hierarchy = self::getByHierarchy($academicYear, $semester);

        foreach ($hierarchy as $camp) {
            if ($camp['campus'] === $campus) {
                return $camp;
            }
        }

        return [];
    }
}
